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

	static $packageConfigPrefix = 'notes';
	static $modelConfigPrefix = 'task';
	static $nameField = 'title';
	public ?string $translationFolderPrefix = 'notes';
	protected $keyType = 'string';
	static $deletingRelationships = ['media'];

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
		return $query->where(function ($query) {
			$query->where('status', '!=', 'closed')->orWhereNull('status');
		});
	}

	public static function getWorkflowStatuses() : array
	{
		return [
			'open' => __('notes::tasks.statuses.open'),
			'in_progress' => __('notes::tasks.statuses.in_progress'),
			'not_manageable' => __('notes::tasks.statuses.not_manageable'),
			'closed' => __('notes::tasks.statuses.closed'),
		];
	}

	public function userCanComment($user = null) : bool
	{
		return (bool) $this->userCanSee($user);
	}

	public static function isTaskStaff($user = null) : bool
	{
		$user = $user ?? auth()->user();
		$roles = config('notes.conversation.staffRoles', config('notes.defaultRoles', []));

		return $user && $user->hasAnyRole(is_array($roles) ? $roles : explode('|', $roles));
	}

	public function participants()
	{
		return $this->belongsToMany(
			config('auth.providers.users.model'), config('notes.conversation.participantsTable'), 'task_id', 'user_id'
		)->withTimestamps();
	}

	public function userCanSee(?User $user = null)
	{
		$user = $user ?? auth()->user();
		if (!$user)
			return false;

		if (static::isTaskStaff($user))
			return parent::userCanSee($user);

		return $this->participants()->whereKey($user->getKey())->exists();
	}

	public function userCanUpdate(?User $user = null)
	{
		$user = $user ?? auth()->user();

		return static::isTaskStaff($user) && parent::userCanUpdate($user);
	}

	public function userCanDelete(?User $user = null)
	{
		$user = $user ?? auth()->user();

		return static::isTaskStaff($user) && parent::userCanDelete($user);
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
