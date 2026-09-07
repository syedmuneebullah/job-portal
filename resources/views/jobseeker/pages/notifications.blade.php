@extends('jobseeker.layouts.app')

@section('title', 'All Notifications')
@section('page-title', 'Notifications')
@php
// Define helper functions for Blade
function getIconClass($type) {
    $icons = [
        'application_status_update' => 'fa-user-check',
        'interview_scheduled' => 'fa-calendar-plus',
        'interview_reminder' => 'fa-clock',
        'interview_cancelled' => 'fa-times-circle',
        'interview_rescheduled' => 'fa-sync-alt',
        'meeting_link' => 'fa-link',
        'new_application' => 'fa-file-alt',
        'application_shortlisted' => 'fa-star',
        'application_hired' => 'fa-trophy',
        'application_rejected' => 'fa-times'
    ];
    return $icons[$type] ?? 'fa-bell';
}

function getIconColor($type) {
    $colors = [
        'application_status_update' => 'bg-blue-100 text-blue-600',
        'interview_scheduled' => 'bg-green-100 text-green-600',
        'interview_reminder' => 'bg-amber-100 text-amber-600',
        'interview_cancelled' => 'bg-red-100 text-red-600',
        'interview_rescheduled' => 'bg-purple-100 text-purple-600',
        'meeting_link' => 'bg-blue-100 text-blue-600',
        'new_application' => 'bg-emerald-100 text-emerald-600',
        'application_shortlisted' => 'bg-yellow-100 text-yellow-600',
        'application_hired' => 'bg-green-100 text-green-600',
        'application_rejected' => 'bg-red-100 text-red-600'
    ];
    return $colors[$type] ?? 'bg-gray-100 text-gray-600';
}
@endphp
@section('content')
<div class="space-y-6">

    <!-- ===== HEADER WITH STATS ===== -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">All Notifications</h2>
            <p class="text-sm text-gray-500 mt-1">Stay updated with your latest notifications</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <button onclick="markAllRead()" 
                    class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-all duration-200 shadow-sm hover:shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Mark All Read
            </button>
            <button onclick="deleteRead()" 
                    class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-all duration-200 shadow-sm hover:shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Clear Read
            </button>
        </div>
    </div>

    <!-- ===== STATS CARDS ===== -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $notifications->total() }}</p>
                </div>
                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Unread</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $unreadCount }}</p>
                </div>
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Read</p>
                    <p class="text-2xl font-bold text-green-600">{{ $notifications->total() - $unreadCount }}</p>
                </div>
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Today</p>
                    <p class="text-2xl font-bold text-purple-600">
                        {{ $notifications->filter(function($n) { return $n->created_at->isToday(); })->count() }}
                    </p>
                </div>
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== FILTERS ===== -->
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
        <form action="{{ route('candidate.notifications.index') }}" method="GET" class="flex flex-wrap items-center gap-4">
            <!-- Filter: Status -->
            <div class="w-full sm:w-40">
                <select name="filter" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all">
                    <option value="">All Status</option>
                    <option value="unread" {{ request('filter') == 'unread' ? 'selected' : '' }}>Unread</option>
                    <option value="read" {{ request('filter') == 'read' ? 'selected' : '' }}>Read</option>
                </select>
            </div>

            <!-- Filter: Type -->
            <div class="w-full sm:w-48">
                <select name="type" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all">
                    <option value="">All Types</option>
                    <option value="application_status_update" {{ request('type') == 'application_status_update' ? 'selected' : '' }}>Application Status</option>
                    <option value="interview_scheduled" {{ request('type') == 'interview_scheduled' ? 'selected' : '' }}>Interview Scheduled</option>
                    <option value="interview_reminder" {{ request('type') == 'interview_reminder' ? 'selected' : '' }}>Interview Reminder</option>
                    <option value="meeting_link" {{ request('type') == 'meeting_link' ? 'selected' : '' }}>Meeting Link</option>
                    <option value="new_application" {{ request('type') == 'new_application' ? 'selected' : '' }}>New Application</option>
                </select>
            </div>

            <!-- Date Range -->
            <div class="w-full sm:w-36">
                <input type="date" name="from_date" value="{{ request('from_date') }}"
                       placeholder="From"
                       class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all">
            </div>
            <div class="w-full sm:w-36">
                <input type="date" name="to_date" value="{{ request('to_date') }}"
                       placeholder="To"
                       class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all">
            </div>

            <!-- Per Page -->
            <div class="w-full sm:w-24">
                <select name="per_page" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all">
                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <button type="submit" class="flex-1 sm:flex-none px-4 py-2 bg-[#1a237e] text-white text-sm font-medium rounded-lg hover:bg-[#0d1445] transition-all duration-200">
                    Apply Filters
                </button>
                <a href="{{ route('candidate.notifications.index') }}" class="flex-1 sm:flex-none px-4 py-2 bg-gray-100 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-200 transition-all duration-200 text-center">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- ===== NOTIFICATIONS LIST ===== -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @if($notifications->count() > 0)
            <div class="divide-y divide-gray-100">
                @foreach($notifications as $notification)
                    <a href="{{ route('candidate.notifications.show', $notification->id) }}" 
                       class="block px-6 py-4 hover:bg-gray-50 transition-colors {{ !$notification->is_read ? 'bg-blue-50' : '' }}">
                        <div class="flex items-start gap-4">
                            <!-- Icon -->
                            <div class="w-10 h-10 rounded-full {{ getIconColor($notification->type) }} flex items-center justify-center flex-shrink-0">
                                <i class="fas {{ getIconClass($notification->type) }} text-sm"></i>
                            </div>
                            
                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-start justify-between gap-2">
                                    <p class="text-sm font-medium text-gray-900 {{ !$notification->is_read ? 'font-semibold' : '' }}">
                                        {{ $notification->title }}
                                    </p>
                                    @if(!$notification->is_read)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                            New
                                        </span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-600 mt-1 line-clamp-2">{{ $notification->message }}</p>
                                <div class="flex flex-wrap items-center gap-3 mt-2">
                                    <span class="text-xs text-gray-400">
                                        <i class="far fa-clock mr-1"></i>
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>
                                    <span class="text-gray-300">•</span>
                                    <span class="text-xs text-gray-400">
                                        <i class="far fa-calendar-alt mr-1"></i>
                                        {{ $notification->created_at->format('M d, Y h:i A') }}
                                    </span>
                                    @if($notification->channel)
                                        <span class="text-gray-300">•</span>
                                        <span class="text-xs text-gray-400">
                                            <i class="fas fa-{{ $notification->channel === 'email' ? 'envelope' : ($notification->channel === 'sms' ? 'sms' : 'bell') }} mr-1"></i>
                                            {{ ucfirst($notification->channel) }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Actions -->
                            <div class="flex items-center gap-2 flex-shrink-0">
                                @if(!$notification->is_read)
                                    <button onclick="event.preventDefault(); markAsRead({{ $notification->id }})" 
                                            class="text-xs text-blue-600 hover:text-blue-800 transition-colors">
                                        Mark read
                                    </button>
                                @endif
                                <form action="{{ route('candidate.notifications.destroy', $notification->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            onclick="event.preventDefault(); if(confirm('Delete this notification?')) this.closest('form').submit();"
                                            class="text-xs text-gray-400 hover:text-red-600 transition-colors">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- ===== PAGINATION ===== -->
            <div class="flex flex-wrap items-center justify-between gap-4 px-6 py-4 border-t border-gray-200 bg-gray-50/50">
                <div class="flex flex-wrap items-center gap-4">
                    <p class="text-sm text-gray-500">
                        Showing <span class="font-medium text-gray-700">{{ $notifications->firstItem() ?? 0 }}</span>
                        to <span class="font-medium text-gray-700">{{ $notifications->lastItem() ?? 0 }}</span>
                        of <span class="font-medium text-gray-700">{{ $notifications->total() }}</span> notifications
                    </p>
                </div>
                <div class="w-full sm:w-auto">
                    {{ $notifications->withQueryString()->links() }}
                </div>
            </div>
        @else
            <!-- ===== EMPTY STATE ===== -->
            <div class="px-6 py-12 text-center">
                <div class="flex flex-col items-center">
                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <p class="text-lg font-medium text-gray-900">No notifications found</p>
                    <p class="text-sm text-gray-500 mt-1">You're all caught up! Check back later for updates.</p>
                    @if(request()->has('filter') || request()->has('type') || request()->has('from_date'))
                        <a href="{{ route('candidate.notifications.index') }}" class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-[#1a237e] text-white text-sm font-medium rounded-lg hover:bg-[#0d1445] transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Clear Filters
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </div>

</div>

<script>
// ===== MARK AS READ =====
function markAsRead(id) {
    fetch(`/candidate/notifications/${id}/mark-read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => console.error('Error marking as read:', error));
}

// ===== MARK ALL READ =====
function markAllRead() {
    if (!confirm('Mark all notifications as read?')) return;
    
    fetch('/candidate/notifications/mark-all-read', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => console.error('Error marking all as read:', error));
}

// ===== DELETE READ NOTIFICATIONS =====
function deleteRead() {
    if (!confirm('Delete all read notifications? This action cannot be undone.')) return;
    
    fetch('/candidate/notifications/read/delete', {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => console.error('Error deleting read notifications:', error));
}

// ===== GET ICON CLASS =====
function getIconClass(type) {
    const icons = {
        'application_status_update': 'fa-user-check',
        'interview_scheduled': 'fa-calendar-plus',
        'interview_reminder': 'fa-clock',
        'interview_cancelled': 'fa-times-circle',
        'interview_rescheduled': 'fa-sync-alt',
        'meeting_link': 'fa-link',
        'new_application': 'fa-file-alt',
        'application_shortlisted': 'fa-star',
        'application_hired': 'fa-trophy',
        'application_rejected': 'fa-times'
    };
    return icons[type] || 'fa-bell';
}

// ===== GET ICON COLOR =====
function getIconColor(type) {
    const colors = {
        'application_status_update': 'bg-blue-100 text-blue-600',
        'interview_scheduled': 'bg-green-100 text-green-600',
        'interview_reminder': 'bg-amber-100 text-amber-600',
        'interview_cancelled': 'bg-red-100 text-red-600',
        'interview_rescheduled': 'bg-purple-100 text-purple-600',
        'meeting_link': 'bg-blue-100 text-blue-600',
        'new_application': 'bg-emerald-100 text-emerald-600',
        'application_shortlisted': 'bg-yellow-100 text-yellow-600',
        'application_hired': 'bg-green-100 text-green-600',
        'application_rejected': 'bg-red-100 text-red-600'
    };
    return colors[type] || 'bg-gray-100 text-gray-600';
}
</script>
@endsection