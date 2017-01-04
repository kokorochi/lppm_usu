<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewProposesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_proposes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('propose_id', false, true);
            $table->string('nidn', 30);
            $table->text('suggestion');
            $table->integer('conclusion_id', false, true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('review_proposes');
    }
}
