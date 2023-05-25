<?php

namespace IlBronza\Notes\Http\ParametersFiles;

use Carbon\Carbon;
use IlBronza\Form\Helpers\FieldsetsProvider\FieldsetParametersFile;

class NoteParameters extends FieldsetParametersFile
{
	public function _getFieldsetsParameters() : array
	{
		return [
			'general' => [
				'fields' => [
					'notes' => [
						'textarea' => 'string|required|max:10240'
					],

                    'type_slug' => [
                        'type' => 'select',
                        'multiple' => false,
                        'rules' => 'string|' . config('notes.types.requiredRule') . '|exists:' . config('notes.types.table') . ',slug',
                        'relation' => 'type',
                    ],

                    'slack' => [
                        'type' => 'boolean',
                        'rules' => 'boolean|required',
                        'visible' => false,
                        'default' => config('notes.channels.slack')
                    ],

                    'create_notification' => [
                        'visible' => false,
                        'type' => 'boolean',
                        'rules' => 'boolean|required',
                        'default' => config('notes.channels.notification')
                    ],

                    'files' => [
                        'type' => 'file',
                        'multiple' => true,
                        'rules' =>'file|nullable|max:30240'
                    ],
	            ]
	        ]
	    ];
	}
}