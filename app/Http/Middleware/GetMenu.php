<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class GetMenu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
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

        $request->attributes->add([
            'menus' => $menus,
        ]);

        return $next($request);
    }
}
