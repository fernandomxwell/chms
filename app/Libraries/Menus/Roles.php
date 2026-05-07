<?php

namespace App\Libraries\Menus;

use App\Interfaces\MenuInterface;

class Roles implements MenuInterface
{
    public array $allowedDefaultRoles = ['super admin'];

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
