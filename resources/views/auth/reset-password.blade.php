<x-guest-layout>
    <div class="bg-surface shadow-sm border border-border-main p-8 w-full relative overflow-hidden" 
         x-data="passwordResetForm()">
        
        <!-- Decorative split top border -->
        <div class="absolute top-0 left-0 w-1/3 h-1 bg-crimson"></div>
        <div class="absolute top-0 right-0 w-2/3 h-1 bg-navy"></div>

        <div class="text-center mb-8 mt-2">
            <h2 class="font-heading text-2xl font-bold text-navy uppercase tracking-tight mb-2">Create New Password</h2>
            <p class="text-sm text-gray-500 font-serif">
                Please enter a strong password that meets the security requirements below.
            </p>
        </div>

        <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
            @csrf
            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address (Hidden but required for Laravel reset) -->
            <input type="hidden" name="email" value="{{ old('email', $request->email) }}">

            <!-- New Password -->
            <div>
                <label for="password" class="block text-sm font-semibold text-navy uppercase tracking-wider mb-2">New Password</label>
                <div class="relative">
                    <input id="password" 
                           class="block w-full border-border-main bg-gray-50 focus:bg-white focus:ring-0 focus:border-navy px-4 py-3 pr-10 text-text-main sm:text-sm" 
                           :type="showPassword ? 'text' : 'password'" 
                           name="password" 
                           x-model="password"
                           required 
                           autocomplete="new-password">
                    <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-navy focus:outline-none" aria-label="Toggle password visibility">
                        <svg x-show="!showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        <svg x-show="showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-crimson" />
                
                <!-- Password Strength Indicator -->
                <div class="mt-3 flex items-center justify-between" x-show="password.length > 0" x-cloak>
                    <div class="text-xs font-semibold uppercase tracking-wider" :class="strengthColorText" x-text="strengthLabel"></div>
                    <div class="flex-1 ml-4 flex h-1.5 space-x-1">
                        <div class="flex-1 bg-gray-200"><div class="h-full transition-all duration-300" :class="strength >= 1 ? strengthColorBg : ''"></div></div>
                        <div class="flex-1 bg-gray-200"><div class="h-full transition-all duration-300" :class="strength >= 3 ? strengthColorBg : ''"></div></div>
                        <div class="flex-1 bg-gray-200"><div class="h-full transition-all duration-300" :class="strength >= 5 ? strengthColorBg : ''"></div></div>
                    </div>
                </div>
            </div>

            <!-- Password Requirements Checklist -->
            <div class="bg-gray-50 p-4 border border-border-main">
                <p class="text-xs font-semibold text-navy uppercase tracking-wider mb-3">Password Requirements</p>
                <ul class="space-y-2 text-sm">
                    <template x-for="req in requirements" :key="req.label">
                        <li class="flex items-center" :class="req.met ? 'text-green-600' : 'text-gray-500'">
                            <svg x-show="req.met" class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            <svg x-show="!req.met" class="w-4 h-4 mr-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            <span x-text="req.label"></span>
                        </li>
                    </template>
                </ul>
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-navy uppercase tracking-wider mb-2">Confirm New Password</label>
                <div class="relative">
                    <input id="password_confirmation" 
                           class="block w-full border-border-main bg-gray-50 focus:bg-white focus:ring-0 focus:border-navy px-4 py-3 pr-10 text-text-main sm:text-sm" 
                           :class="{'border-crimson focus:border-crimson': confirmationError}"
                           :type="showConfirmPassword ? 'text' : 'password'" 
                           name="password_confirmation" 
                           x-model="passwordConfirmation"
                           required 
                           autocomplete="new-password">
                    <button type="button" @click="showConfirmPassword = !showConfirmPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-navy focus:outline-none" aria-label="Toggle password visibility">
                        <svg x-show="!showConfirmPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        <svg x-show="showConfirmPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                    </button>
                </div>
                <p x-show="confirmationError" class="text-crimson text-xs mt-2" x-cloak>Passwords do not match.</p>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-crimson" />
            </div>

            <div class="pt-4">
                <button type="submit" 
                        class="w-full flex justify-center py-3 px-4 border border-transparent text-sm font-heading font-bold uppercase tracking-wider text-white transition-colors"
                        :class="isFormValid ? 'bg-navy hover:bg-black' : 'bg-gray-400 cursor-not-allowed'"
                        :disabled="!isFormValid">
                    Reset Password
                </button>
            </div>
        </form>
    </div>

    <!-- Alpine Component Script -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('passwordResetForm', () => ({
                password: '',
                passwordConfirmation: '',
                showPassword: false,
                showConfirmPassword: false,

                get requirements() {
                    return [
                        { label: 'At least 8 characters', met: this.password.length >= 8 },
                        { label: 'Contains uppercase letter', met: /[A-Z]/.test(this.password) },
                        { label: 'Contains lowercase letter', met: /[a-z]/.test(this.password) },
                        { label: 'Contains number', met: /[0-9]/.test(this.password) },
                        { label: 'Contains special character', met: /[^A-Za-z0-9]/.test(this.password) }
                    ];
                },

                get strength() {
                    if (this.password.length === 0) return 0;
                    return this.requirements.filter(r => r.met).length;
                },

                get strengthLabel() {
                    if (this.strength === 0) return '';
                    if (this.strength < 3) return 'Weak';
                    if (this.strength < 5) return 'Medium';
                    return 'Strong';
                },

                get strengthColorText() {
                    if (this.strength < 3) return 'text-crimson';
                    if (this.strength < 5) return 'text-yellow-600';
                    return 'text-green-600';
                },

                get strengthColorBg() {
                    if (this.strength < 3) return 'bg-crimson';
                    if (this.strength < 5) return 'bg-yellow-500';
                    return 'bg-green-500';
                },

                get confirmationError() {
                    return this.passwordConfirmation.length > 0 && this.password !== this.passwordConfirmation;
                },

                get isFormValid() {
                    return this.strength === 5 && this.password === this.passwordConfirmation;
                }
            }));
        });
    </script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</x-guest-layout>
