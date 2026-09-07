@extends('jobseeker.layouts.app')

@section('title', 'My Resume')
@section('page-title', 'Resume Management')

@section('content')
<div class="space-y-6">

    <!-- ===== HEADER ===== -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">My Resumes</h2>
            <p class="text-sm text-gray-500 mt-1">Upload and manage your resumes for AI-powered matching</p>
        </div>
        <button onclick="openUploadModal()" 
                class="inline-flex items-center gap-2 px-4 py-2 bg-[#1a237e] text-white text-sm font-medium rounded-lg hover:bg-[#0d1445] transition-all duration-200 shadow-sm hover:shadow-md">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Upload New Resume
        </button>
    </div>

    <!-- ===== STATS CARDS ===== -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Resumes</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $resumes->total() }}</p>
                </div>
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Active Resumes</p>
                    <p class="text-2xl font-bold text-green-600">
                        {{ $resumes->where('status', 'completed')->count() }}
                    </p>
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
                    <p class="text-sm text-gray-500">Skills Extracted</p>
                    <p class="text-2xl font-bold text-purple-600">
                        {{ $resumes->sum(function($r) { return count($r->skills ?? []); }) }}
                    </p>
                </div>
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Job Matches</p>
                    <p class="text-2xl font-bold text-amber-600">
                        {{ App\Models\CandidateMatch::whereHas('application', function($q) {
                            $q->where('applicant_id', auth()->id());
                        })->count() }}
                    </p>
                </div>
                <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== RESUMES LIST ===== -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @if($resumes->count() > 0)
            <div class="divide-y divide-gray-100">
                @foreach($resumes as $resume)
                    <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex items-start gap-4 flex-1 min-w-0">
                                <!-- File Icon -->
                                <div class="w-10 h-10 rounded-lg 
                                    @if($resume->status === 'completed') bg-green-100 text-green-600
                                    @elseif($resume->status === 'failed') bg-red-100 text-red-600
                                    @else bg-amber-100 text-amber-600
                                    @endif
                                    flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-file-pdf text-xl"></i>
                                </div>
                                
                                <!-- File Info -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <h4 class="text-sm font-medium text-gray-900 truncate">{{ $resume->file_name }}</h4>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                            @if($resume->status === 'completed') bg-green-100 text-green-700
                                            @elseif($resume->status === 'failed') bg-red-100 text-red-700
                                            @else bg-amber-100 text-amber-700
                                            @endif">
                                            @if($resume->status === 'completed')
                                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1"></span>
                                            @elseif($resume->status === 'failed')
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1"></span>
                                            @else
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1 animate-pulse"></span>
                                            @endif
                                            {{ ucfirst($resume->status) }}
                                        </span>
                                    </div>
                                    
                                    <div class="flex flex-wrap items-center gap-3 mt-1 text-xs text-gray-500">
                                        <span>
                                            <i class="far fa-calendar-alt mr-1"></i>
                                            Uploaded {{ $resume->created_at->diffForHumans() }}
                                        </span>
                                        <span>•</span>
                                        <span>
                                            <i class="fas fa-code mr-1"></i>
                                            {{ count($resume->skills ?? []) }} skills
                                        </span>
                                        <span>•</span>
                                        <span>
                                            <i class="fas fa-briefcase mr-1"></i>
                                            {{ count($resume->experience ?? []) }} experiences
                                        </span>
                                        @if($resume->parsed_at)
                                            <span>•</span>
                                            <span>
                                                <i class="fas fa-check-circle text-green-500 mr-1"></i>
                                                Parsed {{ $resume->parsed_at->diffForHumans() }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center gap-2 flex-shrink-0">
                                @if($resume->status === 'completed')
                                    <a href="{{ route('candidate.resume.view', $resume->id) }}" 
                                       class="px-3 py-1.5 text-xs font-medium text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors">
                                        View Details
                                    </a>
                                    <a href="{{ route('candidate.matches.index') }}" 
                                       class="px-3 py-1.5 text-xs font-medium text-green-600 hover:text-green-800 hover:bg-green-50 rounded-lg transition-colors">
                                        View Matches
                                    </a>
                                @endif
                                
                                @if($resume->status === 'pending')
                                    <span class="px-3 py-1.5 text-xs font-medium text-amber-600 bg-amber-50 rounded-lg">
                                        <i class="fas fa-spinner fa-spin mr-1"></i>
                                        Processing...
                                    </span>
                                @endif

                                <button onclick="deleteResume({{ $resume->id }})" 
                                        class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Skills Preview -->
                        @if($resume->status === 'completed' && count($resume->skills ?? []) > 0)
                            <div class="mt-3 flex flex-wrap gap-1.5">
                                @foreach(array_slice($resume->skills, 0, 8) as $skill)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                        {{ $skill }}
                                    </span>
                                @endforeach
                                @if(count($resume->skills) > 8)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-50 text-gray-600">
                                        +{{ count($resume->skills) - 8 }} more
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- ===== PAGINATION ===== -->
            <div class="flex flex-wrap items-center justify-between gap-4 px-6 py-4 border-t border-gray-200 bg-gray-50/50">
                <div class="flex flex-wrap items-center gap-4">
                    <p class="text-sm text-gray-500">
                        Showing <span class="font-medium text-gray-700">{{ $resumes->firstItem() ?? 0 }}</span>
                        to <span class="font-medium text-gray-700">{{ $resumes->lastItem() ?? 0 }}</span>
                        of <span class="font-medium text-gray-700">{{ $resumes->total() }}</span> resumes
                    </p>
                </div>
                <div class="w-full sm:w-auto">
                    {{ $resumes->withQueryString()->links() }}
                </div>
            </div>
        @else
            <!-- ===== EMPTY STATE ===== -->
            <div class="px-6 py-12 text-center">
                <div class="flex flex-col items-center">
                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-lg font-medium text-gray-900">No resumes uploaded yet</p>
                    <p class="text-sm text-gray-500 mt-1">Upload your resume to get AI-powered job matching</p>
                    <button onclick="openUploadModal()" 
                            class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-[#1a237e] text-white text-sm font-medium rounded-lg hover:bg-[#0d1445] transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Upload Your First Resume
                    </button>
                </div>
            </div>
        @endif
    </div>

</div>

<!-- ===== UPLOAD RESUME MODAL ===== -->
<div id="uploadModal" class="fixed inset-0 z-[9999]" style="display:none;">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="closeUploadModal()"></div>
    
    <!-- Modal Container -->
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full max-h-[90vh] overflow-y-auto relative" style="z-index: 10000;">
            <!-- Close button -->
            <button type="button" 
                    onclick="closeUploadModal()"
                    class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 transition-colors p-1 z-10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Upload Resume</h3>
                
                <form id="uploadForm" action="{{ route('candidate.resume.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Select Resume File <span class="text-red-500">*</span>
                        </label>
                        <div id="dropZone" class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-[#1a237e] transition-colors cursor-pointer">
                            <input type="file" 
                                   name="resume" 
                                   id="resumeFile" 
                                   accept=".pdf,.doc,.docx,.txt"
                                   class="hidden"
                                   required>
                            <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <p class="text-sm text-gray-600" id="fileLabel">
                                <span class="font-medium text-[#1a237e]">Click to upload</span> or drag and drop
                            </p>
                            <p class="text-xs text-gray-400 mt-1">PDF, DOC, DOCX, TXT (Max 5MB)</p>
                            <p id="fileName" class="text-sm font-medium text-green-600 mt-2 hidden"></p>
                        </div>
                        @error('resume')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" 
                                onclick="closeUploadModal()"
                                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                            Cancel
                        </button>
                        <button type="submit" 
                                id="uploadSubmitBtn"
                                class="px-4 py-2 bg-[#1a237e] text-white rounded-lg hover:bg-[#0d1445] transition-colors font-medium">
                            Upload & Analyze
                        </button>
                    </div>
                </form>

                <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                    <p class="text-xs text-blue-700">
                        <i class="fas fa-info-circle mr-1"></i>
                        Your resume will be analyzed using AI to extract skills, experience, and education for smart job matching.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// ============================================================
// UPLOAD MODAL FUNCTIONS
// ============================================================

window.openUploadModal = function() {
    const modal = document.getElementById('uploadModal');
    if (modal) {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        console.log('Modal opened');
    } else {
        console.error('Modal not found');
    }
};

window.closeUploadModal = function() {
    const modal = document.getElementById('uploadModal');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
        // Reset form
        const form = document.getElementById('uploadForm');
        if (form) form.reset();
        const fileName = document.getElementById('fileName');
        if (fileName) fileName.classList.add('hidden');
        const fileLabel = document.getElementById('fileLabel');
        if (fileLabel) fileLabel.innerHTML = '<span class="font-medium text-[#1a237e]">Click to upload</span> or drag and drop';
        console.log('Modal closed');
    }
};

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeUploadModal();
    }
});

// Close modal when clicking outside (on backdrop)
document.addEventListener('click', function(e) {
    const modal = document.getElementById('uploadModal');
    if (modal && modal.style.display === 'flex') {
        if (e.target.classList.contains('bg-black/50') || e.target.classList.contains('backdrop-blur-sm')) {
            closeUploadModal();
        }
    }
});

// ============================================================
// FILE INPUT HANDLING
// ============================================================

document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('resumeFile');
    const dropZone = document.getElementById('dropZone');
    const fileLabel = document.getElementById('fileLabel');
    const fileName = document.getElementById('fileName');

    if (fileInput) {
        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                const size = (file.size / 1024 / 1024).toFixed(2);
                fileLabel.innerHTML = `<span class="font-medium text-green-600">${file.name}</span> (${size} MB)`;
                fileName.textContent = `Selected: ${file.name}`;
                fileName.classList.remove('hidden');
            }
        });
    }

    if (dropZone) {
        dropZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('border-[#1a237e]', 'bg-blue-50');
        });

        dropZone.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('border-[#1a237e]', 'bg-blue-50');
        });

        dropZone.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('border-[#1a237e]', 'bg-blue-50');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                fileInput.dispatchEvent(new Event('change'));
            }
        });

        dropZone.addEventListener('click', function() {
            fileInput.click();
        });
    }
});

// ============================================================
// DELETE RESUME
// ============================================================

window.deleteResume = function(id) {
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
                        location.reload();
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
};

// ============================================================
// POLLING FOR PARSE STATUS
// ============================================================

document.addEventListener('DOMContentLoaded', function() {
    const pendingResumes = document.querySelectorAll('.status-pending');
    
    if (pendingResumes.length > 0) {
        const interval = setInterval(() => {
            let hasPending = false;
            
            pendingResumes.forEach(element => {
                const resumeId = element.dataset.resumeId;
                if (resumeId) {
                    hasPending = true;
                    checkParseStatus(resumeId);
                }
            });
            
            if (!hasPending) {
                clearInterval(interval);
            }
        }, 5000);
    }
});

function checkParseStatus(id) {
    fetch(`/candidate/resume/${id}/parse-status`)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.status === 'completed') {
                location.reload();
            }
        })
        .catch(error => console.error('Error checking parse status:', error));
}

// ============================================================
// FORM SUBMISSION HANDLING
// ============================================================

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('uploadForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('uploadSubmitBtn');
            const originalText = submitBtn.innerHTML;
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <svg class="animate-spin h-4 w-4 mr-2 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Uploading...
            `;
            
            setTimeout(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }, 5000);
        });
    }
});

console.log('Resume page loaded successfully');
console.log('Upload modal element exists:', document.getElementById('uploadModal') !== null);
</script>
<style>
.badge-pulse {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}
</style>
@endsection