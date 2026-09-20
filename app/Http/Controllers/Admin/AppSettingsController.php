<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AppSettingsController extends Controller
{
    /**
     * Tampilkan halaman pengaturan aplikasi.
     */
    public function index(): View
    {
        $settings = Setting::all()->keyBy('key');
        $boostPrices = \App\Models\BoostPrice::all();

        return view('admin.app-settings', compact('settings', 'boostPrices'));
    }

    /**
     * Simpan perubahan pengaturan aplikasi.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'publish_fee' => 'required|integer|min:1000|max:10000000',
            'boost_prices' => 'array',
            'boost_prices.*.price' => 'required|integer|min:0',
            'boost_prices.*.is_active' => 'sometimes|boolean',
        ], [
            'publish_fee.required' => 'Biaya publish wajib diisi.',
            'publish_fee.integer'  => 'Biaya publish harus berupa angka bulat.',
            'publish_fee.min'      => 'Biaya publish minimal Rp 1.000.',
            'publish_fee.max'      => 'Biaya publish maksimal Rp 10.000.000.',
        ]);

        Setting::set('publish_fee', $validated['publish_fee']);

        if (isset($validated['boost_prices'])) {
            foreach ($validated['boost_prices'] as $id => $data) {
                \App\Models\BoostPrice::where('id', $id)->update([
                    'price' => $data['price'],
                    'is_active' => isset($data['is_active']) ? true : false,
                ]);
            }
        }

        if ($request->has('new_boost_prices') && is_array($request->new_boost_prices)) {
            foreach ($request->new_boost_prices as $newBp) {
                if (!empty($newBp['duration_type']) && !empty($newBp['duration_days']) && isset($newBp['price'])) {
                    \App\Models\BoostPrice::create([
                        'duration_type' => $newBp['duration_type'],
                        'duration_days' => $newBp['duration_days'],
                        'price'         => $newBp['price'],
                        'is_active'     => isset($newBp['is_active']) ? true : false,
                    ]);
                }
            }
        }

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }

    /**
     * Hapus satu paket harga boost.
     */
    public function destroyBoostPrice(\App\Models\BoostPrice $boostPrice): RedirectResponse
    {
        if (\App\Models\Boost::where('boost_price_id', $boostPrice->id)->exists()) {
            return back()->with('error', 'Paket boost ini tidak dapat dihapus karena sudah tercatat dalam riwayat boost artikel. Silakan nonaktifkan status paket ini.');
        }

        $boostPrice->delete();
        return back()->with('success', 'Paket boost berhasil dihapus.');
    }
}
