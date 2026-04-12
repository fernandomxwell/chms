<?php

namespace App\Libraries\Menus;

use App\Interfaces\MenuInterface;

class Home implements MenuInterface
{
    public function getActions()
    {
        return [
            'view',
        ];
    }

    public function getOrder()
    {
        return 1;
    }
}
