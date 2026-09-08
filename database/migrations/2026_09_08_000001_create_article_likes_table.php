<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('article_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamp('created_at')->useCurrent();

            // One like per user per article (toggle, not counter)
            $table->unique(['article_id', 'user_id']);
            $table->index('article_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_likes');
    }
};
