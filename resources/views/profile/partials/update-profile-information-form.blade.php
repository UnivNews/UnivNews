<section>
    <header>
        <h2 class="font-heading font-semibold text-2xl text-[#00081E]">
            Profile Information
        </h2>

        <p class="mt-1 font-sans text-[17px] text-[#44464E]">
            Update your account's profile information and email address.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-8 space-y-6">
        @csrf
        @method('patch')

        <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-8">
            <label for="name" class="font-sans font-semibold text-sm text-[#1B1B1C] uppercase w-full md:w-48 flex-shrink-0">
                FULL NAME
            </label>
            <div class="flex-grow">
                <input id="name" name="name" type="text" class="block w-full border border-[#C5C6CF] rounded-none focus:border-[#00081E] focus:ring-0 text-[#1B1B1C] py-3 px-4 font-sans text-base" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>
        </div>

        <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-8">
            <label for="email" class="font-sans font-semibold text-sm text-[#1B1B1C] uppercase w-full md:w-48 flex-shrink-0">
                EMAIL ADDRESS
            </label>
            <div class="flex-grow">
                <input id="email" name="email" type="email" class="block w-full border border-[#C5C6CF] rounded-none focus:border-[#00081E] focus:ring-0 text-[#1B1B1C] py-3 px-4 font-sans text-base" value="{{ old('email', $user->email) }}" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div>
                        <p class="text-sm mt-2 text-gray-800">
                            {{ __('Your email address is unverified.') }}

                            <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <div class="flex justify-end items-center gap-4 mt-8">
            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="font-sans text-sm text-[#44464E]"
                >Saved.</p>
            @endif
            <button type="submit" class="bg-[#00081E] hover:bg-gray-800 text-white font-sans font-semibold text-sm px-6 py-3 transition-colors">
                SAVE CHANGES
            </button>
        </div>
    </form>
</section>
