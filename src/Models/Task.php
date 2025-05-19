<?php

namespace IlBronza\Notes\Models;

use IlBronza\AccountManager\Models\User;
use IlBronza\CRUD\Models\BaseModel;
use IlBronza\CRUD\Traits\Media\InteractsWithMedia;
use IlBronza\CRUD\Traits\Model\CRUDCreatedByUserTrait;
use IlBronza\CRUD\Traits\Model\CRUDUseUuidTrait;
use IlBronza\CRUD\Traits\Model\PackagedModelsTrait;
use IlBronza\Notes\Traits\InteractsWithNotesTrait;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\HasMedia;

class Task extends BaseModel implements HasMedia
{
	use InteractsWithNotesTrait;
	use CRUDCreatedByUserTrait;
	use InteractsWithMedia;
	use CRUDUseUuidTrait;
	use PackagedModelsTrait;

	use CRUDCreatedByUserTrait;

	static $packageConfigPrefix = 'notes';
	static $modelConfigPrefix = 'task';
	public ?string $translationFolderPrefix = 'notes';
	protected $keyType = 'string';
	protected $deletingRelationships = ['media'];

	protected $casts = [
		'start_date' => 'datetime',
		'end_date' => 'datetime',
		'deleted_at' => 'datetime',
	];

	public function scopeClosed($query)
	{
		$query->where('status', 'closed');
	}

	public function scopeNotClosed($query)
	{
		$query->where('status', '!=', 'closed');
	}

	public function assignee()
	{
		return $this->belongsTo(config('auth.providers.users.model'), 'assignee_user_id');
	}

	public function getPossibleAssignees() : Collection
	{
		return User::gpc()::role('taskAssignee')->get();
	}

	public function getPossibleAssigneeUsersArray() : array
	{
		return $this->getPossibleAssignees()->pluck('name', 'id')->toArray();
	}
}
