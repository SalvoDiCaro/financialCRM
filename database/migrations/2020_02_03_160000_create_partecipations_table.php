<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartecipationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partecipations', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('instance_id');
            $table->foreign('instance_id')->references('id')->on('instances')->onDelete('cascade');

            $table->unsignedBigInteger('lead_id');
            $table->foreign('lead_id')->references('id')->on('leads');

            $table->string('typology'); //richiedente/garante
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
        Schema::dropIfExists('partecipations');
    }
}
