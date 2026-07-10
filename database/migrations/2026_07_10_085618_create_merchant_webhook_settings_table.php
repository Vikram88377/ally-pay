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
Schema::create('merchant_webhook_settings', function (Blueprint $table) {

        $table->id();

        $table->foreignId('merchant_id')
            ->constrained()
            ->cascadeOnDelete();

        $table->string('callback_url');

        $table->string('secret_key');

        $table->boolean('is_active')
            ->default(true);

        $table->timestamps();

        $table->unique('merchant_id');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchant_webhook_settings');
    }
};
