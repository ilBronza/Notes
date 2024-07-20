<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMeaningTypeToIbnotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('notes.models.notetype.table'), function (Blueprint $table) {
            $table->string('meaning', 1024)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('notes.models.notetype.table'), function (Blueprint $table) {
            $table->dropColumn('meaning');
        });
    }
}
