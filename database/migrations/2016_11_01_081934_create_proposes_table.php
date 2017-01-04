<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProposesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('period_id', false, true)->nullable();
            $table->char('is_own', 1)->nullable();
            $table->string('faculty_code', 10);
            $table->string('areas_of_expertise')->nullable();
            $table->string('title', 100);
            $table->double('total_amount', 15, 2);
            $table->double('final_amount', 15, 2)->nullable();
            $table->integer('output_type_id', false, true)->nullable();
            $table->smallInteger('time_period', false, true);
            $table->smallInteger('student_involved', false, true)->nullable();
            $table->string('address');
            $table->string('bank_account_name', 50)->nullable();
            $table->string('bank_account_no', 30)->nullable();
            $table->string('file_propose_ori')->nullable();
            $table->string('file_propose')->nullable();
            $table->string('file_propose_final_ori')->nullable();
            $table->string('file_propose_final')->nullable();
            $table->string('approval_status', 10)->nullable();
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
        Schema::dropIfExists('proposes');
    }
}
