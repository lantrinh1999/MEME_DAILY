<?php

return [
    [
        'name' => 'Views',
        'flag' => 'view.index',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'view.create',
        'parent_flag' => 'view.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'view.edit',
        'parent_flag' => 'view.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'view.destroy',
        'parent_flag' => 'view.index',
    ],
];
