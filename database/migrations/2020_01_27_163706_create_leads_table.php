<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('surname');
            $table->string('phone');
            $table->string('email');
            $table->string('channel');
            $table->string('current_state');
            $table->string('document')->nullable();
            $table->string('fis_cod')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('birth_place')->nullable();
            $table->string('job')->nullable();
            $table->string('contract_type')->nullable();
            $table->string('work_since')->nullable();
            $table->string('sector')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies');
            $table->string('annual_income')->nullable();
            $table->string('address')->nullable();
            $table->string('city_of_residence')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('work_notes')->nullable();
            $table->string('loan_notes')->nullable();
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
        Schema::dropIfExists('leads');
    }
}
