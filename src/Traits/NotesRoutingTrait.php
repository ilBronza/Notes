<?php

namespace IlBronza\Notes\Traits;

use Illuminate\Database\Eloquent\Model;

trait NotesRoutingTrait
{
    static function route(string $routeName, array $parameters = []) : string
    {
        return route(config('notes.routePrefix') . $routeName, $parameters);
    }

    static function getModelRouteParameters(Model $model) : array
    {
        return [
            'class' => get_class($model),
            'key' => $model->getKey()
        ];
    }

    static function getRoutedModel(Model $model, string $routeName) : string
    {
        return static::route(
            $routeName,
            static::getModelRouteParameters($model)
        );
    }    
}