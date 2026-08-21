<?php

use IlBronza\Notes\Http\Controllers\CrudAddNoteToModelController;
use IlBronza\Notes\Http\ParametersFiles\Datatables\TaskFieldsGroupParametersFile;
use IlBronza\Notes\Http\ParametersFiles\Fieldsets\NoteShowFieldsetsParameters;
use IlBronza\Notes\Http\ParametersFiles\Fieldsets\NotetypeShowFieldsetsParameters;
use IlBronza\Notes\Http\ParametersFiles\Fieldsets\TaskCreateStoreFieldsetsParameters;
use IlBronza\Notes\Http\ParametersFiles\Fieldsets\TaskShowFieldsetsParameters;
use IlBronza\Notes\Http\ParametersFiles\NoteParameters;
use IlBronza\Notes\Http\ParametersFiles\NotetypeParameters;
use IlBronza\Notes\Models\Note;
use IlBronza\Notes\Models\Notetype;
use IlBronza\Notes\Models\Task;

return [
    'routePrefix' => 'notesmanager',
	'routePrefixTasks' => 'notesmanagertasks.',

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
	    'task' => [
			'enabled' => false,
			'class' => Task::class,
		    'table' => 'notes__tasks',
		    'parametersFiles' => [
			    'create' => TaskCreateStoreFieldsetsParameters::class,
			    'edit' => TaskCreateStoreFieldsetsParameters::class,
			    'show' => TaskShowFieldsetsParameters::class,
		    ],
		    'fieldsGroupsFiles' => [
			    'index' => TaskFieldsGroupParametersFile::class
		    ],
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