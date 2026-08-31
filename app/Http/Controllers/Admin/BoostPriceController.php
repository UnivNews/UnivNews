<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BoostPrice;
use Illuminate\Http\Request;

class BoostPriceController extends Controller
{
    public function index()
    {
        $boostPrices = BoostPrice::all();
        return response()->json(['data' => $boostPrices]);
    }

    public function update(Request $request, BoostPrice $boostPrice)
    {
        $validated = $request->validate([
            'price' => 'required|integer|min:0',
            'is_active' => 'required|boolean',
        ]);

        $boostPrice->update($validated);

        return response()->json(['message' => 'Boost price updated successfully', 'data' => $boostPrice]);
    }
}
