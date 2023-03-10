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

use IlBronza\Notes\Http\ParametersFiles\NotetypeParameters;
use IlBronza\Notes\Models\Notetype;

use Illuminate\Http\Request;

class CrudNotetypeController extends CRUD
{
    public $parametersFile = NotetypeParameters::class;

    public static $tables = [

        'index' => [
            'fields' => 
            [
                'mySelfEdit' => 'links.edit',
                'mySelfSee' => 'links.see',
                'slug' => 'flat',
                'name' => 'flat',
                'description' => 'flat',
                'mySelfDelete' => 'links.delete'
            ]
        ]
    ];

	public function getRouteBaseNamePieces()
	{
		return [
			config('notes.routePrefix') . 'notetypes'
		];
	}    

    public $showMethodRelationships = [];

    use CRUDShowTrait;
    use CRUDPlainIndexTrait;
    use CRUDIndexTrait;
    use CRUDEditUpdateTrait;

    use CRUDCreateStoreTrait;

    use CRUDDeleteTrait;
    use CRUDDestroyTrait;
    use CRUDRelationshipTrait;

    public function getModelClass() : string
    {
        $this->modelClass = config('notes.types.class');

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
    public function show(Notetype $notetype)
    {
        //$this->addExtraView('top', 'folder.subFolder.viewName', ['some' => $thing]);

        return $this->_show($notetype);
    }

    public function edit(Notetype $notetype)
    {
        return $this->_edit($notetype);
    }

    public function update(Request $request, Notetype $notetype)
    {
        return $this->_update($request, $notetype);
    }

    public function destroy(Notetype $notetype)
    {
        return $this->_destroy($notetype);
    }

    /**
     * END base methods
     **/





}

