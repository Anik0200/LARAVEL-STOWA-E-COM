<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->decimal('total');
            $table->string('transaction_id')->nullable();
            $table->string('coupon_name')->nullable();
            $table->integer('coupon_amount')->nullable();
            $table->integer('shipping_charge')->nullable();
            $table->string('order_status')->default('processing')->comment('processing, compleate, failed, cancle');
            $table->string('payment_status')->default('unpaid')->comment('unpaid, paid');
            $table->longText('order_note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
