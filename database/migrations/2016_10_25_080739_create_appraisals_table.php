<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppraisalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appraisals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('created_by', 30);
            $table->string('updated_by', 30)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('appraisals_i', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('appraisal_id', false, true);
            $table->smallInteger('item', false, true);
            $table->string('aspect');
            $table->smallInteger('quality', false, true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appraisals');
        Schema::dropIfExists('appraisals_i');
    }
}
