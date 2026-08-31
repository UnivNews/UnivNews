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
            // Sub-filter 1: Research Field (Biomedical Sciences, Engineering, dll.)
            $table->string('research_field')->nullable()->after('registration_deadline');
            // Sub-filter 2: Research Center / Lab
            $table->string('research_center')->nullable()->after('research_field');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn(['research_field', 'research_center']);
        });
    }
};
