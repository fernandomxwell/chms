<?php

namespace App\Libraries\Menus;

use App\Interfaces\MenuInterface;

class Activities implements MenuInterface
{
    public array $allowedDefaultRoles = ['super admin', 'admin'];

    public function getActions(): ?array
    {
        return [
            'view',
            'create',
            'edit',
            'delete',
        ];
    }

    public function getOrder(): int
    {
        return 2;
    }
}
