<?php

return [
    App\Providers\AppServiceProvider::class,
    class_exists(App\Providers\TelescopeServiceProvider::class)
        ? App\Providers\TelescopeServiceProvider::class
        : null,
];
