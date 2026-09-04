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
        $categoriesToDelete = ['Academic', 'Campus Life', 'Science & Technology', 'Sports'];
        $fallbackCategoryName = 'Research & Innovation';

        // 1. Ensure fallback category exists
        $fallbackCategory = \App\Models\Category::firstOrCreate([
            'slug' => \Illuminate\Support\Str::slug($fallbackCategoryName)
        ], [
            'name' => $fallbackCategoryName
        ]);

        // 2. Find categories to delete
        $categories = \App\Models\Category::whereIn('name', $categoriesToDelete)->get();

        foreach ($categories as $category) {
            // Create a tag with the same name as the category
            $tag = \App\Models\Tag::firstOrCreate([
                'name' => $category->name
            ]);

            // Reassign articles and attach tag
            $articles = \App\Models\Article::where('category_id', $category->id)->get();
            foreach ($articles as $article) {
                // Attach tag without detaching others
                $article->tags()->syncWithoutDetaching([$tag->id]);
                // Reassign category
                $article->update(['category_id' => $fallbackCategory->id]);
            }

            // Finally, delete the category
            $category->delete();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Re-create the deleted categories so we can rollback cleanly
        $categoriesToRestore = ['Academic', 'Campus Life', 'Science & Technology', 'Sports'];
        foreach ($categoriesToRestore as $catName) {
            \App\Models\Category::firstOrCreate([
                'slug' => \Illuminate\Support\Str::slug($catName)
            ], [
                'name' => $catName
            ]);
        }
    }
};
