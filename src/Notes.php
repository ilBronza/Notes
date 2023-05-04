<?php

namespace IlBronza\Notes;

use IlBronza\Buttons\Button;
use IlBronza\Notes\Models\Notetype;
use IlBronza\Notes\Traits\NotesMenuTrait;
use IlBronza\Notes\Traits\NotesRoutingTrait;
use IlBronza\UikitTemplate\Fetcher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

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

    static function getFilteredPDFStringByTypes(Model $model, array $types)
    {
        $notes = $model->getNotesByTypes($types);

        return view('notes::string', compact('notes'));
    }

    static function getAllNotesWithRelated(Model $model, array $related = []) : Collection
    {
        $notes = collect();

        $notes->push(
            $model->notes()->with('noteable')->get()
        );

        foreach($related as $elements)
            if(class_basename($elements) == 'Collection')
                foreach($elements as $element)
                    $notes->push(
                        $element->notes()->with('noteable')->get()
                    );

            else if($elements)
                $notes->push(
                    $elements->notes()->with('noteable')->get()
                );

        return $notes->flatten();
    }

    static function getNotesWithRelatedByTypes(Model $model, array $related = [], array $types) : Collection
    {
        $notes = collect();

        $notes->push(
            $model->notes()->byTypes($types)->with('noteable')->get()
        );

        foreach($related as $elements)
            if(class_basename($elements) == 'Collection')
                foreach($elements as $element)
                    $notes->push(
                        $element->notes()->byTypes($types)->with('noteable')->get()
                    );

            else if($elements)
                $notes->push(
                    $elements->notes()->byTypes($types)->with('noteable')->get()
                );

        return $notes->flatten();
    }

    static function getNotesNumberWithRelated(Model $model, array $related = []) : int
    {
        $result = $model->notes()->count();

        foreach($related as $elements)
            if(class_basename($elements) == 'Collection')
                foreach($elements as $element)
                    $result += $element->notes()->count();

            else if($elements)
                $result += $elements->notes()->count();

        return $result;
    }

    static function getCachedNotesNumberWithRelated(Model $model, array $related = []) : int
    {
        return cache()->remember(
            $model->cacheKey('notesCount'),
            1200,
            function() use($model, $related)
            {
                return static::getNotesNumberWithRelated($model, $related);
            }
        );
    }

    static function getFetcher(Model $model = null)
    {
        if(! $model)
            return null;

        $fetcher = new Fetcher([
            'title' => __('notes::notes.notesFor', [
                'type' => __('crudModels.' . $model->getCamelcaseClassBasename()),
                'name' => $model->getName()
            ]),
            'url' =>  static::getRoutedModel($model, 'notes.by')
        ]);

        $fetcher->addButton(
            static::getAddNotesForModelButton($model)
        );

        return $fetcher->renderCard();
    }

    static function getNotetypeByName(string $slug) : Notetype
    {
        if($notetype = Notetype::where('name', $slug)->first())
            return $notetype;

        return Notetype::createByName($slug);
    }

    static function cacheKey(Model $model, string $key)
    {
        return implode("_", [
            class_basename($model),
            $model->updated_at ?? '',
            $model->getKey(),
            Str::slug($key)
        ]);        
    }
}
