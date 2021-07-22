<?php

return [
    [
        'name' => 'Memes',
        'flag' => 'meme.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'meme.create',
        'parent_flag' => 'meme.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'meme.edit',
        'parent_flag' => 'meme.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'meme.destroy',
        'parent_flag' => 'meme.index',
    ],

    // /tag
    [
        'name' => 'Meme tags',
        'flag' => 'meme-tag.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'meme-tag.create',
        'parent_flag' => 'meme-tag.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'meme-tag.edit',
        'parent_flag' => 'meme-tag.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'meme-tag.destroy',
        'parent_flag' => 'meme-tag.index',
    ],
];
