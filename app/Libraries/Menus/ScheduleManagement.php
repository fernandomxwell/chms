<?php

namespace App\Libraries\Menus;

use App\Interfaces\MenuInterface;

class ScheduleManagement implements MenuInterface
{
    public function getActions()
    {
        return null;
    }

    public function getOrder()
    {
        return 5;
    }
}
