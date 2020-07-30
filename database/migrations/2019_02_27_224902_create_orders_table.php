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
            $table->id();
            $table->double('total_price', 8, 2);
            $table->double('finel_total_price', 8, 2);
            $table->double('sale', 8, 2);
            $table->double('paid', 8, 2);
            
            $table->string('status')->default('the_receipt_of_the_request');
            $table->longText('note')->nullable();
            $table->string('type_status')->default('internal');
            $table->string('payment')->default('cash');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');;
    
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('set null');;
        
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
        Schema::dropIfExists('orders');
    }
}
