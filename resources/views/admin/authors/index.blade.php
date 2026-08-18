@extends('layouts.cms')

@section('title', 'User & Author Management - University News')
@section('header_tagline', 'USER MANAGEMENT - CMS PORTAL')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">
    
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold font-heading text-[#00081e] tracking-tight">User &amp; Author Management</h1>
            <p class="text-gray-500 font-sans text-sm mt-1">Review author applications, manage contributors, and control permissions.</p>
        </div>
    </div>

    <!-- Section 1: Pending Author Applications -->
    <div class="bg-white border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between bg-yellow-50/50">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-yellow-500"></span>
                <h2 class="text-base font-bold font-heading text-[#00081e]">Pending Author Applications ({{ $pendingAuthors->count() }})</h2>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs font-sans">
                <thead class="bg-[#f8f9fa] text-gray-500 uppercase tracking-wider border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3.5 font-bold">Applicant</th>
                        <th class="px-6 py-3.5 font-bold">University &amp; Department</th>
                        <th class="px-6 py-3.5 font-bold">Bio / Statement</th>
                        <th class="px-6 py-3.5 font-bold">Date Applied</th>
                        <th class="px-6 py-3.5 font-bold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($pendingAuthors as $applicant)
                    <tr class="hover:bg-gray-50/80 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900 text-sm">{{ $applicant->name }}</div>
                            <div class="text-gray-500">{{ $applicant->email }}</div>
                            @if($applicant->phone_number)
                                <div class="text-gray-400 text-[10px]">{{ $applicant->phone_number }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-700">
                            <div class="font-medium">{{ $applicant->university->name ?? 'No University' }}</div>
                            <div class="text-gray-500 text-[11px]">{{ $applicant->department ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 text-gray-600 max-w-xs font-serif-content">
                            {{ $applicant->author_bio ?? 'No statement provided.' }}
                        </td>
                        <td class="px-6 py-4 text-gray-500">
                            {{ $applicant->created_at->format('M j, Y') }}
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <!-- Approve Button -->
                            <form action="{{ route('admin.authors.approve', $applicant) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white font-bold uppercase tracking-wider text-[10px] shadow-sm transition-colors">
                                    Approve
                                </button>
                            </form>

                            <!-- Reject Button -->
                            <form action="{{ route('admin.authors.reject', $applicant) }}" method="POST" class="inline-block" onsubmit="return confirm('Reject this author application?');">
                                @csrf
                                <button type="submit" class="px-3 py-1.5 border border-red-300 text-red-700 hover:bg-red-50 font-bold uppercase tracking-wider text-[10px] transition-colors">
                                    Reject
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-400 italic">No pending applications at this time.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Section 2: Active Authors & Staff -->
    <div class="bg-white border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between bg-[#fcfcfd]">
            <h2 class="text-base font-bold font-heading text-[#00081e]">Active Authors &amp; Contributors ({{ $activeAuthors->total() }})</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs font-sans">
                <thead class="bg-[#f8f9fa] text-gray-500 uppercase tracking-wider border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3.5 font-bold">Author</th>
                        <th class="px-6 py-3.5 font-bold">University &amp; Department</th>
                        <th class="px-6 py-3.5 font-bold">Role</th>
                        <th class="px-6 py-3.5 font-bold">Status</th>
                        <th class="px-6 py-3.5 font-bold">Articles</th>
                        <th class="px-6 py-3.5 font-bold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($activeAuthors as $user)
                    <tr class="hover:bg-gray-50/80 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900 text-sm">{{ $user->name }}</div>
                            <div class="text-gray-500">{{ $user->email }}</div>
                        </td>
                        <td class="px-6 py-4 text-gray-700">
                            <div class="font-medium">{{ $user->university->name ?? 'None' }}</div>
                            <div class="text-gray-500 text-[11px]">{{ $user->department ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-0.5 bg-gray-100 border border-gray-200 text-gray-800 text-[11px] font-semibold">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($user->author_status === 'approved')
                                <span class="px-2.5 py-0.5 bg-green-100 text-green-800 font-semibold border border-green-200 text-[11px]">Active</span>
                            @elseif($user->author_status === 'suspended')
                                <span class="px-2.5 py-0.5 bg-red-100 text-red-800 font-semibold border border-red-200 text-[11px]">Suspended</span>
                            @else
                                <span class="px-2.5 py-0.5 bg-gray-100 text-gray-600 border border-gray-200 text-[11px]">{{ ucfirst($user->author_status) }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-600 font-medium">
                            {{ $user->articles_count ?? $user->articles()->count() }} stories
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            @if($user->author_status === 'suspended')
                                <form action="{{ route('admin.authors.approve', $user) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-800 font-semibold">
                                        Unsuspend
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('admin.authors.suspend', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('Suspend this author account?');">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">
                                        Suspend
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-400 italic">No active authors.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($activeAuthors->hasPages())
        <div class="p-4 border-t border-gray-200 bg-[#f8f9fa]">
            {{ $activeAuthors->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
