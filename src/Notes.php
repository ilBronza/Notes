<?php

namespace IlBronza\Notes;

use IlBronza\Notes\Traits\NotesMenuTrait;
use IlBronza\Notes\Traits\NotesRoutingTrait;

use IlBronza\Buttons\Button;
use IlBronza\UikitTemplate\Fetcher;
use Illuminate\Database\Eloquent\Model;

class Notes
{
    use NotesRoutingTrait;
    use NotesMenuTrait;

    static function getNoteClass()
    {
        return config('notes.class');
    }

    static function getAddNotesForModelButton(Model $model)
    {
        return Button::create([
                'href' => static::getRoutedModel($model, 'notes.add'),
                'text' => __('notes::notes.addNote'),
                'icon' => 'plus'
            ]);
    }

    static function makeNoteByMorphData(string $type, string $id)
    {
        return static::getNoteClass()::create([
            'noteable_type' => $type,
            'noteable_id' => $id,
        ]);
    }

    static function getFetcher(Model $model)
    {
        $fetcher = new Fetcher([
            'title' => __('notes::notes.notesFor', [
                'type' => __('crudModels.' . $model->getPluralCamelcaseClassBasename()),
                'name' => $model->getName()
            ]),
            'url' =>  static::getRoutedModel($model, 'notes.by')
        ]);

        $fetcher->addButton(
            static::getAddNotesForModelButton($model)
        );

        return $fetcher->renderCard();
    }
}
