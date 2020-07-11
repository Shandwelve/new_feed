<?php

return [
    ''                 => [
        'controller' => 'main',
        'action'     => 'index'
    ],
    'page/{page:\d+}'  => [
        'controller' => 'main',
        'action'     => 'index'
    ],
    'article/{id:\d+}' => [
        'controller' => 'main',
        'action'     => 'article'
    ],
    'add'              => [
        'controller' => 'main',
        'action'     => 'add'
    ],
    'edit/{id:\d+}'    => [
        'controller' => 'main',
        'action'     => 'edit'
    ],
    'delete/{id:\d+}'  => [
        'controller' => 'main',
        'action'     => 'delete'
    ]
];