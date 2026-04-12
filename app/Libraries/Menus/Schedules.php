<?php

namespace App\Libraries\Menus;

use App\Interfaces\MenuInterface;

class Schedules implements MenuInterface
{
    public function getActions()
    {
        return [
            'view',
            'create',
            'delete',
        ];
    }

    public function getOrder()
    {
        return 2;
    }
}
