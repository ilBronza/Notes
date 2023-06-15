<?php

namespace IlBronza\Notes\Http\Controllers;

use IlBronza\Buttons\Button;
use IlBronza\CRUD\CRUD;
use IlBronza\CRUD\Traits\CRUDArchiveTrait;
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
    public $rowSelectCheckboxes = true;
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
                'imported' => 'boolean',
                'created_at' => [
                    'type' => 'dates.datetime',
                    'order' => [
                        'priority' => 10,
                        'type' => 'DESC'
                    ]
                ],
                'mySelfEdit' => 'links.edit',
                'mySelfSee' => 'links.see',
                'user_id' => 'users.name',
                'noteable_type' => 'flat',
                'notes' => [
                    'type' => 'flat',
                    'width' => '650px'
                ],
                'slack' => 'boolean',
                'create_notification' => 'boolean',
                'type_slug' => 'flat',
                'mySelfArchive' => 'links.archive',
                'mySelfDelete' => 'links.delete'
            ]
        ],

        'related' => [
            'fields' => 
            [
                'imported' => 'boolean',
                'created_at' => [
                    'type' => 'dates.datetime',
                    'order' => [
                        'priority' => 10,
                        'type' => 'DESC'
                    ]
                ],
                'mySelfEdit' => 'links.edit',
                'mySelfSee' => 'links.see',
                'user_id' => 'users.name',
                'noteable_type' => 'flat',
                'notes' => [
                    'type' => 'flat',
                    'width' => '650px'
                ],
                'slack' => 'boolean',
                'create_notification' => 'boolean',
                'type_slug' => 'flat',
                'mySelfArchive' => 'links.archive',
                'mySelfDelete' => 'links.delete'
            ]
        ],

        'archived' => [
            'fields' => 
            [
                'imported' => 'boolean',
                'created_at' => [
                    'type' => 'dates.datetime',
                    'order' => [
                        'priority' => 10,
                        'type' => 'DESC'
                    ]
                ],
                'archived_at' => 'dates.datetime',
                'mySelfEdit' => 'links.edit',
                'mySelfSee' => 'links.see',
                'user_id' => 'users.name',
                'noteable_type' => 'flat',
                'notes' => [
                    'type' => 'flat',
                    'width' => '650px'
                ],
                'slack' => 'boolean',
                'create_notification' => 'boolean',
                'type_slug' => 'flat',
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

    use CRUDArchiveTrait;

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

    public function addArchiveBulkButton()
    {
        $button = Button::create([
            'href' => Note::getArchiveBulkUrl(),
            'text' => 'notes.archive',
            'icon' => 'archive'
        ]);

        $button->setAjaxTableButton();

        $this->table->addButton($button);        
    }

    public function addIndexButtons()
    {
        $this->addArchiveBulkButton();
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
        'archive',
        'archiveBulk',
        'archived'
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

    public function archiveBulk(Request $request)
    {
        $request->validate([
            'ids' => 'array|required',
            'ids.*' => 'string|exists:ibnotes,id'
        ]);

        $notes = Note::whereIn('id', $request->ids)->get();

        foreach($notes as $note)
            $note->archive();

        $updateParameters = [];
        $updateParameters['success'] = true;
        $updateParameters['action'] = 'reloadTable';

        return $updateParameters;
    }

    public function archive(Request $request, Note $note)
    {
        $data = $this->_archive($request, $note);

        if($request->ajax())
            return $data;

        return back();
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

