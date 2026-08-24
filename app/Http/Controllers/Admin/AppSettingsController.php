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

        return view('admin.app-settings', compact('settings'));
    }

    /**
     * Simpan perubahan pengaturan aplikasi.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'publish_fee' => 'required|integer|min:1000|max:10000000',
        ], [
            'publish_fee.required' => 'Biaya publish wajib diisi.',
            'publish_fee.integer'  => 'Biaya publish harus berupa angka bulat.',
            'publish_fee.min'      => 'Biaya publish minimal Rp 1.000.',
            'publish_fee.max'      => 'Biaya publish maksimal Rp 10.000.000.',
        ]);

        Setting::set('publish_fee', $validated['publish_fee']);

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}
