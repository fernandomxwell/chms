<?php

namespace App\Http\Middleware;

use App\Models\Menu;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class GetNavigation
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $menus = Cache::remember('menus', 3600, function () {
            return Menu::parent()
                ->with('children')
                ->orderBy('order')
                ->get([
                    'id',
                    'name',
                    'link',
                ]);
        });

        $routeName = Route::currentRouteName();
        $activeMenu = null;
        $virtualCrumb = null;

        if ($routeName) {
            // Try exact match
            $activeMenu = Cache::remember("menu_for_route:{$routeName}", 3600, function () use ($routeName) {
                return Menu::where('link', $routeName)
                    ->with('parents')
                    ->first([
                        'name',
                        'link',
                        'parent_id',
                    ]);
            });

            // Resource Fuzzy Match (e.g. activities.edit -> activities.index)
            if (!$activeMenu && str_contains($routeName, '.')) {
                $parts = explode('.', $routeName);
                array_pop($parts);
                $resourcePrefix = implode('.', $parts);

                $indexRoute = $resourcePrefix . '.index';
                $activeMenu = Cache::remember("menu_for_route:{$indexRoute}", 3600, function () use ($indexRoute) {
                    return Menu::where('link', $indexRoute)
                        ->with('parents')
                        ->first([
                            'name',
                            'link',
                            'parent_id',
                        ]);
                });

                if ($activeMenu) {
                    $virtualCrumb = (object)[
                        'translated_name' => __("{$routeName}"),
                        'link' => $routeName,
                    ];
                }
            }
        }

        $breadcrumbs = $this->buildBreadcrumbs($activeMenu);

        if ($virtualCrumb) {
            $breadcrumbs->push($virtualCrumb);
        }

        $request->attributes->add([
            'menus' => $menus,
            'breadcrumbs' => $breadcrumbs,
        ]);

        return $next($request);
    }

    protected function buildBreadcrumbs($menu): Collection
    {
        $breadcrumbs = collect();

        while ($menu) {
            $breadcrumbs->prepend($menu);

            $menu = $menu->parents;
        }

        return $breadcrumbs;
    }
}
