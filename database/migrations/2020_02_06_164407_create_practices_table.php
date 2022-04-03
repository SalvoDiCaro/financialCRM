<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePracticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('practice_number');

            $table->unsignedBigInteger('instance_id');
            $table->foreign('instance_id')->references('id')->on('instances');

            $table->string('stipulation_date');
            $table->string('cpi_awards');
            $table->string('fire');
            $table->string('complete_fire');
            $table->string('injuries');
            $table->string('ppl');
            $table->string('life');
            $table->string('spread_band');
            $table->string('cpi_number');
            $table->string('fire_amount');
            $table->string('complete_fire_amount');
            $table->string('injuries_amount');
            $table->string('ppl_amount');
            $table->string('life_amount');
            $table->string('ltv_band');
            $table->string('paper_digital');
            $table->string('notary');

            $table->unsignedBigInteger('dealer_id')->nullable();;
            $table->foreign('dealer_id')->references('id')->on('users');

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
        Schema::dropIfExists('practices');
    }
}
