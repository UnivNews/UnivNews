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
        Schema::create('boost_prices', function (Blueprint $table) {
            $table->id();
            $table->string('duration_type', 50); // bebas, misal: 3_days, 1_week, 2_weeks, dll.
            $table->unsignedInteger('duration_days'); // jumlah hari
            $table->unsignedBigInteger('price'); // in Rupiah
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boost_prices');
    }
};
