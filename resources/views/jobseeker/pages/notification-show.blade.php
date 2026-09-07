@extends('jobseeker.layouts.app')

@section('title', 'Notification Details')
@section('page-title', 'Notification Details')

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

    <!-- ===== BACK BUTTON ===== -->
    <div class="flex items-center justify-between">
        <a href="{{ route('candidate.notifications.index') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 bg-[#1a237e] text-white text-sm font-medium rounded-lg hover:bg-[#0d1445] transition-all duration-200 shadow-sm hover:shadow-md">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Notifications
        </a>
        
        @if(!$notification->is_read)
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-1.5 animate-pulse"></span>
                New
            </span>
        @endif
    </div>

    <!-- ===== NOTIFICATION DETAIL CARD ===== -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-[#1a237e]/5 to-transparent">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-full {{ getIconColor($notification->type) }} flex items-center justify-center flex-shrink-0">
                    <i class="fas {{ getIconClass($notification->type) }} text-xl"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <h2 class="text-xl font-bold text-gray-900">{{ $notification->title }}</h2>
                    <div class="flex flex-wrap items-center gap-3 mt-1">
                        <span class="text-sm text-gray-500">
                            <i class="far fa-clock mr-1"></i>
                            {{ $notification->created_at->format('F d, Y h:i A') }}
                        </span>
                        <span class="text-gray-300">|</span>
                        <span class="text-sm text-gray-500">
                            <i class="far fa-calendar-alt mr-1"></i>
                            {{ $notification->created_at->diffForHumans() }}
                        </span>
                        @if($notification->channel)
                            <span class="text-gray-300">|</span>
                            <span class="text-sm text-gray-500">
                                <i class="fas fa-{{ $notification->channel === 'email' ? 'envelope' : ($notification->channel === 'sms' ? 'sms' : 'bell') }} mr-1"></i>
                                {{ ucfirst($notification->channel) }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Body -->
        <div class="px-6 py-6">
            <div class="prose max-w-none">
                <p class="text-gray-700 text-base leading-relaxed">{{ $notification->message }}</p>
            </div>

            <!-- Additional Data -->
            @if($notification->data)
                <div class="mt-6">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Additional Information</h4>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($notification->data as $key => $value)
                                @if(!in_array($key, ['application_id', 'job_post_id', 'schedule_interview_id']))
                                    <div>
                                        <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">{{ Str::title(str_replace('_', ' ', $key)) }}</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            @if(is_array($value))
                                                {{ json_encode($value) }}
                                            @elseif($value instanceof \DateTime)
                                                {{ $value->format('M d, Y h:i A') }}
                                            @else
                                                {{ $value }}
                                            @endif
                                        </dd>
                                    </div>
                                @endif
                            @endforeach
                        </dl>
                    </div>
                </div>
            @endif

            <!-- Action Buttons based on type -->
            <div class="mt-6 flex flex-wrap gap-3">
                @if($notification->type === 'interview_scheduled' || $notification->type === 'meeting_link')
                    @if(isset($notification->data['meeting_link']))
                        <a href="{{ $notification->data['meeting_link'] }}" 
                           target="_blank"
                           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Join Meeting
                        </a>
                    @endif
                @endif

                @if($notification->type === 'application_status_update' || $notification->type === 'new_application')
                    @if(isset($notification->data['application_id']))
                        <a href="{{ route('candidate.job.details', $notification->data['application_id']) }}" 
                           class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            View Application
                        </a>
                    @endif
                @endif

                @if($notification->type === 'interview_scheduled' && isset($notification->data['interview_datetime']))
                    <button onclick="addToCalendar('{{ $notification->data['interview_datetime'] }}', '{{ $notification->title }}')"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Add to Calendar
                    </button>
                @endif
            </div>
        </div>

        <!-- Footer -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <form action="{{ route('candidate.notifications.destroy', $notification->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            onclick="return confirm('Are you sure you want to delete this notification?')"
                            class="text-sm text-red-600 hover:text-red-800 transition-colors">
                        <i class="fas fa-trash-alt mr-1"></i>
                        Delete
                    </button>
                </form>
                
                @if(!$notification->is_read)
                    <span class="text-gray-300">|</span>
                    <button onclick="markAsRead({{ $notification->id }})" 
                            class="text-sm text-blue-600 hover:text-blue-800 transition-colors">
                        <i class="fas fa-check-circle mr-1"></i>
                        Mark as Read
                    </button>
                @endif
            </div>
            
            <div class="flex items-center gap-3 text-xs text-gray-400">
                <span>Notification ID: #{{ $notification->id }}</span>
                <span>•</span>
                <span>Type: {{ ucfirst(str_replace('_', ' ', $notification->type)) }}</span>
            </div>
        </div>
    </div>

    <!-- ===== RELATED NOTIFICATIONS ===== -->
    @if(isset($relatedNotifications) && $relatedNotifications->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900">Related Notifications</h3>
            </div>
            <div class="divide-y divide-gray-100">
                @foreach($relatedNotifications as $related)
                    <a href="{{ route('candidate.notifications.show', $related->id) }}" 
                       class="block px-6 py-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full {{ getIconColor($related->type) }} flex items-center justify-center flex-shrink-0">
                                <i class="fas {{ getIconClass($related->type) }} text-xs"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">{{ $related->title }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $related->created_at->diffForHumans() }}</p>
                            </div>
                            @if(!$related->is_read)
                                <span class="w-2 h-2 rounded-full bg-blue-500 flex-shrink-0 mt-1.5"></span>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

</div>

<script>
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

function addToCalendar(datetime, title) {
    const date = new Date(datetime);
    const endDate = new Date(date.getTime() + 60 * 60 * 1000); // 1 hour later
    
    const googleUrl = `https://www.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent(title)}&dates=${date.toISOString().replace(/-|:|\.\d\d\d/g, '')}/${endDate.toISOString().replace(/-|:|\.\d\d\d/g, '')}`;
    
    window.open(googleUrl, '_blank');
}
</script>
@endsection