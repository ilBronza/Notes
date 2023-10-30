<?php

namespace IlBronza\Notes\Http\Controllers;

use IlBronza\Notes\Facades\Notes;
use IlBronza\Notes\Http\ParametersFiles\NoteParameters;
use Illuminate\Http\Request;

class CrudNoteByModelController extends CrudNoteController
{
    public $parametersFile = NoteParameters::class;

    public $allowedMethods = [
        'notesBy',
    ];

    public function notesBy(Request $request, string $class, string $key)
    {
        $notes = Notes::getNoteClass()::where([
            'noteable_type' => $class,
            'noteable_id' => $key
        ])->with('media')->get();

        return view('notes::_table', compact('notes', 'key'))->render();
    }
}

