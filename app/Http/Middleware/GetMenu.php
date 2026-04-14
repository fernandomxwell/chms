<?php

namespace App\Http\Middleware;

use App\Models\Menu;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class GetMenu
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

        $request->attributes->add([
            'menus' => $menus,
        ]);

        return $next($request);
    }
}
