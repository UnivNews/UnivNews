@extends('layouts.cms')

@section('title', 'Universities Management - University News')
@section('header_tagline', 'INSTITUTION DIRECTORY - CMS PORTAL')

@section('content')
<div class="max-w-6xl mx-auto space-y-8" x-data="{ addModalOpen: false }">
    
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold font-heading text-[#00081e] tracking-tight">University Management</h1>
            <p class="text-gray-500 font-sans text-sm mt-1">Manage participating universities, abbreviations, and network campuses.</p>
        </div>

        <button @click="addModalOpen = true" class="px-5 py-2.5 bg-[#8b1528] hover:bg-[#721120] text-white text-xs font-bold uppercase tracking-wider flex items-center gap-2 shadow-sm transition-colors self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add University
        </button>
    </div>

    <!-- Universities Table Card -->
    <div class="bg-white border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs font-sans">
                <thead class="bg-[#f8f9fa] text-gray-500 uppercase tracking-wider border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3.5 font-bold">University Name</th>
                        <th class="px-6 py-3.5 font-bold">Abbreviation</th>
                        <th class="px-6 py-3.5 font-bold">Registered Users</th>
                        <th class="px-6 py-3.5 font-bold">Date Added</th>
                        <th class="px-6 py-3.5 font-bold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($universities as $uni)
                    <tr class="hover:bg-gray-50/80 transition-colors">
                        <td class="px-6 py-4 font-bold text-gray-900 text-sm">
                            {{ $uni->name }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-0.5 bg-gray-100 border border-gray-200 text-gray-800 font-semibold text-xs">
                                {{ $uni->abbreviation ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-600 font-medium">
                            {{ $uni->users_count ?? $uni->users()->count() }} users
                        </td>
                        <td class="px-6 py-4 text-gray-500">
                            {{ $uni->created_at->format('M j, Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <form action="{{ route('admin.universities.destroy', $uni) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this university?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-400 italic">No universities registered.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add University Modal -->
    <div x-show="addModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4">
        <div class="bg-white border border-gray-300 w-full max-w-md p-6 shadow-2xl space-y-5" @click.away="addModalOpen = false">
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <h3 class="text-base font-bold font-heading text-[#00081e]">Add New University</h3>
                <button type="button" @click="addModalOpen = false" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
            </div>

            <form action="{{ route('admin.universities.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="modal_name" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">University Name</label>
                    <input type="text" 
                           name="name" 
                           id="modal_name" 
                           placeholder="e.g. University of Indonesia" 
                           class="w-full bg-[#f8f9fa] border border-gray-300 px-3 py-2 text-xs text-gray-800 focus:bg-white focus:outline-none focus:border-[#8b1528] focus:ring-0" 
                           required>
                </div>

                <div>
                    <label for="modal_abbreviation" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Abbreviation (Code)</label>
                    <input type="text" 
                           name="abbreviation" 
                           id="modal_abbreviation" 
                           placeholder="e.g. UI, ITB, Harvard" 
                           class="w-full bg-[#f8f9fa] border border-gray-300 px-3 py-2 text-xs text-gray-800 focus:bg-white focus:outline-none focus:border-[#8b1528] focus:ring-0">
                </div>

                <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                    <button type="button" @click="addModalOpen = false" class="px-4 py-2 border border-gray-300 text-gray-700 text-xs font-semibold uppercase tracking-wider">
                        Cancel
                    </button>
                    <button type="submit" class="px-5 py-2 bg-[#8b1528] hover:bg-[#721120] text-white text-xs font-bold uppercase tracking-wider shadow-sm">
                        Add University
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
