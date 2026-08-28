<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
$articles = \App\Models\Article::with('tags')->get();
foreach($articles as $a) {
    echo $a->title . " -> " . ($a->tags->first()->name ?? 'NONE') . PHP_EOL;
}
