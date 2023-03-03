<?php

namespace IlBronza\Notes\Models;

use IlBronza\AccountManager\Models\User;
use IlBronza\CRUD\Models\BaseModel;
use IlBronza\CRUD\Traits\Media\InteractsWithMedia;
use IlBronza\CRUD\Traits\Model\CRUDCreatedByUserTrait;
use IlBronza\CRUD\Traits\Model\CRUDUseUuidTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\MediaLibrary\HasMedia;

class Note extends BaseModel implements HasMedia
{
    use InteractsWithMedia;
    use CRUDUseUuidTrait;
	/**
	 *  CRUDCreatedByUserTrait 
	 **/
	use CRUDCreatedByUserTrait;

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

    public function getType()
    {
        return $this->type;
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
        return $this->slack;
    }

    public function sendSlackNotification()
    {
        
    }

    public static function boot()
    {
        parent::boot();
        // Will fire everytime an User is created
        static::saved(function ($note) {
            if($note->isDirty('slack') && $note->mustSendSlackNotification())
                $note->sendSlackNotification();

            if($note->isDirty('create_notification') && $note->mustCreateNotification())
                $note->createkNotification();
        });
    }

}
