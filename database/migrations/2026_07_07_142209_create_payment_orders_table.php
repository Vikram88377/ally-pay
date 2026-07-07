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
            Schema::create('payment_orders', function (Blueprint $table) {
                $table->id();

                $table->foreignId('merchant_id')
                    ->constrained()
                    ->cascadeOnDelete();

                $table->string('order_id')->unique();
                $table->decimal('amount', 12, 2);
                $table->string('currency')->default('INR');

                $table->enum('status', [
                    'pending',
                    'success',
                    'failed',
                    'cancelled'
                ])->default('pending');

                $table->string('customer_name')->nullable();
                $table->string('customer_email')->nullable();
                $table->string('customer_phone')->nullable();

                $table->string('callback_url')->nullable();
                $table->json('metadata')->nullable();

                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_orders');
    }
};
