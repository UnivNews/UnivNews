<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="bg-navy shadow-sm border border-border-main px-8 py-10 w-full relative">
        <div class="text-center mt-4 mb-8">
            <h2 class="font-heading text-2xl font-bold text-white uppercase tracking-tight">Admin CMS</h2>
            <p class="text-gray-300 text-sm mt-2">Sign in to the administrative dashboard.</p>
        </div>

        <form method="POST" action="{{ route('admin.login') }}" class="space-y-6">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-semibold text-white uppercase tracking-wider mb-2">Email Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <input id="email" class="block w-full pl-10 border-border-main bg-white focus:ring-0 focus:border-crimson px-4 py-3 text-text-main sm:text-sm" type="email" name="email" :value="old('email')" required autofocus autocomplete="username">
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-crimson" />
            </div>

            <!-- Password -->
            <div>
                <div class="flex justify-between items-end mb-2">
                    <label for="password" class="block text-sm font-semibold text-white uppercase tracking-wider">Password</label>
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <input id="password" class="block w-full pl-10 pr-10 border-border-main bg-white focus:ring-0 focus:border-crimson px-4 py-3 text-text-main sm:text-sm" type="password" name="password" required autocomplete="current-password">
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-crimson" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="text-crimson border-border-main focus:ring-crimson h-4 w-4" name="remember">
                    <span class="ml-2 text-sm text-gray-300">Remember me</span>
                </label>
            </div>

            <!-- Sign In Button -->
            <div>
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent text-sm font-heading font-bold uppercase tracking-wider text-white bg-crimson hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-crimson transition-colors">
                    Sign In
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
