<?php

namespace IlBronza\Notes\Http\Controllers\Tasks;

use IlBronza\CRUD\Traits\CRUDIndexTrait;
use IlBronza\CRUD\Traits\CRUDPlainIndexTrait;

class ClosedTaskIndexController extends TaskIndexController
{
	public function getIndexElements()
	{
		return $this->getModelClass()::closed()->get();
	}

}
