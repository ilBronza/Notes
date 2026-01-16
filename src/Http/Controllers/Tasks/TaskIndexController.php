<?php

namespace IlBronza\Notes\Http\Controllers\Tasks;

use IlBronza\CRUD\Traits\CRUDIndexTrait;
use IlBronza\CRUD\Traits\CRUDPlainIndexTrait;

class TaskIndexController extends TaskCRUD
{
	use CRUDPlainIndexTrait;
	use CRUDIndexTrait;

	public $allowedMethods = ['index'];

	public function getIndexFieldsArray()
	{
		//TaskFieldsGroupParametersFile
		return config('notes.models.task.fieldsGroupsFiles.index')::getFieldsGroup();
	}

	public function getIndexElements()
	{
		return $this->getModelClass()::notClosed()->get();
	}

}
