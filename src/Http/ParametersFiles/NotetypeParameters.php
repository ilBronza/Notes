<?php

namespace IlBronza\Notes\Http\ParametersFiles;

use Carbon\Carbon;
use IlBronza\Form\Helpers\FieldsetsProvider\FieldsetParametersFile;

class NotetypeParameters extends FieldsetParametersFile
{
	public function _getFieldsetsParameters() : array
	{
		return [
			'general' => [
				'fields' => [
	                'name' => ['text' => 'string|required|max:255'],
	                'description' => ['text' => 'string|required|max:255'],
	                'meaning' => ['text' => 'string|required|max:1024'],
	            ]
	        ]
	    ];
	}
}