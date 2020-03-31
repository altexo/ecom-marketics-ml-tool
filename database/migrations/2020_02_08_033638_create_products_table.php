<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 191);
            $table->integer('price');
            $table->string('image', 191);
            $table->string('ml_product_id',15)->unique();
            $table->string('ml_account_ml_user_id',15);
            $table->timestamps();

            $table->foreign('ml_account_ml_user_id')
            ->references('ml_user_id')->on('ml_account')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
