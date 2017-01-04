<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewProposesIsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_proposes_i', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('review_propose_id', false, true);
            $table->smallInteger('item', false, true);
            $table->string('aspect');
            $table->smallInteger('quality', false, true);
            $table->tinyInteger('score', false, true);
            $table->text('comment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('review_proposes_i');
    }
}
