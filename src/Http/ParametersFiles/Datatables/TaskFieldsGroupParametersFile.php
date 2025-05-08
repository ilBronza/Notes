<?php

namespace IlBronza\Notes\Http\ParametersFiles\Datatables;

use IlBronza\Form\Helpers\FieldsetsProvider\FieldsetParametersFile;

class TaskFieldsGroupParametersFile extends FieldsetParametersFile
{
	static function getFieldsGroup() : array
	{
		return [
			'translationPrefix' => 'notes::fields',
			'fields' =>
				[
					'mySelfPrimary' => 'primary',

					'mySelfEdit' => 'links.edit',

					'title' => 'flat',
					'notes' => 'flat',
					'start_date' => 'dates.datetime',
					'end_date' => 'dates.datetime',
					'minutes' => 'flat',
					'commit' => 'flat',

					'mySelfDelete' => 'links.delete'
				]
		];
	}
}
