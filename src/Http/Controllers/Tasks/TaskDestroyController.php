<?php

namespace IlBronza\Notes\Http\Controllers\Tasks;

use IlBronza\CRUD\Traits\CRUDDeleteTrait;

class TaskDestroyController extends TaskCRUD
{
	use CRUDDeleteTrait;

	public $allowedMethods = ['destroy'];

	public function destroy($task)
	{
		$task = $this->findModel($task);

		return $this->_destroy($task);
	}}
