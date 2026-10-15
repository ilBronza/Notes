<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up() : void
	{
		// Notes can belong to integer-keyed models as well as UUID-keyed tasks.
		Schema::table(config('notes.models.note.table'), function (Blueprint $table) {
			// Existing notes may have no subject; preserve their NULL references.
			$table->string('noteable_id', 191)->nullable()->change();
			$table->string('conversation_visibility', 16)->default('internal');
			$table->unsignedBigInteger('conversation_order')->nullable();
		});

		Schema::create(config('notes.conversation.participantsTable'), function (Blueprint $table) {
			$table->uuid('task_id');
			$table->unsignedBigInteger('user_id');
			$table->timestamps();
			$table->primary(['task_id', 'user_id']);
			$table->foreign('task_id')->references('id')->on(config('notes.models.task.table'))->cascadeOnDelete();
			$table->foreign('user_id')->references('id')->on((new (config('auth.providers.users.model')))->getTable())->cascadeOnDelete();
		});
	}

	public function down() : void
	{
		Schema::dropIfExists(config('notes.conversation.participantsTable'));
		Schema::table(config('notes.models.note.table'), function (Blueprint $table) {
			$table->dropColumn(['conversation_visibility', 'conversation_order']);
		});
		// Keep string keys: converting UUIDs back to integers would destroy references.
	}
};
