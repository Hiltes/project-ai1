<?php

return [

   /*
    |--------------------------------------------------------------------------
    | Class-Based Component Layout
    |--------------------------------------------------------------------------
    */
    'layout' => 'layouts.app',

    /*
    |--------------------------------------------------------------------------
    | Volt Components Location
    |--------------------------------------------------------------------------
    */
    'view_path' => resource_path('views/livewire'),

    /*
    |--------------------------------------------------------------------------
    | Livewire Asset URLs
    |--------------------------------------------------------------------------
    |
    | Jeśli chcesz ręcznie określić ścieżki do plików Livewire (JS, CSS),
    | możesz to zrobić tutaj. Zostaw null, jeśli nie używasz.
    |
    */

    'assets_url' => null,

    /*
    |--------------------------------------------------------------------------
    | Livewire App URL
    |--------------------------------------------------------------------------
    |
    | Przydatne, gdy Twoja aplikacja działa za reverse proxy lub innym hostem.
    |
    */

    'app_url' => null,

    /*
    |--------------------------------------------------------------------------
    | Livewire Middleware
    |--------------------------------------------------------------------------
    |
    | Middleware, które będą stosowane do żądań Livewire.
    |
    */

    'middleware_group' => 'web',

    /*
    |--------------------------------------------------------------------------
    | Temporary File Upload Configuration
    |--------------------------------------------------------------------------
    |
    | Dotyczy obsługi tymczasowych plików w formularzach (np. zdjęcia).
    |
    */

    'temporary_file_upload' => [
        'disk' => null,
        'rules' => null,
        'directory' => null,
        'middleware' => null,
        'preview_mimes' => [
            'png', 'jpg', 'jpeg', 'gif', 'bmp', 'svg', 'webp',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Render on Redirect
    |--------------------------------------------------------------------------
    |
    | Czy komponenty mają się renderować przy redirectach.
    |
    */

    'render_on_redirect' => false,

];
