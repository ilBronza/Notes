<?php

namespace IlBronza\Notes\Models;

use App\Models\User;
use Auth;
use Carbon\Carbon;
use IlBronza\CRUD\Models\BaseModel;
use IlBronza\CRUD\Traits\Media\InteractsWithMedia;
use IlBronza\CRUD\Traits\Model\CRUDArchiverTrait;
use IlBronza\CRUD\Traits\Model\CRUDCreatedByUserTrait;
use IlBronza\CRUD\Traits\Model\CRUDUseUuidTrait;
use IlBronza\CRUD\Traits\Model\PackagedModelsTrait;
use IlBronza\Notes\Notifications\NoteNotification;
use IlBronza\Notes\Traits\Models\NoteSettersGettersTrait;
use IlBronza\Notifications\Notification as IbNotification;
use IlBronza\Notifications\Notifications\SlackNotification;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Notification;
use Spatie\MediaLibrary\HasMedia;

class Note extends BaseModel implements HasMedia
{
	use PackagedModelsTrait;

	static $packageConfigPrefix = 'notes';
	static $modelConfigPrefix = 'note';

	public ?string $translationFolderPrefix = 'notes';

	use CRUDArchiverTrait;
	use InteractsWithMedia;
	use CRUDUseUuidTrait;

	protected $keyType = 'string';
	/**
	 *  CRUDCreatedByUserTrait
	 **/
	use CRUDCreatedByUserTrait;

	use NoteSettersGettersTrait;

	protected $deletingRelationships = ['media'];

	protected $fillable = [
		'noteable_type',
		'noteable_id',
	];

	// public function getTable() : string
	// {
	// 	return config('notes.models.notes.table');
	// }

	public static function boot()
	{
		parent::boot();

		static::saving(function ($note)
		{
			if ($note->isDirty('slack') && $note->mustSendSlackNotification())
				$note->sendSlackNotification();

			if ($note->isDirty('create_notification') && $note->mustCreateNotification())
				$note->createNotification();
		});
	}

	public function mustSendSlackNotification() : bool
	{
		if (! config('notes.channels.slack'))
			return false;

		return ! ! $this->slack;
	}

	public function sendSlackNotification()
	{
		Notification::route(
			'slack', $this->getSlackWebhook()
		)->notify(
			new SlackNotification(
				$this->getMessageTypePrefix() . $this->getText()
			)
		);
	}

	public function getSlackWebhook() : string
	{
		return config(
			$this->getTypeWebhookName(), config('notes.slack.webhooks.default')
		);
	}

	public function getTypeWebhookName() : string
	{
		return 'notes.slack.webhooks.' . $this->getTypeSlug();
	}

	public function getTypeSlug() : ?string
	{
		return $this->getType()?->getKey();
	}

	public function getMessageTypePrefix() : ?string
	{
		if (! ($type = $this->getType()))
			return null;

		if ($this->existsTypeWebhook())
			return null;

		return $type->getName() . ":: ";
	}

	public function existsTypeWebhook() : bool
	{
		return ! ! config(
			$this->getTypeWebhookName(), false
		);
	}

	public function getText()
	{
		return $this->notes;
	}

	public function mustCreateNotification() : bool
	{
		return ! ! $this->create_notification;
	}

	public function createNotification()
	{
		IbNotification::roles('administrator')->users(
			User::inRandomOrder()->take(5)->get()
		)->notification(
			new NoteNotification(
				$this
			)
		)->send();
	}

	static function getSeeBulkUrl()
	{
		return route(config('notes.routePrefix') . 'notes.seeBulk');
	}

	static function getArchiveBulkUrl()
	{
		return route(config('notes.routePrefix') . 'notes.archiveBulk');
	}

	public function noteable() : MorphTo
	{
		return $this->morphTo();
	}

	public function type() : BelongsTo
	{
		return $this->belongsTo(Notetype::class);
	}

	public function getTypeName()
	{
		return $this->getType()?->getName();
	}

	public function getType() : ?Notetype
	{
		return $this->type;
	}

	public function getImages()
	{
		return $this->media;
	}

	public function getShowUrl(array $data = [])
	{
		return route(config('notes.routePrefix') . 'notes.show', [$this]);
	}

	public function getEditUrl(array $data = [])
	{
		return route(config('notes.routePrefix') . 'notes.edit', [$this]);
	}

	public function getSeenUrl(array $data = [])
	{
		return route(config('notes.routePrefix') . 'notes.seen', [$this]);
	}

	public function scopeByTypes($query, array $types)
	{
		return $query->whereIn('type_slug', $types);
	}

	public function scopeUnseen($query)
	{
		return $query->whereNull('seen_at');
	}

	public function canBeDeleted()
	{
		return true;
	}

	public function canBeArchived()
	{
		return true;
	}

	public function getDeleteButton()
	{
		return '<form method="POST" action="' . $this->getDeleteUrl() . '">' . csrf_field() . ' ' . method_field('DELETE') . '<button class="uk-button uk-button-small" type="submit"><i class="fa-solid fa-trash"></i></button></form>';
	}

	public function getDeleteUrl(array $data = [])
	{
		return route(config('notes.routePrefix') . 'notes.destroy', [$this]);
	}

	public function getArchiveButton()
	{
		return '<form method="POST" onSubmit="return confirm(\'Sei sicuro?\');" action="' . $this->getArchiveUrl() . '">' . csrf_field() . ' ' . method_field('PUT') . '<button class="uk-button uk-button-small" type="submit"><i class="fa-solid fa-archive"></i></button></form>';
	}

	public function getArchiveUrl(array $data = [])
	{
		return route(config('notes.routePrefix') . 'notes.archive', [$this]);
	}

	public function seen()
	{
		$this->seen_at = Carbon::now();

		if (array_key_exists('seen_by', $this->attributes))
			$this->seen_by = Auth::id();

		$this->save();
	}

	public function getWholeString()
	{
		return "{$this->getType()?->getName()} - {$this->getUserName()}: {$this->getLastCompilationDate()} -> {$this->getText()}";
	}

	public function getUserName() : string
	{
		if ($user = $this->getUser())
			return $user->getName();

		return __('notes::notes.unknownUser');
	}

	public function getUser() : ?User
	{
		if (! $userKey = $this->getUserId())
			return null;

		return app('accountmanager')->getCachedUserById(
			$this->getUserId($userKey)
		);
	}

	public function getUserId()
	{
		return $this->user_id;
	}

	public function getLastCompilationDate()
	{
		return $this->updated_at->format(__('crud::dates.humanShort'));
	}
}
