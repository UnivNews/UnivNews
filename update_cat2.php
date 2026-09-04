<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$c_events = App\Models\Category::where('slug', 'events')->first()->id;
$c_ach = App\Models\Category::where('slug', 'achievements')->first()->id;
$c_ri = App\Models\Category::where('slug', 'research-innovation')->first()->id;

App\Models\Article::whereHas('category', function($q) {
    $q->whereIn('slug', ['campus-life', 'sports']);
})->update(['category_id' => $c_events]);

App\Models\Article::whereHas('category', function($q) {
    $q->where('slug', 'academic');
})->update(['category_id' => $c_ach]);

App\Models\Article::whereHas('category', function($q) {
    $q->where('slug', 'science-technology');
})->update(['category_id' => $c_ri]);

echo "Updated DB categories successfully.\n";
