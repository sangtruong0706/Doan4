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
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('coupon_code_id')->nullable()->after('coupon_code');

            // Tạo liên kết khóa ngoại với bảng discount_coupons
            $table->foreign('coupon_code_id')
                ->references('id')
                ->on('discount_coupons')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Drop foreign key first
            $table->dropForeign(['coupon_code_id']);
            // Then drop the column
            $table->dropColumn('coupon_code_id');
        });
    }
};
