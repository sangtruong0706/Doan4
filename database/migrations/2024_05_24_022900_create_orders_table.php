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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('subtotal',10,2);
            $table->decimal('shipping',10,2);
            $table->string('coupon_code')->nullable();
            $table->double('discount',10,2)->nullable();
            $table->decimal('grand_total',10,2);
            $table->string('payment_method');

            // User addresses related columns
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->foreignId('province_id')->constrained()->onDelete('cascade');
            $table->foreignId('district_id')->constrained()->onDelete('cascade');
            $table->foreignId('ward_id')->constrained()->onDelete('cascade');

            $table->string('address');
            $table->string('phone');
            $table->text('note')->nullable();
            $table->timestamps();
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
