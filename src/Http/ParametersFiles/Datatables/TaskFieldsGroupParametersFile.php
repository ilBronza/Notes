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

					'created_at' => 'dates.datetime',
					'user_id' => 'users.name',
					'title' => 'flat',
					'notes' => 'text',
					'start_date' => 'editor.dates.datetime',
					'end_date' => 'editor.dates.datetime',
					'status' => [
						'type' => 'editor.select',
						'refreshRow' => true,
						'valueAsRowClass' => true
					],
					'mySelfNotes' => 'notes::notesList',

//					'note_number' => [
//						'type' => 'flat',
//						'fetcher' => [
//							'urlMethod' => 'getNotesPopupUrl',
//							'target' => 'row'
//						],
//						'valueAsRowClass' => true,
//						'width' => '45px'
//					],
//
					'assignee_user_id' => [
						'type' => 'editor.select',
	                    'width' => '250px',
	                    'possibleValuesMethod' => 'getPossibleAssigneeUsersArray',
	                    'refreshRow' => true,
					],
					'minutes' => 'editor.numeric',
					'commit' => 'editor.text',

					'mySelfDelete' => 'links.delete'
				]
		];
	}
}
