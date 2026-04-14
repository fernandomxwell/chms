<?php

namespace App\Libraries\Menus;

use App\Interfaces\MenuInterface;

class Home implements MenuInterface
{
    public function getActions(): ?array
    {
        return [
            'view',
        ];
    }

    public function getOrder(): int
    {
        return 1;
    }
}
