<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('string'); // string, integer, boolean
            $table->string('label')->nullable();        // Human-readable label for admin UI
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Seed default values
        DB::table('settings')->insert([
            [
                'key'         => 'publish_fee',
                'value'       => env('PUBLISH_FEE', '25000'),
                'type'        => 'integer',
                'label'       => 'Biaya Publish Artikel (IDR)',
                'description' => 'Nominal biaya yang harus dibayar author setiap kali mempublikasikan artikel. Satuan: Rupiah (tanpa titik/koma).',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
