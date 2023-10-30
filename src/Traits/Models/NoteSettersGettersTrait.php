<?php

namespace IlBronza\Notes\Traits\Models;


trait NoteSettersGettersTrait
{
	public function setTypeSlug(string $typeSlug = null, bool $save = false)
	{
		return $this->_customSetter('type_slug', $typeSlug, $save);
	}

	public function setCreateNotification(bool $createNotification = null, bool $save = false)
	{		
		return $this->_customSetter('create_notification', $createNotification, $save);
	}

	public function setNotes(string $notes = null, bool $save = false)
	{
		return $this->_customSetter('notes', $notes, $save);
	}

	public function setSlack(bool $slack = null, bool $save = false)
	{
		return $this->_customSetter('slack', $slack, $save);
	}	
}