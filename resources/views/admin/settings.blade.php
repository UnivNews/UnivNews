@extends('layouts.cms')

@section('title', 'User Profile - University News')
@section('header_tagline', 'University News CMS')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold font-heading text-[#00081e] tracking-tight">User Profile</h1>
        <p class="text-gray-500 font-sans text-sm mt-1">Manage your account settings and preferences.</p>
    </div>

    @if($errors->any())
    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-600 text-red-700 text-sm">
        <p class="font-bold">Please correct the following errors:</p>
        <ul class="list-disc pl-5 mt-1 space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Left Column: Profile Card & Account Status -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Main Profile Summary Card -->
            <div class="bg-white border border-gray-200 p-6 text-center shadow-sm">
                <!-- Avatar -->
                <div class="w-32 h-40 mx-auto bg-gray-100 border border-gray-200 overflow-hidden shadow-inner flex items-center justify-center mb-4">
                    @if(auth()->user()->avatar_path)
                        <img src="{{ asset(auth()->user()->avatar_path) }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-slate-200 flex flex-col items-center justify-center text-slate-400">
                            <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- User Name & Title -->
                <h2 class="text-xl font-bold font-heading text-[#00081e]">{{ auth()->user()->name }}</h2>
                <div class="mt-1.5 inline-block">
                    <span class="px-2.5 py-0.5 bg-gray-100 text-gray-700 text-xs font-semibold uppercase tracking-wider border border-gray-200">
                        {{ auth()->user()->isAdmin() ? 'Senior Editor' : (auth()->user()->isAuthor() ? 'Author' : 'Reader') }}
                    </span>
                </div>

                <!-- Meta Details -->
                <div class="mt-6 pt-6 border-t border-gray-100 text-left space-y-3.5 text-xs text-gray-600 font-sans">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span class="truncate">{{ auth()->user()->email }}</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span>{{ auth()->user()->phone_number ?? '+1 (555) 123-4567' }}</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <span>{{ auth()->user()->department ?? 'Department of Communications' }}</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>Joined {{ auth()->user()->created_at->format('F Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Account Status Card -->
            <div class="bg-white border border-gray-200 p-6 shadow-sm">
                <h3 class="text-sm font-bold font-heading text-[#00081e] mb-4 pb-2 border-b border-gray-100">Account Status</h3>
                
                <div class="space-y-3.5 text-xs font-sans">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-500">Role Level</span>
                        <span class="font-semibold text-gray-800">
                            {{ auth()->user()->isAdmin() ? 'Level 4 (Admin)' : (auth()->user()->isAuthor() ? 'Level 2 (Author)' : 'Level 1 (Public)') }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-gray-500">Articles Published</span>
                        <span class="font-semibold text-gray-800">
                            {{ number_format(auth()->user()->articles()->where('status', 'published')->count()) }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-gray-500">Last Login</span>
                        <span class="font-semibold text-gray-800">Today, {{ now()->format('h:i A') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Edit Profile & Password Form -->
        <div class="lg:col-span-8 space-y-8">
            
            <!-- Edit Profile Card -->
            <div class="bg-white border border-gray-200 shadow-sm p-6 lg:p-8">
                <h2 class="text-xl font-bold font-heading text-[#00081e] mb-6">Edit Profile</h2>

                <form method="POST" action="{{ auth()->user()->isAdmin() ? route('admin.settings.update') : route('author.settings.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <!-- Full Name & Preferred Name -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Full Name</label>
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       value="{{ old('name', auth()->user()->name) }}" 
                                       class="w-full bg-[#f8f9fa] border border-gray-300 px-3.5 py-2.5 text-sm text-gray-800 focus:bg-white focus:outline-none focus:border-[#8b1528] focus:ring-0" 
                                       required>
                            </div>

                            <div>
                                <label for="preferred_name" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Preferred Name</label>
                                <input type="text" 
                                       name="preferred_name" 
                                       id="preferred_name" 
                                       value="{{ old('preferred_name', auth()->user()->preferred_name ?? '') }}" 
                                       class="w-full bg-[#f8f9fa] border border-gray-300 px-3.5 py-2.5 text-sm text-gray-800 focus:bg-white focus:outline-none focus:border-[#8b1528] focus:ring-0">
                            </div>
                        </div>

                        <!-- Email Address & Phone Number -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="email" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Email Address</label>
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       value="{{ old('email', auth()->user()->email) }}" 
                                       class="w-full bg-[#f8f9fa] border border-gray-300 px-3.5 py-2.5 text-sm text-gray-800 focus:bg-white focus:outline-none focus:border-[#8b1528] focus:ring-0" 
                                       required>
                            </div>

                            <div>
                                <label for="phone_number" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Phone Number</label>
                                <input type="text" 
                                       name="phone_number" 
                                       id="phone_number" 
                                       value="{{ old('phone_number', auth()->user()->phone_number ?? '') }}" 
                                       placeholder="+1 (555) 123-4567" 
                                       class="w-full bg-[#f8f9fa] border border-gray-300 px-3.5 py-2.5 text-sm text-gray-800 focus:bg-white focus:outline-none focus:border-[#8b1528] focus:ring-0">
                            </div>
                        </div>

                        <!-- University & Department -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="university_id" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">University</label>
                                <select name="university_id" 
                                        id="university_id" 
                                        class="w-full bg-[#f8f9fa] border border-gray-300 px-3.5 py-2.5 text-sm text-gray-800 focus:bg-white focus:outline-none focus:border-[#8b1528] focus:ring-0">
                                    <option value="">Select University</option>
                                    @foreach($universities as $uni)
                                        <option value="{{ $uni->id }}" {{ old('university_id', auth()->user()->university_id) == $uni->id ? 'selected' : '' }}>
                                            {{ $uni->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="department" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Department</label>
                                <input type="text" 
                                       name="department" 
                                       id="department" 
                                       value="{{ old('department', auth()->user()->department ?? '') }}" 
                                       placeholder="e.g. Department of Communications" 
                                       class="w-full bg-[#f8f9fa] border border-gray-300 px-3.5 py-2.5 text-sm text-gray-800 focus:bg-white focus:outline-none focus:border-[#8b1528] focus:ring-0">
                            </div>
                        </div>

                        <!-- Biography -->
                        <div>
                            <label for="author_bio" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Biography</label>
                            <textarea name="author_bio" 
                                      id="author_bio" 
                                      rows="4" 
                                      class="w-full bg-[#f8f9fa] border border-gray-300 px-3.5 py-2.5 text-sm text-gray-800 focus:bg-white focus:outline-none focus:border-[#8b1528] focus:ring-0">{{ old('author_bio', auth()->user()->author_bio ?? '') }}</textarea>
                            <p class="text-gray-400 text-xs mt-1.5 font-sans">Brief description for your author profile page. Markdown supported.</p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="pt-6 border-t border-gray-100 flex items-center justify-end space-x-4">
                            <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('author.dashboard') }}" 
                               class="px-5 py-2.5 border border-gray-300 text-gray-700 hover:bg-gray-50 text-xs font-semibold uppercase tracking-wider transition-colors">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2.5 bg-[#8b1528] hover:bg-[#721120] text-white text-xs font-semibold uppercase tracking-wider flex items-center gap-2 shadow-sm transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                                </svg>
                                Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Security & Password Card -->
            <div class="bg-white border border-gray-200 shadow-sm p-6 lg:p-8">
                <h2 class="text-xl font-bold font-heading text-[#00081e] mb-3">Security & Password</h2>
                <p class="text-gray-600 text-xs font-sans mb-6">
                    To change your password, click the button below to receive a reset link via email.
                </p>

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                    <button type="submit" 
                            class="px-5 py-2.5 bg-[#8b1528] hover:bg-[#721120] text-white text-xs font-semibold uppercase tracking-wider inline-flex items-center gap-2 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Reset Password
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
