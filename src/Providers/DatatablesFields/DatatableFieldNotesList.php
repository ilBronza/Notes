<?php

namespace IlBronza\Notes\Providers\DatatablesFields;

use IlBronza\Datatables\DatatablesFields\Links\DatatableFieldLightbox;

class DatatableFieldNotesList extends DatatableFieldLightbox
{
	public $method = 'getNotesListUrl';
	public $faIcon = 'clipboard';
}