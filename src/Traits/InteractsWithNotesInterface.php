<?php

namespace IlBronza\Notes\Traits;

use IlBronza\Notes\Facades\Notes;

trait InteractsWithNotesTrait
{
    public function getNoteClass()
    {
        return Notes::getNoteClass();
    }

    public function notes()
    {
        return $this->morphMany(
            $this->getNoteClass(),
            'noteable'
        );
    }

    public function createNote()
    {
        return $this->notes()->create();
    }
}