@extends('layouts.cms')

@section('title', 'User & Author Management - University News')
@section('header_tagline', 'USER MANAGEMENT - CMS PORTAL')
@section('page_tour_id', 'admin.authors.index')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold font-heading text-[#00081e] tracking-tight">User &amp; Author Management</h1>
            <p class="text-gray-500 font-sans text-sm mt-1">Review author applications, manage contributors, and control permissions.</p>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="p-4 bg-green-50 border-l-4 border-green-500 text-green-800 text-sm shadow-sm">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="p-4 bg-red-50 border-l-4 border-red-500 text-red-800 text-sm shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    <!-- Photo 2 Style Tabs Navigation Bar -->
    <div class="flex items-center gap-2 border-b border-gray-200 pb-px overflow-x-auto text-xs font-semibold uppercase tracking-wider" data-tour="admin-users-tabs">
        <a href="{{ route('admin.authors.index', ['tab' => 'authors']) }}" 
           class="px-4 py-2.5 border-b-2 transition-colors flex items-center gap-2 {{ $activeTab === 'authors' ? 'border-[#8b1528] text-[#8b1528] font-bold' : 'border-transparent text-gray-500 hover:text-gray-900' }}">
            <span>Authors &amp; Contributors</span>
            <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ $activeTab === 'authors' ? 'bg-[#8b1528]/10 text-[#8b1528]' : 'bg-gray-100 text-gray-600' }}">
                {{ ($activeAuthors ? $activeAuthors->total() : $activeAuthorsCount) + $pendingAuthorsCount }}
            </span>
        </a>
        <a href="{{ route('admin.authors.index', ['tab' => 'readers']) }}" 
           class="px-4 py-2.5 border-b-2 transition-colors flex items-center gap-2 {{ $activeTab === 'readers' ? 'border-[#8b1528] text-[#8b1528] font-bold' : 'border-transparent text-gray-500 hover:text-gray-900' }}">
            <span>Reader Users</span>
            <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ $activeTab === 'readers' ? 'bg-[#8b1528]/10 text-[#8b1528]' : 'bg-gray-100 text-gray-600' }}">
                {{ $totalReadersCount }}
            </span>
        </a>
    </div>

    @if($activeTab === 'authors')
    <!-- ========================================== -->
    <!-- TAB 1: AUTHORS & CONTRIBUTORS -->
    <!-- ========================================== -->
    <div class="space-y-8">
        <!-- Section 1: Pending Author Applications -->
        <div class="bg-white border border-gray-200 shadow-sm overflow-hidden" data-tour="authors-pending-section">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between bg-yellow-50/50">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-yellow-500 {{ $pendingAuthors->count() > 0 ? 'animate-pulse' : '' }}"></span>
                    <h2 class="text-base font-bold font-heading text-[#00081e]">Pending Author Applications ({{ $pendingAuthors->count() }})</h2>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs font-sans">
                    <thead class="bg-[#f8f9fa] text-gray-500 uppercase tracking-wider border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3.5 font-bold">Applicant</th>
                            <th class="px-6 py-3.5 font-bold">University &amp; Department</th>
                            <th class="px-6 py-3.5 font-bold">Applied</th>
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
                                    <div class="text-gray-400 text-[10px]">📞 {{ $applicant->phone_number }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-700">
                                <div class="font-medium">{{ $applicant->university->name ?? 'No University' }}</div>
                                <div class="text-gray-500 text-[11px]">{{ $applicant->department ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 text-gray-500">
                                {{ $applicant->author_applied_at?->format('d M Y') ?? $applicant->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <!-- Detail Button (opens modal) -->
                                <button type="button"
                                        onclick="openDetailModal({{ $applicant->id }})"
                                        class="px-3 py-1.5 border border-gray-300 text-gray-700 hover:bg-gray-50 font-bold uppercase tracking-wider text-[10px] transition-colors">
                                    Detail
                                </button>

                                <!-- Quick Approve Button -->
                                <form action="{{ route('admin.authors.approve', $applicant) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" data-tour="authors-approve-btn" class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white font-bold uppercase tracking-wider text-[10px] shadow-sm transition-colors">
                                        Approve
                                    </button>
                                </form>
                            </td>
                        </tr>

                        {{-- Detail Modal for this applicant --}}
                        <div id="modal-{{ $applicant->id }}"
                             class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 hidden"
                             onclick="if(event.target===this) closeDetailModal({{ $applicant->id }})">
                            <div class="bg-white max-w-xl w-full mx-4 shadow-2xl max-h-[90vh] overflow-y-auto">
                                <!-- Modal Header -->
                                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-[#00081e]">
                                    <h3 class="text-sm font-bold text-white font-heading uppercase tracking-wider">Application Detail</h3>
                                    <button onclick="closeDetailModal({{ $applicant->id }})" class="text-gray-400 hover:text-white transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>

                                <!-- Modal Body -->
                                <div class="p-6 space-y-4 text-xs">
                                    <!-- Applicant Info -->
                                    <div class="grid grid-cols-2 gap-3">
                                        <div class="bg-gray-50 p-3 border border-gray-100">
                                            <div class="text-[10px] text-gray-400 uppercase tracking-wider mb-1">Name</div>
                                            <div class="font-semibold text-gray-900">{{ $applicant->name }}</div>
                                        </div>
                                        <div class="bg-gray-50 p-3 border border-gray-100">
                                            <div class="text-[10px] text-gray-400 uppercase tracking-wider mb-1">Email</div>
                                            <div class="text-gray-700 break-all">{{ $applicant->email }}</div>
                                        </div>
                                        <div class="bg-gray-50 p-3 border border-gray-100">
                                            <div class="text-[10px] text-gray-400 uppercase tracking-wider mb-1">University</div>
                                            <div class="font-semibold text-gray-900">{{ $applicant->university->name ?? '-' }}</div>
                                        </div>
                                        <div class="bg-gray-50 p-3 border border-gray-100">
                                            <div class="text-[10px] text-gray-400 uppercase tracking-wider mb-1">Faculty / Dept.</div>
                                            <div class="text-gray-700">{{ $applicant->department ?? '-' }}</div>
                                        </div>
                                        <div class="bg-gray-50 p-3 border border-gray-100">
                                            <div class="text-[10px] text-gray-400 uppercase tracking-wider mb-1">Phone Number</div>
                                            <div class="text-gray-700">{{ $applicant->phone_number ?? '-' }}</div>
                                        </div>
                                        <div class="bg-gray-50 p-3 border border-gray-100">
                                            <div class="text-[10px] text-gray-400 uppercase tracking-wider mb-1">Author Slug</div>
                                            <div class="text-gray-700 font-mono">{{ $applicant->page_name ?? '-' }}</div>
                                        </div>
                                    </div>

                                    <!-- Bio / Statement -->
                                    <div class="bg-gray-50 p-3 border border-gray-100">
                                        <div class="text-[10px] text-gray-400 uppercase tracking-wider mb-2">Bio / Why Contribute?</div>
                                        <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $applicant->author_bio ?? 'No statement provided.' }}</p>
                                    </div>

                                    <div class="text-[10px] text-gray-400 text-right">
                                        Applied: {{ $applicant->author_applied_at?->format('d M Y, H:i') ?? $applicant->created_at->format('d M Y, H:i') }}
                                    </div>
                                </div>

                                <!-- Modal Actions -->
                                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex items-center justify-between gap-3">
                                    <!-- Reject with reason -->
                                    <form action="{{ route('admin.authors.reject', $applicant) }}" method="POST" class="flex-1"
                                          data-confirm-title="Reject author application?"
                                          data-confirm-description="Are you sure you want to reject this applicant?"
                                          data-confirm-btn="Reject"
                                          data-confirm-variant="warning">
                                        @csrf
                                        <div class="flex gap-2">
                                            <input type="text"
                                                   name="reason"
                                                   placeholder="Alasan penolakan (opsional)"
                                                   class="flex-1 border border-gray-300 px-3 py-1.5 text-xs text-gray-700 focus:outline-none focus:border-[#8b1528]">
                                            <button type="submit"
                                                    class="px-4 py-1.5 border border-red-300 text-red-700 hover:bg-red-50 font-bold uppercase tracking-wider text-[10px] transition-colors whitespace-nowrap">
                                                Reject
                                            </button>
                                        </div>
                                    </form>

                                    <!-- Approve -->
                                    <form action="{{ route('admin.authors.approve', $applicant) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                class="px-5 py-1.5 bg-green-600 hover:bg-green-700 text-white font-bold uppercase tracking-wider text-[10px] shadow-sm transition-colors">
                                            ✓ Approve
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-400 italic">No pending applications at this time.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Section 2: Active Authors & Staff -->
        <div class="bg-white border border-gray-200 shadow-sm overflow-hidden" data-tour="authors-active-section">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between bg-[#fcfcfd]">
                <h2 class="text-base font-bold font-heading text-[#00081e]">Active Authors &amp; Contributors ({{ $activeAuthors ? $activeAuthors->total() : $activeAuthorsCount }})</h2>
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
                        @if($activeAuthors)
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
                                    @if($user->approvalToken)
                                        <span class="px-2.5 py-0.5 bg-amber-50 text-amber-800 font-semibold border border-amber-200 text-[11px]" title="Awaiting password creation & verification">Awaiting Setup</span>
                                    @elseif($user->author_status === 'approved')
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
                                    @if($user->approvalToken)
                                        <form action="{{ route('admin.authors.cancel-approval', $user) }}" 
                                              method="POST" 
                                              class="inline-block"
                                              data-confirm-title="Cancel author approval?"
                                              data-confirm-description="Are you sure you want to cancel the author approval for &quot;{{ addslashes($user->name) }}&quot;? The user has not completed setup yet and will be reverted to Reader."
                                              data-confirm-btn="Cancel Approval"
                                              data-confirm-variant="warning">
                                            @csrf
                                            <button type="submit" class="text-orange-600 hover:text-orange-800 font-semibold">
                                                Cancel Approval
                                            </button>
                                        </form>
                                    @endif

                                    @if($user->author_status === 'suspended')
                                        <form action="{{ route('admin.authors.approve', $user) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-800 font-semibold">
                                                Unsuspend
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.authors.suspend', $user) }}" 
                                              method="POST" 
                                              class="inline-block"
                                              data-confirm-title="Suspend author account?"
                                              data-confirm-description="Are you sure you want to suspend &quot;{{ addslashes($user->name) }}&quot;? The author will not be able to publish new articles."
                                              data-confirm-btn="Suspend"
                                              data-confirm-variant="warning">
                                            @csrf
                                            <button type="submit" data-tour="authors-suspend-btn" class="text-amber-600 hover:text-amber-800 font-semibold">
                                                Suspend
                                            </button>
                                        </form>
                                    @endif

                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.authors.destroy', $user) }}" 
                                              method="POST" 
                                              class="inline-block"
                                              data-confirm-title="Delete author account?"
                                              data-confirm-description="Are you sure you want to permanently delete &quot;{{ addslashes($user->name) }}&quot;? All articles belonging to this author will be transferred to Admin."
                                              data-confirm-btn="Delete">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 font-semibold ml-1">
                                                Delete
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
                        @endif
                    </tbody>
                </table>
            </div>

            @if($activeAuthors && $activeAuthors->hasPages())
            <div class="p-4 border-t border-gray-200 bg-[#f8f9fa]">
                {{ $activeAuthors->links() }}
            </div>
            @endif
        </div>
    </div>

    @else
    <!-- ========================================== -->
    <!-- TAB 2: READER USERS MANAGEMENT -->
    <!-- ========================================== -->
    <div class="space-y-6" data-tour="readers-management-section">

        <!-- Stat Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white border border-gray-200 p-4 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Readers</span>
                    <div class="text-2xl font-black font-heading text-[#00081e] mt-1">{{ number_format($totalReadersCount) }}</div>
                    <span class="text-[11px] text-gray-500">Registered readers</span>
                </div>
                <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            </div>

            <div class="bg-white border border-gray-200 p-4 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Active Readers</span>
                    <div class="text-2xl font-black font-heading text-emerald-700 mt-1">{{ number_format($activeReadersCount) }}</div>
                    <span class="text-[11px] text-emerald-600">With reading history</span>
                </div>
                <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>

            <div class="bg-white border border-gray-200 p-4 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">New Readers</span>
                    <div class="text-2xl font-black font-heading text-[#8b1528] mt-1">{{ number_format($newReadersCount) }}</div>
                    <span class="text-[11px] text-gray-500">Joined in last 30 days</span>
                </div>
                <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center text-[#8b1528]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Search & Filter Controls -->
        <div class="bg-white border border-gray-200 p-4 shadow-sm">
            <form method="GET" action="{{ route('admin.authors.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
                <input type="hidden" name="tab" value="readers">
                
                <div class="sm:col-span-8">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-600 mb-1">Search Readers</label>
                    <input type="text" 
                           name="q" 
                           value="{{ request('q') }}" 
                           placeholder="Search by name, email, or phone..." 
                           class="w-full text-xs border border-gray-300 px-3 py-2 text-gray-800 placeholder-gray-400 focus:outline-none focus:border-[#8b1528]">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-600 mb-1">Status</label>
                    <select name="status" class="w-full text-xs border border-gray-300 px-3 py-2 text-gray-800 bg-white focus:outline-none focus:border-[#8b1528]">
                        <option value="">All Statuses</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                </div>

                <div class="sm:col-span-2 flex items-end gap-2">
                    <button type="submit" class="flex-1 bg-[#8b1528] hover:bg-[#721120] text-white py-2 text-xs font-bold uppercase tracking-wider transition-colors text-center">
                        Filter
                    </button>
                    @if(request('q') || request('status'))
                    <a href="{{ route('admin.authors.index', ['tab' => 'readers']) }}" class="px-2.5 py-2 border border-gray-300 text-gray-600 hover:bg-gray-50 text-xs font-medium transition-colors" title="Reset Filters">
                        ✕
                    </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Readers Table -->
        <div class="bg-white border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between bg-[#fcfcfd]">
                <div class="flex items-center gap-2">
                    <h2 class="text-base font-bold font-heading text-[#00081e]">
                        All Reader Users ({{ $readers ? $readers->total() : 0 }})
                    </h2>
                    <span class="text-xs text-gray-500 font-sans">
                        Profile details and reader activity overview
                    </span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs font-sans">
                    <thead class="bg-[#f8f9fa] text-gray-500 uppercase tracking-wider border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3.5 font-bold">Reader Profile</th>
                            <th class="px-6 py-3.5 font-bold">Joined</th>
                            <th class="px-6 py-3.5 font-bold">Status</th>
                            <th class="px-6 py-3.5 font-bold">Engagement</th>
                            <th class="px-6 py-3.5 font-bold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @if($readers)
                            @forelse($readers as $reader)
                            @php
                                $recentHistories = $reader->readingHistories->take(5);
                            @endphp
                            <tr class="hover:bg-gray-50/80 transition-colors">
                                <!-- Reader Profile -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($reader->hasAvatar())
                                            <img src="{{ $reader->avatar_url }}" alt="{{ $reader->name }}" class="w-9 h-9 rounded-full object-cover border border-gray-200">
                                        @else
                                            <div class="w-9 h-9 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-700 font-bold text-xs uppercase font-heading">
                                                {{ substr($reader->name, 0, 2) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-bold text-gray-900 text-sm">{{ $reader->name }}</div>
                                            <div class="text-gray-500">{{ $reader->email }}</div>
                                            @if($reader->phone_number)
                                                <div class="text-gray-400 text-[10px]">📞 {{ $reader->phone_number }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <!-- Joined Date -->
                                <td class="px-6 py-4 text-gray-600 whitespace-nowrap">
                                    <div>{{ $reader->created_at->format('d M Y') }}</div>
                                    <div class="text-[10px] text-gray-400">{{ $reader->created_at->diffForHumans() }}</div>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($reader->author_status === 'suspended')
                                        <span class="px-2.5 py-0.5 bg-red-100 text-red-800 font-semibold border border-red-200 text-[11px]">Suspended</span>
                                    @else
                                        <span class="px-2.5 py-0.5 bg-green-100 text-green-800 font-semibold border border-green-200 text-[11px]">Active</span>
                                    @endif
                                </td>

                                <!-- Engagement Stats -->
                                <td class="px-6 py-4 text-gray-600">
                                    <div class="flex flex-col gap-0.5">
                                        <span class="font-semibold text-gray-900">📖 {{ $reader->reading_histories_count }} read</span>
                                        <span class="text-gray-500 text-[11px]">💬 {{ $reader->comments_count }} comments</span>
                                        <span class="text-gray-500 text-[11px]">❤️ {{ $reader->likes_count }} likes</span>
                                    </div>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 text-right whitespace-nowrap space-x-2">
                                    <!-- View Profile & Activity Button -->
                                    <button type="button"
                                            onclick="openReaderModal({{ $reader->id }})"
                                            class="px-3 py-1.5 border border-gray-300 text-gray-700 hover:bg-gray-100 font-bold uppercase tracking-wider text-[10px] transition-colors">
                                        Detail &amp; Activity
                                    </button>

                                    <!-- Suspend / Unsuspend -->
                                    <form action="{{ route('admin.readers.toggle-status', $reader) }}" method="POST" class="inline-block"
                                          data-confirm-title="{{ $reader->author_status === 'suspended' ? 'Aktifkan Akun Pembaca?' : 'Tangguhkan Akun Pembaca?' }}"
                                          data-confirm-description="Apakah Anda yakin ingin {{ $reader->author_status === 'suspended' ? 'mengaktifkan kembali' : 'menangguhkan' }} akun &quot;{{ addslashes($reader->name) }}&quot;?"
                                          data-confirm-btn="{{ $reader->author_status === 'suspended' ? 'Aktifkan' : 'Tangguhkan' }}"
                                          data-confirm-variant="{{ $reader->author_status === 'suspended' ? 'info' : 'warning' }}">
                                        @csrf
                                        <button type="submit" class="text-[11px] font-semibold {{ $reader->author_status === 'suspended' ? 'text-green-600 hover:text-green-800' : 'text-amber-600 hover:text-amber-800' }}">
                                            {{ $reader->author_status === 'suspended' ? 'Unsuspend' : 'Suspend' }}
                                        </button>
                                    </form>

                                    <!-- Delete Reader -->
                                    <form action="{{ route('admin.authors.destroy', $reader) }}" 
                                          method="POST" 
                                          class="inline-block"
                                          data-confirm-title="Hapus akun pembaca?"
                                          data-confirm-description="Apakah Anda yakin ingin menghapus akun &quot;{{ addslashes($reader->name) }}&quot; secara permanen? Seluruh riwayat dan interaksinya akan dihapus."
                                          data-confirm-btn="Hapus Permanen">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-[11px] text-red-600 hover:text-red-800 font-semibold ml-1">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            {{-- Detailed Reader Profile & Activity Modal --}}
                            <div id="modal-reader-{{ $reader->id }}"
                                 class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 hidden"
                                 onclick="if(event.target===this) closeReaderModal({{ $reader->id }})">
                                <div class="bg-white max-w-2xl w-full mx-4 shadow-2xl max-h-[90vh] flex flex-col overflow-hidden border border-gray-300">
                                    <!-- Modal Header -->
                                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-[#00081e] text-white">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center font-bold text-xs uppercase font-heading text-white">
                                                {{ substr($reader->name, 0, 2) }}
                                            </div>
                                            <div>
                                                <h3 class="text-sm font-bold font-heading uppercase tracking-wider text-white">Reader Profile &amp; Activity</h3>
                                                <p class="text-[11px] text-gray-300">{{ $reader->name }} ({{ $reader->email }})</p>
                                            </div>
                                        </div>
                                        <button onclick="closeReaderModal({{ $reader->id }})" class="text-gray-400 hover:text-white transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Modal Body (Scrollable) -->
                                    <div class="p-6 space-y-6 overflow-y-auto text-xs font-sans">
                                        
                                        <!-- Profile Overview Cards -->
                                        <div>
                                            <h4 class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2">Profile Details</h4>
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                                <div class="bg-gray-50 p-3 border border-gray-200">
                                                    <div class="text-[10px] text-gray-400 uppercase tracking-wider mb-1">Full Name</div>
                                                    <div class="font-bold text-gray-900 text-sm">{{ $reader->name }}</div>
                                                    @if($reader->preferred_name)
                                                        <div class="text-[10px] text-gray-500">Alias: {{ $reader->preferred_name }}</div>
                                                    @endif
                                                </div>
                                                <div class="bg-gray-50 p-3 border border-gray-200">
                                                    <div class="text-[10px] text-gray-400 uppercase tracking-wider mb-1">Email Address</div>
                                                    <div class="text-gray-800 break-all font-medium">{{ $reader->email }}</div>
                                                    <div class="text-[10px] {{ $reader->email_verified_at ? 'text-green-600' : 'text-amber-600' }}">
                                                        {{ $reader->email_verified_at ? '✓ Email Verified' : '⚠ Unverified Email' }}
                                                    </div>
                                                </div>
                                                <div class="bg-gray-50 p-3 border border-gray-200">
                                                    <div class="text-[10px] text-gray-400 uppercase tracking-wider mb-1">Affiliation / University</div>
                                                    @if($reader->university)
                                                        <div class="font-semibold text-gray-900">{{ $reader->university->name }}</div>
                                                        <div class="text-gray-500 text-[11px]">{{ $reader->department ?? '-' }}</div>
                                                    @else
                                                        <div class="text-gray-500 font-medium">None / General Reader</div>
                                                        <div class="text-gray-400 text-[10px]">(University affiliation is only required for Authors)</div>
                                                    @endif
                                                </div>
                                                <div class="bg-gray-50 p-3 border border-gray-200">
                                                    <div class="text-[10px] text-gray-400 uppercase tracking-wider mb-1">Account &amp; Status</div>
                                                    <div class="flex items-center gap-2 mt-0.5">
                                                        <span class="px-2 py-0.5 bg-gray-200 text-gray-800 font-semibold text-[10px]">Reader</span>
                                                        @if($reader->author_status === 'suspended')
                                                            <span class="px-2 py-0.5 bg-red-100 text-red-800 font-semibold text-[10px]">Suspended</span>
                                                        @else
                                                            <span class="px-2 py-0.5 bg-green-100 text-green-800 font-semibold text-[10px]">Active</span>
                                                        @endif
                                                    </div>
                                                    <div class="text-[10px] text-gray-400 mt-1">Joined: {{ $reader->created_at->format('d M Y, H:i') }}</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Engagement Counters -->
                                        <div>
                                            <h4 class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2">Activity Overview</h4>
                                            <div class="grid grid-cols-3 gap-3">
                                                <div class="bg-blue-50/60 p-3 border border-blue-100 text-center">
                                                    <div class="text-xl font-extrabold text-blue-800">{{ $reader->reading_histories_count }}</div>
                                                    <div class="text-[10px] text-blue-600 uppercase tracking-wider font-semibold">Articles Read</div>
                                                </div>
                                                <div class="bg-purple-50/60 p-3 border border-purple-100 text-center">
                                                    <div class="text-xl font-extrabold text-purple-800">{{ $reader->comments_count }}</div>
                                                    <div class="text-[10px] text-purple-600 uppercase tracking-wider font-semibold">Comments</div>
                                                </div>
                                                <div class="bg-pink-50/60 p-3 border border-pink-100 text-center">
                                                    <div class="text-xl font-extrabold text-pink-800">{{ $reader->likes_count }}</div>
                                                    <div class="text-[10px] text-pink-600 uppercase tracking-wider font-semibold">Likes Given</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Last 3-5 Read Articles History -->
                                        <div>
                                            <div class="flex items-center justify-between mb-2">
                                                <h4 class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">
                                                    Reading History (Last 3–5 Articles Read)
                                                </h4>
                                                <span class="text-[10px] text-gray-400">
                                                    Showing {{ min(5, $recentHistories->count()) }} most recent
                                                </span>
                                            </div>

                                            @if($recentHistories->isNotEmpty())
                                                <div class="divide-y divide-gray-100 border border-gray-200 bg-white shadow-sm">
                                                    @foreach($recentHistories as $idx => $item)
                                                        @if($item->article)
                                                        <div class="p-3.5 hover:bg-gray-50/80 transition-colors flex items-start justify-between gap-3">
                                                            <div class="space-y-1">
                                                                <div class="flex items-center gap-2">
                                                                    <span class="w-5 h-5 rounded-full bg-gray-100 text-gray-600 text-[10px] font-bold flex items-center justify-center font-heading">
                                                                        {{ $idx + 1 }}
                                                                    </span>
                                                                    @if($item->article->category)
                                                                        <span class="px-2 py-0.5 bg-gray-100 text-gray-600 border border-gray-200 text-[10px] font-semibold">
                                                                            {{ $item->article->category->name }}
                                                                        </span>
                                                                    @endif
                                                                    <span class="text-[10px] text-gray-400">
                                                                        By {{ $item->article->user->name ?? 'Author' }}
                                                                    </span>
                                                                </div>
                                                                <a href="{{ route('article', $item->article->slug) }}" target="_blank" class="font-bold text-gray-900 hover:text-[#8b1528] text-sm block">
                                                                    {{ $item->article->title }}
                                                                    <span class="text-gray-400 text-xs inline-block ml-1">↗</span>
                                                                </a>
                                                            </div>
                                                            <div class="text-right whitespace-nowrap">
                                                                <div class="text-[10px] text-gray-500 font-medium">
                                                                    {{ $item->last_read_at?->format('d M Y, H:i') ?? '-' }}
                                                                </div>
                                                                <div class="text-[10px] text-gray-400">
                                                                    {{ $item->last_read_at?->diffForHumans() }}
                                                                </div>
                                                                <span class="inline-block mt-1 px-1.5 py-0.5 bg-gray-100 text-gray-600 text-[9px] font-semibold rounded">
                                                                    Read {{ $item->read_count }}x
                                                                </span>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="p-6 bg-gray-50 border border-gray-200 text-center text-gray-400 italic">
                                                    No articles have been read by this reader user yet.
                                                </div>
                                            @endif
                                        </div>

                                    </div>

                                    <!-- Modal Footer Actions -->
                                    <div class="px-6 py-3.5 border-t border-gray-200 bg-gray-50 flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <!-- Suspend / Unsuspend -->
                                            <form action="{{ route('admin.readers.toggle-status', $reader) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="px-3 py-1.5 text-xs font-bold uppercase tracking-wider border {{ $reader->author_status === 'suspended' ? 'border-green-300 text-green-700 hover:bg-green-50' : 'border-amber-300 text-amber-700 hover:bg-amber-50' }} transition-colors">
                                                    {{ $reader->author_status === 'suspended' ? 'Unsuspend Reader' : 'Suspend Reader' }}
                                                </button>
                                            </form>
                                        </div>

                                        <button type="button" onclick="closeReaderModal({{ $reader->id }})" class="px-4 py-1.5 bg-gray-200 hover:bg-gray-300 text-gray-800 text-xs font-bold uppercase tracking-wider transition-colors">
                                            Close
                                        </button>
                                    </div>
                                </div>
                            </div>

                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-400 italic">No readers found matching your filters.</td>
                            </tr>
                            @endforelse
                        @endif
                    </tbody>
                </table>
            </div>

            @if($readers && $readers->hasPages())
            <div class="p-4 border-t border-gray-200 bg-[#f8f9fa]">
                {{ $readers->links() }}
            </div>
            @endif
        </div>

    </div>
    @endif

</div>

<script>
function openDetailModal(id) {
    var m = document.getElementById('modal-' + id);
    if (m) {
        m.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}
function closeDetailModal(id) {
    var m = document.getElementById('modal-' + id);
    if (m) {
        m.classList.add('hidden');
        document.body.style.overflow = '';
    }
}
function openReaderModal(id) {
    var m = document.getElementById('modal-reader-' + id);
    if (m) {
        m.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}
function closeReaderModal(id) {
    var m = document.getElementById('modal-reader-' + id);
    if (m) {
        m.classList.add('hidden');
        document.body.style.overflow = '';
    }
}
// Close on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('[id^="modal-"]').forEach(function(m) {
            m.classList.add('hidden');
        });
        document.body.style.overflow = '';
    }
});
</script>
@endsection
