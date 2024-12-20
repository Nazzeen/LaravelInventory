<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],



    'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],

    'admin' => [
        'driver' => 'session',
        'provider' => 'admins', // Define a separate provider for admins
    ],
],



    'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => App\Models\User::class,
    ],

    'admins' => [ // Define the admin provider
        'driver' => 'eloquent',
        'model' => App\Models\Admin::class, // Create an Admin model
    ],
],


    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],


    'password_timeout' => 10800,

];
