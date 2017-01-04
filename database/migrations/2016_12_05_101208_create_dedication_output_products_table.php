<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDedicationOutputProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dedication_output_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dedication_id', false, true);
            $table->string('file_blueprint_ori');
            $table->string('file_blueprint');
            $table->string('file_finished_good_ori');
            $table->string('file_finished_good');
            $table->string('file_working_pic_ori');
            $table->string('file_working_pic');
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
        Schema::dropIfExists('dedication_output_products');
    }
}
