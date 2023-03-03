<?php

use IlBronza\Notes\Models\Note;
use IlBronza\Notes\Models\Notetype;

return [
    'table' => 'ibnotes',
    'class' => Note::class,
    'routePrefix' => 'notesmanager',

    'models' => [
    ],

    'channels' => [
        'slack' => true,
        'notification' => true,
    ],

    'types' => [
        'table' => 'ibnotes_types',
        'class' => Notetype::class
    ]
];