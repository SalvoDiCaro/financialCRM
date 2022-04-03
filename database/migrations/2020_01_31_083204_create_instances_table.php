<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                ->references('id')->on('products');
            $table->string('product_type')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')->on('users');
            $table->string('branch');
            $table->string('current_state');
            $table->string('amount')->nullable();
            $table->string('finality')->nullable();
            $table->string('duration')->nullable();
            $table->string('spread')->nullable();
            $table->string('rating')->nullable();
            $table->string('property_cost')->nullable();
            $table->string('property_value')->nullable();
            $table->string('first_erogation')->nullable();
            $table->string('inquest')->nullable();
            $table->string('property_address')->nullable();
            $table->string('property_city')->nullable();
            $table->string('property_postal_code')->nullable();
            $table->string('property_extension_address')->nullable();
            $table->string('property_extension_city')->nullable();
            $table->string('property_extension_postal_code')->nullable();
            $table->string('family_members')->nullable();
            $table->string('housing_situation')->nullable();
            $table->string('consap')->nullable();
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
        Schema::dropIfExists('instances');
    }
}
