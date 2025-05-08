<?php

namespace IlBronza\Notes\Models;

use IlBronza\CRUD\Models\BaseModel;
use IlBronza\CRUD\Traits\Media\InteractsWithMedia;
use IlBronza\CRUD\Traits\Model\CRUDCreatedByUserTrait;
use IlBronza\CRUD\Traits\Model\CRUDUseUuidTrait;
use IlBronza\CRUD\Traits\Model\PackagedModelsTrait;
use Spatie\MediaLibrary\HasMedia;

class Task extends BaseModel implements HasMedia
{
	use CRUDCreatedByUserTrait;
	use InteractsWithMedia;
	use CRUDUseUuidTrait;
	use PackagedModelsTrait;

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
}
