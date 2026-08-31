<section class="border-l-[2px] border-[#B71032] pl-8 space-y-6">
    <header>
        <h2 class="font-heading font-semibold text-2xl text-[#B71032] flex items-center gap-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            Danger Zone
        </h2>

        <p class="mt-4 font-sans text-[17px] text-[#44464E]">
            Once your account is deleted, all of its resources and data will be permanently deleted. This action cannot be undone.
        </p>
    </header>

    <div class="flex items-center gap-4 pt-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="bg-[#00081E] hover:bg-gray-800 text-white font-sans font-bold text-sm px-6 py-3 uppercase tracking-wider transition-colors">
                LOG OUT
            </button>
        </form>

        <button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="bg-[#B71032] hover:bg-red-800 text-white font-sans font-bold text-sm px-6 py-3 uppercase tracking-wider transition-colors"
        >
            PERMANENTLY DELETE ACCOUNT
        </button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4 border border-[#C5C6CF] rounded-none focus:border-[#B71032] focus:ring-0 text-[#1B1B1C] py-2 px-3 font-sans"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
