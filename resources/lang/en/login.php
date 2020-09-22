<?php

declare(strict_types=1);

return [

    'title' => 'Login',

    'labels' => [
        'email' => 'Email',
        'password' => 'Password',
        'rememberMe' => 'Remember me',
        'send' => [
            'default' => 'Login',
            'loading' => 'Logging in...',
        ],
    ],

    'placeholders' => [
        'email' => 'admin@example.com',
    ],

    'errors' => [
        'email' => [
            'notActivated' => 'This account has not been activated yet.',
            'suspended' => 'Your access has been temporarily suspended, due to too many consecutive wrong password attempts. Please try again later.',
            'unregistered' => 'This account does not exist.',
        ],
    ],

];
