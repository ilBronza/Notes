<?php

namespace IlBronza\Notes;

use IlBronza\Buttons\Button;
use IlBronza\CRUD\Providers\RouterProvider\RoutedObjectInterface;
use IlBronza\CRUD\Traits\IlBronzaPackages\IlBronzaPackagesTrait;
use IlBronza\Notes\Models\Notetype;
use IlBronza\Notes\Traits\NotesMenuTrait;
use IlBronza\Notes\Traits\NotesRoutingTrait;
use IlBronza\UikitTemplate\Fetcher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

use function __;

class Notes implements RoutedObjectInterface
{
	use IlBronzaPackagesTrait;

	static $packageConfigPrefix = 'notes';

	use NotesRoutingTrait;
	use NotesMenuTrait;

	static function getNoteClass()
	{
		return config('notes.models.note.class');
	}

	static function getAddNotesForModelButton(Model $model)
	{
		$button = Button::create([
			'href' => static::getRoutedModel($model, 'notes.add'),
			'text' => trans('notes::notes.addNote'),
			'icon' => 'plus'
		]);

		$button->renderIFrame();

		return $button;
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

		foreach ($related as $elements)
			if (class_basename($elements) == 'Collection')
				foreach ($elements as $element)
					$notes->push(
						$element->notes()->with('noteable')->get()
					);

			else if ($elements)
				$notes->push(
					$elements->notes()->with('noteable')->get()
				);

		return $notes->flatten();
	}

	static function getNotesWithRelatedByTypes(Model $model, array $related = [], array $types) : Collection
	{
		$notes = collect();

		if(! $model->relationLoaded('notes'))
			$model->load('notes');

		$notes->push(
			$model->notes->filter(function($note) use($types)
				{
					return in_array($note->type_slug, $types);
				})
		);

		foreach ($related as $elements)
			if (class_basename($elements) == 'Collection')
			{
				foreach ($elements as $element)
				{
					if(! $element->relationLoaded('notes'))
						$element->load('notes.noteable');

					$notes->push(
						$element->notes->filter(function($note) use($types)
							{
								return in_array($note->type_slug, $types);
							})
					);
				}

			}

			else if ($elements)
			{
				if(! $elements->relationLoaded('notes'))
					$elements->load('notes.noteable');

				$notes->push(
					$element->notes->filter(function($note) use($types)
							{
								return in_array($note->type_slug, $types);
							})
				);
			}

		return $notes->flatten();
	}

	static function getNotesNumberWithRelated(Model $model, callable $getRelated) : int
	{
		$result = $model->notes()->count();

		foreach ($getRelated() as $elements)
			if (class_basename($elements) == 'Collection')
				foreach ($elements as $element)
					$result += $element->notes()->count();

			else if ($elements)
				$result += $elements->notes()->count();

		return $result;
	}

	static function getCachedNotesNumberWithRelated(Model $model, callable $getRelated) : int
	{
		return cache()->remember(
			$model->cacheKey('notesCount'), 360000, function () use ($model, $getRelated)
		{
			return static::getNotesNumberWithRelated(
				$model, $getRelated
			);
		}
		);
	}

	static function createFetcherByModel(Model $model = null) : ?Fetcher
	{
		if (! $model)
			return null;

		$fetcher = new Fetcher([
			'title' => __('notes::notes.notesFor', [
				'type' => __('notes.crudModels' . $model->getCamelcaseClassBasename()),
				'name' => $model->getName()
			]),
			'url' => static::getRoutedModel($model, 'notes.by')
		]);

		$fetcher->addButton(
			static::getAddNotesForModelButton($model)
		);

		return $fetcher;
	}

	static function createFlatFetcherByModel(Model $model = null) : ?Fetcher
	{
		if (! $model)
			return null;

		$fetcher = new Fetcher([
			'url' => static::getRoutedModel($model, 'notes.by')
		]);

		$fetcher->addButton(
			static::getAddNotesForModelButton($model)
		);

		return $fetcher;
	}

	static function getFetcher(Model $model = null, ?bool $flat = false)
	{
		if (! $model)
			return;

		if ($flat)
			$fetcher = static::createFlatFetcherByModel($model);
		else
			$fetcher = static::createFetcherByModel($model);

		return $fetcher->renderCard();
	}

	static function getNotetypeByName(string $slug) : Notetype
	{
		if ($notetype = Notetype::where('name', $slug)->first())
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
