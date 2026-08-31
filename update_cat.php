<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$cl = App\Models\Category::where('slug', 'campus-life')->first()->id;
$ac = App\Models\Category::where('slug', 'academic')->first()->id;

App\Models\Article::whereHas('category', function($q) {
    $q->whereIn('slug', ['sports', 'events']);
})->update(['category_id' => $cl]);

App\Models\Article::whereHas('category', function($q) {
    $q->where('slug', 'achievements');
})->update(['category_id' => $ac]);

echo "Updated DB categories successfully.\n";
