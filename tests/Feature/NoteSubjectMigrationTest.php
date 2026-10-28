<?php

namespace IlBronza\Notes\Tests\Feature;

use IlBronza\Notes\Tests\TestCase;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class NoteSubjectMigrationTest extends TestCase
{
	protected function defineDatabaseMigrations()
	{
		Schema::create('users', function (Blueprint $table) {
			$table->id();
		});
		Schema::create(config('notes.models.note.table'), function (Blueprint $table) {
			$table->uuid('id')->primary();
			$table->nullableMorphs('noteable');
			$table->text('notes')->nullable();
		});
	}

	public function test_uuid_migration_preserves_null_and_numeric_subjects() : void
	{
		$table = config('notes.models.note.table');
		$unassignedNote = (string) Str::uuid();
		$numericNote = (string) Str::uuid();
		$zeroNote = (string) Str::uuid();
		DB::table($table)->insert([
			['id' => $unassignedNote, 'noteable_type' => null, 'noteable_id' => null, 'notes' => 'Unassigned'],
			['id' => $numericNote, 'noteable_type' => 'LegacyModel', 'noteable_id' => 42, 'notes' => 'Numeric subject'],
			['id' => $zeroNote, 'noteable_type' => 'LegacyModel', 'noteable_id' => 0, 'notes' => 'Zero subject'],
		]);

		$migration = require __DIR__ . '/../../database/migrations/2026_10_14_160000_support_uuid_note_subjects.php';
		$migration->up();

		$this->assertDatabaseHas($table, ['id' => $unassignedNote, 'noteable_id' => null, 'notes' => 'Unassigned']);
		$this->assertSame('42', DB::table($table)->where('id', $numericNote)->value('noteable_id'));
		$this->assertSame('0', DB::table($table)->where('id', $zeroNote)->value('noteable_id'));
		$this->assertDatabaseHas($table, ['id' => $numericNote, 'conversation_visibility' => 'internal', 'conversation_order' => null]);

		$taskId = (string) Str::uuid();
		DB::table($table)->insert(['id' => (string) Str::uuid(), 'noteable_type' => 'Task', 'noteable_id' => $taskId]);
		$this->assertDatabaseHas($table, ['noteable_type' => 'Task', 'noteable_id' => $taskId]);
	}
}
