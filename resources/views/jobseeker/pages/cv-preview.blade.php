{{-- resources/views/jobseeker/pages/cv-preview.blade.php --}}
@extends('jobseeker.layouts.app')

@section('title', 'CV Preview - ' . ($cv->title ?? 'My CV'))
@section('page-title', 'CV Preview')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $cv->title ?? 'My CV' }}</h1>
                    <div class="flex items-center gap-3 mt-1">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $cv->status_badge ?? 'bg-gray-100 text-gray-700' }}">
                            {{ $cv->status_label ?? ucfirst($cv->status) }}
                        </span>
                        <span class="text-gray-300">|</span>
                        <span class="text-sm text-gray-500">Template: {{ $cv->template->name ?? 'N/A' }}</span>
                        <span class="text-gray-300">|</span>
                        <span class="text-sm text-gray-500">Created: {{ $cv->created_at->format('M d, Y') }}</span>
                        @if($cv->last_generated_at)
                            <span class="text-gray-300">|</span>
                            <span class="text-sm text-gray-500">Last Generated: {{ $cv->last_generated_at->format('M d, Y H:i A') }}</span>
                        @endif
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('candidate.cv.builder') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Builder
                    </a>
                    @if($cv->file_url)
                        <a href="{{ $cv->file_url }}" download 
                           class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Download PDF
                        </a>
                    @else
                        <button onclick="downloadCV()" 
                                class="inline-flex items-center gap-2 px-4 py-2 bg-[#1a237e] text-white text-sm font-medium rounded-lg hover:bg-[#0d1445] transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Generate PDF
                        </button>
                    @endif
                    <button onclick="confirmDelete({{ $cv->id }})" 
                            class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 text-red-700 text-sm font-medium rounded-lg hover:bg-red-100 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Delete
                    </button>
                </div>
            </div>

            <!-- CV Preview -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-4 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-medium text-gray-700">CV Preview</span>
                        <span class="text-xs text-gray-400">{{ $cv->template->name ?? 'Template' }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <button onclick="toggleZoom()" class="px-3 py-1 bg-gray-200 rounded-lg text-xs font-medium hover:bg-gray-300 transition-colors">
                            Toggle Zoom
                        </button>
                        <button onclick="window.print()" class="px-3 py-1 bg-gray-200 rounded-lg text-xs font-medium hover:bg-gray-300 transition-colors">
                            Print
                        </button>
                    </div>
                </div>
                <div id="cvPreviewContainer" class="p-8 overflow-auto max-h-[800px] preview-container">
                    <div id="cvPreview" class="cv-preview">
                        {!! $html !!}
                    </div>
                </div>
            </div>

            <!-- CV Details -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                    <h4 class="text-sm font-medium text-gray-500 mb-2">Template</h4>
                    <p class="text-sm font-semibold text-gray-900">{{ $cv->template->name ?? 'N/A' }}</p>
                    <p class="text-xs text-gray-500">{{ $cv->template->category ?? '' }} • {{ $cv->template->style ?? '' }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                    <h4 class="text-sm font-medium text-gray-500 mb-2">Status</h4>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $cv->status_badge ?? 'bg-gray-100 text-gray-700' }}">
                        {{ $cv->status_label ?? ucfirst($cv->status) }}
                    </span>
                    <p class="text-xs text-gray-500 mt-1">Version {{ $cv->version ?? 1 }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                    <h4 class="text-sm font-medium text-gray-500 mb-2">File</h4>
                    @if($cv->file_url)
                        <p class="text-sm font-semibold text-gray-900">
                            <a href="{{ $cv->file_url }}" download class="text-[#1a237e] hover:underline">
                                {{ $cv->original_name ?? 'Download CV' }}
                            </a>
                        </p>
                        <p class="text-xs text-gray-500">{{ $cv->formatted_size ?? '' }}</p>
                    @else
                        <p class="text-sm text-gray-500">No PDF generated yet</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .preview-container {
        transition: all 0.3s ease;
        background: #f9fafb;
    }
    .preview-container.zoomed {
        transform: scale(1.1);
        height: 900px;
    }
    .preview-container.zoomed .cv-preview {
        transform: scale(0.9);
        transform-origin: top center;
    }
    .cv-preview {
        background: #ffffff;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        max-width: 1100px;
        margin: 0 auto;
        padding: 20px;
    }
    @media print {
        .preview-container {
            max-height: none !important;
            overflow: visible !important;
            transform: none !important;
        }
        .preview-container.zoomed {
            transform: none !important;
        }
        .cv-preview {
            border: none !important;
            box-shadow: none !important;
        }
        .no-print {
            display: none !important;
        }
    }
</style>

<script>
    let isZoomed = false;

    function toggleZoom() {
        const container = document.getElementById('cvPreviewContainer');
        isZoomed = !isZoomed;
        if (isZoomed) {
            container.classList.add('zoomed');
        } else {
            container.classList.remove('zoomed');
        }
    }

    function downloadCV() {
        const templateId = {{ $cv->cv_template_id ?? 0 }};
        const cvId = {{ $cv->id ?? 0 }};
        
        if (!templateId) {
            showToast('Template not found', 'error');
            return;
        }

        showLoading(true);

        // Create form for download
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("candidate.cv.download") }}';
        
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        form.appendChild(csrfInput);
        
        const templateInput = document.createElement('input');
        templateInput.type = 'hidden';
        templateInput.name = 'template_id';
        templateInput.value = templateId;
        form.appendChild(templateInput);

        const cvInput = document.createElement('input');
        cvInput.type = 'hidden';
        cvInput.name = 'cv_id';
        cvInput.value = cvId;
        form.appendChild(cvInput);
        
        const formatInput = document.createElement('input');
        formatInput.type = 'hidden';
        formatInput.name = 'format';
        formatInput.value = 'pdf';
        form.appendChild(formatInput);

        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
        
        showLoading(false);
    }

    function confirmDelete(id) {
    if (confirm('Are you sure you want to delete this CV? This action cannot be undone.')) {
        // Build the URL dynamically
        const deleteUrl = '/candidate/cv/delete/' + id;
        
        fetch(deleteUrl, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('CV deleted successfully!', 'success');
                setTimeout(() => {
                    window.location.href = '{{ route("candidate.cv.builder") }}';
                }, 1500);
            } else {
                showToast(data.message || 'Error deleting CV', 'error');
            }
        })
        .catch(error => {
            showToast('Error deleting CV', 'error');
            console.error(error);
        });
    }
}

    function showLoading(show) {
        // Optional: Show loading indicator
    }

    function showToast(message, type = 'success') {
        const colors = {
            success: 'bg-emerald-500',
            error: 'bg-red-500',
            warning: 'bg-amber-500',
            info: 'bg-blue-500'
        };

        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 z-[9999] px-6 py-3 rounded-lg text-white text-sm font-medium ${colors[type] || colors.success} shadow-lg transform transition-all duration-300 translate-x-full`;
        toast.textContent = message;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.classList.remove('translate-x-full');
        }, 10);

        setTimeout(() => {
            toast.classList.add('translate-x-full');
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 3000);
    }

    // Add print styles
    document.addEventListener('DOMContentLoaded', function() {
        const style = document.createElement('style');
        style.textContent = `
            @media print {
                .preview-container {
                    max-height: none !important;
                    overflow: visible !important;
                }
                .preview-container.zoomed {
                    transform: none !important;
                }
                .cv-preview {
                    border: none !important;
                    box-shadow: none !important;
                }
                .no-print {
                    display: none !important;
                }
            }
        `;
        document.head.appendChild(style);
    });
</script>
@endsection