@extends('employer.layouts.app')
@section('title', 'Screened Applications')

@section('content')
<div class="max-w-7xl mx-auto">

    <!-- Header -->
    <div class="bg-white rounded-lg border border-gray-200 p-6 mb-4">
        <div class="flex items-start justify-between flex-wrap gap-4">
            <div>
                <a href="{{ route('employer.jobs.show', $job->id) }}" class="text-sm text-[#1a237e] hover:underline mb-2 inline-block">
                    ← Back to job
                </a>
                <h1 class="text-xl font-bold text-gray-900">Screened candidates</h1>
                <p class="text-sm text-gray-500 mt-1">
                    Ranked automatically — top {{ $applications->total() }} candidates for <span class="font-semibold text-gray-700">{{ $job->title }}</span>
                </p>
            </div>
            <form method="POST" action="{{ route('employer.jobs.rescreen', $job->id) }}">
                @csrf
                <button class="px-5 py-2.5 bg-[#1a237e] hover:bg-[#131b63] text-white text-sm font-semibold rounded-full">
                    Re-screen all
                </button>
            </form>
        </div>
    </div>

    <!-- Band summary -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-3 mb-4">
        @php
            $bands = [
                'strong'  => ['label' => 'Strong',  'bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200'],
                'good'    => ['label' => 'Good',    'bg' => 'bg-blue-50',    'text' => 'text-blue-700',    'border' => 'border-blue-200'],
                'average' => ['label' => 'Average', 'bg' => 'bg-amber-50',   'text' => 'text-amber-700',   'border' => 'border-amber-200'],
                'weak'    => ['label' => 'Weak',    'bg' => 'bg-red-50',     'text' => 'text-red-700',     'border' => 'border-red-200'],
            ];
        @endphp
        @foreach($bands as $key => $meta)
            <a href="{{ route('employer.jobs.screened', ['id' => $job->id, 'band' => $key]) }}"
               class="rounded-lg border {{ $meta['border'] }} {{ $meta['bg'] }} p-4 hover:shadow-md transition-shadow {{ request('band') === $key ? 'ring-2 ring-offset-1 ring-[#1a237e]' : '' }}">
                <p class="text-2xl font-bold {{ $meta['text'] }}">{{ $bandCounts[$key] ?? 0 }}</p>
                <p class="text-xs font-semibold uppercase tracking-wide {{ $meta['text'] }}">{{ $meta['label'] }}</p>
            </a>
        @endforeach
        <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
            <p class="text-2xl font-bold text-gray-700">{{ $knockedCount }}</p>
            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Knocked out</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg border border-gray-200 p-4 mb-4">
        <form method="GET" class="flex flex-wrap items-center gap-3">
            @if(request('band'))<input type="hidden" name="band" value="{{ request('band') }}">@endif
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name or email..."
                   class="flex-1 min-w-[200px] px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#1a237e]/30 focus:border-[#1a237e]">
            <label class="inline-flex items-center gap-2 text-sm text-gray-600">
                <input type="checkbox" name="show_knocked" value="1" @checked(request('show_knocked')) class="rounded">
                Show knocked-out
            </label>
            <button class="px-5 py-2 bg-[#1a237e] text-white text-sm font-semibold rounded-full">Filter</button>
            <a href="{{ route('employer.jobs.screened', $job->id) }}" class="text-sm text-gray-500 hover:text-[#1a237e]">Reset</a>
        </form>
    </div>

    <!-- Applications list -->
    <div class="space-y-3">
        @forelse($applications as $app)
            @php
                $bandColors = [
                    'strong'  => ['bg-emerald-500', 'text-white'],
                    'good'    => ['bg-blue-500',    'text-white'],
                    'average' => ['bg-amber-500',   'text-white'],
                    'weak'    => ['bg-red-500',     'text-white'],
                ];
                $band = $bandColors[$app->screening_band ?? 'weak'];
                $breakdown = is_array($app->screening_breakdown) ? $app->screening_breakdown : json_decode($app->screening_breakdown ?? '{}', true);
            @endphp

            <div class="bg-white rounded-lg border border-gray-200 p-5 {{ $app->auto_knocked_out ? 'opacity-60' : '' }}">
                <div class="flex flex-col md:flex-row md:items-center gap-4">

                    <!-- Score badge -->
                    <div class="shrink-0 text-center">
                        <div class="w-16 h-16 rounded-full {{ $band[0] }} {{ $band[1] }} flex items-center justify-center mx-auto">
                            <span class="text-xl font-bold">{{ (int) $app->screening_score }}</span>
                        </div>
                        <p class="text-[10px] font-bold uppercase tracking-wide mt-1 text-gray-500">
                            {{ ucfirst($app->screening_band ?? 'N/A') }}
                        </p>
                    </div>

                    <!-- Candidate info -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <h3 class="text-base font-bold text-gray-900">
                                {{ $app->applicant->first_name ?? '' }} {{ $app->applicant->last_name ?? '' }}
                            </h3>
                            @if($app->auto_knocked_out)
                                <span class="text-xs font-semibold px-2 py-0.5 bg-red-100 text-red-700 rounded-full">
                                    Auto-Knocked: {{ $app->knockout_reason }}
                                </span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-500 mt-0.5">
                            {{ $app->applicant->email ?? 'N/A' }}
                            @if($app->applicant->applicantProfile?->current_job_title)
                                · {{ $app->applicant->applicantProfile->current_job_title }}
                            @endif
                        </p>

                        <!-- Breakdown bars -->
                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-2 mt-3">
                            @foreach(['skills' => 35, 'experience' => 25, 'education' => 15, 'location' => 10, 'salary' => 10, 'answers' => 5] as $key => $max)
                                @php
                                    $val = $breakdown[$key] ?? 0;
                                    $pct = $max > 0 ? round(($val / $max) * 100) : 0;
                                @endphp
                                <div>
                                    <div class="flex items-center justify-between text-[10px] font-semibold uppercase tracking-wide text-gray-500 mb-1">
                                        <span>{{ ucfirst($key) }}</span>
                                        <span>{{ $val }}/{{ $max }}</span>
                                    </div>
                                    <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full rounded-full transition-all
                                            {{ $pct >= 80 ? 'bg-emerald-500' : ($pct >= 50 ? 'bg-blue-500' : ($pct >= 25 ? 'bg-amber-500' : 'bg-red-500')) }}"
                                            style="width: {{ $pct }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex md:flex-col gap-2 shrink-0">
                        <a href="{{ route('employer.applications.show', $app->id) }}"
                           class="px-4 py-2 bg-[#1a237e] hover:bg-[#131b63] text-white text-xs font-semibold rounded-lg text-center whitespace-nowrap">
                            View
                        </a>
                        <button onclick="updateStatus({{ $app->id }}, 'shortlisted')"
                                class="px-4 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-xs font-semibold rounded-lg border border-emerald-200 whitespace-nowrap">
                            Shortlist
                        </button>
                        <button onclick="updateStatus({{ $app->id }}, 'rejected')"
                                class="px-4 py-2 bg-red-50 hover:bg-red-100 text-red-700 text-xs font-semibold rounded-lg border border-red-200 whitespace-nowrap">
                            Reject
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg border border-gray-200 p-12 text-center">
                <p class="text-gray-500">No applications match your filters.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $applications->links() }}
    </div>
</div>

<script>
function updateStatus(id, status) {
    if (!confirm(`Mark this application as ${status}?`)) return;

    fetch(`/employer/applications/${id}/status`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: JSON.stringify({ status }),
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Failed: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(() => alert('Network error'));
}
</script>
@endsection