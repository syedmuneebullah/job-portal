<!-- resources/views/employer/pages/jobs/matches.blade.php -->
@extends('employer.layouts.app')

@section('title', 'Candidate Matches - {{ $job->title }}')
@section('page-title', 'Candidate Matches')

@section('content')
<div class="space-y-6">
    
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm p-4">
            <p class="text-sm text-gray-500">Total Candidates</p>
            <p class="text-2xl font-bold">{{ $summary['total_matches'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4">
            <p class="text-sm text-gray-500">Highly Recommended</p>
            <p class="text-2xl font-bold text-green-600">{{ $summary['highly_recommended'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4">
            <p class="text-sm text-gray-500">Shortlisted</p>
            <p class="text-2xl font-bold text-blue-600">{{ $summary['shortlisted'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4">
            <p class="text-sm text-gray-500">Avg Match Score</p>
            <p class="text-2xl font-bold text-purple-600">{{ round($summary['average_score']) }}%</p>
        </div>
    </div>

    <!-- Tier Distribution -->
    <div class="bg-white rounded-xl shadow-sm p-4">
        <h3 class="text-sm font-semibold mb-3">Candidate Tiers</h3>
        <div class="flex items-center gap-4">
            <div class="flex-1">
                <div class="flex items-center gap-2">
                    <span class="text-sm font-medium">A</span>
                    <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-green-500" style="width: {{ ($summary['top_tiers']['A'] / max($summary['total_matches'], 1)) * 100 }}%"></div>
                    </div>
                    <span class="text-sm text-gray-600">{{ $summary['top_tiers']['A'] }}</span>
                </div>
            </div>
            <!-- Repeat for B, C, D -->
        </div>
    </div>

    <!-- Matches Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Candidate</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Score</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Tier</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Skills Match</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Status</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($matches as $match)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-[#1a237e]/10 flex items-center justify-center">
                                {{ substr($match->application->applicant->first_name ?? 'U', 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-medium">{{ $match->application->applicant->full_name }}</p>
                                <p class="text-xs text-gray-500">{{ $match->application->applicant->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-4">
                        <span class="text-sm font-semibold {{ $match->overall_score >= 80 ? 'text-green-600' : ($match->overall_score >= 60 ? 'text-amber-600' : 'text-red-600') }}">
                            {{ round($match->overall_score) }}%
                        </span>
                    </td>
                    <td class="px-4 py-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                            {{ $match->tier === 'A' ? 'bg-green-100 text-green-700' : 
                               ($match->tier === 'B' ? 'bg-blue-100 text-blue-700' : 
                               ($match->tier === 'C' ? 'bg-amber-100 text-amber-700' : 'bg-gray-100 text-gray-700')) }}">
                            Tier {{ $match->tier }}
                        </span>
                    </td>
                    <td class="px-4 py-4">
                        <div class="flex items-center gap-2">
                            <div class="flex-1 max-w-[100px]">
                                <div class="h-1.5 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-blue-500" style="width: {{ $match->skills_match_score }}%"></div>
                                </div>
                            </div>
                            <span class="text-xs text-gray-500">{{ round($match->skills_match_score) }}%</span>
                        </div>
                    </td>
                    <td class="px-4 py-4">
                        @if($match->is_shortlisted)
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Shortlisted
                            </span>
                        @elseif($match->is_recommended)
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                Recommended
                            </span>
                        @else
                            <span class="text-xs text-gray-400">Pending</span>
                        @endif
                    </td>
                    <td class="px-4 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button onclick="showRecommendations({{ $match->id }})" 
                                    class="text-blue-600 hover:text-blue-800 text-sm">
                                AI Insights
                            </button>
                            @if(!$match->is_shortlisted)
                                <button onclick="shortlistCandidate({{ $match->id }})" 
                                        class="text-green-600 hover:text-green-800 text-sm">
                                    Shortlist
                                </button>
                            @endif
                            <a href="{{ route('employer.applications.show', $match->application_id) }}" 
                               class="text-[#1a237e] hover:text-[#0d1445] text-sm">
                                View
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
function showRecommendations(matchId) {
    fetch(`/employer/matches/${matchId}/recommendations`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const rec = data.data;
                Swal.fire({
                    title: 'AI Insights',
                    html: `
                        <div class="text-left">
                            <h4 class="font-semibold">Strengths</h4>
                            <ul class="list-disc ml-4 text-sm">
                                ${rec.strengths?.map(s => `<li>${s}</li>`).join('') || '<li>No strengths identified</li>'}
                            </ul>
                            <h4 class="font-semibold mt-3">Weaknesses</h4>
                            <ul class="list-disc ml-4 text-sm">
                                ${rec.weaknesses?.map(w => `<li>${w}</li>`).join('') || '<li>No weaknesses identified</li>'}
                            </ul>
                            <h4 class="font-semibold mt-3">Recommended Interview Questions</h4>
                            <ul class="list-disc ml-4 text-sm">
                                ${rec.interview_questions?.map(q => `<li>${q}</li>`).join('') || '<li>No questions available</li>'}
                            </ul>
                            <p class="mt-3 text-sm">${rec.ai_analysis || 'No additional analysis available.'}</p>
                        </div>
                    `,
                    confirmButtonText: 'Close'
                });
            }
        });
}

function shortlistCandidate(matchId) {
    if (!confirm('Shortlist this candidate?')) return;
    
    fetch(`/employer/matches/${matchId}/shortlist`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}
</script>
@endsection