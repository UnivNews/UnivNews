<x-guest-layout>
    <div class="bg-surface shadow-sm border border-border-main px-8 py-10 w-full relative">
        
        <!-- Graduation Cap Icon -->
        <div class="absolute -top-6 left-1/2 transform -translate-x-1/2 bg-navy rounded-full p-3 shadow-md border-4 border-background">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 14l9-5-9-5-9 5 9 5z"></path>
                <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path>
            </svg>
        </div>

        <div class="text-center mt-4 mb-8">
            <h2 class="font-heading text-2xl font-bold text-navy uppercase tracking-tight">Create Account</h2>
            <p class="text-gray-500 text-sm mt-2">Join the University Portal to manage news and content.</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-navy uppercase tracking-wider mb-2">Name</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <input id="name" class="block w-full pl-10 border-border-main bg-gray-50 focus:bg-white focus:ring-0 focus:border-navy px-4 py-3 text-text-main sm:text-sm" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Full Name">
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-crimson" />
            </div>

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-semibold text-navy uppercase tracking-wider mb-2">Email Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <input id="email" class="block w-full pl-10 border-border-main bg-gray-50 focus:bg-white focus:ring-0 focus:border-navy px-4 py-3 text-text-main sm:text-sm" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="e.g. jdoe@university.edu">
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-crimson" />
            </div>

            <!-- Password -->
            <div x-data="{ show: false }">
                <label for="password" class="block text-sm font-semibold text-navy uppercase tracking-wider mb-2">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <input id="password" class="block w-full pl-10 pr-10 border-border-main bg-gray-50 focus:bg-white focus:ring-0 focus:border-navy px-4 py-3 text-text-main sm:text-sm" :type="show ? 'text' : 'password'" name="password" required autocomplete="new-password" placeholder="Create a password">
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-navy focus:outline-none" aria-label="Toggle password visibility">
                        <svg x-show="!show" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        <svg x-show="show" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-crimson" />
                <p class="text-xs text-gray-500 mt-2">Password must be at least 8 characters and contain at least one uppercase letter, one lowercase letter, one number, and one symbol.</p>
            </div>

            <!-- Confirm Password -->
            <div x-data="{ show: false }">
                <label for="password_confirmation" class="block text-sm font-semibold text-navy uppercase tracking-wider mb-2">Confirm Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <input id="password_confirmation" class="block w-full pl-10 pr-10 border-border-main bg-gray-50 focus:bg-white focus:ring-0 focus:border-navy px-4 py-3 text-text-main sm:text-sm" :type="show ? 'text' : 'password'" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password">
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-navy focus:outline-none" aria-label="Toggle password visibility">
                        <svg x-show="!show" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        <svg x-show="show" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-crimson" />
            </div>

            <!-- Terms and Privacy Policy -->
            <div class="block">
                <label for="terms" class="inline-flex items-center">
                    <input id="terms" type="checkbox" class="text-crimson border-border-main focus:ring-crimson h-4 w-4" name="terms" required>
                    <span class="ml-2 text-sm text-gray-600">I agree to the <a href="#" class="underline hover:text-navy">Terms of Service</a> and <a href="#" class="underline hover:text-navy">Privacy Policy</a></span>
                </label>
                <x-input-error :messages="$errors->get('terms')" class="mt-2 text-crimson" />
            </div>

            @if(env('CAPTCHA_SITE_KEY'))
            <div>
                <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_SITE_KEY') }}"></div>
                <x-input-error :messages="$errors->get('g-recaptcha-response')" class="mt-2 text-crimson" />
                <script src="https://www.google.com/recaptcha/api.js" async defer></script>
            </div>
            @endif

            <!-- Register Button -->
            <div>
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent text-sm font-heading font-bold uppercase tracking-wider text-white bg-navy hover:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-navy transition-colors">
                    Register
                </button>
            </div>
        </form>

        <div class="mt-8 text-center border-t border-gray-100 pt-6">
            <p class="text-sm text-gray-500">
                Already registered? 
                <a href="{{ route('login') }}" class="font-semibold text-crimson hover:text-navy transition-colors">Sign in here</a>
            </p>
        </div>
    </div>
</x-guest-layout>
