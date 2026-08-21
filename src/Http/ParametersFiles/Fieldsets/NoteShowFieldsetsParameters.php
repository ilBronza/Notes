<?php

namespace IlBronza\Notes\Http\ParametersFiles\Fieldsets;

use IlBronza\Form\Helpers\FieldsetsProvider\FieldsetParametersFile;

class NoteShowFieldsetsParameters extends FieldsetParametersFile
{
	public function _getFieldsetsParameters() : array
	{
		return [
			'general' => [
				'translationPrefix' => 'notes::fields',
				'fields' => [
					'notes' => ['textarea' => 'string|required|max:10240'],
					'type_slug' => [
						'type' => 'select',
						'multiple' => false,
						'rules' => 'string|' . config('notes.models.notetype.requiredRule') . '|exists:' . config('notes.models.notetype.table') . ',slug',
						'relation' => 'type'
					],
					'files' => [
						'type' => 'file',
						'multiple' => true,
						'rules' => 'file|nullable|max:30240'
					],
				],
				'width' => ['1-2@l', '1-1@m']
			],
			'tracking' => [
				'translationPrefix' => 'notes::fields',
				'fields' => [
					'user_id' => [
						'type' => 'select',
						'multiple' => false,
						'rules' => 'string|nullable|exists:users,id',
						'relation' => 'user'
					],
					'created_at' => ['datetime' => 'date|nullable'],
				],
				'width' => ['1-2@l', '1-1@m']
			]
		];
	}
}
