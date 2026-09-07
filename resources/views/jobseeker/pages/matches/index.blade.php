@extends('jobseeker.layouts.app')

@section('title', 'My Job Matches')
@section('page-title', 'AI-Powered Job Matches')

@section('content')
<div class="space-y-6">

    <!-- ===== HEADER ===== -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">Your Job Matches</h2>
            <p class="text-sm text-gray-500 mt-1">AI-powered recommendations based on your resume and skills</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('candidate.resume.index') }}" 
               class="inline-flex items-center gap-2 px-4 py-2 bg-[#1a237e] text-white text-sm font-medium rounded-lg hover:bg-[#0d1445] transition-all duration-200 shadow-sm hover:shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Manage Resume
            </a>
        </div>
    </div>

    <!-- ===== STATS CARDS ===== -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Matches</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Highly Recommended</p>
                    <p class="text-2xl font-bold text-green-600">{{ $stats['highly_recommended'] ?? 0 }}</p>
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
                    <p class="text-sm text-gray-500">Shortlisted</p>
                    <p class="text-2xl font-bold text-purple-600">{{ $stats['shortlisted'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Avg Match Score</p>
                    <p class="text-2xl font-bold text-amber-600">{{ round($stats['average_score'] ?? 0) }}%</p>
                </div>
                <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== MATCHES LIST ===== -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @if($matches->count() > 0)
            <div class="divide-y divide-gray-100">
                @foreach($matches as $match)
                    <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1 min-w-0">
                                <!-- Job Title & Company -->
                                <div class="flex flex-wrap items-center gap-2">
                                    <h4 class="text-sm font-semibold text-gray-900">{{ $match->jobPost->title ?? 'N/A' }}</h4>
                                    <span class="text-xs text-gray-400">•</span>
                                    <span class="text-sm text-gray-600">{{ $match->jobPost->employer->company_name ?? 'Unknown Company' }}</span>
                                </div>
                                
                                <!-- Match Score -->
                                <div class="flex flex-wrap items-center gap-4 mt-2">
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs text-gray-500">Match Score:</span>
                                        <div class="w-24 h-2 bg-gray-200 rounded-full overflow-hidden">
                                            <div class="h-full rounded-full 
                                                @if($match->overall_score >= 80) bg-green-500
                                                @elseif($match->overall_score >= 60) bg-amber-500
                                                @else bg-red-500
                                                @endif"
                                                style="width: {{ $match->overall_score }}%">
                                            </div>
                                        </div>
                                        <span class="text-sm font-semibold 
                                            @if($match->overall_score >= 80) text-green-600
                                            @elseif($match->overall_score >= 60) text-amber-600
                                            @else text-red-600
                                            @endif">
                                            {{ round($match->overall_score) }}%
                                        </span>
                                    </div>
                                    
                                    <span class="text-gray-300">|</span>
                                    
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                        {{ $match->tier === 'A' ? 'bg-green-100 text-green-700' : 
                                           ($match->tier === 'B' ? 'bg-blue-100 text-blue-700' : 
                                           ($match->tier === 'C' ? 'bg-amber-100 text-amber-700' : 'bg-gray-100 text-gray-700')) }}">
                                        Tier {{ $match->tier }}
                                    </span>
                                    
                                    @if($match->is_shortlisted)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-700">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Shortlisted
                                        </span>
                                    @endif
                                    
                                    @if($match->is_recommended)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                            <i class="fas fa-star mr-1 text-yellow-500"></i>
                                            Recommended
                                        </span>
                                    @endif
                                </div>
                                
                                <!-- Match Details -->
                                <div class="flex flex-wrap items-center gap-3 mt-2 text-xs text-gray-500">
                                    <span>
                                        <i class="fas fa-code mr-1"></i>
                                        Skills: {{ count($match->matched_skills ?? []) }}/{{ count($match->matched_skills ?? []) + count($match->missing_skills ?? []) }}
                                    </span>
                                    <span>•</span>
                                    <span>
                                        <i class="fas fa-briefcase mr-1"></i>
                                        Experience: {{ $match->matching_experience ?? 0 }} years
                                    </span>
                                    <span>•</span>
                                    <span>
                                        <i class="fas fa-calendar-alt mr-1"></i>
                                        Matched {{ $match->matched_at ? $match->matched_at->diffForHumans() : $match->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                
                                <!-- Matched Skills -->
                                @if(count($match->matched_skills ?? []) > 0)
                                    <div class="flex flex-wrap gap-1.5 mt-2">
                                        @foreach(array_slice($match->matched_skills, 0, 5) as $skill)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700">
                                                {{ $skill }}
                                            </span>
                                        @endforeach
                                        @if(count($match->matched_skills) > 5)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-50 text-gray-600">
                                                +{{ count($match->matched_skills) - 5 }} more
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <!-- Actions -->
                            <div class="flex flex-col items-end gap-2 flex-shrink-0">
                                <a href="{{ route('candidate.matches.details', $match->id) }}" 
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-white bg-[#1a237e] rounded-lg hover:bg-[#0d1445] transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    View Details
                                </a>
                                @if(!$match->is_shortlisted)
                                    <span class="text-xs text-gray-400">Apply to get shortlisted</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- ===== PAGINATION ===== -->
            <div class="flex flex-wrap items-center justify-between gap-4 px-6 py-4 border-t border-gray-200 bg-gray-50/50">
                <div class="flex flex-wrap items-center gap-4">
                    <p class="text-sm text-gray-500">
                        Showing <span class="font-medium text-gray-700">{{ $matches->firstItem() ?? 0 }}</span>
                        to <span class="font-medium text-gray-700">{{ $matches->lastItem() ?? 0 }}</span>
                        of <span class="font-medium text-gray-700">{{ $matches->total() }}</span> matches
                    </p>
                </div>
                <div class="w-full sm:w-auto">
                    {{ $matches->withQueryString()->links() }}
                </div>
            </div>
        @else
            <!-- ===== EMPTY STATE ===== -->
            <div class="px-6 py-12 text-center">
                <div class="flex flex-col items-center">
                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    <p class="text-lg font-medium text-gray-900">No matches found yet</p>
                    <p class="text-sm text-gray-500 mt-1">Upload your resume to get AI-powered job recommendations</p>
                    <a href="{{ route('candidate.resume.index') }}" 
                       class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-[#1a237e] text-white text-sm font-medium rounded-lg hover:bg-[#0d1445] transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Upload Resume
                    </a>
                </div>
            </div>
        @endif
    </div>

</div>
@endsection