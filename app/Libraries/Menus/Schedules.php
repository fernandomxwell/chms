<?php

namespace App\Libraries\Menus;

use App\Interfaces\MenuInterface;

class Schedules implements MenuInterface
{
    public array $allowedDefaultRoles = ['super admin', 'admin'];

    public function getActions(): ?array
    {
        return [
            'view',
            'create',
            'delete',
        ];
    }

    public function getOrder(): int
    {
        return 2;
    }
}
