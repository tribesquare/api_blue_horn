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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('listing_id')->constrained();
            $table->boolean('notification_sent')->default(false);
            $table->string('reference')->nullable();
            $table->string('status')->default('pending');
            $table->string('amount');
            $table->string('currency')->default('NGN');
            $table->string('email');
            $table->string('paystack_init_response')->nullable();
            $table->json('paystack_verify_response')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
