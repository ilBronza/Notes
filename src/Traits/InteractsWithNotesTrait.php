<?php

namespace IlBronza\Notes\Traits;

use IlBronza\Buttons\Button;
use IlBronza\Notes\Facades\Notes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

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

    public function getNotes() : Collection
    {
        if($this->relationLoaded('notes'))
            return $this->notes;

        return $this->notes()->get();
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
        {
            $methodName = 'get' . ucfirst($name);

            if(method_exists($this, $methodName))
                $result[$name] = $this->{$methodName}();

            else
                $result[$name] = $this->$name;
        }

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