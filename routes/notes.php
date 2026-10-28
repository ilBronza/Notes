<?php

use IlBronza\Notes\Facades\Notes;
use IlBronza\Notes\Http\Controllers\CrudNoteByModelController;
use IlBronza\Notes\Http\Controllers\CrudNoteController;
use IlBronza\Notes\Http\Controllers\CrudNotetypeController;
use IlBronza\Notes\Http\Controllers\CrudUnseenNoteController;

Route::group([
	'middleware' => ['web', 'auth', 'notes.roles'],
	'prefix' => 'notes-management',
	'as' => config('notes.routePrefix'),
	'routeTranslationPrefix' => Notes::getRouteTranslationPrefix()	
	],
	function()
	{
		Route::resource('notetypes', CrudNotetypeController::class);
		Route::resource('notes', CrudNoteController::class);

		Route::post('archive-bulk', [CrudNoteController::class, 'archiveBulk'])->name('notes.archiveBulk');

		Route::get('unseen-notes', [CrudUnseenNoteController::class, 'index'])->name('notes.unseen');

		Route::post('see-bulk', [CrudUnseenNoteController::class, 'seeBulk'])->name('notes.seeBulk');

		Route::post('notes/{note}/seen', [CrudUnseenNoteController::class, 'seen'])->name('notes.seen');

		Route::match(['get', 'post', 'patch', 'delete'], 'delete-media/{note}/{media}', [CrudNoteController::class, 'deleteMedia'])->name('notes.deleteMedia');

		Route::get('notes-by/{class}/{key}', [CrudNoteByModelController::class, 'notesBy'])->name('notes.by');


		Route::get('notes-add-by/{class}/{key}', [Notes::getController('note', 'addNote'), 'addBy'])->name('notes.addBy');
		Route::get('notes-add-for/{class}/{key}', [Notes::getController('note', 'addNote'), 'addFor'])->name('notes.add');
		Route::post('notes-add-for/{class}/{key}', [Notes::getController('note', 'addNote'), 'addFor'])->name('notes.addFor');
	});
