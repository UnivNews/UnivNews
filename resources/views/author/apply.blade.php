<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#fcf8f9]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Apply for Author Access - University News</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Work+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Work Sans', sans-serif; }
        h1, h2, h3, h4, h5, h6, .font-heading { font-family: 'Montserrat', sans-serif; }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-4px); }
            20%, 40%, 60%, 80% { transform: translateX(4px); }
        }
        .shake { animation: shake 0.5s ease-in-out; }

        .field-error input, .field-error select, .field-error textarea {
            border-color: #dc2626 !important;
        }
        .tooltip-wrapper { position: relative; display: inline-block; }
        .tooltip-wrapper .tooltip-box {
            display: none; position: absolute; bottom: 125%; left: 50%;
            transform: translateX(-50%); background: #1f2937; color: #f9fafb;
            font-size: 11px; padding: 6px 10px; border-radius: 4px;
            white-space: nowrap; z-index: 10; width: 240px; white-space: normal; text-align: left; line-height: 1.5;
        }
        .tooltip-wrapper:hover .tooltip-box { display: block; }
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

        {{-- Session Messages --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-600 text-green-800 text-xs">
                {{ session('success') }}
            </div>
        @endif

        @if(session('info'))
            <div class="mb-6 p-4 bg-blue-50 border-l-4 border-blue-500 text-blue-800 text-xs">
                {{ session('info') }}
            </div>
        @endif

        {{-- PENDING STATE --}}
        @if(auth()->user()->author_status === 'pending')
            <div class="p-6 bg-yellow-50 border-l-4 border-yellow-500 text-yellow-900 text-sm">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 mt-0.5 flex-shrink-0 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <h3 class="font-bold text-base mb-1">Application Pending Review</h3>
                        <p class="text-xs leading-relaxed">Your request to become a contributing author has been submitted and is currently being evaluated by the editorial team. You will be notified via email once a decision has been made.</p>
                        <p class="text-xs mt-2 text-yellow-700">Applied on: {{ auth()->user()->author_applied_at?->format('d M Y, H:i') ?? '-' }}</p>
                        <div class="mt-4">
                            <a href="{{ route('home') }}" class="text-xs font-bold text-[#8b1528] hover:underline uppercase">&larr; Return to News Portal</a>
                        </div>
                    </div>
                </div>
            </div>

        {{-- REJECTED STATE — can re-apply --}}
        @elseif(auth()->user()->author_status === 'rejected')
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-900 text-xs">
                <p class="font-bold text-sm mb-1">Previous Application Not Approved</p>
                @if(auth()->user()->author_rejection_reason)
                    <p class="text-xs text-red-700 mb-2"><em>"{{ auth()->user()->author_rejection_reason }}"</em></p>
                @endif
                <p>You can re-apply by filling out the form below with more complete information.</p>
            </div>
            @include('author._apply-form', ['universities' => $universities])

        {{-- FORM STATE (none or re-applying) --}}
        @else
            @include('author._apply-form', ['universities' => $universities])
        @endif

    </div>
</body>
</html>
