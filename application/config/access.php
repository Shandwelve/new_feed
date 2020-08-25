<?php

return [
    'all'   => [
        'index',
        'show'
    ],
    'guest' => [
        'signin',
        'signup'
    ],
    'user'  => [
        'getComments',
        'addComment',
        'addLike',
        'addDislike',
        'signout'
    ],
    'admin' => [
        'add',
        'edit',
        'delete',
        'getComments',
        'addComment',
        'deleteComment',
        'addLike',
        'addDislike',
        'signout'
    ]
];