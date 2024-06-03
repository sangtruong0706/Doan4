<?php

use App\Models\Order;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            Order::where('payment_status', 'Chưa thanh toán')->update(['payment_status' => 'unpaid']);
            Order::where('payment_status', 'Đã thanh toán')->update(['payment_status' => 'paid']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            Order::where('payment_status', 'unpaid')->update(['payment_status' => 'Chưa thanh toán']);
            Order::where('payment_status', 'paid')->update(['payment_status' => 'Đã thanh toán']);
        });
    }
};
