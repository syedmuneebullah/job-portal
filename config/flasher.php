<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Flasher
    |--------------------------------------------------------------------------
    */
    'default' => 'sweetalert', // Change this to 'sweetalert'

    /*
    |--------------------------------------------------------------------------
    | The flasher adapters
    |--------------------------------------------------------------------------
    */
    'adapters' => [
        'sweetalert' => [
            'scripts' => [
                'https://cdn.jsdelivr.net/npm/sweetalert2@11',
            ],
            'styles' => [
                'https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css',
            ],
            'options' => [
                'title' => 'Notification',
                'timer' => 5000,
                'showConfirmButton' => true,
            ],
        ],
    ],
];