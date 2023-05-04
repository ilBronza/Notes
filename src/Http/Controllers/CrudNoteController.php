<?php

namespace IlBronza\Notes\Http\Controllers;

use IlBronza\CRUD\CRUD;
use IlBronza\CRUD\Traits\CRUDCreateStoreTrait;
use IlBronza\CRUD\Traits\CRUDDeleteTrait;
use IlBronza\CRUD\Traits\CRUDDestroyTrait;
use IlBronza\CRUD\Traits\CRUDEditUpdateTrait;
use IlBronza\CRUD\Traits\CRUDIndexTrait;
use IlBronza\CRUD\Traits\CRUDPlainIndexTrait;
use IlBronza\CRUD\Traits\CRUDRelationshipTrait;
use IlBronza\CRUD\Traits\CRUDShowTrait;
use IlBronza\Notes\Facades\Notes;
use IlBronza\Notes\Http\ParametersFiles\NoteParameters;
use IlBronza\Notes\Models\Note;
use Illuminate\Http\Request;

class CrudNoteController extends CRUD
{
    public $parametersFile = NoteParameters::class;

    public $avoidCreateButton = true;

    public $saveAndNew = false;
    public $saveAndRefresh = false;


    public $returnBack = true;

    public function getReturnUrl() : ? string
    {
        if($url = session("ilbronzanoteshttpcontrollerscrudaddnotetomodelcontroller", null))
        {
            session()->forget("ilbronzanoteshttpcontrollerscrudaddnotetomodelcontroller");

            return $url;
        }

        return parent::getReturnUrl();

        // $url = session($classKey, null);
        // session()->forget($classKey);

        // return $url;
    }

    public static $tables = [

        'index' => [
            'fields' => 
            [
                'mySelfEdit' => 'links.edit',
                'mySelfSee' => 'links.see',
                'notes' => 'flat',
                'type' => 'flat',
                'user_id' => 'flat',
                'mySelfDelete' => 'links.delete'
            ]
        ]
    ];

    use CRUDDeleteTrait;
    use CRUDDestroyTrait;

    use CRUDShowTrait;
    use CRUDPlainIndexTrait;
    use CRUDIndexTrait;
    use CRUDEditUpdateTrait;

    use CRUDRelationshipTrait;

    use CRUDCreateStoreTrait;

    use CRUDDeleteTrait;
    use CRUDDestroyTrait;

    public function getRouteBaseNamePieces()
    {
        return [
            config('notes.routePrefix') . 'notes'
        ];
    }

    public function getRouteBaseNamePrefix() : ? string
    {
        return config('notes.routePrefix');
    }

    public function getModelClass() : string
    {
        $this->modelClass = Notes::getNoteClass();

        return $this->modelClass;
    }

    /**
     * http methods allowed. remove non existing methods to get a 403
     **/
    public $allowedMethods = [
        'index',
        'show',
        'edit',
        'update',
        'create',
        'store',
        'destroy',
    ];

    public function getIndexElements()
    {
        return $this->getModelClass()::all();
    }

    /**
     * START base methods declared in extended controller to correctly perform dependency injection
     *
     * these methods are compulsorily needed to execute CRUD base functions
     **/
    public function show(Note $note)
    {
        //$this->addExtraView('top', 'folder.subFolder.viewName', ['some' => $thing]);

        return $this->_show($note);
    }

    public function edit(Note $note)
    {
        return $this->_edit($note);
    }

    public function update(Request $request, Note $note)
    {
        return $this->_update($request, $note);
    }

    public function getDeletedRedirectUrl()
    {
        return url()->previous();
    }

    public function destroy(Note $note)
    {
        return $this->_destroy($note);
    }

    /**
     * END base methods
     **/





}

