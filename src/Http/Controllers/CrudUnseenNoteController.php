<?php

namespace IlBronza\Notes\Http\Controllers;

use IlBronza\Notes\Http\Controllers\CrudNoteController;
use Illuminate\Http\Request;

class CrudUnseenNoteController extends CrudNoteController
{
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
                'mySelfSeen' => 'links.seen',
                'mySelfArchive' => 'links.archive',
                'mySelfDelete' => 'links.delete'
            ]
        ]
    ];

    /**
     * http methods allowed. remove non existing methods to get a 403
     **/
    public $allowedMethods = [
        'index',
        'seen'
    ];

    public function getIndexElements()
    {
        return $this->getModelClass()::unseen()->get();
    }

    public function seen(Request $request, $note)
    {
        $note = $this->getModelClass()::withoutGlobalScope(ArchivingScope::class)->find($note);

        $data = $note->seen();

        if($request->ajax())
            return $data;

        return back();
    }
}

