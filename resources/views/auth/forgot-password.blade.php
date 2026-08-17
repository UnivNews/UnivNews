<x-guest-layout>
    
    @slot('support')
        <div class="pr-8">
            <h3 class="font-heading font-bold text-xl text-navy uppercase tracking-tight border-b-2 border-crimson pb-2 mb-4 inline-block">Support Center</h3>
            <div class="space-y-4 text-sm text-gray-600">
                <p>If you're having trouble accessing your account, please contact the IT Helpdesk.</p>
                
                @if(config('support.phone'))
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-crimson mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    <span>{{ config('support.phone') }}</span>
                </div>
                @endif
                
                @if(config('support.email'))
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-crimson mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    <span>{{ config('support.email') }}</span>
                </div>
                @endif
                
                @if(!config('support.phone') && !config('support.email'))
                <div class="p-4 bg-gray-50 border border-border-main text-gray-500 italic">
                    IT Helpdesk contact information will be added here.
                </div>
                @endif
            </div>
        </div>
    @endslot

    @slot('support_mobile')
        <div class="bg-white p-6 shadow-sm border border-border-main">
            <h3 class="font-heading font-bold text-lg text-navy uppercase tracking-tight mb-3">Support Center</h3>
            <p class="text-sm text-gray-600 mb-3">Having trouble? Contact the IT Helpdesk.</p>
            @if(config('support.phone') || config('support.email'))
                <div class="space-y-2 text-sm text-gray-600">
                    @if(config('support.phone')) <div>Phone: {{ config('support.phone') }}</div> @endif
                    @if(config('support.email')) <div>Email: {{ config('support.email') }}</div> @endif
                </div>
            @else
                <div class="text-sm text-gray-400 italic">Contact information will be added here.</div>
            @endif
        </div>
    @endslot

    <div class="bg-surface shadow-sm border border-border-main border-t-4 border-t-crimson p-8 w-full">
        
        @if (session('status'))
            <!-- SUCCESS STATE: PASSWORD RESET LINK SENT -->
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-crimson mb-6 shadow-md">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                
                <h2 class="font-heading text-2xl font-bold text-navy uppercase tracking-tight mb-2">Link Sent!</h2>
                <p class="text-sm text-gray-600 mb-8 font-serif">
                    We've sent a password reset link to your email address. Please check your inbox.
                </p>

                <div class="space-y-4">
                    <a href="mailto:" class="w-full flex justify-center py-3 px-4 border border-transparent text-sm font-heading font-bold uppercase tracking-wider text-white bg-navy hover:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-navy transition-colors">
                        Open Email App
                    </a>
                    
                    <div class="text-sm text-gray-500 pt-4 border-t border-gray-100">
                        Didn't receive it? 
                        <form method="POST" action="{{ route('password.email') }}" class="inline">
                            @csrf
                            <input type="hidden" name="email" value="{{ old('email') }}">
                            <button type="submit" class="font-semibold text-crimson hover:text-navy transition-colors">
                                Resend Link
                            </button>
                        </form>
                    </div>
                </div>
                
                <div class="mt-8">
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-500 hover:text-navy uppercase tracking-wider">
                        &larr; Back to Login
                    </a>
                </div>
            </div>
        @else
            <!-- DEFAULT STATE: FORGOT PASSWORD FORM -->
            <div class="text-center mb-8">
                <h2 class="font-heading text-2xl font-bold text-navy uppercase tracking-tight mb-2">Reset Password</h2>
                <p class="text-sm text-gray-500 font-serif">
                    Enter your institutional email address and we will send you a link to reset your password.
                </p>
            </div>

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-navy uppercase tracking-wider mb-2">Institutional Email</label>
                    <input id="email" class="block w-full border-border-main bg-gray-50 focus:bg-white focus:ring-0 focus:border-navy px-4 py-3 text-text-main sm:text-sm" type="email" name="email" :value="old('email')" required autofocus placeholder="e.g. jdoe@university.edu">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-crimson" />
                </div>

                <div class="flex items-center justify-between pt-4">
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-crimson hover:text-navy uppercase tracking-wider transition-colors">
                        Return to Login
                    </a>
                    
                    <button type="submit" class="flex justify-center py-3 px-6 border border-transparent text-sm font-heading font-bold uppercase tracking-wider text-white bg-navy hover:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-navy transition-colors">
                        Send Reset Link
                    </button>
                </div>
            </form>
        @endif
    </div>
</x-guest-layout>
