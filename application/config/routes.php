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
    'show/{id:\d+}' => [
        'controller' => 'article',
        'action'     => 'show'
    ],
    'add'              => [
        'controller' => 'article',
        'action'     => 'add'
    ],
    'edit/{id:\d+}'    => [
        'controller' => 'article',
        'action'     => 'edit'
    ],
    'delete/{id:\d+}'  => [
        'controller' => 'article',
        'action'     => 'delete'
    ],
    'signin' => [
        'controller' => 'account',
        'action' => 'signin'
    ]
];