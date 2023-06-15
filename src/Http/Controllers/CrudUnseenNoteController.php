<?php

namespace IlBronza\Notes\Http\Controllers;

use IlBronza\Buttons\Button;
use IlBronza\Notes\Http\Controllers\CrudNoteController;
use IlBronza\Notes\Models\Note;
use Illuminate\Http\Request;

class CrudUnseenNoteController extends CrudNoteController
{
    public static $tables = [

        'index' => [
            'fields' => 
            [
                'mySelfPrimary' => 'primary',
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
        'seen',
        'seeBulk'
    ];

    public function addDSeeBulkButton()
    {
        $button = Button::create([
            'href' => Note::getSeeBulkUrl(),
            'text' => 'notes.see',
            'icon' => 'eye'
        ]);

        $button->setAjaxTableButton();

        $this->table->addButton($button);        
    }

    public function addIndexButtons()
    {
        $this->addDSeeBulkButton();
        $this->addArchiveBulkButton();
    }

    public function getIndexElements()
    {
        return $this->getModelClass()::unseen()->get();
    }

    public function seen(Request $request, $note)
    {
        $note = $this->getModelClass()::withoutGlobalScope(ArchivingScope::class)->find($note);

        $note->seen();

        if($request->ajax())
            return [
                'success' => true,
                'action' => 'removeRow'
            ];

        return back();
    }

    public function seeBulk(Request $request)
    {
        $request->validate([
            'ids' => 'array|required',
            'ids.*' => 'string|exists:ibnotes,id'
        ]);

        $notes = Note::whereIn('id', $request->ids)->get();

        foreach($notes as $note)
            $note->seen();

        $updateParameters = [];
        $updateParameters['success'] = true;
        $updateParameters['action'] = 'reloadTable';

        return $updateParameters;
    }

}

