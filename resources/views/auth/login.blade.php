<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

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
            <h2 class="font-heading text-2xl font-bold text-navy uppercase tracking-tight">University Portal</h2>
            <p class="text-gray-500 text-sm mt-2">Sign in to manage news and editorial content.</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email Address / NetID -->
            <div>
                <label for="email" class="block text-sm font-semibold text-navy uppercase tracking-wider mb-2">Email Address / NetID</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <input id="email" class="block w-full pl-10 border-border-main bg-gray-50 focus:bg-white focus:ring-0 focus:border-navy px-4 py-3 text-text-main sm:text-sm" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="e.g. jdoe@university.edu">
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-crimson" />
            </div>

            <!-- Password -->
            <div x-data="{ show: false }">
                <div class="flex justify-between items-end mb-2">
                    <label for="password" class="block text-sm font-semibold text-navy uppercase tracking-wider">Password</label>
                    @if (Route::has('password.request'))
                        <a class="text-xs font-semibold text-crimson hover:text-navy transition-colors" href="{{ route('password.request') }}">
                            Forgot your password?
                        </a>
                    @endif
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <input id="password" class="block w-full pl-10 pr-10 border-border-main bg-gray-50 focus:bg-white focus:ring-0 focus:border-navy px-4 py-3 text-text-main sm:text-sm" :type="show ? 'text' : 'password'" name="password" required autocomplete="current-password" placeholder="Enter your password">
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-navy focus:outline-none" aria-label="Toggle password visibility">
                        <svg x-show="!show" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        <svg x-show="show" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-crimson" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="text-crimson border-border-main focus:ring-crimson h-4 w-4" name="remember">
                    <span class="ml-2 text-sm text-gray-600">Keep me signed in for 30 days</span>
                </label>
            </div>

            <!-- Sign In Button -->
            <div>
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent text-sm font-heading font-bold uppercase tracking-wider text-white bg-navy hover:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-navy transition-colors">
                    Sign In
                </button>
            </div>
        </form>

        <div class="mt-6">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-border-main"></div>
                </div>
                <div class="relative flex justify-center text-xs">
                    <span class="px-2 bg-surface text-gray-400 uppercase tracking-widest font-heading font-semibold">
                        Or continue with
                    </span>
                </div>
            </div>

            <div class="mt-6">
                <button type="button" class="w-full flex justify-center items-center py-3 px-4 border border-border-main bg-white text-sm font-heading font-bold uppercase tracking-wider text-navy hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-navy transition-colors">
                    <svg class="w-5 h-5 mr-2 text-crimson" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.477 2 2 6.477 2 12c0 5.523 4.477 10 10 10s10-4.477 10-10c0-5.523-4.477-10-10-10zm5.121 13.536c-.463 1.253-1.63 2.152-3.036 2.378-1.745.281-3.418-.755-3.864-2.476-.445-1.721.503-3.475 2.186-3.987a3.953 3.953 0 011.666-.089V10.21c-.551-.101-1.121-.082-1.665.056-2.247.57-3.619 2.859-3.064 5.105.555 2.246 2.845 3.618 5.092 3.048 1.838-.466 3.167-2.029 3.328-3.918l-3.643-.965z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                    Institutional SSO
                </button>
            </div>
        </div>
        
        <div class="mt-8 text-center border-t border-gray-100 pt-6">
            <p class="text-sm text-gray-500">
                Don't have access? 
                <a href="{{ url('/account-request') }}" class="font-semibold text-crimson hover:text-navy transition-colors">Request an account</a>
            </p>
        </div>
    </div>
</x-guest-layout>
