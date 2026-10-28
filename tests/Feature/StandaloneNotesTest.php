<?php

namespace IlBronza\Notes\Tests\Feature;

use IlBronza\Notes\Models\Note;
use IlBronza\Notes\Tests\TestCase;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

class StandaloneNotesTest extends TestCase
{
    public function test_notes_boots_and_migrates_without_registering_tasks(): void
    {
        $this->assertTrue(Schema::hasTable('ibnotes'));
        $this->assertFalse(Schema::hasTable('notes__tasks'));
        $this->assertFalse(Schema::hasTable('notes__task_participants'));
        $this->assertTrue(Route::has('notesmanagernotes.index'));
        $this->assertFalse(Route::has('notesmanagertasks.index'));
        $this->assertFalse(app()->bound('tasks'));
        $user = $this->actingAsSuperadmin();
        $note = new Note;
        $note->noteable()->associate($user);
        $note->notes = 'Standalone note';
        $note->save();
        $this->assertTrue((bool) $note->userCanSee());
    }

    public function test_unknown_subjects_fail_closed_when_their_package_is_missing(): void
    {
        $this->actingAsSuperadmin();
        $note = new Note;
        $note->noteable_type = 'MissingSubject';
        $note->noteable_id = 'missing';
        $note->notes = 'Private note';
        $note->save();
        $this->assertFalse($note->userCanSee());
        $this->assertFalse($note->userCanUpdate());
        $this->assertFalse($note->userCanDelete());
    }
}
