<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ReadingHistory;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReadingHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $publishedArticles = Article::where('status', Article::STATUS_PUBLISHED)->get();
        if ($publishedArticles->isEmpty()) {
            return;
        }

        $readers = User::where('role', User::ROLE_PUBLIC)->get();

        foreach ($readers as $reader) {
            // Pick 3 to 5 random published articles for this reader
            $count = min($publishedArticles->count(), rand(3, 5));
            $randomArticles = $publishedArticles->random($count);

            $minutesAgo = 30;
            foreach ($randomArticles as $article) {
                ReadingHistory::updateOrCreate(
                    [
                        'user_id'    => $reader->id,
                        'article_id' => $article->id,
                    ],
                    [
                        'last_read_at' => now()->subMinutes($minutesAgo),
                        'read_count'   => rand(1, 4),
                    ]
                );
                $minutesAgo += rand(60, 1440); // space them out
            }
        }
    }
}
