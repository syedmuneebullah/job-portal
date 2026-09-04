{{-- resources/views/admin/cv-templates/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'CV Templates')
@section('page-title', 'CV Templates Management')

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">All Templates</h2>
            <p class="text-sm text-gray-500 mt-1">Manage your CV templates and their configurations</p>
        </div>
        <a href="{{ route('admin.cv-templates.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-[#1a237e] text-white text-sm font-medium rounded-lg hover:bg-[#0d1445] transition-all duration-200 shadow-sm hover:shadow-md">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Create New Template
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg border border-gray-200 p-4">
        <div class="flex flex-wrap items-center gap-4">
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-600">Filter:</span>
                <select id="filterCategory" class="px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#1a237e] focus:border-transparent">
                    <option value="">All Categories</option>
                    <option value="professional">Professional</option>
                    <option value="modern">Modern</option>
                    <option value="creative">Creative</option>
                    <option value="minimalist">Minimalist</option>
                    <option value="executive">Executive</option>
                </select>
                <select id="filterStatus" class="px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#1a237e] focus:border-transparent">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
                <select id="filterPremium" class="px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#1a237e] focus:border-transparent">
                    <option value="">All Types</option>
                    <option value="free">Free</option>
                    <option value="premium">Premium</option>
                </select>
            </div>
            <div class="flex-1"></div>
            <div class="relative">
                <input type="text" id="searchTemplates" placeholder="Search templates..."
                       class="w-64 px-4 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#1a237e] focus:border-transparent pl-9">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Templates Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse($templates as $template)
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300">
            <!-- Template Thumbnail -->
            <div class="relative h-48 bg-gray-100">
                @if($template->thumbnail)
                    <img src="{{ $template->thumbnail_url }}" alt="{{ $template->name }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100">
                        <div class="text-center">
                            <svg class="w-16 h-16 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-xs text-gray-400 mt-2">No thumbnail</p>
                        </div>
                    </div>
                @endif
                
                <!-- Badges -->
                <div class="absolute top-3 right-3 flex flex-col gap-1.5">
                    @if($template->is_default)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                            Default
                        </span>
                    @endif
                    @if($template->is_premium)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                            Premium
                        </span>
                    @endif
                    @if(!$template->is_active)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            Inactive
                        </span>
                    @endif
                </div>
            </div>

            <!-- Template Info -->
            <div class="p-5">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <h3 class="text-base font-semibold text-gray-900">{{ $template->name }}</h3>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                {{ ucfirst($template->category) }}
                            </span>
                            <span class="text-xs text-gray-500">{{ ucfirst($template->style) }}</span>
                        </div>
                        <p class="text-sm text-gray-600 mt-2 line-clamp-2">{{ $template->description }}</p>
                    </div>
                </div>

                <!-- Stats -->
                <div class="mt-4 flex items-center gap-4 text-xs text-gray-500 border-t border-gray-100 pt-4">
                    <span class="flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                        {{ $template->sections_count }} Sections
                    </span>
                    <span class="flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        {{ $template->usage_count }} Uses
                    </span>
                </div>

                <!-- Actions -->
                <div class="mt-4 pt-4 border-t border-gray-100 flex items-center gap-2">
                    <a href="{{ route('admin.cv-templates.edit', $template) }}"
                       class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-1.5 bg-[#1a237e] text-white text-sm font-medium rounded-lg hover:bg-[#0d1445] transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit
                    </a>
                    
                    <button onclick="confirmDelete({{ $template->id }}, '{{ $template->name }}')"
                            class="px-3 py-1.5 bg-red-50 text-red-700 text-sm font-medium rounded-lg hover:bg-red-100 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                    
                    <a href="{{route('admin.cv-templates.show', $template->id)}}"
                       class="px-3 py-1.5 bg-gray-50 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-100 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full">
            <div class="bg-white rounded-lg border border-gray-200 p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No templates found</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by creating your first CV template.</p>
                <div class="mt-6">
                    <a href="{{ route('admin.cv-templates.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-[#1a237e] text-white text-sm font-medium rounded-lg hover:bg-[#0d1445] transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Create Template
                    </a>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $templates->links() }}
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
            <form id="deleteForm" method="POST" class="mt-6 flex items-center justify-center gap-3">
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
    // Filter functionality
    document.addEventListener('DOMContentLoaded', function() {
        const filterCategory = document.getElementById('filterCategory');
        const filterStatus = document.getElementById('filterStatus');
        const filterPremium = document.getElementById('filterPremium');
        const searchInput = document.getElementById('searchTemplates');
        
        function filterTemplates() {
            const category = filterCategory.value;
            const status = filterStatus.value;
            const premium = filterPremium.value;
            const search = searchInput.value.toLowerCase();
            
            const templates = document.querySelectorAll('.grid > div');
            
            templates.forEach(template => {
                let show = true;
                
                // Category filter
                if (category) {
                    const templateCategory = template.querySelector('.bg-blue-50')?.textContent?.toLowerCase();
                    if (templateCategory && !templateCategory.includes(category)) {
                        show = false;
                    }
                }
                
                // Status filter
                if (status && show) {
                    const inactiveBadge = template.querySelector('.bg-red-100');
                    if (status === 'active' && inactiveBadge) show = false;
                    if (status === 'inactive' && !inactiveBadge) show = false;
                }
                
                // Premium filter
                if (premium && show) {
                    const premiumBadge = template.querySelector('.bg-amber-100');
                    if (premium === 'free' && premiumBadge) show = false;
                    if (premium === 'premium' && !premiumBadge) show = false;
                }
                
                // Search filter
                if (search && show) {
                    const name = template.querySelector('h3')?.textContent?.toLowerCase() || '';
                    const desc = template.querySelector('p')?.textContent?.toLowerCase() || '';
                    if (!name.includes(search) && !desc.includes(search)) {
                        show = false;
                    }
                }
                
                template.style.display = show ? '' : 'none';
            });
        }
        
        filterCategory.addEventListener('change', filterTemplates);
        filterStatus.addEventListener('change', filterTemplates);
        filterPremium.addEventListener('change', filterTemplates);
        searchInput.addEventListener('input', filterTemplates);
    });

    // Delete functions
    function confirmDelete(id, name) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');
        const message = document.getElementById('deleteMessage');
        
        form.action = '/admin/cv-templates/' + id;
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