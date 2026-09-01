@extends('admin.layouts.app')

@section('title', $job->title . ' - Admin Panel')
@section('page-title', 'Job Details')

@section('content')
<div class="space-y-6">
    
    <!-- ===== HEADER ===== -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-gray-900">{{ $job->title }}</h2>
            <p class="text-sm text-gray-500">{{ $job->employer?->company_name ?? 'N/A' }} • {{ $job->location }}</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.jobs.edit', $job->id) }}" 
               class="px-4 py-2 bg-[#1a237e] text-white text-sm font-medium rounded-lg hover:bg-[#0d1445] transition-all">
                Edit Job
            </a>
            <a href="{{ route('admin.jobs.index') }}" 
               class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-all">
                Back
            </a>
        </div>
    </div>
    
    <!-- ===== JOB INFO CARDS ===== -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <p class="text-xs text-gray-400">Status</p>
            <span class="inline-flex items-center mt-1 px-2.5 py-1 rounded-full text-xs font-medium
                @if($job->status === 'published') bg-emerald-50 text-emerald-700
                @elseif($job->status === 'draft') bg-amber-50 text-amber-700
                @else bg-gray-50 text-gray-700
                @endif">
                {{ ucfirst($job->status) }}
            </span>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <p class="text-xs text-gray-400">Work Type</p>
            <p class="text-sm font-medium text-gray-900 mt-1">{{ ucfirst($job->work_type) }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <p class="text-xs text-gray-400">Employment Type</p>
            <p class="text-sm font-medium text-gray-900 mt-1">{{ ucfirst(str_replace('_', ' ', $job->employment_type)) }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <p class="text-xs text-gray-400">Applications</p>
            <p class="text-2xl font-bold text-[#1a237e] mt-1">{{ $stats['total_applications'] ?? 0 }}</p>
        </div>
    </div>
    
    <!-- ===== DETAILS & STATS ===== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Main Details -->
        <div class="lg:col-span-2 space-y-4">
            <!-- Description -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">Description</h3>
                <p class="text-sm text-gray-600 whitespace-pre-wrap">{{ $job->description }}</p>
            </div>
            
            <!-- Requirements -->
            @if($job->requirements)
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">Requirements</h3>
                <p class="text-sm text-gray-600 whitespace-pre-wrap">{{ $job->requirements }}</p>
            </div>
            @endif
            
            <!-- Benefits -->
            @if($job->benefits)
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">Benefits</h3>
                <p class="text-sm text-gray-600 whitespace-pre-wrap">{{ $job->benefits }}</p>
            </div>
            @endif
            
            <!-- Skills -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @if($job->required_skills)
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-900 mb-3">Required Skills</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach(is_array($job->required_skills) ? $job->required_skills : json_decode($job->required_skills ?? '[]', true) as $skill)
                            <span class="px-2.5 py-1 bg-blue-50 text-blue-700 text-xs rounded-full">{{ $skill }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
                
                @if($job->preferred_skills)
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-900 mb-3">Preferred Skills</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach(is_array($job->preferred_skills) ? $job->preferred_skills : json_decode($job->preferred_skills ?? '[]', true) as $skill)
                            <span class="px-2.5 py-1 bg-purple-50 text-purple-700 text-xs rounded-full">{{ $skill }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Sidebar Info -->
        <div class="space-y-4">
            <!-- Quick Info -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Quick Info</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-gray-400">Employer</p>
                        <p class="text-sm font-medium text-gray-900">{{ $job->employer?->company_name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Recruiter</p>
                        <p class="text-sm font-medium text-gray-900">{{ $job->recruiter?->first_name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Department</p>
                        <p class="text-sm font-medium text-gray-900">{{ $job->department ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Experience Level</p>
                        <p class="text-sm font-medium text-gray-900">{{ ucfirst(str_replace('_', ' ', $job->experience_level ?? 'N/A')) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Salary</p>
                        <p class="text-sm font-medium text-gray-900">{{ $job->salary_range ?? 'Not specified' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Visibility</p>
                        <p class="text-sm font-medium text-gray-900">{{ ucfirst($job->visibility) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">AI Generated</p>
                        <p class="text-sm font-medium text-gray-900">{{ $job->is_ai_generated ? 'Yes' : 'No' }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Dates -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Dates</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-gray-400">Created</p>
                        <p class="text-sm font-medium text-gray-900">{{ $job->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Published</p>
                        <p class="text-sm font-medium text-gray-900">{{ $job->published_at?->format('M d, Y H:i') ?? 'Not published' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Closing</p>
                        <p class="text-sm font-medium text-gray-900">{{ $job->closing_at?->format('M d, Y H:i') ?? 'No closing date' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Last Updated</p>
                        <p class="text-sm font-medium text-gray-900">{{ $job->updated_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- ===== APPLICATION STATS ===== -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <h3 class="text-sm font-semibold text-gray-900 mb-4">Application Statistics</h3>
        <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
            <div>
                <p class="text-xs text-gray-400">Total</p>
                <p class="text-lg font-bold text-gray-900">{{ $stats['total_applications'] ?? 0 }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Pending</p>
                <p class="text-lg font-bold text-amber-600">{{ $stats['pending_applications'] ?? 0 }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Shortlisted</p>
                <p class="text-lg font-bold text-blue-600">{{ $stats['shortlisted'] ?? 0 }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Interviewing</p>
                <p class="text-lg font-bold text-purple-600">{{ $stats['interviewing'] ?? 0 }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Hired</p>
                <p class="text-lg font-bold text-emerald-600">{{ $stats['hired'] ?? 0 }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Rejected</p>
                <p class="text-lg font-bold text-red-600">{{ $stats['rejected'] ?? 0 }}</p>
            </div>
        </div>
    </div>
</div>
@endsection