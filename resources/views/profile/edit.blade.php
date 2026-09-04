@extends('layouts.transactional')

@section('content')
    <div class="max-w-[1280px] w-full mx-auto px-6 md:px-10 py-20">
        <div class="px-0 lg:px-[240px]">
            <h1 class="font-heading font-semibold text-[32px] text-[#00081E] mb-2">Account Settings</h1>
            <p class="font-sans text-[17px] text-[#44464E] mb-12">Manage your profile, security, and account preferences.</p>
            
            <div class="space-y-12">
                <!-- Profile Info Form -->
                <div class="border-t border-[#C5C6CF] pt-12">
                    @include('profile.partials.update-profile-information-form')
                </div>

                <!-- Password Form -->
                <div class="border-t border-[#C5C6CF] pt-12">
                    @include('profile.partials.update-password-form')
                </div>

                <!-- Delete Account Form -->
                <div class="pt-12">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection
