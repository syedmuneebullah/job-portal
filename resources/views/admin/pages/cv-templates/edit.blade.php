{{-- resources/views/admin/pages/cv-templates/edit.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Edit CV Template')
@section('page-title', 'Edit CV Template')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">Editing: {{ $cvTemplate->name }}</h2>
            <div class="flex items-center gap-3 mt-1">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                    @if($cvTemplate->is_active) bg-emerald-100 text-emerald-800
                    @else bg-red-100 text-red-800 @endif">
                    {{ $cvTemplate->is_active ? 'Active' : 'Inactive' }}
                </span>
                @if($cvTemplate->is_default)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        Default Template
                    </span>
                @endif
                @if($cvTemplate->is_premium)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                        Premium
                    </span>
                @endif
                <span class="text-gray-300">|</span>
                <span class="text-sm text-gray-500">Layout: {{ ucfirst(str_replace('_', ' ', $cvTemplate->layout_type)) }}</span>
                <span class="text-gray-300">|</span>
                <span class="text-sm text-gray-500">Usage: {{ $cvTemplate->usage_count }} times</span>
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
            <a href="{{ route('admin.cv-templates.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-[#1a237e] text-white text-sm font-medium rounded-lg hover:bg-[#0d1445] transition-all duration-200 shadow-sm hover:shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Templates
            </a>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <form action="{{ route('admin.cv-templates.update', $cvTemplate) }}" method="POST" enctype="multipart/form-data" id="templateForm">
            @csrf
            @method('PUT')

            <div class="space-y-8">
                <!-- Basic Information -->
                <div>
                    <h3 class="text-base font-semibold text-gray-900 mb-4">Basic Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Template Name *</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $cvTemplate->name) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e] focus:border-transparent outline-none transition duration-200"
                                   placeholder="e.g., Professional Classic" required>
                            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
                            <select id="category" name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e] focus:border-transparent outline-none transition duration-200" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}" {{ old('category', $cvTemplate->category) == $category ? 'selected' : '' }}>
                                        {{ ucfirst($category) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="style" class="block text-sm font-medium text-gray-700 mb-1">Style *</label>
                            <select id="style" name="style" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e] focus:border-transparent outline-none transition duration-200" required>
                                <option value="">Select Style</option>
                                @foreach($styles as $style)
                                    <option value="{{ $style }}" {{ old('style', $cvTemplate->style) == $style ? 'selected' : '' }}>
                                        {{ ucfirst($style) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('style') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="layout_type" class="block text-sm font-medium text-gray-700 mb-1">Layout Type *</label>
                            <select id="layout_type" name="layout_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e] focus:border-transparent outline-none transition duration-200" required>
                                <option value="">Select Layout</option>
                                @foreach($layoutTypes as $key => $name)
                                    <option value="{{ $key }}" {{ old('layout_type', $cvTemplate->layout_type) == $key ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="mt-1 text-xs text-gray-500">Changing layout will reset layout configuration</p>
                            @error('layout_type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-1">Thumbnail</label>
                            @if($cvTemplate->thumbnail)
                                <div class="mb-3">
                                    <img src="{{ $cvTemplate->thumbnail_url }}" alt="Current Thumbnail" class="w-32 h-24 object-cover rounded-lg border border-gray-200">
                                    <p class="text-xs text-gray-500 mt-1">Current thumbnail</p>
                                </div>
                            @endif
                            <input type="file" id="thumbnail" name="thumbnail" accept="image/*"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e] focus:border-transparent outline-none transition duration-200 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-[#1a237e]/10 file:text-[#1a237e] hover:file:bg-[#1a237e]/20">
                            <p class="mt-1 text-xs text-gray-500">Recommended size: 600x400px, Max 2MB. Leave empty to keep current.</p>
                            @error('thumbnail') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea id="description" name="description" rows="3"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e] focus:border-transparent outline-none transition duration-200"
                                  placeholder="Describe your template...">{{ old('description', $cvTemplate->description) }}</textarea>
                        @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Color Scheme -->
                <div>
                    <h3 class="text-base font-semibold text-gray-900 mb-4">Color Scheme</h3>
                    @php
                        $colors = $cvTemplate->default_colors;
                    @endphp
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="primary_color" class="block text-sm font-medium text-gray-700 mb-1">Primary Color *</label>
                            <div class="flex items-center gap-3">
                                <input type="color" id="primary_color" name="primary_color" 
                                       value="{{ old('primary_color', $colors['primary'] ?? '#1a237e') }}"
                                       class="w-12 h-12 rounded-lg border border-gray-300 cursor-pointer p-1">
                                <input type="text" id="primary_color_hex" 
                                       value="{{ old('primary_color', $colors['primary'] ?? '#1a237e') }}"
                                       class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e] focus:border-transparent outline-none transition duration-200 font-mono text-sm">
                            </div>
                            @error('primary_color') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="secondary_color" class="block text-sm font-medium text-gray-700 mb-1">Secondary Color *</label>
                            <div class="flex items-center gap-3">
                                <input type="color" id="secondary_color" name="secondary_color" 
                                       value="{{ old('secondary_color', $colors['secondary'] ?? '#0d1445') }}"
                                       class="w-12 h-12 rounded-lg border border-gray-300 cursor-pointer p-1">
                                <input type="text" id="secondary_color_hex" 
                                       value="{{ old('secondary_color', $colors['secondary'] ?? '#0d1445') }}"
                                       class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e] focus:border-transparent outline-none transition duration-200 font-mono text-sm">
                            </div>
                            @error('secondary_color') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="accent_color" class="block text-sm font-medium text-gray-700 mb-1">Accent Color *</label>
                            <div class="flex items-center gap-3">
                                <input type="color" id="accent_color" name="accent_color" 
                                       value="{{ old('accent_color', $colors['accent'] ?? '#e8eaf6') }}"
                                       class="w-12 h-12 rounded-lg border border-gray-300 cursor-pointer p-1">
                                <input type="text" id="accent_color_hex" 
                                       value="{{ old('accent_color', $colors['accent'] ?? '#e8eaf6') }}"
                                       class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e] focus:border-transparent outline-none transition duration-200 font-mono text-sm">
                            </div>
                            @error('accent_color') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="text_color" class="block text-sm font-medium text-gray-700 mb-1">Text Color *</label>
                            <div class="flex items-center gap-3">
                                <input type="color" id="text_color" name="text_color" 
                                       value="{{ old('text_color', $colors['text'] ?? '#1a1a1a') }}"
                                       class="w-12 h-12 rounded-lg border border-gray-300 cursor-pointer p-1">
                                <input type="text" id="text_color_hex" 
                                       value="{{ old('text_color', $colors['text'] ?? '#1a1a1a') }}"
                                       class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e] focus:border-transparent outline-none transition duration-200 font-mono text-sm">
                            </div>
                            @error('text_color') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="background_color" class="block text-sm font-medium text-gray-700 mb-1">Background Color *</label>
                            <div class="flex items-center gap-3">
                                <input type="color" id="background_color" name="background_color" 
                                       value="{{ old('background_color', $colors['background'] ?? '#ffffff') }}"
                                       class="w-12 h-12 rounded-lg border border-gray-300 cursor-pointer p-1">
                                <input type="text" id="background_color_hex" 
                                       value="{{ old('background_color', $colors['background'] ?? '#ffffff') }}"
                                       class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e] focus:border-transparent outline-none transition duration-200 font-mono text-sm">
                            </div>
                            @error('background_color') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Fonts -->
                <div>
                    <h3 class="text-base font-semibold text-gray-900 mb-4">Font Settings</h3>
                    @php
                        $fonts = $cvTemplate->default_fonts;
                    @endphp
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="heading_font" class="block text-sm font-medium text-gray-700 mb-1">Heading Font *</label>
                            <select id="heading_font" name="heading_font" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e] focus:border-transparent outline-none transition duration-200" required>
                                <option value="Inter, sans-serif" {{ old('heading_font', $fonts['heading'] ?? '') == 'Inter, sans-serif' ? 'selected' : '' }}>Inter</option>
                                <option value="Georgia, serif" {{ old('heading_font', $fonts['heading'] ?? '') == 'Georgia, serif' ? 'selected' : '' }}>Georgia</option>
                                <option value="Poppins, sans-serif" {{ old('heading_font', $fonts['heading'] ?? '') == 'Poppins, sans-serif' ? 'selected' : '' }}>Poppins</option>
                                <option value="Lora, serif" {{ old('heading_font', $fonts['heading'] ?? '') == 'Lora, serif' ? 'selected' : '' }}>Lora</option>
                                <option value="Space Grotesk, sans-serif" {{ old('heading_font', $fonts['heading'] ?? '') == 'Space Grotesk, sans-serif' ? 'selected' : '' }}>Space Grotesk</option>
                                <option value="Playfair Display, serif" {{ old('heading_font', $fonts['heading'] ?? '') == 'Playfair Display, serif' ? 'selected' : '' }}>Playfair Display</option>
                                <option value="Merriweather, serif" {{ old('heading_font', $fonts['heading'] ?? '') == 'Merriweather, serif' ? 'selected' : '' }}>Merriweather</option>
                            </select>
                            @error('heading_font') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="body_font" class="block text-sm font-medium text-gray-700 mb-1">Body Font *</label>
                            <select id="body_font" name="body_font" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e] focus:border-transparent outline-none transition duration-200" required>
                                <option value="Inter, sans-serif" {{ old('body_font', $fonts['body'] ?? '') == 'Inter, sans-serif' ? 'selected' : '' }}>Inter</option>
                                <option value="Arial, sans-serif" {{ old('body_font', $fonts['body'] ?? '') == 'Arial, sans-serif' ? 'selected' : '' }}>Arial</option>
                                <option value="Open Sans, sans-serif" {{ old('body_font', $fonts['body'] ?? '') == 'Open Sans, sans-serif' ? 'selected' : '' }}>Open Sans</option>
                                <option value="Poppins, sans-serif" {{ old('body_font', $fonts['body'] ?? '') == 'Poppins, sans-serif' ? 'selected' : '' }}>Poppins</option>
                                <option value="Roboto, sans-serif" {{ old('body_font', $fonts['body'] ?? '') == 'Roboto, sans-serif' ? 'selected' : '' }}>Roboto</option>
                                <option value="Lato, sans-serif" {{ old('body_font', $fonts['body'] ?? '') == 'Lato, sans-serif' ? 'selected' : '' }}>Lato</option>
                                <option value="Nunito, sans-serif" {{ old('body_font', $fonts['body'] ?? '') == 'Nunito, sans-serif' ? 'selected' : '' }}>Nunito</option>
                            </select>
                            @error('body_font') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="font_size" class="block text-sm font-medium text-gray-700 mb-1">Font Size *</label>
                            <select id="font_size" name="font_size" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e] focus:border-transparent outline-none transition duration-200" required>
                                <option value="12px" {{ old('font_size', $fonts['size'] ?? '') == '12px' ? 'selected' : '' }}>Small (12px)</option>
                                <option value="13px" {{ old('font_size', $fonts['size'] ?? '') == '13px' ? 'selected' : '' }}>Medium Small (13px)</option>
                                <option value="14px" {{ old('font_size', $fonts['size'] ?? '') == '14px' ? 'selected' : '' }}>Medium (14px)</option>
                                <option value="15px" {{ old('font_size', $fonts['size'] ?? '') == '15px' ? 'selected' : '' }}>Medium Large (15px)</option>
                                <option value="16px" {{ old('font_size', $fonts['size'] ?? '') == '16px' ? 'selected' : '' }}>Large (16px)</option>
                                <option value="17px" {{ old('font_size', $fonts['size'] ?? '') == '17px' ? 'selected' : '' }}>Extra Large (17px)</option>
                            </select>
                            @error('font_size') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Sections -->
                <div>
                    <h3 class="text-base font-semibold text-gray-900 mb-4">Template Sections</h3>
                    <p class="text-sm text-gray-500 mb-4">Select and order the sections that will be available in this template.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3" id="sectionsContainer">
                        @php
                            $selectedSections = old('sections', $cvTemplate->sections ?? []);
                            if (!is_array($selectedSections)) {
                                $selectedSections = $cvTemplate->templateSections->pluck('section_key')->toArray();
                            }
                        @endphp
                        @foreach($availableSections as $key => $name)
                            <label class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                                <input type="checkbox" name="sections[]" value="{{ $key }}"
                                       {{ in_array($key, $selectedSections) ? 'checked' : '' }}
                                       class="w-4 h-4 text-[#1a237e] border-gray-300 rounded focus:ring-[#1a237e]">
                                <div>
                                    <span class="text-sm font-medium text-gray-700">{{ $name }}</span>
                                    <p class="text-xs text-gray-500">{{ $key }}</p>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('sections') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Settings -->
                <div>
                    <h3 class="text-base font-semibold text-gray-900 mb-4">Additional Settings</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <label class="flex items-center gap-3 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                            <input type="checkbox" name="is_default" value="1" {{ old('is_default', $cvTemplate->is_default) ? 'checked' : '' }}
                                   class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                            <span class="text-sm font-medium text-gray-700">Set as Default Template</span>
                        </label>

                        <label class="flex items-center gap-3 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                            <input type="checkbox" name="is_premium" value="1" {{ old('is_premium', $cvTemplate->is_premium) ? 'checked' : '' }}
                                   class="w-4 h-4 text-amber-600 border-gray-300 rounded focus:ring-amber-500">
                            <span class="text-sm font-medium text-gray-700">Premium Template</span>
                        </label>

                        <label class="flex items-center gap-3 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $cvTemplate->is_active) ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="text-sm font-medium text-gray-700">Active</span>
                        </label>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex flex-wrap items-center gap-4 pt-6 border-t border-gray-200">
                    <button type="submit" class="px-6 py-2.5 bg-[#1a237e] text-white font-medium rounded-lg hover:bg-[#0d1445] transition-colors">
                        Update Template
                    </button>
                    <a href="{{ route('admin.cv-templates.index') }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors">
                        Cancel
                    </a>
                    <div class="flex-1"></div>
                    <button type="button" onclick="confirmDelete({{ $cvTemplate->id }}, '{{ $cvTemplate->name }}')"
                            class="px-6 py-2.5 bg-red-50 text-red-700 font-medium rounded-lg hover:bg-red-100 transition-colors">
                        Delete Template
                    </button>
                </div>
            </div>
        </form>
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
            <p class="mt-2 text-sm text-center text-gray-500" id="deleteMessage">Are you sure you want to delete "{{ $cvTemplate->name }}"? This action cannot be undone.</p>
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
    // Sync color inputs
    document.querySelectorAll('input[type="color"]').forEach(colorInput => {
        const hexInput = document.getElementById(colorInput.id + '_hex');
        if (hexInput) {
            colorInput.addEventListener('input', function() {
                hexInput.value = this.value;
            });
            hexInput.addEventListener('input', function() {
                if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) {
                    colorInput.value = this.value;
                }
            });
        }
    });

    // Delete functions
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