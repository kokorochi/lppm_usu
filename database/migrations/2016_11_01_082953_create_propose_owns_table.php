<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProposeOwnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposes_own', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('propose_id', false, true);
            $table->smallInteger('years', false, true)->nullable();
            $table->integer('dedication_type', false, true)->nullable();
            $table->string('scheme')->nullable();
            $table->string('sponsor')->nullable();
            $table->smallInteger('member', false, true)->nullable();
            $table->text('annotation')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proposes_own');
    }
}
