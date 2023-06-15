<?php

namespace IlBronza\Notes\Traits;

use IlBronza\Buttons\Button;
use IlBronza\Notes\Facades\Notes;
use Illuminate\Database\Eloquent\Model;

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

    public function getNotesByTypes(array $types)
    {
        return $this->notes()
            ->byTypes($types)
            ->get();        
    }

    // public function createNote()
    // {
    //     return $this->notes()->create();
    // }

    public function getNotesSubject() : Model
    {
        return $this;
    }

    public function getNotesRelationships() : array
    {
        $names = $this->getNotesRelationshipsNames();

        $result = [];

        foreach($names as $name)
            $result[$name] = $this->$name;

        return $result;
    }

    public function getNotesRelationshipsNames() : array
    {
        return static::$notesRelationshipsNames ?? [];
    }

    public function getAddNotesUrl() : string
    {
        return Notes::getRoutedModel($this, 'notes.addBy');
    }

    public function getAddNotesButton() : Button
    {
        return Button::create([
                'href' => $this->getAddNotesUrl(),
                'icon' => 'clipboard'
            ]);
    }

    public function getAddNotesLink() : string
    {
        return $this->getAddNotesButton()
                    ->render();
    }
}