<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Modül Keşif Yolları
    |--------------------------------------------------------------------------
    |
    | Modüller composer ile yüklenip Laravel auto-discovery tarafından boot
    | edilir. Bu yollar yalnızca `herkobi:install` / `herkobi:uninstall`
    | komutlarının ve ileride yapılacak "Modüller" ekranının module.json
    | dosyalarını bulabilmesi içindir (salt-okur metadata).
    |
    */
    'module_discovery_paths' => [
        base_path('packages/*/module.json'),
        base_path('vendor/herkobi/*/module.json'),
    ],
];
