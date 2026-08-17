<x-guest-layout>
    <div class="bg-surface shadow-sm border border-border-main p-8 w-full">
        
        @if(session('status'))
            <!-- Success State -->
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-600 mb-6 shadow-md">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h2 class="font-heading text-2xl font-bold text-navy uppercase tracking-tight mb-2">Request Submitted</h2>
                <p class="text-sm text-gray-600 mb-8 font-serif">
                    {{ session('status') }} We will review your request and contact you via email shortly.
                </p>
                <a href="{{ route('login') }}" class="w-full flex justify-center py-3 px-4 border border-transparent text-sm font-heading font-bold uppercase tracking-wider text-white bg-navy hover:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-navy transition-colors">
                    Return to Login
                </a>
            </div>
        @else
            <!-- Request Form -->
            <div class="text-center mb-8">
                <h2 class="font-heading text-2xl font-bold text-navy uppercase tracking-tight mb-2">Account Request</h2>
                <p class="text-sm text-gray-500 font-serif">
                    Submit your details to request faculty/staff access to the CMS.
                </p>
            </div>

            <form method="POST" action="{{ route('account-request.store') }}" class="space-y-6">
                @csrf

                <!-- Full Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-navy uppercase tracking-wider mb-2">Full Name</label>
                    <input id="name" class="block w-full border-border-main bg-gray-50 focus:bg-white focus:ring-0 focus:border-navy px-4 py-3 text-text-main sm:text-sm" type="text" name="name" :value="old('name')" required autofocus placeholder="e.g. John Doe">
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-crimson" />
                </div>

                <!-- Institutional Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-navy uppercase tracking-wider mb-2">Institutional Email</label>
                    <input id="email" class="block w-full border-border-main bg-gray-50 focus:bg-white focus:ring-0 focus:border-navy px-4 py-3 text-text-main sm:text-sm" type="email" name="email" :value="old('email')" required placeholder="e.g. jdoe@university.edu">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-crimson" />
                </div>

                <!-- Department / Role -->
                <div>
                    <label for="department" class="block text-sm font-semibold text-navy uppercase tracking-wider mb-2">Department / Role</label>
                    <div class="relative">
                        <select id="department" name="department" class="block w-full border-border-main bg-gray-50 focus:bg-white focus:ring-0 focus:border-navy px-4 py-3 text-text-main sm:text-sm appearance-none" required>
                            <option value="" disabled selected>Select your primary affiliation</option>
                            <option value="faculty" @selected(old('department') == 'faculty')>Faculty / Academic Staff</option>
                            <option value="administration" @selected(old('department') == 'administration')>University Administration</option>
                            <option value="communications" @selected(old('department') == 'communications')>Communications & PR</option>
                            <option value="research" @selected(old('department') == 'research')>Research Institute</option>
                            <option value="other" @selected(old('department') == 'other')>Other</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('department')" class="mt-2 text-crimson" />
                </div>

                <!-- Request Access Button -->
                <div>
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent text-sm font-heading font-bold uppercase tracking-wider text-white bg-navy hover:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-navy transition-colors">
                        Request Access
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center border-t border-gray-100 pt-6">
                <p class="text-sm text-gray-500">
                    <span class="text-crimson font-semibold">Already verified?</span>
                    <a href="{{ route('login') }}" class="font-semibold text-navy hover:text-crimson uppercase tracking-wider text-xs ml-2 transition-colors">Return to Login</a>
                </p>
            </div>

            <!-- Security Notice -->
            <div class="mt-8 bg-gray-50 border-l-4 border-l-crimson border-y border-r border-y-border-main border-r-border-main p-4 flex items-start">
                <svg class="w-5 h-5 text-crimson mr-3 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <div class="text-xs text-gray-600 font-sans leading-relaxed">
                    Access to this system is restricted to authorized personnel only. Use of this system is subject to institutional IT security and acceptable use policies.
                </div>
            </div>
        @endif
    </div>
</x-guest-layout>
