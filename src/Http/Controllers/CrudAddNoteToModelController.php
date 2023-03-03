<?php

namespace IlBronza\Notes\Http\Controllers;

use IlBronza\Notes\Facades\Notes;
use IlBronza\Notes\Http\ParametersFiles\NoteParameters;
use Illuminate\Http\Request;

class CrudAddNoteToModelController extends CrudNoteController
{
    public $parametersFile = NoteParameters::class;

    public $allowedMethods = [
        'addFor',
    ];

    public function addFor(Request $request, string $class, string $key)
    {
        $this->setModel(
            Notes::makeNoteByMorphData($type = $class, $id = $key)
        );

        return redirect(
            $this->getModel()->getEditUrl()
        );
    }
}

