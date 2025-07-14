<?php

use IlBronza\Notes\Http\Controllers\CrudAddNoteToModelController;
use IlBronza\Notes\Http\ParametersFiles\Datatables\TaskFieldsGroupParametersFile;
use IlBronza\Notes\Http\ParametersFiles\Fieldsets\TaskCreateStoreFieldsetsParameters;
use IlBronza\Notes\Models\Note;
use IlBronza\Notes\Models\Notetype;
use IlBronza\Notes\Models\Task;

return [
    'routePrefix' => 'notesmanager',
	'routePrefixTasks' => 'notesmanagertasks.',

	'enabled' => true,

    'models' => [
        'note' => [
            'class' => Note::class,
            'table' => 'ibnotes',
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
		    ],
		    'fieldsGroupsFiles' => [
			    'index' => TaskFieldsGroupParametersFile::class
		    ],
	    ],
        'notetype' => [
            'class' => Notetype::class,
            'table' => 'ibnotes_types',
            'requiredRule' => 'required'
        ]
    ],

    'channels' => [
        'slack' => false,
        'notification' => false,
    ],

    'slack' => [
        'webhooks' => [
            'default' => env('NOTES_SLACK_WEBHOOK', 'https://hooks.slack.com/services/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')
        ]
    ],

    'slack' => [
        'webhooks' => [
            'default' => env('NOTES_SLACK_WEBHOOK', 'https://hooks.slack.com/services/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')
        ]
    ]
];