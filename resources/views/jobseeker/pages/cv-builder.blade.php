{{-- resources/views/jobseeker/pages/cv-builder.blade.php --}}
@extends('jobseeker.layouts.app')

@section('title', 'CV Builder')
@section('page-title', 'Build Your Professional CV')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">CV Builder</h1>
                <p class="text-gray-600 mt-2">Select a template, preview your CV, and download it in seconds</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <!-- Left Sidebar - Template Selection -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sticky top-4">
                        <h3 class="font-semibold text-gray-900 mb-4">Choose Template</h3>
                        
                        <div class="space-y-3">
                            @foreach($templates as $template)
                            <label class="template-option block p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-[#1a237e] transition-all duration-200 {{ $loop->first ? 'border-[#1a237e] bg-[#1a237e]/5' : '' }}"
                                   data-template-id="{{ $template->id }}">
                                <div class="flex items-start gap-3">
                                    <input type="radio" name="template_id" value="{{ $template->id }}"
                                           class="mt-1 w-4 h-4 text-[#1a237e] focus:ring-[#1a237e]"
                                           {{ $loop->first ? 'checked' : '' }}>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <span class="font-medium text-gray-900 text-sm">{{ $template->name }}</span>
                                            @if($template->is_premium)
                                                <span class="text-xs bg-amber-100 text-amber-700 px-2 py-0.5 rounded">Premium</span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $template->description }}</p>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="text-xs text-gray-400">{{ ucfirst($template->category) }}</span>
                                            <span class="text-xs text-gray-300">•</span>
                                            <span class="text-xs text-gray-400">{{ ucfirst($template->style) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </label>
                            @endforeach
                        </div>

                        <!-- Actions -->
                        <div class="mt-6 pt-4 border-t border-gray-200 space-y-3">
                            <button onclick="generateCV()" 
                                    class="w-full px-4 py-2.5 bg-[#1a237e] text-white font-medium rounded-lg hover:bg-[#0d1445] transition-colors flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                Generate CV
                            </button>
                            
                            <div class="flex gap-2">
                                <button onclick="downloadCV('pdf')" 
                                        class="flex-1 px-3 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition-colors flex items-center justify-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                    PDF
                                </button>
                                <button onclick="saveCV()" 
                                        class="flex-1 px-3 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Save
                                </button>
                            </div>
                        </div>

                        <!-- Saved CVs -->
                        @if($savedCVs->count() > 0)
                        <div class="mt-6 pt-4 border-t border-gray-200">
                            <h4 class="text-sm font-medium text-gray-700 mb-3">Your Saved CVs</h4>
                            <div class="space-y-2">
                                @foreach($savedCVs as $saved)
                                <a href="{{ route('candidate.cv.show', $saved->id) }}" 
                                   class="block p-2 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors text-sm">
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-700 truncate">{{ $saved->title }}</span>
                                        <span class="text-xs text-gray-400">{{ $saved->created_at->diffForHumans() }}</span>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Right Side - CV Preview -->
                <div class="lg:col-span-3">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="p-4 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="text-sm font-medium text-gray-700">CV Preview</span>
                                <span class="text-xs text-gray-400" id="templateName">{{ $templates->first()->name ?? 'Select a template' }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <button onclick="toggleZoom()" class="px-3 py-1 bg-gray-200 rounded-lg text-xs font-medium hover:bg-gray-300 transition-colors">
                                    Toggle Zoom
                                </button>
                            </div>
                        </div>
                        <div id="cvPreviewContainer" class="p-8 overflow-auto max-h-[800px] preview-container">
                            <div id="cvPreview" class="cv-preview">
                                <div class="text-center py-16 text-gray-400">
                                    <svg class="w-20 h-20 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <h3 class="mt-4 text-lg font-medium">No CV Generated</h3>
                                    <p class="mt-1 text-sm">Select a template and click "Generate CV"</p>
                                </div>
                            </div>
                        </div>
                    </div>
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
    .template-option.selected {
        border-color: #1a237e;
        background: #f0f1f8;
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

    // Template selection
    document.querySelectorAll('.template-option').forEach(option => {
        option.addEventListener('click', function() {
            document.querySelectorAll('.template-option').forEach(opt => {
                opt.classList.remove('selected', 'border-[#1a237e]', 'bg-[#1a237e]/5');
            });
            this.classList.add('selected', 'border-[#1a237e]', 'bg-[#1a237e]/5');
            this.querySelector('input[type="radio"]').checked = true;
            
            // Update template name
            const name = this.querySelector('.font-medium')?.textContent || 'Template';
            document.getElementById('templateName').textContent = name;
        });
    });

    // Generate CV
    function generateCV() {
        const selected = document.querySelector('input[name="template_id"]:checked');
        if (!selected) {
            showToast('Please select a template first', 'warning');
            return;
        }

        showLoading(true);

        fetch('{{ route("candidate.cv.preview") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                template_id: selected.value
            })
        })
        .then(response => response.json())
        .then(data => {
            showLoading(false);
            if (data.success) {
                document.getElementById('cvPreview').innerHTML = data.html;
                showToast('CV generated successfully!', 'success');
            } else {
                showToast(data.message || 'Error generating CV', 'error');
            }
        })
        .catch(error => {
            showLoading(false);
            showToast('Error generating CV', 'error');
            console.error(error);
        });
    }

    // Download CV
    function downloadCV(format = 'pdf') {
        const selected = document.querySelector('input[name="template_id"]:checked');
        if (!selected) {
            showToast('Please select a template first', 'warning');
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
        templateInput.value = selected.value;
        form.appendChild(templateInput);
        
        const formatInput = document.createElement('input');
        formatInput.type = 'hidden';
        formatInput.name = 'format';
        formatInput.value = format;
        form.appendChild(formatInput);

        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
        
        showLoading(false);
    }

    // Save CV
    function saveCV() {
        const selected = document.querySelector('input[name="template_id"]:checked');
        if (!selected) {
            showToast('Please select a template first', 'warning');
            return;
        }

        const title = prompt('Enter a title for your CV:', 'My Professional CV');
        if (title === null) return;

        showLoading(true);

        fetch('{{ route("candidate.cv.save") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                template_id: selected.value,
                title: title
            })
        })
        .then(response => response.json())
        .then(data => {
            showLoading(false);
            if (data.success) {
                document.getElementById('cvPreview').innerHTML = data.html;
                showToast('CV saved successfully!', 'success');
                setTimeout(() => location.reload(), 1500);
            } else {
                showToast(data.message || 'Error saving CV', 'error');
            }
        })
        .catch(error => {
            showLoading(false);
            showToast('Error saving CV', 'error');
            console.error(error);
        });
    }

    // Loading indicator
    function showLoading(show) {
        const container = document.getElementById('cvPreview');
        if (show) {
            container.innerHTML = `
                <div class="text-center py-16">
                    <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-[#1a237e] border-t-transparent"></div>
                    <p class="mt-4 text-gray-500">Generating your CV...</p>
                </div>
            `;
        }
    }

    // Toast notification
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

    // Auto-generate on load if template selected
    document.addEventListener('DOMContentLoaded', function() {
        const defaultTemplate = document.querySelector('input[name="template_id"]:checked');
        if (defaultTemplate) {
            // Optionally auto-generate
            // generateCV();
        }
    });
</script>
@endsection