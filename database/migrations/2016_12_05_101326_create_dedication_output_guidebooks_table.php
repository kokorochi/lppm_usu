<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDedicationOutputGuidebooksTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dedication_output_guidebooks', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('dedication_id', false, true);
            $table->string('title');
            $table->smallInteger('book_year', false, true);
            $table->string('publisher');
            $table->string('isbn');
            $table->string('file_cover_ori');
            $table->string('file_cover');
            $table->string('file_back_ori');
            $table->string('file_back');
            $table->string('file_table_of_contents_ori');
            $table->string('file_table_of_contents');
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
        Schema::dropIfExists('dedication_output_guidebooks');
    }
}
