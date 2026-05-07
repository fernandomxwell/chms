<?php

namespace App\Http\Middleware;

use App\Models\Menu;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class GetNavigation
{
    public function handle(Request $request, Closure $next): Response
    {
        $allMenus = Cache::remember('menus', 3600, function () {
            return Menu::parent()
                ->with('children')
                ->orderBy('order')
                ->get([
                    'id',
                    'name',
                    'link',
                    'actions',
                ]);
        });

        $permissions = optional(optional(Auth::user())->role)->permissions ?? [];
        $menus = $this->filterMenusByPermissions($allMenus, $permissions);

        $routeName = Route::currentRouteName();
        $activeMenu = null;
        $virtualCrumb = null;

        if ($routeName) {
            $activeMenu = Cache::remember("menu_for_route:{$routeName}", 3600, function () use ($routeName) {
                return Menu::where('link', $routeName)
                    ->with('parents')
                    ->first([
                        'name',
                        'link',
                        'parent_id',
                    ]);
            });

            if (! $activeMenu && str_contains($routeName, '.')) {
                $parts = explode('.', $routeName);

                while (count($parts) > 1) {
                    array_pop($parts);
                    $indexRoute = implode('.', $parts) . '.index';

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
                        $translationKey = $routeName;
                        if (__($translationKey) === $translationKey) {
                            $crumbParts = explode('.', $routeName);
                            array_pop($crumbParts);
                            $translationKey = implode('.', $crumbParts);
                        }
                        $virtualCrumb = (object)[
                            'translated_name' => __($translationKey),
                            'link' => $routeName,
                        ];
                        break;
                    }
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

    protected function filterMenusByPermissions(Collection $menus, array $permissions): Collection
    {
        return $menus->filter(function ($menu) use ($permissions) {
            if ($menu->children->isEmpty()) {
                return !empty(array_intersect($menu->actions ?? [], $permissions));
            }

            $menu->children = $this->filterMenusByPermissions($menu->children, $permissions);
            return $menu->children->isNotEmpty();
        })->values();
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
