<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDownloadLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('download_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('propose_id', false, true);
            $table->string('download_type', 30);
            $table->string('file_name_ori');
            $table->string('file_name');
            $table->string('created_by', 30);
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
        Schema::dropIfExists('download_logs');
    }
}
