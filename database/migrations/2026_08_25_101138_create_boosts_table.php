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
        Schema::create('boosts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->comment('author who purchased the boost');
            $table->foreignId('boost_price_id')->constrained();

            $table->string('duration_type');
            $table->unsignedInteger('duration_days');
            $table->unsignedBigInteger('price_paid');

            $table->date('start_date');
            $table->date('end_date');

            $table->unsignedTinyInteger('slot_number')->nullable();
            $table->enum('status', [
                'pending_payment',
                'scheduled',
                'active',
                'expired',
                'cancelled',
            ])->default('pending_payment');

            $table->timestamps();
            
            $table->index(['status', 'start_date', 'end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boosts');
    }
};
