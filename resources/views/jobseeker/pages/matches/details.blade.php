@extends('jobseeker.layouts.app')

@section('title', 'Match Details')
@section('page-title', 'Match Details')

@section('content')
<div class="space-y-6">

    <!-- ===== BACK BUTTON ===== -->
    <div class="flex items-center justify-between">
        <a href="{{ route('candidate.matches.index') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 bg-[#1a237e] text-white text-sm font-medium rounded-lg hover:bg-[#0d1445] transition-all duration-200 shadow-sm hover:shadow-md">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Matches
        </a>
        
        @if($match->is_shortlisted)
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-700">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Shortlisted
            </span>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- ===== MAIN CONTENT ===== -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Job Details -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-[#1a237e]/5 to-transparent">
                    <h3 class="text-lg font-semibold text-gray-900">Job Details</h3>
                </div>
                <div class="px-6 py-5 space-y-4">
                    <div>
                        <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Position</label>
                        <p class="text-lg font-semibold text-gray-900 mt-1">{{ $match->jobPost->title ?? 'N/A' }}</p>
                    </div>
                    
                    <div>
                        <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Company</label>
                        <p class="text-sm text-gray-900 mt-1">{{ $match->jobPost->employer->company_name ?? 'N/A' }}</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Location</label>
                            <p class="text-sm text-gray-900 mt-1">{{ $match->jobPost->location ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Employment Type</label>
                            <p class="text-sm text-gray-900 mt-1">{{ ucfirst(str_replace('_', ' ', $match->jobPost->employment_type ?? 'N/A')) }}</p>
                        </div>
                    </div>
                    
                    @if($match->jobPost->description)
                        <div>
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Description</label>
                            <p class="text-sm text-gray-600 mt-1 line-clamp-3">{{ $match->jobPost->description }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Match Score Breakdown -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900">Match Breakdown</h3>
                </div>
                <div class="px-6 py-5 space-y-4">
                    <!-- Overall Score -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm font-medium text-gray-700">Overall Match</span>
                            <span class="text-sm font-bold 
                                @if($match->overall_score >= 80) text-green-600
                                @elseif($match->overall_score >= 60) text-amber-600
                                @else text-red-600
                                @endif">
                                {{ round($match->overall_score) }}%
                            </span>
                        </div>
                        <div class="w-full h-3 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-500
                                @if($match->overall_score >= 80) bg-green-500
                                @elseif($match->overall_score >= 60) bg-amber-500
                                @else bg-red-500
                                @endif"
                                style="width: {{ $match->overall_score }}%">
                            </div>
                        </div>
                    </div>

                    <!-- Individual Scores -->
                    <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-100">
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-xs text-gray-600">Skills Match</span>
                                <span class="text-xs font-semibold">{{ round($match->skills_match_score) }}%</span>
                            </div>
                            <div class="w-full h-1.5 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full rounded-full bg-blue-500" style="width: {{ $match->skills_match_score }}%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-xs text-gray-600">Experience Match</span>
                                <span class="text-xs font-semibold">{{ round($match->experience_match_score) }}%</span>
                            </div>
                            <div class="w-full h-1.5 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full rounded-full bg-green-500" style="width: {{ $match->experience_match_score }}%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-xs text-gray-600">Education Match</span>
                                <span class="text-xs font-semibold">{{ round($match->education_match_score) }}%</span>
                            </div>
                            <div class="w-full h-1.5 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full rounded-full bg-purple-500" style="width: {{ $match->education_match_score }}%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-xs text-gray-600">Certifications Match</span>
                                <span class="text-xs font-semibold">{{ round($match->certifications_match_score) }}%</span>
                            </div>
                            <div class="w-full h-1.5 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full rounded-full bg-amber-500" style="width: {{ $match->certifications_match_score }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Skills Analysis -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900">Skills Analysis</h3>
                </div>
                <div class="px-6 py-5">
                    @if(count($match->matched_skills ?? []) > 0 || count($match->missing_skills ?? []) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Matched Skills -->
                            <div>
                                <h4 class="text-sm font-medium text-green-700 mb-3">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Matched Skills ({{ count($match->matched_skills ?? []) }})
                                </h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($match->matched_skills ?? [] as $skill)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700">
                                            {{ $skill }}
                                        </span>
                                    @endforeach
                                    @if(empty($match->matched_skills))
                                        <p class="text-sm text-gray-500">No matched skills</p>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Missing Skills -->
                            <div>
                                <h4 class="text-sm font-medium text-red-700 mb-3">
                                    <i class="fas fa-times-circle mr-1"></i>
                                    Missing Skills ({{ count($match->missing_skills ?? []) }})
                                </h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($match->missing_skills ?? [] as $skill)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-50 text-red-700">
                                            {{ $skill }}
                                        </span>
                                    @endforeach
                                    @if(empty($match->missing_skills))
                                        <p class="text-sm text-gray-500">No missing skills</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <p class="text-sm text-gray-500">No skill data available</p>
                    @endif
                </div>
            </div>

        </div>

        <!-- ===== SIDEBAR ===== -->
        <div class="space-y-6">
            
            <!-- AI Recommendations -->
            @if($match->aiRecommendation)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-purple-50 to-transparent">
                        <h3 class="text-lg font-semibold text-gray-900">
                            <i class="fas fa-robot text-purple-600 mr-2"></i>
                            AI Insights
                        </h3>
                    </div>
                    <div class="px-6 py-5 space-y-4">
                        @if($match->aiRecommendation->strengths && count($match->aiRecommendation->strengths) > 0)
                            <div>
                                <h4 class="text-sm font-medium text-green-700 mb-2">Strengths</h4>
                                <ul class="space-y-1">
                                    @foreach($match->aiRecommendation->strengths as $strength)
                                        <li class="text-sm text-gray-600 flex items-start gap-2">
                                            <svg class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            {{ $strength }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if($match->aiRecommendation->weaknesses && count($match->aiRecommendation->weaknesses) > 0)
                            <div>
                                <h4 class="text-sm font-medium text-red-700 mb-2">Areas for Improvement</h4>
                                <ul class="space-y-1">
                                    @foreach($match->aiRecommendation->weaknesses as $weakness)
                                        <li class="text-sm text-gray-600 flex items-start gap-2">
                                            <svg class="w-4 h-4 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                            {{ $weakness }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if($match->aiRecommendation->recommendation)
                            <div>
                                <h4 class="text-sm font-medium text-blue-700 mb-2">Recommendations</h4>
                                <p class="text-sm text-gray-600">{{ $match->aiRecommendation->recommendation }}</p>
                            </div>
                        @endif

                        @if($match->aiRecommendation->interview_questions && count($match->aiRecommendation->interview_questions) > 0)
                            <div>
                                <h4 class="text-sm font-medium text-purple-700 mb-2">Sample Interview Questions</h4>
                                <ul class="space-y-1">
                                    @foreach($match->aiRecommendation->interview_questions as $question)
                                        <li class="text-sm text-gray-600 flex items-start gap-2">
                                            <span class="text-purple-500 font-bold">Q:</span>
                                            {{ $question }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if($match->aiRecommendation->confidence_score)
                            <div class="pt-4 border-t border-gray-100">
                                <span class="text-xs text-gray-500">Confidence Score: 
                                    <span class="font-medium text-gray-700">{{ ucfirst($match->aiRecommendation->confidence_score) }}</span>
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-900">Quick Actions</h3>
                </div>
                <div class="px-6 py-4 space-y-3">
                    @if($match->jobPost && $match->jobPost->id)
                        <a href="{{ route('candidate.job.details', $match->jobPost->id) }}" 
                           class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-[#1a237e] text-white text-sm font-medium rounded-lg hover:bg-[#0d1445] transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            View Job Posting
                        </a>
                    @endif

                    @if($match->application && $match->application->id)
                        <a href="{{ route('candidate.application.status', $match->application->job_post_id) }}" 
                           class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-50 text-blue-700 text-sm font-medium rounded-lg hover:bg-blue-100 transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Check Application Status
                        </a>
                    @endif

                    <a href="{{ route('candidate.resume.index') }}" 
                       class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gray-50 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-100 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Update Resume
                    </a>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection