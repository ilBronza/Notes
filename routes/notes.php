<?php

use IlBronza\Notes\Facades\Notes;
use IlBronza\Notes\Http\Controllers\CrudNoteByModelController;
use IlBronza\Notes\Http\Controllers\CrudNoteController;
use IlBronza\Notes\Http\Controllers\CrudNotetypeController;
use IlBronza\Notes\Http\Controllers\CrudUnseenNoteController;

use IlBronza\Notes\Http\Controllers\Tasks\TaskCreateStoreController;
use IlBronza\Notes\Http\Controllers\Tasks\TaskDestroyController;
use IlBronza\Notes\Http\Controllers\Tasks\TaskEditUpdateController;
use IlBronza\Notes\Http\Controllers\Tasks\TaskIndexController;
use IlBronza\Vehicles\Vehicles;

Route::group([
	'middleware' => ['web', 'auth'],
	'prefix' => 'notes-management',
	'as' => config('notes.routePrefix'),
	'routeTranslationPrefix' => 'notes::routes.'	
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


		Route::get('notes-add-by/{class}/{key}', [Notes::getController('note', 'addNote'), 'addBy'])->name('notes.addBy');
		Route::get('notes-add-for/{class}/{key}', [Notes::getController('note', 'addNote'), 'addFor'])->name('notes.add');
		Route::post('notes-add-for/{class}/{key}', [Notes::getController('note', 'addNote'), 'addFor'])->name('notes.addFor');
	});



Route::group([
	'middleware' => ['web', 'auth'],
	'prefix' => 'tasks-management',
	'as' => config('notes.routePrefixTasks'),
	'routeTranslationPrefix' => 'notes::routes.'
],
	function()
	{
		Route::get('', [TaskIndexController::class, 'index'])->name('index');
		Route::post('', [TaskCreateStoreController::class, 'store'])->name('store');
		Route::get('create', [TaskCreateStoreController::class, 'create'])->name('create');
		Route::get('{task}/edit', [TaskEditUpdateController::class, 'edit'])->name('edit');
		Route::put('{task}', [TaskEditUpdateController::class, 'update'])->name('update');


		Route::delete('{task}/delete', [TaskDestroyController::class, 'destroy'])->name('destroy');
	});







// Route::get('create', [Vehicles::getController('type', 'create'), 'create'])->name('types.create');
// Route::post('', [Vehicles::getController('type', 'store'), 'store'])->name('types.store');
// Route::get('{type}', [Vehicles::getController('type', 'show'), 'show'])->name('types.show');
// Route::get('{type}/edit', [Vehicles::getController('type', 'edit'), 'edit'])->name('types.edit');
// Route::put('{type}', [Vehicles::getController('type', 'edit'), 'update'])->name('types.update');

// Route::delete('{type}/delete', [Vehicles::getController('type', 'destroy'), 'destroy'])->name('types.destroy');
