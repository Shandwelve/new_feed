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
        'addComment',
        'addLike',
        'addDislike',
        'signout'
    ],
    'admin' => [
        'add',
        'edit',
        'delete',
        'addComment',
        'deleteComment',
        'addLike',
        'addDislike',
        'signout'
    ]
];