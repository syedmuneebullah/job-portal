@extends('jobseeker.layouts.app')

@section('title', 'Resume Details')
@section('page-title', 'Resume Details')

@section('content')
<div class="space-y-6">

    <!-- ===== BACK BUTTON ===== -->
    <div class="flex items-center justify-between">
        <a href="{{ route('candidate.resume.index') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 bg-[#1a237e] text-white text-sm font-medium rounded-lg hover:bg-[#0d1445] transition-all duration-200 shadow-sm hover:shadow-md">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Resumes
        </a>
        
        @if($resume->status === 'completed')
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5"></span>
                Parsed Successfully
            </span>
        @endif
    </div>

    <!-- ===== RESUME DETAILS ===== -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-[#1a237e]/5 to-transparent">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-file-pdf text-2xl"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <h2 class="text-xl font-bold text-gray-900">{{ $resume->file_name }}</h2>
                    <div class="flex flex-wrap items-center gap-3 mt-1">
                        <span class="text-sm text-gray-500">
                            <i class="far fa-calendar-alt mr-1"></i>
                            Uploaded {{ $resume->created_at->format('F d, Y h:i A') }}
                        </span>
                        <span class="text-gray-300">|</span>
                        <span class="text-sm text-gray-500">
                            <i class="far fa-clock mr-1"></i>
                            {{ $resume->created_at->diffForHumans() }}
                        </span>
                        @if($resume->parsed_at)
                            <span class="text-gray-300">|</span>
                            <span class="text-sm text-gray-500">
                                <i class="fas fa-check-circle text-green-500 mr-1"></i>
                                Parsed {{ $resume->parsed_at->diffForHumans() }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Body -->
        <div class="px-6 py-6 space-y-6">
            
            <!-- Summary -->
            @if($resume->summary)
                <div>
                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Professional Summary</h4>
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $resume->summary }}</p>
                </div>
            @endif

            <!-- Skills -->
            @if($resume->skills && count($resume->skills) > 0)
                <div>
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Skills</h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach($resume->skills as $skill)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                {{ $skill }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Experience -->
            @if($resume->experience && count($resume->experience) > 0)
                <div>
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Experience</h4>
                    <div class="space-y-4">
                        @foreach($resume->experience as $exp)
                            <div class="border-l-4 border-blue-500 pl-4">
                                <p class="text-sm font-medium text-gray-900">{{ $exp['title'] ?? 'Position' }}</p>
                                <p class="text-sm text-gray-600">{{ $exp['company'] ?? 'Company' }}</p>
                                @if(isset($exp['years']))
                                    <p class="text-xs text-gray-400">{{ $exp['years'] }} years</p>
                                @endif
                                @if(isset($exp['description']))
                                    <p class="text-sm text-gray-500 mt-1">{{ $exp['description'] }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Education -->
            @if($resume->education && count($resume->education) > 0)
                <div>
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Education</h4>
                    <div class="space-y-3">
                        @foreach($resume->education as $edu)
                            <div class="flex items-start gap-3">
                                <div class="w-2 h-2 rounded-full bg-green-500 mt-2"></div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $edu['degree'] ?? 'Degree' }}</p>
                                    <p class="text-sm text-gray-600">{{ $edu['field'] ?? '' }}</p>
                                    <p class="text-xs text-gray-400">{{ $edu['institution'] ?? '' }} @if(isset($edu['year'])) ({{ $edu['year'] }}) @endif</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Certifications -->
            @if($resume->certifications && count($resume->certifications) > 0)
                <div>
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Certifications</h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach($resume->certifications as $cert)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-50 text-purple-700">
                                <i class="fas fa-certificate mr-1"></i>
                                {{ $cert }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Languages -->
            @if($resume->languages && count($resume->languages) > 0)
                <div>
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Languages</h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach($resume->languages as $lang)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700">
                                {{ $lang }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

        <!-- Footer -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <a href="{{ route('candidate.matches.index') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    View Job Matches
                </a>
                <button onclick="deleteResume({{ $resume->id }})" 
                        class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 text-red-600 text-sm font-medium rounded-lg hover:bg-red-100 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Delete Resume
                </button>
            </div>
            
            <div class="flex items-center gap-3 text-xs text-gray-400">
                <span>Resume ID: #{{ $resume->id }}</span>
                <span>•</span>
                <span>Status: {{ ucfirst($resume->status) }}</span>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function deleteResume(id) {
    Swal.fire({
        title: 'Delete Resume?',
        text: 'This action cannot be undone. All associated data will be removed.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/candidate/resume/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'Resume deleted successfully.',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = '{{ route("candidate.resume.index") }}';
                    });
                } else {
                    Swal.fire('Error', data.message || 'Failed to delete resume.', 'error');
                }
            })
            .catch(error => {
                Swal.fire('Error', 'Failed to delete resume. Please try again.', 'error');
            });
        }
    });
}
</script>
@endsection