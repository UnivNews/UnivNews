<form action="{{ route('author.apply.store') }}" method="POST" class="space-y-6" id="applyForm">
    @csrf

    {{-- Global error list --}}
    @if($errors->any())
        <div class="p-3 bg-red-50 border border-red-200 text-red-700 text-xs rounded">
            <ul class="list-disc list-inside space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Row 1: Applicant Name & Email -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

        <!-- Name — EDITABLE -->
        <div class="{{ $errors->has('name') ? 'field-error' : '' }} {{ $errors->has('name') ? 'shake' : '' }}">
            <label for="name" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                Applicant Name <span class="text-[#8b1528]">*</span>
            </label>
            <input type="text"
                   name="name"
                   id="name"
                   value="{{ old('name', auth()->user()->name) }}"
                   class="w-full bg-[#f8f9fa] border border-gray-300 px-3 py-2 text-xs text-gray-800 focus:bg-white focus:outline-none focus:border-[#8b1528] focus:ring-0"
                   required>
            @error('name')
                <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email — READ-ONLY -->
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                Email
                <span class="ml-1 text-[10px] text-gray-400 font-normal normal-case">(cannot be changed)</span>
            </label>
            <div class="relative">
                <span class="absolute inset-y-0 right-3 flex items-center text-gray-400 pointer-events-none">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </span>
                <input type="email"
                       value="{{ auth()->user()->email }}"
                       disabled
                       class="w-full bg-gray-100 border border-gray-300 px-3 py-2 pr-9 text-xs text-gray-500 cursor-not-allowed select-none">
            </div>
        </div>
    </div>

    <!-- Row 2: University & Department -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

        <div class="{{ $errors->has('university_id') ? 'field-error' : '' }}">
            <label for="university_id" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                University <span class="text-[#8b1528]">*</span>
            </label>
            <select name="university_id" id="university_id"
                    class="w-full bg-[#f8f9fa] border border-gray-300 px-3 py-2 text-xs text-gray-800 focus:bg-white focus:outline-none focus:border-[#8b1528] focus:ring-0"
                    required>
                <option value="">Select University</option>
                @foreach($universities as $uni)
                    <option value="{{ $uni->id }}" {{ (old('university_id', auth()->user()->university_id) == $uni->id) ? 'selected' : '' }}>
                        {{ $uni->name }}
                    </option>
                @endforeach
            </select>
            @error('university_id')
                <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="{{ $errors->has('department') ? 'field-error' : '' }}">
            <label for="department" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                Faculty / Department <span class="text-[#8b1528]">*</span>
            </label>
            <input type="text"
                   name="department"
                   id="department"
                   value="{{ old('department', auth()->user()->department) }}"
                   placeholder="e.g. Faculty of Engineering"
                   class="w-full bg-[#f8f9fa] border border-gray-300 px-3 py-2 text-xs text-gray-800 focus:bg-white focus:outline-none focus:border-[#8b1528] focus:ring-0"
                   required>
            @error('department')
                <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Row 3: Author Slug & Phone -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

        <div>
            <label for="page_name" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                Author Slug / Desk Name
                <span class="tooltip-wrapper cursor-help">
                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="tooltip-box">
                        Ini akan menjadi identitas/byline penulis kamu yang tampil di bawah artikel yang kamu tulis. Contoh: "campus-correspondent" → tampil sebagai "Campus Correspondent".
                    </span>
                </span>
            </label>
            <input type="text"
                   name="page_name"
                   id="page_name"
                   value="{{ old('page_name', auth()->user()->page_name) }}"
                   placeholder="e.g. campus-correspondent"
                   class="w-full bg-[#f8f9fa] border border-gray-300 px-3 py-2 text-xs text-gray-800 focus:bg-white focus:outline-none focus:border-[#8b1528] focus:ring-0">
        </div>

        <div>
            <label for="phone_number" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                Phone Number
            </label>
            <input type="text"
                   name="phone_number"
                   id="phone_number"
                   value="{{ old('phone_number', auth()->user()->phone_number) }}"
                   placeholder="+1 (555) 000-0000"
                   class="w-full bg-[#f8f9fa] border border-gray-300 px-3 py-2 text-xs text-gray-800 focus:bg-white focus:outline-none focus:border-[#8b1528] focus:ring-0">
        </div>
    </div>

    <!-- Bio / Statement -->
    <div class="{{ $errors->has('author_bio') ? 'field-error' : '' }}">
        <label for="author_bio" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
            Why do you want to contribute? (Bio &amp; Topics)
            <span class="text-[#8b1528]">*</span>
        </label>
        <div class="relative">
            <textarea name="author_bio"
                      id="author_bio"
                      rows="5"
                      minlength="50"
                      maxlength="2000"
                      placeholder="Brief statement about your academic background, beats you plan to cover, or laboratory findings..."
                      class="w-full bg-[#f8f9fa] border border-gray-300 p-3 pb-6 text-xs text-gray-800 focus:bg-white focus:outline-none focus:border-[#8b1528] focus:ring-0 resize-none"
                      required>{{ old('author_bio', auth()->user()->author_bio) }}</textarea>
            <!-- Character counter -->
            <div class="absolute bottom-2 right-3 flex items-center gap-2">
                <span id="bioCounter" class="text-[10px] text-gray-400">0/2000</span>
                <span id="bioMinHint" class="text-[10px] text-red-400 hidden">min. 50</span>
            </div>
        </div>
        @error('author_bio')
            <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Footer Actions -->
    <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
        <a href="{{ route('home') }}" class="text-xs text-gray-500 hover:text-[#00081e] uppercase font-semibold tracking-wide">
            Cancel
        </a>
        <button type="submit" id="submitBtn"
                class="px-6 py-2.5 bg-[#00081e] hover:bg-[#8b1528] text-white text-xs font-bold uppercase tracking-wider transition-colors shadow-sm">
            Submit Application
        </button>
    </div>
</form>

<script>
(function () {
    const textarea = document.getElementById('author_bio');
    const counter  = document.getElementById('bioCounter');
    const minHint  = document.getElementById('bioMinHint');

    function update() {
        const len = textarea.value.length;
        counter.textContent = len + '/2000';
        if (len < 50) {
            counter.classList.add('text-red-400');
            counter.classList.remove('text-gray-400');
            minHint.classList.remove('hidden');
        } else {
            counter.classList.remove('text-red-400');
            counter.classList.add('text-gray-400');
            minHint.classList.add('hidden');
        }
    }

    if (textarea) {
        textarea.addEventListener('input', update);
        update(); // Run on load (for old() value)
    }

    // Shake animation on error fields after load
    document.querySelectorAll('.field-error').forEach(function (el) {
        el.classList.add('shake');
        setTimeout(function () { el.classList.remove('shake'); }, 600);
    });
})();
</script>
