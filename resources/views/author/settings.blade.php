@extends('layouts.cms')

@section('title', 'Author Profile & Settings - University News')
@section('header_tagline', 'University News CMS')
@section('page_tour_id', 'author.settings')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold font-heading text-[#00081e] tracking-tight">User Profile</h1>
        <p class="text-gray-500 font-sans text-sm mt-1">Manage your author account settings and preferences.</p>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-600 text-green-700 text-sm font-sans flex items-center gap-2">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

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

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start"
         x-data="{
             previewUrl: '{{ auth()->user()->avatar_url }}',
             hasAvatar: {{ auth()->user()->hasAvatar() ? 'true' : 'false' }},
             removeAvatar: false,
             newPhotoSelected: false,
             errorMessage: '',
             validateAndPreview(e) {
                 const file = e.target.files[0];
                 if (!file) return;

                 this.errorMessage = '';

                 // Format validation (Strictly PNG or JPG)
                 const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                 const fileExt = file.name.split('.').pop().toLowerCase();
                 const validExts = ['jpg', 'jpeg', 'png'];

                 if (!validTypes.includes(file.type) && !validExts.includes(fileExt)) {
                     const msg = 'Invalid format! Only PNG or JPG photos are allowed.';
                     this.errorMessage = msg;
                     if (window.showWarningAlert) {
                         window.showWarningAlert('Format Warning', msg);
                     } else {
                         alert(msg);
                     }
                     e.target.value = '';
                     return;
                 }

                 // Maximum size: 2MB (2 * 1024 * 1024 = 2,097,152 bytes)
                 if (file.size > 2 * 1024 * 1024) {
                     const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
                     const msg = 'Photo exceeds the 2MB size limit (' + sizeMB + ' MB). Please choose a smaller file.';
                     this.errorMessage = msg;
                     if (window.showWarningAlert) {
                         window.showWarningAlert('File Size Warning', msg);
                     } else {
                         alert(msg);
                     }
                     e.target.value = '';
                     return;
                 }

                 this.removeAvatar = false;
                 this.newPhotoSelected = true;
                 this.previewUrl = URL.createObjectURL(file);
                 if (window.showSuccessAlert) {
                     window.showSuccessAlert('Photo Selected', 'Click Save Changes to apply your new profile photo.');
                 }
             },
             removePhoto() {
                 this.previewUrl = '';
                 this.removeAvatar = true;
                 this.newPhotoSelected = false;
                 this.errorMessage = '';
                 const input = document.getElementById('author_avatar_input');
                 if (input) input.value = '';
                 if (window.showInfoAlert) {
                     window.showInfoAlert('Photo Marked for Removal', 'Click Save Changes to permanently remove your photo.');
                 }
             }
         }">
        
        <!-- Left Column: Profile Card & Account Status -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Main Profile Summary Card -->
            <div class="bg-white border border-gray-200 p-6 text-center shadow-sm">
                <!-- Avatar -->
                <div class="relative group w-32 h-40 mx-auto bg-gray-100 border border-gray-200 overflow-hidden shadow-inner flex items-center justify-center mb-3">
                    <template x-if="previewUrl">
                        <img :src="previewUrl" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                    </template>
                    <template x-if="!previewUrl">
                        <div class="w-full h-full bg-slate-200 flex flex-col items-center justify-center text-slate-400">
                            <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                        </div>
                    </template>

                    <!-- Quick Change Overlay -->
                    <button type="button" 
                            @click="document.getElementById('author_avatar_input').click()"
                            class="absolute inset-0 bg-black/50 text-white opacity-0 group-hover:opacity-100 flex flex-col items-center justify-center gap-1 transition-opacity cursor-pointer text-xs font-semibold">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>Change</span>
                    </button>
                </div>

                <!-- Avatar Actions -->
                <div class="mb-4 space-y-2">
                    <div class="flex items-center justify-center gap-2">
                        <button type="button" 
                                @click="document.getElementById('author_avatar_input').click()"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#f4f6f8] hover:bg-[#eef0f2] border border-gray-300 text-gray-700 text-xs font-semibold uppercase tracking-wider transition-colors">
                            <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            <span>Change Photo</span>
                        </button>

                        <button type="button" 
                                x-show="previewUrl"
                                @click="removePhoto()"
                                class="inline-flex items-center px-2.5 py-1.5 text-xs font-semibold text-red-600 hover:text-red-800 hover:bg-red-50 transition-colors">
                            Remove
                        </button>
                    </div>

                    <!-- Size / Format Help text -->
                    <p class="text-[11px] text-gray-500 font-sans">
                        PNG or JPG &bull; Max <strong>2MB</strong> &bull; Auto compressed
                    </p>

                    <template x-if="newPhotoSelected">
                        <div class="inline-flex items-center gap-1 text-[11px] font-semibold text-amber-600 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                            <span>Photo selected &mdash; click Save Changes</span>
                        </div>
                    </template>
                    <template x-if="removeAvatar">
                        <div class="inline-flex items-center gap-1 text-[11px] font-semibold text-red-600 bg-red-50 border border-red-200 px-2 py-0.5 rounded">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                            <span>Removed &mdash; click Save Changes</span>
                        </div>
                    </template>
                    <template x-if="errorMessage">
                        <p class="text-[11px] font-semibold text-red-600 font-sans" x-text="errorMessage"></p>
                    </template>
                </div>

                <!-- User Name & Title -->
                <h2 class="text-xl font-bold font-heading text-[#00081e]">{{ auth()->user()->name }}</h2>
                <div class="mt-1.5 inline-block">
                    <span class="px-2.5 py-0.5 bg-gray-100 text-gray-700 text-xs font-semibold uppercase tracking-wider border border-gray-200">
                        {{ auth()->user()->department ? auth()->user()->department : 'Staff Author' }}
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
                        <span>{{ auth()->user()->university->name ?? 'University of Indonesia' }}</span>
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
            <div class="bg-white border border-gray-200 p-6 shadow-sm" data-tour="settings-profile-card">
                <h3 class="text-sm font-bold font-heading text-[#00081e] mb-4 pb-2 border-b border-gray-100">Account Status</h3>
                
                <div class="space-y-3.5 text-xs font-sans">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-500">Role Level</span>
                        <span class="font-semibold text-gray-800">
                            Level 2 (Author)
                        </span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-gray-500">Articles Published</span>
                        <span class="font-semibold text-gray-800">
                            {{ number_format(auth()->user()->articles()->where('status', 'published')->count()) }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-gray-500">Author Status</span>
                        <span class="px-2 py-0.5 text-xs font-medium bg-green-100 text-green-800">
                            {{ ucfirst(auth()->user()->author_status) }}
                        </span>
                    </div>
                </div>

                <!-- Tutorial Replay Button -->
                <div class="mt-5 pt-4 border-t border-gray-100">
                    <button
                        onclick="typeof window.replayOnboarding === 'function' ? window.replayOnboarding() : null"
                        class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-[#f4f6f8] hover:bg-[#eef0f2] border border-gray-200 text-gray-600 hover:text-[#8b1528] text-[11px] font-semibold uppercase tracking-wider transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Lihat Tutorial Dashboard
                    </button>
                </div>
            </div>
        </div>

        <!-- Right Column: Edit Profile & Password Form -->
        <div class="lg:col-span-8 space-y-8">
            
            <!-- Edit Profile Card -->
            <div class="bg-white border border-gray-200 shadow-sm p-6 lg:p-8">
                <h2 class="text-xl font-bold font-heading text-[#00081e] mb-6">Edit Profile</h2>

                <form id="author-send-verification" method="POST" action="{{ route('verification.send') }}">
                    @csrf
                </form>

                <form id="author-profile-form" method="POST" action="{{ route('author.settings.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <input type="file" 
                           id="author_avatar_input" 
                           name="avatar" 
                           accept="image/png,image/jpeg" 
                           class="hidden" 
                           @change="validateAndPreview($event)">
                    <input type="hidden" 
                           name="remove_avatar" 
                           :value="removeAvatar ? '1' : '0'">

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

                        <!-- Email Address & Phone Number with Google Verification -->
                        @php $authorUser = auth()->user(); @endphp
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6"
                             x-data="{
                                 emailInput: '{{ old('email', $authorUser->email) }}',
                                 checking: false,
                                 checkResult: null,
                                 async checkGoogleEmail() {
                                     if (!this.emailInput || !this.emailInput.includes('@')) {
                                         this.checkResult = { is_google: false, message: 'Please enter a valid email address.' };
                                         return;
                                     }
                                     this.checking = true;
                                     this.checkResult = null;
                                     try {
                                         const res = await fetch('{{ route('profile.check-google-email') }}?email=' + encodeURIComponent(this.emailInput));
                                         const data = await res.json();
                                         this.checkResult = data;
                                     } catch (err) {
                                         this.checkResult = { is_google: false, message: 'Could not connect to Google verification check.' };
                                     } finally {
                                         this.checking = false;
                                     }
                                 }
                             }">
                            <div>
                                <label for="email" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Email Address</label>
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       x-model="emailInput"
                                       value="{{ old('email', $authorUser->email) }}" 
                                       class="w-full bg-[#f8f9fa] border border-gray-300 px-3.5 py-2.5 text-sm text-gray-800 focus:bg-white focus:outline-none focus:border-[#8b1528] focus:ring-0" 
                                       required>

                                <div class="mt-3 space-y-3 font-sans">
                                    @if ($authorUser->hasVerifiedEmail())
                                        <div class="flex flex-wrap items-center justify-between gap-3 p-3 bg-green-50 border border-green-200 rounded-md">
                                            <div class="flex items-center gap-2">
                                                <span class="w-5 h-5 rounded-full bg-green-600 text-white flex items-center justify-center text-xs font-bold">✓</span>
                                                <div>
                                                    <span class="text-xs font-bold text-green-900 uppercase tracking-wider">Email Verified</span>
                                                    <p class="text-[11px] text-green-700">Verified at {{ $authorUser->email_verified_at->format('d M Y, H:i') }}</p>
                                                </div>
                                            </div>

                                            @if($authorUser->isGoogleLinked())
                                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-white border border-gray-200 rounded text-[11px] font-semibold text-gray-700 shadow-xs">
                                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24"><path fill="#EA4335" d="M12 5c1.6 0 3 .6 4.1 1.7l3.1-3.1C17.3 1.8 14.8 1 12 1 7.4 1 3.5 3.6 1.6 7.4l3.7 2.9C6.2 7.2 8.9 5 12 5z"/><path fill="#4285F4" d="M23.5 12.3c0-.8-.1-1.6-.2-2.3H12v4.5h6.5c-.3 1.5-1.1 2.8-2.4 3.7l3.7 2.9c2.2-2 3.7-5 3.7-8.8z"/><path fill="#FBBC05" d="M5.3 14.7c-.2-.7-.4-1.5-.4-2.7s.2-2 .4-2.7L1.6 6.4C.6 8.4 0 10.6 0 12s.6 3.6 1.6 5.6l3.7-2.9z"/><path fill="#34A853" d="M12 23c3.2 0 6-1.1 8-3l-3.7-2.9c-1.1.7-2.5 1.2-4.3 1.2-3.1 0-5.8-2.2-6.7-5.3L1.6 16C3.5 19.8 7.4 23 12 23z"/></svg>
                                                    <span>Connected with Google (Gmail)</span>
                                                </div>
                                            @else
                                                <a href="{{ route('auth.google.redirect') }}" class="inline-flex items-center gap-1.5 px-3 py-1 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 rounded text-[11px] font-bold uppercase tracking-wider transition-colors shadow-xs">
                                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24"><path fill="#EA4335" d="M12 5c1.6 0 3 .6 4.1 1.7l3.1-3.1C17.3 1.8 14.8 1 12 1 7.4 1 3.5 3.6 1.6 7.4l3.7 2.9C6.2 7.2 8.9 5 12 5z"/><path fill="#4285F4" d="M23.5 12.3c0-.8-.1-1.6-.2-2.3H12v4.5h6.5c-.3 1.5-1.1 2.8-2.4 3.7l3.7 2.9c2.2-2 3.7-5 3.7-8.8z"/><path fill="#FBBC05" d="M5.3 14.7c-.2-.7-.4-1.5-.4-2.7s.2-2 .4-2.7L1.6 6.4C.6 8.4 0 10.6 0 12s.6 3.6 1.6 5.6l3.7-2.9z"/><path fill="#34A853" d="M12 23c3.2 0 6-1.1 8-3l-3.7-2.9c-1.1.7-2.5 1.2-4.3 1.2-3.1 0-5.8-2.2-6.7-5.3L1.6 16C3.5 19.8 7.4 23 12 23z"/></svg>
                                                    <span>Connect Google Account</span>
                                                </a>
                                            @endif
                                        </div>
                                    @elseif (!$authorUser->hasGoogleEmail())
                                        <!-- Alert: Non-Google Email Address -->
                                        <div class="p-4 bg-red-50 border border-red-200 rounded-md space-y-3">
                                            <div class="flex items-start gap-2.5">
                                                <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                                <div>
                                                    <div class="font-bold text-xs text-red-900 uppercase tracking-wider">Google Account Not Found</div>
                                                    <p class="text-xs text-red-800 mt-0.5">
                                                        The email <strong>{{ $authorUser->email }}</strong> was not found on Google. Authors must use a valid Google (Gmail) account to receive editorial status notifications.
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="flex flex-wrap items-center gap-2 pt-1 border-t border-red-100">
                                                <button type="button"
                                                        @click="checkGoogleEmail()"
                                                        :disabled="checking"
                                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-xs font-bold uppercase tracking-wider rounded transition-colors shadow-xs">
                                                    <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                                    <span x-text="checking ? 'Checking Google...' : 'Check if Email Exists on Google'">Check if Email Exists on Google</span>
                                                </button>

                                                <a href="{{ route('auth.google.redirect') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-xs font-bold uppercase tracking-wider rounded transition-colors shadow-xs">
                                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24"><path fill="#EA4335" d="M12 5c1.6 0 3 .6 4.1 1.7l3.1-3.1C17.3 1.8 14.8 1 12 1 7.4 1 3.5 3.6 1.6 7.4l3.7 2.9C6.2 7.2 8.9 5 12 5z"/><path fill="#4285F4" d="M23.5 12.3c0-.8-.1-1.6-.2-2.3H12v4.5h6.5c-.3 1.5-1.1 2.8-2.4 3.7l3.7 2.9c2.2-2 3.7-5 3.7-8.8z"/><path fill="#FBBC05" d="M5.3 14.7c-.2-.7-.4-1.5-.4-2.7s.2-2 .4-2.7L1.6 6.4C.6 8.4 0 10.6 0 12s.6 3.6 1.6 5.6l3.7-2.9z"/><path fill="#34A853" d="M12 23c3.2 0 6-1.1 8-3l-3.7-2.9c-1.1.7-2.5 1.2-4.3 1.2-3.1 0-5.8-2.2-6.7-5.3L1.6 16C3.5 19.8 7.4 23 12 23z"/></svg>
                                                    <span>Connect with Google (Gmail)</span>
                                                </a>
                                            </div>

                                            <template x-if="checkResult">
                                                <div class="p-2.5 rounded text-xs font-medium" :class="checkResult.is_google ? 'bg-green-100 text-green-900 border border-green-200' : 'bg-red-100 text-red-900 border border-red-200'" x-text="checkResult.message"></div>
                                            </template>
                                        </div>
                                    @else
                                        <!-- Alert: Google Email Detected — Unverified -->
                                        <div class="p-4 bg-amber-50 border border-amber-300 rounded-md space-y-3">
                                            <div class="flex items-start gap-2.5">
                                                <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                                <div>
                                                    <div class="font-bold text-xs text-amber-900 uppercase tracking-wider">Google (Gmail) Account Detected — Unverified</div>
                                                    <p class="text-xs text-amber-800 mt-0.5">
                                                        Your author email address is recognized as a Google account, but has not yet been verified. Verify via your Gmail mailbox or verify directly via Google.
                                                    </p>
                                                </div>
                                            </div>

                                            @if (session('status') === 'verification-link-sent')
                                                <div class="p-2.5 bg-green-50 border border-green-200 rounded text-xs text-green-800 font-medium">
                                                    ✓ A new verification link has been sent to your Gmail inbox (<strong>{{ $authorUser->email }}</strong>). Please check your Gmail mailbox or spam folder.
                                                </div>
                                            @endif

                                            <div class="flex flex-wrap items-center gap-2 pt-1">
                                                <button form="author-send-verification" type="submit" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-[#8b1528] hover:bg-[#6b0f1f] text-white text-xs font-bold uppercase tracking-wider rounded transition-colors shadow-xs">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                                    <span>Verify via Gmail Mailbox</span>
                                                </button>

                                                <a href="{{ route('auth.google.redirect') }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-xs font-bold uppercase tracking-wider rounded transition-colors shadow-xs">
                                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24"><path fill="#EA4335" d="M12 5c1.6 0 3 .6 4.1 1.7l3.1-3.1C17.3 1.8 14.8 1 12 1 7.4 1 3.5 3.6 1.6 7.4l3.7 2.9C6.2 7.2 8.9 5 12 5z"/><path fill="#4285F4" d="M23.5 12.3c0-.8-.1-1.6-.2-2.3H12v4.5h6.5c-.3 1.5-1.1 2.8-2.4 3.7l3.7 2.9c2.2-2 3.7-5 3.7-8.8z"/><path fill="#FBBC05" d="M5.3 14.7c-.2-.7-.4-1.5-.4-2.7s.2-2 .4-2.7L1.6 6.4C.6 8.4 0 10.6 0 12s.6 3.6 1.6 5.6l3.7-2.9z"/><path fill="#34A853" d="M12 23c3.2 0 6-1.1 8-3l-3.7-2.9c-1.1.7-2.5 1.2-4.3 1.2-3.1 0-5.8-2.2-6.7-5.3L1.6 16C3.5 19.8 7.4 23 12 23z"/></svg>
                                                    <span>Verify with Google Account</span>
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div>
                                <label for="phone_number" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Phone Number</label>
                                <input type="text" 
                                       name="phone_number" 
                                       id="phone_number" 
                                       value="{{ old('phone_number', $authorUser->phone_number ?? '') }}" 
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
                                       placeholder="e.g. Advanced Physics Laboratory" 
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
                            <a href="{{ route('author.dashboard') }}" 
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
            <div class="bg-white border border-gray-200 shadow-sm p-6 lg:p-8" data-tour="settings-password">
                <h2 class="text-xl font-bold font-heading text-[#00081e] mb-3">Security & Password</h2>
                
                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-3 border border-green-200">
                        {{ session('status') }}
                    </div>
                @endif

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
