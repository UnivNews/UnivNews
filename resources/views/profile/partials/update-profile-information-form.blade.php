<section class="bg-white border border-[#C5C6CF] p-6 sm:p-8 rounded-lg shadow-sm">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-gray-100">
        <div>
            <h2 class="font-heading font-bold text-lg text-[#00081E] flex items-center gap-2">
                <svg class="w-5 h-5 text-[#8b1528]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Profile Information
            </h2>
            <p class="font-sans text-xs sm:text-sm text-gray-500 mt-1">Update your account's public name, primary email address, and contact number.</p>
        </div>
        <div>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-gray-100 text-gray-700 border border-gray-200">
                Personal Info
            </span>
        </div>
    </div>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Profile Photo -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-6 items-center pb-6 border-b border-gray-100"
             x-data="{
                 previewUrl: '{{ $user->avatar_url }}',
                 hasAvatar: {{ $user->hasAvatar() ? 'true' : 'false' }},
                 removeAvatar: false,
                 errorMessage: '',
                 validateAndPreview(e) {
                     const file = e.target.files[0];
                     if (!file) return;

                     this.errorMessage = '';

                     // Format validation (PNG or JPG)
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
                     this.previewUrl = URL.createObjectURL(file);
                 },
                 removePhoto() {
                     this.previewUrl = '';
                     this.removeAvatar = true;
                     this.errorMessage = '';
                     const input = document.getElementById('profile_avatar_input');
                     if (input) input.value = '';
                 }
             }">
            <label class="font-sans font-bold text-xs text-[#00081E] uppercase tracking-wider">
                Profile Photo
            </label>
            <div class="md:col-span-2 flex flex-col sm:flex-row sm:items-center gap-5">
                <!-- Avatar Circle -->
                <div class="relative w-20 h-20 rounded-full border-2 border-gray-200 overflow-hidden bg-slate-100 flex-shrink-0 shadow-sm flex items-center justify-center">
                    <template x-if="previewUrl">
                        <img :src="previewUrl" alt="Profile Photo" class="w-full h-full object-cover">
                    </template>
                    <template x-if="!previewUrl">
                        <span class="font-heading font-bold text-xl text-navy uppercase">
                            {{ substr($user->name, 0, 2) }}
                        </span>
                    </template>
                </div>

                <!-- Action buttons and notes -->
                <div class="space-y-2">
                    <div class="flex items-center gap-3">
                        <input type="file"
                               id="profile_avatar_input"
                               name="avatar"
                               accept="image/png,image/jpeg"
                               class="hidden"
                               @change="validateAndPreview($event)">
                        <input type="hidden" name="remove_avatar" :value="removeAvatar ? '1' : '0'">

                        <button type="button"
                                @click="document.getElementById('profile_avatar_input').click()"
                                class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white border border-gray-300 hover:border-navy hover:text-navy text-xs font-bold uppercase tracking-wider rounded-md text-gray-700 shadow-xs transition-colors">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>Upload Photo</span>
                        </button>

                        <button type="button"
                                x-show="previewUrl"
                                @click="removePhoto()"
                                class="px-3 py-2 text-xs font-semibold text-red-600 hover:text-red-800 transition-colors">
                            Remove
                        </button>
                    </div>

                    <p class="font-sans text-xs text-gray-500">
                        PNG or JPG only (max. <strong>2MB</strong>). Automatically compressed before saving.
                    </p>

                    <template x-if="errorMessage">
                        <p class="font-sans text-xs text-red-600 font-semibold" x-text="errorMessage"></p>
                    </template>
                    <x-input-error class="mt-1" :messages="$errors->get('avatar')" />
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-6 items-start">
            <label for="name" class="font-sans font-bold text-xs text-[#00081E] uppercase tracking-wider pt-2.5">
                Full Name
            </label>
            <div class="md:col-span-2">
                <input id="name" name="name" type="text" class="block w-full rounded-md border border-gray-300 focus:border-[#8b1528] focus:ring-1 focus:ring-[#8b1528] px-4 py-2.5 font-sans text-sm text-gray-900 transition-colors" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-6 items-start"
             x-data="{
                 emailInput: '{{ old('email', $user->email) }}',
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
            <label for="email" class="font-sans font-bold text-xs text-[#00081E] uppercase tracking-wider pt-2.5">
                Email Address
            </label>
            <div class="md:col-span-2">
                <input id="email"
                       name="email"
                       type="email"
                       x-model="emailInput"
                       class="block w-full rounded-md border border-gray-300 focus:border-[#8b1528] focus:ring-1 focus:ring-[#8b1528] px-4 py-2.5 font-sans text-sm text-gray-900 transition-colors"
                       value="{{ old('email', $user->email) }}"
                       required
                       autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                <div class="mt-3 space-y-3">
                    @if ($user->hasVerifiedEmail())
                        <div class="flex flex-wrap items-center justify-between gap-3 p-3 bg-green-50 border border-green-200 rounded-md">
                            <div class="flex items-center gap-2">
                                <span class="w-5 h-5 rounded-full bg-green-600 text-white flex items-center justify-center text-xs font-bold">✓</span>
                                <div>
                                    <span class="text-xs font-bold text-green-900 uppercase tracking-wider">Email Verified</span>
                                    <p class="text-[11px] text-green-700">Verified at {{ $user->email_verified_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>

                            @if($user->isGoogleLinked())
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
                    @elseif (!$user->hasGoogleEmail())
                        <!-- Alert: Non-Google Email Address (Not Found on Google) -->
                        <div class="p-4 bg-red-50 border border-red-200 rounded-md space-y-3">
                            <div class="flex items-start gap-2.5">
                                <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                <div>
                                    <div class="font-bold text-xs text-red-900 uppercase tracking-wider">Google Account Not Found</div>
                                    <p class="text-xs text-red-800 mt-0.5">
                                        The email <strong>{{ $user->email }}</strong> was not found on Google. Author applicants must use a valid Google (Gmail) account to receive notifications.
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
                                        Your email must be verified before you can apply to become an Author. Verify it via your Gmail mailbox or verify directly via Google.
                                    </p>
                                </div>
                            </div>

                            @if (session('status') === 'verification-link-sent')
                                <div class="p-2.5 bg-green-50 border border-green-200 rounded text-xs text-green-800 font-medium">
                                    ✓ A new verification link has been sent to your Gmail inbox (<strong>{{ $user->email }}</strong>). Please check your Gmail mailbox or spam folder.
                                </div>
                            @endif

                            <div class="flex flex-wrap items-center gap-2 pt-1">
                                <button form="send-verification" type="submit" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-[#8b1528] hover:bg-[#6b0f1f] text-white text-xs font-bold uppercase tracking-wider rounded transition-colors shadow-xs">
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
        </div>

        <!-- Phone Number -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-6 items-start">
            <label for="phone_number" class="font-sans font-bold text-xs text-[#00081E] uppercase tracking-wider pt-2.5">
                Phone Number
            </label>
            <div class="md:col-span-2">
                <input id="phone_number"
                       name="phone_number"
                       type="tel"
                       placeholder="e.g. +62 812-3456-7890"
                       class="block w-full rounded-md border border-gray-300 focus:border-[#8b1528] focus:ring-1 focus:ring-[#8b1528] px-4 py-2.5 font-sans text-sm text-gray-900 transition-colors"
                       value="{{ old('phone_number', $user->phone_number) }}"
                       autocomplete="tel" />
                <p class="font-sans text-xs text-gray-500 mt-1.5">Optional. Used for account security, verification, and editorial contact if you apply as an Author.</p>
                <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
            </div>
        </div>

        <div class="flex justify-end items-center gap-4 pt-4 border-t border-gray-100">
            @if (session('status') === 'profile-updated')
                <span
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2500)"
                    class="font-sans text-xs font-semibold text-green-600 flex items-center gap-1"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Saved successfully.
                </span>
            @endif
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-navy hover:bg-gray-800 text-white font-sans font-bold text-xs uppercase tracking-wider rounded-md transition-colors shadow-sm">
                Save Changes
            </button>
        </div>
    </form>
</section>
