<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDedicationOutputMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dedication_output_methods', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dedication_id', false, true);
            $table->smallInteger('item', false, true);
            $table->string('file_name_ori');
            $table->string('file_name');
            $table->text('annotation')->nullable();
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
        Schema::dropIfExists('dedication_output_methods');
    }
}
