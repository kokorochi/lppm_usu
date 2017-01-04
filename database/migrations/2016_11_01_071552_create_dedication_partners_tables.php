<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDedicationPartnersTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dedication_partners', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('propose_id', false, true);
            $table->smallInteger('item', false, true);
            $table->string('name');
            $table->string('territory');
            $table->string('city');
            $table->string('province');
            $table->smallInteger('distance', false, true);
            $table->string('file_partner_contract_ori');
            $table->string('file_partner_contract');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dedication_partners');
    }
}
