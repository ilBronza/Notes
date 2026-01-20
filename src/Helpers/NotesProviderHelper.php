<?php

namespace IlBronza\Notes\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class NotesProviderHelper
{
	static function getByElement(Model $element) : Collection
	{
		$result = $element->getNotes();

		foreach($element->getNotesRelationships() as $element)
			if($element instanceof Collection)
				foreach($element as $_element)
					$result = $result->merge(
						$_element->getNotes()
					);
			else
				$result = $result->merge(
					$element->getNotes()
				);

		return $result;
	}
}
