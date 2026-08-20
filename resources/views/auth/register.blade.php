<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- University -->
        <div class="mt-4">
            <x-input-label for="university_id" :value="__('University / Institution')" />
            <select id="university_id" name="university_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                <option value="">Select your university</option>
                @foreach($universities as $uni)
                    <option value="{{ $uni->id }}" {{ old('university_id') == $uni->id ? 'selected' : '' }}>
                        {{ $uni->name }} ({{ $uni->abbreviation }})
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('university_id')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Terms and Privacy Policy -->
        <div class="block mt-4">
            <label for="terms" class="inline-flex items-center">
                <input id="terms" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 h-4 w-4" name="terms" required>
                <span class="ml-2 text-sm text-gray-600">I agree to the <a href="#" class="underline hover:text-gray-900">Terms of Service</a> and <a href="#" class="underline hover:text-gray-900">Privacy Policy</a></span>
            </label>
            <x-input-error :messages="$errors->get('terms')" class="mt-2 text-red-600" />
        </div>

        @if(env('CAPTCHA_SITE_KEY'))
        <div class="mt-4">
            <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_SITE_KEY') }}"></div>
            <x-input-error :messages="$errors->get('g-recaptcha-response')" class="mt-2 text-red-600" />
            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        </div>
        @endif

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
