<?php

return [
    ''                    => [
        'controller' => 'main',
        'action'     => 'index'
    ],
    'page/{page:\d+}'     => [
        'controller' => 'main',
        'action'     => 'index'
    ],
    'show/{id:\d+}'       => [
        'controller' => 'article',
        'action'     => 'show'
    ],
    'add'                 => [
        'controller' => 'article',
        'action'     => 'add'
    ],
    'addComment/{id:\d+}' => [
        'controller' => 'article',
        'action'     => 'addComment'
    ],
    'deleteComment/{id:\d+}' => [
        'controller' => 'article',
        'action'     => 'deleteComment'
    ],
    'edit/{id:\d+}'       => [
        'controller' => 'article',
        'action'     => 'edit'
    ],
    'delete/{id:\d+}'     => [
        'controller' => 'article',
        'action'     => 'delete'
    ],
    'signin'              => [
        'controller' => 'account',
        'action'     => 'signin'
    ],
    'signup'              => [
        'controller' => 'account',
        'action'     => 'signup'
    ],
    'signout'             => [
        'controller' => 'account',
        'action'     => 'signout'
    ]
];