<?php

namespace IlBronza\Notes\Http\Controllers\Crons;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use IlBronza\Notes\Models\Note;

class EmptyNoteCleanerController extends Controller
{
    public function execute()
    {
        $notes = Note::whereNull('notes')
                    ->doesntHave('media')
                    ->where('created_at', '<', Carbon::now()->subHours(1))
                    ->get();

        foreach($notes as $note)
            $note->delete();

        return true;
    }
}