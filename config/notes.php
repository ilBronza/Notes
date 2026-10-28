<?php

use IlBronza\Notes\Http\Controllers\CrudAddNoteToModelController;
use IlBronza\Notes\Http\ParametersFiles\Fieldsets\NoteShowFieldsetsParameters;
use IlBronza\Notes\Http\ParametersFiles\Fieldsets\NotetypeShowFieldsetsParameters;
use IlBronza\Notes\Http\ParametersFiles\NoteParameters;
use IlBronza\Notes\Http\ParametersFiles\NotetypeParameters;
use IlBronza\Notes\Models\Note;
use IlBronza\Notes\Models\Notetype;

return [
    'routePrefix' => 'notesmanager',

    'defaultRoles' => [
        'superadmin',
        'administrator',
        'notes',
    ],

    'routeRoles' => [
    ],

	'enabled' => true,

    'datatableFieldWidths' => [
        'datatableFieldNotesList' => '2em'
    ],

    'models' => [
        'note' => [
            'class' => Note::class,
            'table' => 'ibnotes',
            'parametersFiles' => [
                'show' => NoteShowFieldsetsParameters::class,
                'edit' => NoteParameters::class,
            ],
            'controllers' => [
                'addNote' => CrudAddNoteToModelController::class
            ]
        ],
        'notetype' => [
            'class' => Notetype::class,
            'table' => 'ibnotes_types',
            'requiredRule' => 'required',
            'parametersFiles' => [
                'show' => NotetypeShowFieldsetsParameters::class,
                'edit' => NotetypeParameters::class,
            ]
        ]
    ],

    'channels' => [
        'slack' => false,
        'notification' => false,
    ],

    'slack' => [
        'webhooks' => [
            'default' => env('NOTES_SLACK_WEBHOOK')
        ]
    ]
];
