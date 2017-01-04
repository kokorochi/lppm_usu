<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDedicationOutputPatentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dedication_output_patents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dedication_id', false, true);
            $table->string('patent_no');
            $table->smallInteger('patent_year', false, true);
            $table->string('patent_owner_name');
            $table->string('patent_type');
            $table->string('file_patent_ori');
            $table->string('file_patent');
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
        Schema::dropIfExists('dedication_output_patents');
    }
}
