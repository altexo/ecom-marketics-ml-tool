<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('ml_order_id')->unique();
            $table->string('status', 30);
            $table->dateTimeTz('ml_date_created');
            $table->string('buyer_nickname');
            $table->string('buyer_id');
            $table->integer('quantity');
            $table->string('product_ml_product_id',15);
            $table->string('ml_account_ml_user_id',15);
            $table->timestamps();

            // $table->foreign('product_ml_product_id')
            // ->references('ml_product_id')->on('products')
            // ->onDelete('cascade');
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
        Schema::dropIfExists('orders');
    }
}
