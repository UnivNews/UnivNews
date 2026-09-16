@extends('layouts.transactional')

@section('content')
    <div class="max-w-[1280px] w-full mx-auto px-6 md:px-10 py-16">
        <div class="px-0 lg:px-[160px]">
            <!-- Header Section -->
            <div class="mb-8">
                <h1 class="font-heading font-semibold text-[32px] text-[#00081E] tracking-tight">Account Settings</h1>
                <p class="font-sans text-[16px] text-[#44464E] mt-1">Manage your profile, security, portal roles, and account preferences.</p>
            </div>

            <!-- Global Status & Alert Banners -->
            @if (session('status') === 'google-linked')
                <div class="mb-8 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center gap-3 text-sm text-green-800">
                    <span class="w-6 h-6 rounded-full bg-green-600 text-white flex items-center justify-center font-bold text-xs flex-shrink-0">✓</span>
                    <div>
                        <p class="font-bold">Google Account Connected!</p>
                        <p class="text-xs text-green-700 mt-0.5">Your account has been successfully verified and connected to Google (Gmail) to receive all portal notifications.</p>
                    </div>
                </div>
            @elseif (session('status') === 'verification-link-sent')
                <div class="mb-8 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center gap-3 text-sm text-green-800">
                    <span class="w-6 h-6 rounded-full bg-green-600 text-white flex items-center justify-center font-bold text-xs flex-shrink-0">✓</span>
                    <div>
                        <p class="font-bold">Verification Email Sent!</p>
                        <p class="text-xs text-green-700 mt-0.5">A new verification link has been sent to your Gmail inbox (<strong>{{ $user->email }}</strong>). Please check your Gmail mailbox or spam folder.</p>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-8 p-4 bg-red-50 border border-red-200 rounded-lg flex items-center gap-3 text-sm text-red-800">
                    <span class="w-6 h-6 rounded-full bg-red-600 text-white flex items-center justify-center font-bold text-xs flex-shrink-0">!</span>
                    <p class="font-medium">{{ session('error') }}</p>
                </div>
            @endif

            @if (session('warning'))
                <div class="mb-8 p-4 bg-amber-50 border border-amber-200 rounded-lg flex items-center gap-3 text-sm text-amber-800">
                    <span class="w-6 h-6 rounded-full bg-amber-600 text-white flex items-center justify-center font-bold text-xs flex-shrink-0">⚠️</span>
                    <p class="font-medium">{{ session('warning') }}</p>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-8 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center gap-3 text-sm text-green-800">
                    <span class="w-6 h-6 rounded-full bg-green-600 text-white flex items-center justify-center font-bold text-xs flex-shrink-0">✓</span>
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Verification Email Form Helper -->
            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                @csrf
            </form>
            
            <div class="space-y-10">
                <!-- 1. Profile Information Card -->
                @include('profile.partials.update-profile-information-form')

                <!-- 2. Security & Password Card -->
                @include('profile.partials.update-password-form')

                <!-- 3. Author Program & Portal Access Section (Directly Below Password Box) -->
                <div class="bg-white border border-[#C5C6CF] p-6 sm:p-8 rounded-lg shadow-sm">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-gray-100">
                        <div>
                            <h2 class="font-heading font-bold text-lg text-[#00081E] flex items-center gap-2">
                                <svg class="w-5 h-5 text-[#8b1528]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                Author Program & Portal Access
                            </h2>
                            <p class="font-sans text-xs sm:text-sm text-gray-500 mt-1">Your current status and access rights for contributing campus articles.</p>
                        </div>
                        <div>
                            @if($user->isAdmin())
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-purple-100 text-purple-800 border border-purple-200">
                                    👑 Administrator
                                </span>
                            @elseif($user->isAuthor())
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-green-100 text-green-800 border border-green-200">
                                    ✍️ Active Author
                                </span>
                            @elseif($user->isAuthorPending())
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-yellow-100 text-yellow-800 border border-yellow-200">
                                    ⏳ Under Review
                                </span>
                            @elseif($user->isAuthorRejected())
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-red-100 text-red-800 border border-red-200">
                                    ⚠️ Revision Required
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-blue-100 text-blue-800 border border-blue-200">
                                    📖 Reader
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="mt-5 text-sm text-gray-600 leading-relaxed font-sans">
                        @if($user->isAdmin())
                            <p class="mb-4">You are logged in with <strong>Administrator</strong> privileges. You can manage news moderation, system configuration, boost payments, and registered users.</p>
                            <div class="flex flex-wrap gap-3">
                                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-[#8b1528] hover:bg-[#6b0f1f] text-white text-xs font-bold uppercase tracking-wider rounded transition-colors shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                                    Open Admin Dashboard
                                </a>
                            </div>
                        @elseif($user->isAuthor())
                            <p class="mb-4">You have active authoring privileges to publish campus news coverage, event agendas, and academic research publications.</p>
                            <div class="flex flex-wrap gap-3">
                                <a href="{{ route('author.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-[#8b1528] hover:bg-[#6b0f1f] text-white text-xs font-bold uppercase tracking-wider rounded transition-colors shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                    Author Dashboard
                                </a>
                                <a href="{{ route('author.articles.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 text-gray-700 hover:text-[#8b1528] hover:border-[#8b1528] text-xs font-bold uppercase tracking-wider rounded transition-colors shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    Write New Article
                                </a>
                            </div>
                        @elseif($user->isAuthorPending())
                            <p class="mb-4">Your application to become an Author has been submitted and is currently under review by our editorial team. You will receive an email notification once the review process is completed.</p>
                            <div class="flex flex-wrap gap-3">
                                <a href="{{ route('author.apply') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white text-xs font-bold uppercase tracking-wider rounded transition-colors shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Check Application Status
                                </a>
                            </div>
                        @else
                            <p class="mb-4">Interested in sharing academic insights, research findings, opinions, and campus coverage? Apply to become an official University News contributor.</p>

                            @if ($user->hasVerifiedEmail() && $user->hasGoogleEmail())
                                <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-md flex flex-wrap items-center justify-between gap-3 text-xs text-green-800">
                                    <div class="flex items-center gap-2">
                                        <span class="w-5 h-5 rounded-full bg-green-600 text-white flex items-center justify-center font-bold text-xs flex-shrink-0">✓</span>
                                        <span class="font-medium">Your email is verified with Google (<strong>{{ $user->email }}</strong>). You are eligible to apply as an Author contributor.</span>
                                    </div>
                                    @if($user->isGoogleLinked())
                                        <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-gray-700 bg-white px-2.5 py-1 rounded border border-gray-200 shadow-xs">
                                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24"><path fill="#EA4335" d="M12 5c1.6 0 3 .6 4.1 1.7l3.1-3.1C17.3 1.8 14.8 1 12 1 7.4 1 3.5 3.6 1.6 7.4l3.7 2.9C6.2 7.2 8.9 5 12 5z"/><path fill="#4285F4" d="M23.5 12.3c0-.8-.1-1.6-.2-2.3H12v4.5h6.5c-.3 1.5-1.1 2.8-2.4 3.7l3.7 2.9c2.2-2 3.7-5 3.7-8.8z"/><path fill="#FBBC05" d="M5.3 14.7c-.2-.7-.4-1.5-.4-2.7s.2-2 .4-2.7L1.6 6.4C.6 8.4 0 10.6 0 12s.6 3.6 1.6 5.6l3.7-2.9z"/><path fill="#34A853" d="M12 23c3.2 0 6-1.1 8-3l-3.7-2.9c-1.1.7-2.5 1.2-4.3 1.2-3.1 0-5.8-2.2-6.7-5.3L1.6 16C3.5 19.8 7.4 23 12 23z"/></svg>
                                            Gmail Linked
                                        </span>
                                    @endif
                                </div>
                                <div class="flex flex-wrap gap-3">
                                    <a href="{{ route('author.apply') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-[#8b1528] hover:bg-[#6b0f1f] text-white text-xs font-bold uppercase tracking-wider rounded transition-colors shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Apply as Contributor
                                    </a>
                                </div>
                            @elseif (!$user->hasGoogleEmail())
                                <!-- Alert: Non-Google Email Address -->
                                <div class="mb-5 p-4 rounded-lg bg-red-50 border border-red-300">
                                    <div class="flex items-start gap-3">
                                        <div class="p-1.5 rounded-full bg-red-100 text-red-700 mt-0.5">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="text-xs font-bold uppercase tracking-wider text-red-950">Google (Gmail) Email Required</h4>
                                            <p class="text-xs text-red-900 mt-1 leading-relaxed">
                                                Before applying to become an Author, your account must use a Google (Gmail) email address. The address <strong>{{ $user->email }}</strong> was not found on Google. Please update your email address in the Profile Information section above to your Gmail address or connect directly with Google.
                                            </p>
                                            <div class="mt-3 flex flex-wrap items-center gap-2">
                                                <a href="{{ route('auth.google.redirect') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-xs font-bold uppercase tracking-wider rounded transition-colors shadow-xs">
                                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24"><path fill="#EA4335" d="M12 5c1.6 0 3 .6 4.1 1.7l3.1-3.1C17.3 1.8 14.8 1 12 1 7.4 1 3.5 3.6 1.6 7.4l3.7 2.9C6.2 7.2 8.9 5 12 5z"/><path fill="#4285F4" d="M23.5 12.3c0-.8-.1-1.6-.2-2.3H12v4.5h6.5c-.3 1.5-1.1 2.8-2.4 3.7l3.7 2.9c2.2-2 3.7-5 3.7-8.8z"/><path fill="#FBBC05" d="M5.3 14.7c-.2-.7-.4-1.5-.4-2.7s.2-2 .4-2.7L1.6 6.4C.6 8.4 0 10.6 0 12s.6 3.6 1.6 5.6l3.7-2.9z"/><path fill="#34A853" d="M12 23c3.2 0 6-1.1 8-3l-3.7-2.9c-1.1.7-2.5 1.2-4.3 1.2-3.1 0-5.8-2.2-6.7-5.3L1.6 16C3.5 19.8 7.4 23 12 23z"/></svg>
                                                    Connect with Google (Gmail)
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-wrap items-center gap-3">
                                    <button type="button" disabled class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-400 border border-gray-200 text-xs font-bold uppercase tracking-wider rounded cursor-not-allowed">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                        Apply as Contributor (Google Email Required)
                                    </button>
                                </div>
                            @else
                                <!-- Alert: Google Email detected but Unverified -->
                                <div class="mb-5 p-4 rounded-lg bg-amber-50 border border-amber-300">
                                    <div class="flex items-start gap-3">
                                        <div class="p-1.5 rounded-full bg-amber-200 text-amber-900 mt-0.5">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="text-xs font-bold uppercase tracking-wider text-amber-950">Google (Gmail) Verification Required</h4>
                                            <p class="text-xs text-amber-900 mt-1 leading-relaxed">
                                                Before applying to become an Author, your Google account email must be verified. This ensures all editorial curation updates and application status notifications are delivered to your Gmail mailbox.
                                            </p>
                                            <div class="mt-3 flex flex-wrap items-center gap-2">
                                                <button form="send-verification" type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#8b1528] hover:bg-[#6b0f1f] text-white text-xs font-bold uppercase tracking-wider rounded transition-colors shadow-xs">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                                    Verify via Gmail Mailbox
                                                </button>
                                                <a href="{{ route('auth.google.redirect') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-xs font-bold uppercase tracking-wider rounded transition-colors shadow-xs">
                                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24"><path fill="#EA4335" d="M12 5c1.6 0 3 .6 4.1 1.7l3.1-3.1C17.3 1.8 14.8 1 12 1 7.4 1 3.5 3.6 1.6 7.4l3.7 2.9C6.2 7.2 8.9 5 12 5z"/><path fill="#4285F4" d="M23.5 12.3c0-.8-.1-1.6-.2-2.3H12v4.5h6.5c-.3 1.5-1.1 2.8-2.4 3.7l3.7 2.9c2.2-2 3.7-5 3.7-8.8z"/><path fill="#FBBC05" d="M5.3 14.7c-.2-.7-.4-1.5-.4-2.7s.2-2 .4-2.7L1.6 6.4C.6 8.4 0 10.6 0 12s.6 3.6 1.6 5.6l3.7-2.9z"/><path fill="#34A853" d="M12 23c3.2 0 6-1.1 8-3l-3.7-2.9c-1.1.7-2.5 1.2-4.3 1.2-3.1 0-5.8-2.2-6.7-5.3L1.6 16C3.5 19.8 7.4 23 12 23z"/></svg>
                                                    Verify with Google Account
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-wrap items-center gap-3">
                                    <button type="button" disabled class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-400 border border-gray-200 text-xs font-bold uppercase tracking-wider rounded cursor-not-allowed">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                        Apply as Contributor (Email Verification Required)
                                    </button>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>

                <!-- 4. Help Center, Information & Policies (Directly Above Danger Zone Box) -->
                <div class="bg-white border border-[#C5C6CF] p-6 sm:p-8 rounded-lg shadow-sm">
                    <div class="pb-5 border-b border-gray-100">
                        <h2 class="font-heading font-bold text-lg text-[#00081E] flex items-center gap-2">
                            <svg class="w-5 h-5 text-[#8b1528]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Help Center, Information & Policies
                        </h2>
                        <p class="font-sans text-xs sm:text-sm text-gray-500 mt-1">Quick links to public information, the editorial desk, guidelines, and terms of service.</p>
                    </div>

                    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4 font-sans">
                        <a href="{{ route('page.about') }}" class="flex items-start gap-3 p-4 border border-gray-200 rounded-lg hover:border-[#8b1528] hover:bg-gray-50 transition-colors group">
                            <div class="w-9 h-9 rounded-md bg-red-50 text-[#8b1528] flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-900 group-hover:text-[#8b1528] transition-colors">About Us</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Vision, mission, and background of University News Portal.</p>
                            </div>
                        </a>

                        <a href="{{ route('page.faq') }}" class="flex items-start gap-3 p-4 border border-gray-200 rounded-lg hover:border-[#8b1528] hover:bg-gray-50 transition-colors group">
                            <div class="w-9 h-9 rounded-md bg-blue-50 text-blue-700 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-900 group-hover:text-[#8b1528] transition-colors">Frequently Asked Questions (FAQ)</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Answers regarding campus articles, editorial curation, and account access.</p>
                            </div>
                        </a>

                        <a href="{{ route('page.contact') }}" class="flex items-start gap-3 p-4 border border-gray-200 rounded-lg hover:border-[#8b1528] hover:bg-gray-50 transition-colors group">
                            <div class="w-9 h-9 rounded-md bg-green-50 text-green-700 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-900 group-hover:text-[#8b1528] transition-colors">Contact Editorial & Support</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Editorial desk contact, support channels, and service hours.</p>
                            </div>
                        </a>

                        <a href="{{ route('page.privacy') }}" class="flex items-start gap-3 p-4 border border-gray-200 rounded-lg hover:border-[#8b1528] hover:bg-gray-50 transition-colors group">
                            <div class="w-9 h-9 rounded-md bg-amber-50 text-amber-700 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-900 group-hover:text-[#8b1528] transition-colors">Privacy Policy</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Information on data collection and personal data protection.</p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- 5. Danger Zone Card -->
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
@endsection
