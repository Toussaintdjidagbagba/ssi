<?php

return [

    'driver' => env('MAIL_DRIVER', 'smtp'),

    'host' => env('MAIL_HOST', 'smtp.googlemail.com'),

    'port' => env('MAIL_PORT', 465),

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'sourcedusucces@gmail.com'),
        'name' => env('MAIL_FROM_NAME', 'LA SOURCE DU SUCCÈS INTERNATIONAL'),
    ],

    'encryption' => env('MAIL_ENCRYPTION', 'ssl'),

    'username' => env('MAIL_USERNAME'),

    'password' => env('MAIL_PASSWORD'),
    
    'sendmail' => '/usr/sbin/sendmail -bs',

    /*
    |--------------------------------------------------------------------------
    | Markdown Mail Settings
    |--------------------------------------------------------------------------
    |
    | If you are using Markdown based email rendering, you may configure your
    | theme and component paths here, allowing you to customize the design
    | of the emails. Or, you may simply stick with the Laravel defaults!
    |
    */

    'markdown' => [
        'theme' => 'default',

        'paths' => [
            resource_path('views/vendor/mail'),
        ],
    ],

];
