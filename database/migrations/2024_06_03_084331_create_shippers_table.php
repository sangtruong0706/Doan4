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
        Schema::create('shippers', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email');
            $table->string("phone");
            $table->text('address');
            $table->enum('status', ['1', '0'])->default(0);
            $table->foreignId('province_id')->constrained()->onDelete('cascade');
            $table->foreignId('district_id')->constrained()->onDelete('cascade');
            $table->foreignId('ward_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shippers');
    }
};
