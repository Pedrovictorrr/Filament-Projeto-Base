<?php

return [

    'labels' => [
        'model' => 'Exception',
        'model_plural' => 'Exceptions',
        'navigation' => 'Log de erros',
        'navigation_group' => 'Admin',

        'tabs' => [
            'exception' => 'Exception',
            'headers' => 'Headers',
            'cookies' => 'Cookies',
            'body' => 'Body',
            'queries' => 'Queries',
        ],
    ],

    'empty_list' => 'Horray! just sit back & enjoy 😎',

    'columns' => [
        'method' => 'Método',
        'path' => 'Caminho',
        'type' => 'Tipo',
        'code' => 'Código',
        'ip' => 'IP',
        'occurred_at' => 'Ocorreu em',
    ],

];
