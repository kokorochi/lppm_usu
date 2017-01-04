<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeriodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periods', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('years', false, true);
            $table->integer('category_type_id', false, true);
            $table->integer('dedication_type_id', false, true);
            $table->integer('appraisal_id', false, true);
            $table->string('scheme');
            $table->string('sponsor');
            $table->smallInteger('min_member', false, true);
            $table->smallInteger('max_member', false, true);
            $table->date('propose_begda'); $table->date('propose_endda');
            $table->date('review_begda'); $table->date('review_endda');
            $table->date('first_begda'); $table->date('first_endda');
            $table->date('monev_begda'); $table->date('monev_endda');
            $table->date('last_begda'); $table->date('last_endda');
            $table->text('annotation');
            $table->string('created_by', 30);
            $table->string('updated_by', 30)->nullable();
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
        Schema::dropIfExists('periods');
    }
}
