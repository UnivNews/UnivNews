<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Setting;
use App\Models\SitePage;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Show About Us page.
     */
    public function aboutUs(): View
    {
        $page = SitePage::findBySlug('about-us');
        return view('pages.about', compact('page'));
    }

    /**
     * Show FAQ page.
     */
    public function faq(): View
    {
        $faqs = Faq::published()->get()->groupBy(function ($faq) {
            return $faq->category ?: 'General';
        });

        return view('pages.faq', compact('faqs'));
    }

    /**
     * Show Contact Info page.
     */
    public function contact(): View
    {
        $contactWhatsapp = Setting::get('contact_whatsapp', '+6281234567890');
        $contactEmail = Setting::get('contact_email', 'contact@universitynews.edu');
        $contactAddress = Setting::get('contact_address', "123 Academic Way, University Plaza\nAcademic Heights, ST 12345");

        return view('pages.contact', compact('contactWhatsapp', 'contactEmail', 'contactAddress'));
    }

    /**
     * Show Privacy Policy page.
     */
    public function privacyPolicy(): View
    {
        $page = SitePage::findBySlug('privacy-policy');
        return view('pages.privacy', compact('page'));
    }
}
