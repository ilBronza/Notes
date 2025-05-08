<?php

namespace IlBronza\Notes\Http\ParametersFiles\Fieldsets;

use IlBronza\Form\Helpers\FieldsetsProvider\FieldsetParametersFile;

class TaskCreateStoreFieldsetsParameters extends FieldsetParametersFile
{
	public function _getFieldsetsParameters() : array
	{
		return [
			'package' => [
				'translationPrefix' => 'notes::fields',
				'fields' => [
					'title' => ['text' => 'string|required|max:255'],
					'notes' => ['textarea' => 'string|nullable'],
					'status' => ['select' => 'string|nullable'],
				],
				'width' => ['1-3@l', '1-2@m']
			],
			'tracking' => [
				'translationPrefix' => 'notes::fields',
						'fields' => [
							'start_date' => ['datetime' => 'date|nullable'],
							'end_date' => ['datetime' => 'date|nullable'],
							'minutes' => ['number' => 'float|nullable|min:0'],
							'commit' => ['text' => 'string|nullable|max:255'],
						],
						'width' => ['1-3@l', '1-2@m']
					]
				];
	}
}
