<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDedicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dedications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('propose_id', false, true);
            $table->string('file_progress_activity')->nullable();
            $table->string('file_progress_activity_ori')->nullable();
            $table->string('file_progress_budgets')->nullable();
            $table->string('file_progress_budgets_ori')->nullable();
            $table->string('file_final_activity')->nullable();
            $table->string('file_final_activity_ori')->nullable();
            $table->string('file_final_budgets')->nullable();
            $table->string('file_final_budgets_ori')->nullable();
            $table->string('created_by', 30);
            $table->string('updated_by', 30)->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('dedications');
    }
}
