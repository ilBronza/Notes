<?php

namespace IlBronza\Notes\Models;

use App\Models\User;
use IlBronza\CRUD\Models\BaseModel;
use IlBronza\CRUD\Traits\Media\InteractsWithMedia;
use IlBronza\CRUD\Traits\Model\CRUDCreatedByUserTrait;
use IlBronza\CRUD\Traits\Model\CRUDUseUuidTrait;
use IlBronza\Notes\Notifications\NoteNotification;
use IlBronza\Notifications\Facades\Notification as IbNotificationFacade;
use IlBronza\Notifications\Notification as IbNotification;
use IlBronza\Notifications\Notifications\SlackNotification;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Notification;
use Spatie\MediaLibrary\HasMedia;

class Note extends BaseModel implements HasMedia
{
    use InteractsWithMedia;
    use CRUDUseUuidTrait;
	/**
	 *  CRUDCreatedByUserTrait 
	 **/
	use CRUDCreatedByUserTrait;

    protected $deletingRelationships = ['media'];

    protected $fillable = [
        'noteable_type',
        'noteable_id',
    ];

    public function getTable()
    {
    	return config('notes.table');
    }

	public function noteable(): MorphTo
    {
        return $this->morphTo();
    }

    public function type() : BelongsTo
    {
        return $this->belongsTo(Notetype::class);
    }

    public function getText()
    {
        return $this->notes;
    }

    public function getType() : ? Notetype
    {
        return $this->type;
    }

    public function getTypeSlug() : ? string
    {
        return $this->getType()?->getKey();
    }

    public function getTypeName()
    {
        return $this->getType()?->getName();        
    }

    public function getImages()
    {
        return $this->media;
    }

    public function getLastCompilationDate()
    {
        return $this->updated_at->format(__('dates.humanShort'));
    }

    public function getUserName() : string
    {
        if($user = $this->getUser())
            return $user->getName();

        return __('notes::notes.unknownUser');
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getUser() : ? User
    {
        if(! $userKey = $this->getUserId())
            return null;

        return app('accountmanager')->getCachedUserById(
            $this->getUserId($userKey)
        );
    }

    public function mustSendSlackNotification() : bool
    {
        return !! $this->slack;
    }

    public function mustCreateNotification() : bool
    {
        return !! $this->create_notification;
    }

    public function getTypeWebhookName() : string
    {
        return 'notes.slack.webhooks.' . $this->getTypeSlug();
    }

    public function existsTypeWebhook() : bool
    {
        return !! config(
            $this->getTypeWebhookName(),
            false
        );
    }

    public function getSlackWebhook() : string
    {
        return config(
            $this->getTypeWebhookName(),
            config('notes.slack.webhooks.default')
        );
    }

    public function getMessageTypePrefix() : ? string
    {
        if(! ($type = $this->getType()))
            return null;

        if($this->existsTypeWebhook())
            return null;

        return $type->getName() . ":: ";
    }

    public function sendSlackNotification()
    {
        Notification::route(
            'slack',
            $this->getSlackWebhook()
        )
        ->notify(new SlackNotification(
            $this->getMessageTypePrefix() . $this->getText()
        )); 
    }

    public function createNotification()
    {
        IbNotification::roles('administrator')
            ->users(
                User::inRandomOrder()->take(5)->get()
            )
            ->notification(
                new NoteNotification(
                    $this
                )
            )
            ->send();
    }

    public static function boot()
    {
        parent::boot();

        static::saving(function ($note)
        {
            if($note->isDirty('slack') && $note->mustSendSlackNotification())
                $note->sendSlackNotification();

            if($note->isDirty('create_notification') && $note->mustCreateNotification())
                $note->createNotification();
        });
    }

    public function getEditUrl(array $data = [])
    {
        return route(config('notes.routePrefix') . 'notes.edit', [$this]);
    }

    public function getDeleteUrl(array $data = [])
    {
        return route(config('notes.routePrefix') . 'notes.destroy', [$this]);
    }

    public function scopeByTypes($query, array $types)
    {
        return $query->whereIn('type_slug', $types);
    }

    public function canBeDeleted()
    {
        return true;
    }

    public function getDeleteButton()
    {
        return '<form method="POST" onSubmit="if(! confirm(\'Sei sicuro?\')){return false;}" action="' . $this->getDeleteUrl() . '">' . csrf_field() . ' ' . method_field('DELETE') . '<button class="uk-button uk-button-small" type="submit"><i class="fa-solid fa-trash"></i></button></form>';
    }
}
