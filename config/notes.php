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
            'default' => env('NOTES_SLACK_WEBHOOK', 'https://hooks.slack.com/services/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')
        ]
    ],

    'types' => [
        'requiredRule' => 'required',
        'table' => 'ibnotes_types',
        'class' => Notetype::class
    ]
];