<?php

namespace IlBronza\Notes\Models;

use IlBronza\CRUD\Models\SluggableBaseModel;
use IlBronza\CRUD\Traits\Model\PackagedModelsTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Notetype extends SluggableBaseModel
{
    use PackagedModelsTrait;

    static $packageConfigPrefix = 'notes';
    static $modelConfigPrefix = 'notetype';


    static $deletingRelationships = [];

    static function createByName(string $name) : static
    {
        $notetype = static::make();
        $notetype->name = strtolower($name);

        $notetype->save();

        return $notetype;
    }

	public function notes(): BelongsToMany
    {
        return $this->belongsToMany(Notes::getNoteClass());
    }

    public function getIndexUrl(array $data = [])
    {
        return implode(".", [
            $this->getRouteBasename(),
            'index'
        ]);
    }
}
