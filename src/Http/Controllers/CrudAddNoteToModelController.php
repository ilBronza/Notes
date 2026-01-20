<?php

namespace IlBronza\Notes\Http\Controllers;

use IlBronza\CRUD\Helpers\ModelHelpers\ModelFinderHelper;
use IlBronza\Notes\Facades\Notes;
use IlBronza\Notes\Http\ParametersFiles\NoteParameters;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;

class CrudAddNoteToModelController extends CrudNoteController
{
    public $returnBack = true;

    public $parametersFile = NoteParameters::class;

    public $allowedMethods = [
        'addFor',
        'addBy'
    ];

    public function addBy(Request $request, string $class, string $key)
    {
		$model = ModelFinderHelper::getByClassKey($class, $key);

        $this->setModel($model);

        $this->setReturnUrlToPrevious();

        $subject = $model->getNotesSubject();
        $elements = $model->getNotesRelationships();

        return view('notes::addBy', compact('subject', 'elements', 'model'));
    }

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

