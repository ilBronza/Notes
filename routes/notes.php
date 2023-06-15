<?php

use IlBronza\Notes\Http\Controllers\CrudNoteByModelController;
use IlBronza\Notes\Http\Controllers\CrudNoteController;
use IlBronza\Notes\Http\Controllers\CrudNotetypeController;
use IlBronza\Notes\Http\Controllers\CrudUnseenNoteController;

Route::group([
	'middleware' => ['web', 'auth'],
	'prefix' => 'notes-management',
	'as' => config('notes.routePrefix')
	],
	function()
	{
		Route::resource('notetypes', CrudNotetypeController::class);
		Route::resource('notes', CrudNoteController::class);

		Route::post('archive-bulk', [CrudNoteController::class, 'archiveBulk'])->name('notes.archiveBulk');

		Route::get('unseen-notes', [CrudUnseenNoteController::class, 'index'])->name('notes.unseen');

		Route::post('see-bulk', [CrudUnseenNoteController::class, 'seeBulk'])->name('notes.seeBulk');

		Route::post('notes/{note}/seen', [CrudUnseenNoteController::class, 'seen'])->name('notes.seen');

		Route::get('delete-media/{note}/{media}', [CrudNoteController::class, 'delete'])->name('notes.deleteMedia');

		Route::get('notes-by/{class}/{key}', [CrudNoteByModelController::class, 'notesBy'])->name('notes.by');

		Route::get('notes-add-by/{class}/{key}', [config('notes.controllers.addNoteController'), 'addBy'])->name('notes.addBy');

		Route::get('notes-add-for/{class}/{key}', [config('notes.controllers.addNoteController'), 'addFor'])->name('notes.add');
		Route::post('notes-add-for/{class}/{key}', [config('notes.controllers.addNoteController'), 'addFor'])->name('notes.addFor');
	});



