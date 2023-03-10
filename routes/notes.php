<?php

use IlBronza\Notes\Http\Controllers\CrudAddNoteToModelController;
use IlBronza\Notes\Http\Controllers\CrudNoteByModelController;
use IlBronza\Notes\Http\Controllers\CrudNoteController;
use IlBronza\Notes\Http\Controllers\CrudNotetypeController;

Route::group([
	'middleware' => ['web', 'auth'],
	'prefix' => 'notes-management',
	'as' => config('notes.routePrefix')
	],
	function()
	{
		Route::resource('notetypes', CrudNotetypeController::class);
		Route::resource('notes', CrudNoteController::class);

		Route::get('delete-media/{note}/{media}', [CrudNoteController::class, 'delete'])->name('notes.deleteMedia');

		Route::get('notes-by/{class}/{key}', [CrudNoteByModelController::class, 'notesBy'])->name('notes.by');

		Route::get('notes-add-by/{class}/{key}', [CrudAddNoteToModelController::class, 'addBy'])->name('notes.addBy');

		Route::get('notes-add-for/{class}/{key}', [CrudAddNoteToModelController::class, 'addFor'])->name('notes.add');
		Route::post('notes-add-for/{class}/{key}', [CrudAddNoteToModelController::class, 'addFor'])->name('notes.addFor');
	});



