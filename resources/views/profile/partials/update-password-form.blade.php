<section>
    <header>
        <h2 class="font-heading font-semibold text-2xl text-[#00081E]">
            Security
        </h2>

        <p class="mt-1 font-sans text-[17px] text-[#44464E]">
            Ensure your account is using a long, random password to stay secure.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-8 space-y-6">
        @csrf
        @method('put')

        <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-8">
            <label for="update_password_current_password" class="font-sans font-semibold text-sm text-[#1B1B1C] uppercase w-full md:w-48 flex-shrink-0">
                CURRENT PASSWORD
            </label>
            <div class="flex-grow">
                <input id="update_password_current_password" name="current_password" type="password" class="block w-full border border-[#C5C6CF] rounded-none focus:border-[#00081E] focus:ring-0 text-[#1B1B1C] py-3 px-4 font-sans text-base" autocomplete="current-password" />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>
        </div>

        <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-8">
            <label for="update_password_password" class="font-sans font-semibold text-sm text-[#1B1B1C] uppercase w-full md:w-48 flex-shrink-0">
                NEW PASSWORD
            </label>
            <div class="flex-grow">
                <input id="update_password_password" name="password" type="password" class="block w-full border border-[#C5C6CF] rounded-none focus:border-[#00081E] focus:ring-0 text-[#1B1B1C] py-3 px-4 font-sans text-base" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>
        </div>

        <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-8">
            <label for="update_password_password_confirmation" class="font-sans font-semibold text-sm text-[#1B1B1C] uppercase w-full md:w-48 flex-shrink-0">
                CONFIRM PASSWORD
            </label>
            <div class="flex-grow">
                <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="block w-full border border-[#C5C6CF] rounded-none focus:border-[#00081E] focus:ring-0 text-[#1B1B1C] py-3 px-4 font-sans text-base" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="flex justify-end items-center gap-4 mt-8">
            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="font-sans text-sm text-[#44464E]"
                >Saved.</p>
            @endif
            <button type="submit" class="bg-[#00081E] hover:bg-gray-800 text-white font-sans font-semibold text-sm px-6 py-3 transition-colors">
                UPDATE PASSWORD
            </button>
        </div>
    </form>
</section>
