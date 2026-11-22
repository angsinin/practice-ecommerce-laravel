<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->string('order_number')->unique();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->string('shipping_method');
            $table->decimal('shipping_fee', 10, 2)->default(0.00);
            $table->decimal('discount', 10, 2)->default(0.00);
            $table->string('payment_method');
            $table->decimal('subtotal', 12, 2);
            $table->decimal('grand_total', 12, 2);
            $table->string('order_status')->default('Pending');
            $table->string('payment_status')->default('Pending');
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
};
