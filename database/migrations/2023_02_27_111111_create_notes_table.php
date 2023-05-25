<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('notes.table'), function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->morphs('noteable');

            $table->text('notes')->nullable();
            
            $table->string('type_slug', 16)->nullable();
            $table->foreign('type_slug')->references('slug')->on(config('notes.types.table'));

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');

            $table->boolean('slack')->nullable();
            $table->boolean('create_notification')->nullable();

            $table->timestamp('archived_at')->nullable();

            $table->unsignedBigInteger('archived_by')->nullable();
            $table->foreign('archived_by')->references('id')->on('users');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('notes.table'));
    }
}
