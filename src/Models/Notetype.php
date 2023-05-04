<?php

namespace IlBronza\Notes\Models;

use IlBronza\CRUD\Models\SluggableBaseModel;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Notetype extends SluggableBaseModel
{
    static function createByName(string $name) : static
    {
        $notetype = static::make();
        $notetype->name = strtolower($name);

        $notetype->save();

        return $notetype;
    }

    static function getModelRoutesPrefix() : ? string
    {
        return config('notes.routePrefix');
    }

    public function getTable()
    {
    	return config('notes.types.table');
    }

	public function notes(): BelongsToMany
    {
        return $this->belongsToMany(Notes::getNoteClass());
    }

    public function getRouteBasename()
    {
        return config('notes.routePrefix') . 'notetypes';
    }

    public function getIndexUrl(array $data = [])
    {
        return implode(".", [
            $this->getRouteBasename(),
            'index'
        ]);
    }

    public function getTranslatedClassname()
    {
        return trans('notes::notes.notetype');
    }

}
