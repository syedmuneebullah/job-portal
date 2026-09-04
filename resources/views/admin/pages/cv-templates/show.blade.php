{{-- resources/views/admin/pages/cv-templates/show.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Template Details - ' . $cvTemplate->name)
@section('page-title', 'Template Details')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">{{ $cvTemplate->name }}</h2>
            <div class="flex flex-wrap items-center gap-3 mt-1">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                    @if($cvTemplate->is_active) bg-emerald-100 text-emerald-800
                    @else bg-red-100 text-red-800 @endif">
                    <span class="w-1.5 h-1.5 rounded-full mr-1.5
                        @if($cvTemplate->is_active) bg-emerald-500
                        @else bg-red-500 @endif"></span>
                    {{ $cvTemplate->is_active ? 'Active' : 'Inactive' }}
                </span>
                @if($cvTemplate->is_default)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Default
                    </span>
                @endif
                @if($cvTemplate->is_premium)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        Premium
                    </span>
                @endif
                <span class="text-gray-300">|</span>
                <span class="text-sm text-gray-500">Layout: {{ ucfirst(str_replace('_', ' ', $cvTemplate->layout_type)) }}</span>
                <span class="text-gray-300">|</span>
                <span class="text-sm text-gray-500">Slug: {{ $cvTemplate->slug }}</span>
                <span class="text-gray-300">|</span>
                <span class="text-sm text-gray-500">Created: {{ $cvTemplate->created_at->format('M d, Y') }}</span>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.cv-templates.preview', $cvTemplate) }}" target="_blank"
               class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                Preview
            </a>
            <a href="{{ route('admin.cv-templates.edit', $cvTemplate) }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-[#1a237e] text-white text-sm font-medium rounded-lg hover:bg-[#0d1445] transition-all duration-200 shadow-sm hover:shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Template
            </a>
            <a href="{{ route('admin.cv-templates.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Template Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Thumbnail & Description -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <div class="flex flex-col md:flex-row gap-6">
                    <div class="md:w-48 flex-shrink-0">
                        @if($cvTemplate->thumbnail)
                            <img src="{{ $cvTemplate->thumbnail_url }}" alt="{{ $cvTemplate->name }}" 
                                 class="w-full h-auto rounded-lg border border-gray-200 shadow-sm">
                        @else
                            <div class="w-full h-48 bg-gray-100 rounded-lg flex items-center justify-center border border-gray-200">
                                <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Description</h3>
                        <p class="text-gray-700">{{ $cvTemplate->description ?? 'No description provided.' }}</p>
                        <div class="mt-4 flex flex-wrap items-center gap-4 text-sm">
                            <span class="flex items-center gap-1 text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                </svg>
                                {{ $cvTemplate->templateSections->count() }} Sections
                            </span>
                            <span class="flex items-center gap-1 text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                                Used {{ $cvTemplate->usage_count }} times
                            </span>
                            <span class="flex items-center gap-1 text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                Downloaded {{ $cvTemplate->download_count }} times
                            </span>
                            <span class="flex items-center gap-1 text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                </svg>
                                Layout: {{ ucfirst(str_replace('_', ' ', $cvTemplate->layout_type)) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Color Scheme -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Color Scheme</h3>
                @php
                    $colors = $cvTemplate->default_colors;
                @endphp
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    <div class="p-4 bg-gray-50 rounded-lg text-center">
                        <div class="w-full h-16 rounded-lg mb-2 border border-gray-200" style="background: {{ $colors['primary'] ?? '#1a237e' }}"></div>
                        <span class="text-xs font-medium text-gray-700">Primary</span>
                        <p class="text-xs text-gray-500 font-mono">{{ $colors['primary'] ?? '#1a237e' }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg text-center">
                        <div class="w-full h-16 rounded-lg mb-2 border border-gray-200" style="background: {{ $colors['secondary'] ?? '#0d1445' }}"></div>
                        <span class="text-xs font-medium text-gray-700">Secondary</span>
                        <p class="text-xs text-gray-500 font-mono">{{ $colors['secondary'] ?? '#0d1445' }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg text-center">
                        <div class="w-full h-16 rounded-lg mb-2 border border-gray-200" style="background: {{ $colors['accent'] ?? '#e8eaf6' }}"></div>
                        <span class="text-xs font-medium text-gray-700">Accent</span>
                        <p class="text-xs text-gray-500 font-mono">{{ $colors['accent'] ?? '#e8eaf6' }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg text-center">
                        <div class="w-full h-16 rounded-lg mb-2 border border-gray-200" style="background: {{ $colors['text'] ?? '#1a1a1a' }}"></div>
                        <span class="text-xs font-medium text-gray-700">Text</span>
                        <p class="text-xs text-gray-500 font-mono">{{ $colors['text'] ?? '#1a1a1a' }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg text-center">
                        <div class="w-full h-16 rounded-lg mb-2 border border-gray-200" style="background: {{ $colors['background'] ?? '#ffffff' }}"></div>
                        <span class="text-xs font-medium text-gray-700">Background</span>
                        <p class="text-xs text-gray-500 font-mono">{{ $colors['background'] ?? '#ffffff' }}</p>
                    </div>
                </div>
            </div>

            <!-- Font Settings -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Font Settings</h3>
                @php
                    $fonts = $cvTemplate->default_fonts;
                @endphp
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Heading Font</span>
                        <p class="text-sm font-semibold text-gray-900 mt-1" style="font-family: {{ $fonts['heading'] ?? 'sans-serif' }}">
                            {{ $fonts['heading'] ?? 'Default' }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1 font-mono">{{ $fonts['heading'] ?? 'Default' }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Body Font</span>
                        <p class="text-sm font-semibold text-gray-900 mt-1" style="font-family: {{ $fonts['body'] ?? 'sans-serif' }}">
                            {{ $fonts['body'] ?? 'Default' }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1 font-mono">{{ $fonts['body'] ?? 'Default' }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Font Size</span>
                        <p class="text-sm font-semibold text-gray-900 mt-1">{{ $fonts['size'] ?? '14px' }}</p>
                        <p class="text-xs text-gray-500 mt-1">Base font size for content</p>
                    </div>
                </div>
            </div>

            <!-- Sections -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Template Sections</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach($cvTemplate->templateSections as $section)
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="flex-shrink-0 w-8 h-8 bg-[#1a237e]/10 rounded-lg flex items-center justify-center">
                                <span class="text-sm font-semibold text-[#1a237e]">{{ $section->order }}</span>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $section->section_name }}</p>
                                <p class="text-xs text-gray-500">{{ $section->section_key }}</p>
                            </div>
                            @if($section->is_required)
                                <span class="ml-auto text-xs text-blue-600 bg-blue-50 px-2 py-0.5 rounded">Required</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right Column - Stats & Actions -->
        <div class="space-y-6">
            <!-- Quick Stats -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Quick Stats</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Total Sections</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $cvTemplate->templateSections->count() }}</p>
                            </div>
                        </div>
                        <span class="text-xs text-gray-500">Active: {{ $cvTemplate->templateSections->where('is_enabled', true)->count() }}</span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Usage Count</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $cvTemplate->usage_count }}</p>
                            </div>
                        </div>
                        <span class="text-xs text-gray-500">Total uses</span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Downloads</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $cvTemplate->download_count }}</p>
                            </div>
                        </div>
                        <span class="text-xs text-gray-500">Total downloads</span>
                    </div>
                </div>
            </div>

            <!-- Template Info -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Template Information</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">ID</span>
                        <span class="text-gray-900 font-mono">#{{ $cvTemplate->id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Slug</span>
                        <span class="text-gray-900 font-mono">{{ $cvTemplate->slug }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Category</span>
                        <span class="text-gray-900 capitalize">{{ $cvTemplate->category }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Style</span>
                        <span class="text-gray-900 capitalize">{{ $cvTemplate->style }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Layout Type</span>
                        <span class="text-gray-900 capitalize">{{ ucfirst(str_replace('_', ' ', $cvTemplate->layout_type)) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Created</span>
                        <span class="text-gray-900">{{ $cvTemplate->created_at->format('M d, Y H:i A') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Last Updated</span>
                        <span class="text-gray-900">{{ $cvTemplate->updated_at->format('M d, Y H:i A') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full">
        <div class="p-6">
            <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <h3 class="mt-4 text-lg font-semibold text-center text-gray-900">Delete Template</h3>
            <p class="mt-2 text-sm text-center text-gray-500" id="deleteMessage">Are you sure you want to delete this template? This action cannot be undone.</p>
            <form id="deleteForm" action="{{ route('admin.cv-templates.destroy', $cvTemplate) }}" method="POST" class="mt-6 flex items-center justify-center gap-3">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id, name) {
        const modal = document.getElementById('deleteModal');
        const message = document.getElementById('deleteMessage');
        message.textContent = `Are you sure you want to delete "${name}"? This action cannot be undone.`;
        modal.classList.remove('hidden');
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }

    // Close modal on backdrop click
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });

    // Close on Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
        }
    });
</script>
@endsection