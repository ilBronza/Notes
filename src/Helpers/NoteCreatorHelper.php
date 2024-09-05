<?php

namespace IlBronza\Notes\Helpers;

use IlBronza\Notes\Models\Note;
use Illuminate\Database\Eloquent\Model;

class NoteCreatorHelper
{
	static function createNoteForModel(Model $model, string $text, array $parameters = []) : Note
	{
		$note = Note::getProjectClassName()::make();

		$note->notes = $text;

		foreach ($parameters as $key => $value)
			$note->$key = $value;

		$model->notes()->save($note);

		return $note;
	}
}
