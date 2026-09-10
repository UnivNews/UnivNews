<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Mengubah kolom duration_type dari ENUM menjadi VARCHAR (string bebas),
     * sehingga admin bisa menambahkan varian boost dengan nama durasi apapun.
     */
    public function up(): void
    {
        // PostgreSQL tidak bisa langsung ALTER kolom ENUM ke VARCHAR,
        // harus via USING cast.
        DB::statement('ALTER TABLE boost_prices DROP CONSTRAINT IF EXISTS boost_prices_duration_type_check');
        DB::statement('ALTER TABLE boost_prices ALTER COLUMN duration_type TYPE VARCHAR(50) USING duration_type::VARCHAR(50)');

        // Hapus unique constraint lama jika masih ada (Laravel memberi nama boost_prices_duration_type_unique)
        Schema::table('boost_prices', function (Blueprint $table) {
            // Coba drop unique index; ignore jika tidak ada
            try {
                $table->dropUnique(['duration_type']);
            } catch (\Throwable $e) {
                // Sudah tidak ada, lanjutkan
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Re-add enum (hanya 3 nilai default, nilai custom akan hilang)
        DB::statement("ALTER TABLE boost_prices ALTER COLUMN duration_type TYPE VARCHAR(50)");
        DB::statement("ALTER TABLE boost_prices ADD CONSTRAINT boost_prices_duration_type_check CHECK (duration_type IN ('3_days', '1_week', '1_month'))");
    }
};
