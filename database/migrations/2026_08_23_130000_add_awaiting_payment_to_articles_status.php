<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds 'awaiting_payment' status to the articles.status enum (PostgreSQL).
     */
    public function up(): void
    {
        // PostgreSQL: alter enum type
        DB::statement("ALTER TABLE articles DROP CONSTRAINT IF EXISTS articles_status_check");
        DB::statement("ALTER TABLE articles ADD CONSTRAINT articles_status_check CHECK (status IN ('draft', 'pending_review', 'awaiting_payment', 'published', 'rejected'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore to original enum without awaiting_payment
        DB::statement("UPDATE articles SET status = 'pending_review' WHERE status = 'awaiting_payment'");
        DB::statement("ALTER TABLE articles DROP CONSTRAINT IF EXISTS articles_status_check");
        DB::statement("ALTER TABLE articles ADD CONSTRAINT articles_status_check CHECK (status IN ('draft', 'pending_review', 'published', 'rejected'))");
    }
};
