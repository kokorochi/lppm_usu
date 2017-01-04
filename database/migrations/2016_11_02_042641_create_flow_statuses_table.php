<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlowStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flow_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('propose_id', false, true);
            $table->smallInteger('item', false, true);
            $table->string('status_code', 2);
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
        Schema::dropIfExists('flow_statuses');
    }
}
