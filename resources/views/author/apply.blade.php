<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#fcf8f9]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Apply for Author Privileges - University News</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Work+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Work Sans', sans-serif; }
        h1, h2, h3, h4, h5, h6, .font-heading { font-family: 'Montserrat', sans-serif; }
    </style>
</head>
<body class="h-full flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8 bg-[#fcf8f9] text-[#1b1b1c]">
    
    <div class="max-w-xl w-full bg-white border border-[#c5c6cf] p-8 sm:p-10 shadow-sm relative">
        
        <!-- Header Cap Icon -->
        <div class="flex justify-center mb-6">
            <div class="w-14 h-14 rounded-full bg-[#00081e] flex items-center justify-center text-white shadow-sm">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3zm6.82 6L12 12.72 5.18 9 12 5.28 18.82 9zM17 15.99l-5 2.73-5-2.73v-3.72L12 15l5-2.73v3.72z"/>
                </svg>
            </div>
        </div>

        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold font-heading text-[#00081e]">Apply for Author Access</h1>
            <p class="text-xs text-gray-500 font-sans mt-2">
                Submit your credentials to contribute campus news, academic research, and official announcements.
            </p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-600 text-green-800 text-xs">
                {{ session('success') }}
            </div>
        @endif

        @if(auth()->user()->author_status === 'pending')
            <div class="p-6 bg-yellow-50 border-l-4 border-yellow-500 text-yellow-900 text-sm">
                <h3 class="font-bold text-base mb-1">Application Pending Review</h3>
                <p class="text-xs">Your request to become a contributing author has been submitted and is currently being evaluated by the editorial team. You will be notified once approved.</p>
                <div class="mt-4">
                    <a href="{{ route('home') }}" class="text-xs font-bold text-[#8b1528] hover:underline uppercase">&larr; Return to News Portal</a>
                </div>
            </div>
        @else
            <form action="{{ route('author.apply.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Name & Email (Pre-filled) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Applicant Name</label>
                        <input type="text" value="{{ auth()->user()->name }}" disabled class="w-full bg-gray-100 border border-gray-300 px-3 py-2 text-xs text-gray-700 cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Email</label>
                        <input type="email" value="{{ auth()->user()->email }}" disabled class="w-full bg-gray-100 border border-gray-300 px-3 py-2 text-xs text-gray-700 cursor-not-allowed">
                    </div>
                </div>

                <!-- University & Department -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="university_id" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">University <span class="text-[#8b1528]">*</span></label>
                        <select name="university_id" id="university_id" class="w-full bg-[#f8f9fa] border border-gray-300 px-3 py-2 text-xs text-gray-800 focus:bg-white focus:outline-none focus:border-[#8b1528] focus:ring-0" required>
                            <option value="">Select University</option>
                            @foreach($universities as $uni)
                                <option value="{{ $uni->id }}" {{ (old('university_id', auth()->user()->university_id) == $uni->id) ? 'selected' : '' }}>
                                    {{ $uni->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="department" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Faculty / Department <span class="text-[#8b1528]">*</span></label>
                        <input type="text" 
                               name="department" 
                               id="department" 
                               value="{{ old('department', auth()->user()->department) }}" 
                               placeholder="e.g. Faculty of Engineering" 
                               class="w-full bg-[#f8f9fa] border border-gray-300 px-3 py-2 text-xs text-gray-800 focus:bg-white focus:outline-none focus:border-[#8b1528] focus:ring-0" 
                               required>
                    </div>
                </div>

                <!-- Page / Display Name & Phone -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="page_name" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Author Slug / Desk Name</label>
                        <input type="text" 
                               name="page_name" 
                               id="page_name" 
                               value="{{ old('page_name', auth()->user()->page_name) }}" 
                               placeholder="e.g. campus-correspondent" 
                               class="w-full bg-[#f8f9fa] border border-gray-300 px-3 py-2 text-xs text-gray-800 focus:bg-white focus:outline-none focus:border-[#8b1528] focus:ring-0">
                    </div>

                    <div>
                        <label for="phone_number" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Phone Number</label>
                        <input type="text" 
                               name="phone_number" 
                               id="phone_number" 
                               value="{{ old('phone_number', auth()->user()->phone_number) }}" 
                               placeholder="+1 (555) 000-0000" 
                               class="w-full bg-[#f8f9fa] border border-gray-300 px-3 py-2 text-xs text-gray-800 focus:bg-white focus:outline-none focus:border-[#8b1528] focus:ring-0">
                    </div>
                </div>

                <!-- Statement / Bio -->
                <div>
                    <label for="author_bio" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Why do you want to contribute? (Bio &amp; Topics) <span class="text-[#8b1528]">*</span></label>
                    <textarea name="author_bio" 
                              id="author_bio" 
                              rows="4" 
                              placeholder="Brief statement about your academic background, beats you plan to cover, or laboratory findings..." 
                              class="w-full bg-[#f8f9fa] border border-gray-300 p-3 text-xs text-gray-800 focus:bg-white focus:outline-none focus:border-[#8b1528] focus:ring-0" 
                              required>{{ old('author_bio', auth()->user()->author_bio) }}</textarea>
                </div>

                <!-- Submit Button -->
                <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                    <a href="{{ route('home') }}" class="text-xs text-gray-500 hover:text-navy uppercase font-semibold">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-[#00081e] hover:bg-[#8b1528] text-white text-xs font-bold uppercase tracking-wider transition-colors shadow-sm">
                        Submit Application
                    </button>
                </div>
            </form>
        @endif

    </div>
</body>
</html>
