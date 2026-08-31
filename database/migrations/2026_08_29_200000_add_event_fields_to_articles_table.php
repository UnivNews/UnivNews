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
        Schema::table('articles', function (Blueprint $table) {
            // Sub-kategori tipe event (Campus Events, Seminar, Sports, dll.)
            $table->string('event_type')->nullable()->after('event_date');
            // URL halaman pendaftaran event
            $table->string('registration_link')->nullable()->after('event_type');
            // Batas akhir pendaftaran event (setelah tanggal ini, tombol daftar disembunyikan)
            $table->dateTime('registration_deadline')->nullable()->after('registration_link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn(['event_type', 'registration_link', 'registration_deadline']);
        });
    }
};
