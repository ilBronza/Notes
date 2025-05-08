<?php

namespace IlBronza\Notes\Http\Controllers;
use IlBronza\CRUD\CRUD;

class CRUDNotesPackageController extends CRUD
{
	public function getRouteBaseNamePrefix() : ? string
	{
		return config('notes.routePrefix');
	}

	public function setModelClass()
	{
		$this->modelClass = config("notes.models.{$this->configModelClassName}.class");
	}
}
