<?php

namespace App\Libraries\Menus;

use App\Interfaces\MenuInterface;

class ScheduleManagement implements MenuInterface
{
    public function getActions(): ?array
    {
        return null;
    }

    public function getOrder(): int
    {
        return 5;
    }
}
