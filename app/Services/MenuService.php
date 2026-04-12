<?php

namespace App\Services;

use App\Interfaces\MenuInterface;
use App\Models\Menu;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class MenuService
{
    private function prepareService($menu)
    {
        App::singleton(MenuInterface::class, "App\Libraries\Menus\\" . str_replace(' ', '', $menu));

        return App::make(MenuInterface::class);
    }

    private function prepareConditions($menu)
    {
        return [
            'name' => $menu,
        ];
    }

    private function prepareData($menu, $order, $parent = null, $actions = [])
    {
        $data = [
            'parent_id' => null,
            'name' => $menu,
            'link' => null,
            'actions' => null,
            'order' => $order,
        ];

        if ($parent) {
            $query = Menu::parent()
                ->where('name', $parent)
                ->firstOrFail(['id']);

            $data['parent_id'] = $query->id;
        }

        if (!empty($actions)) {
            $prefix = Str::snake($menu) . '.';

            $data['link'] = $prefix . 'index';
            $data['actions'] = array_map(fn($action) => $prefix . $action, $actions);
        }

        return $data;
    }

    public function updateOrCreate($menu, $parent)
    {
        $service = $this->prepareService($menu);

        $actions = $service->getActions();
        $order = $service->getOrder();

        $conditions = $this->prepareConditions($menu);

        $data = $this->prepareData($menu, $order, $parent, $actions);

        Menu::updateOrCreate($conditions, $data);
    }
}
