<?php

namespace App\Http\Controllers;

use App\Models\Boost;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function featured()
    {
        $boosts = Boost::with(['article.user', 'article.category'])
            ->where('status', 'active')
            ->orderBy('start_date', 'asc')
            ->get();
            
        $articles = $boosts->map(function ($boost) {
            return $boost->article;
        });

        return response()->json([
            'data' => $articles
        ]);
    }
}
