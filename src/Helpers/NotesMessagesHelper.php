<?php

namespace IlBronza\Notes\Helpers;

use IlBronza\Ukn\Ukn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class NotesMessagesHelper
{
	static function flashByElement(Model $element) : Collection
	{
		$notes = NotesProviderHelper::getByElement($element);

		foreach($notes as $note)
			Ukn::w($note->notes);

		return $notes;
	}


}
