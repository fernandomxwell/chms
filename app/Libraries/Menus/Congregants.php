<?php

namespace App\Libraries\Menus;

use App\Interfaces\MenuInterface;

class Congregants implements MenuInterface
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
        return 3;
    }
}
