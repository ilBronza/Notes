<?php

namespace IlBronza\Notes\Helpers;

use IlBronza\Ukn\Ukn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class NotesDisplayerHelper
{
	static function display(Collection $notes) : string
	{
		return view('notes::notes.display', compact('notes'))->render();
	}

	static function displayByElement(Model $element) : string
	{
		$elements = $element->getNotesRelationships();

		return view('notes::notes.displayByElement', compact('element', 'elements'))->render();
	}


}
