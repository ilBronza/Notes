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

    'slack' => [
        'webhooks' => [
            'default' => 'https://hooks.slack.com/services/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',
        ]
    ],

    'types' => [
        'requiredRule' => 'required',
        'table' => 'ibnotes_types',
        'class' => Notetype::class
    ]
];