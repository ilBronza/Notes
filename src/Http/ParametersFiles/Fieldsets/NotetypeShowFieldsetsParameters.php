<?php

namespace IlBronza\Notes\Http\ParametersFiles\Fieldsets;

use IlBronza\Form\Helpers\FieldsetsProvider\FieldsetParametersFile;

class NotetypeShowFieldsetsParameters extends FieldsetParametersFile
{
	public function _getFieldsetsParameters() : array
	{
		return [
			'general' => [
				'translationPrefix' => 'notes::fields',
				'fields' => [
					'slug' => ['text' => 'string|required|max:16'],
					'name' => ['text' => 'string|required|max:255'],
					'description' => ['text' => 'string|nullable|max:255'],
					'meaning' => ['text' => 'string|nullable|max:1024'],
				],
				'width' => ['1-2@l', '1-1@m']
			]
		];
	}
}
