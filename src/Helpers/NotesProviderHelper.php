<?php

namespace IlBronza\Notes\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class NotesProviderHelper
{
	static function getByElement(Model $element) : Collection
	{
		$result = $element->getNotes();

		foreach($element->getNotesRelationships() as $__element)
			if($__element instanceof Collection)
				foreach($__element as $_element)
					$result = $result->merge(
						$_element->getNotes()
					);
			else
				if($__element)
					$result = $result->merge(
						$__element->getNotes()
					);

		return $result;
	}
}
