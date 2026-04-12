<?php

namespace App\Libraries\Menus;

use App\Interfaces\MenuInterface;

class Activities implements MenuInterface
{
    public function getActions()
    {
        return [
            'view',
            'create',
            'edit',
            'delete',
        ];
    }

    public function getOrder()
    {
        return 2;
    }
}
