<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function edit(): View
    {
        $whatsapp = Setting::get('contact_whatsapp', '+6281234567890');
        $email = Setting::get('contact_email', 'contact@universitynews.edu');
        $address = Setting::get('contact_address', "123 Academic Way, University Plaza\nAcademic Heights, ST 12345");

        return view('admin.pages.contact', compact('whatsapp', 'email', 'address'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'contact_whatsapp' => ['required', 'string', 'regex:/^\+?[0-9\s\-]+$/'],
            'contact_email' => 'required|email|max:255',
            'contact_address' => 'required|string',
        ], [
            'contact_whatsapp.regex' => 'WhatsApp number must contain valid digits/phone format (e.g. +6281234567890).',
        ]);

        Setting::set('contact_whatsapp', $validated['contact_whatsapp']);
        Setting::set('contact_email', $validated['contact_email']);
        Setting::set('contact_address', $validated['contact_address']);

        return back()->with('success', 'Contact info updated successfully.');
    }
}
