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
            $table->smallInteger('years', false, true);
            $table->integer('dedication_type', false, true);
            $table->string('scheme');
            $table->string('sponsor');
            $table->smallInteger('member', false, true);
            $table->text('annotation');
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
