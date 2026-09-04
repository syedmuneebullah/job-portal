{{-- resources/views/admin/pages/cv-templates/create.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Create CV Template')
@section('page-title', 'Create New CV Template')

@section('content')
<div class="bg-white rounded-lg border border-gray-200 p-6">
    <form action="{{ route('admin.cv-templates.store') }}" method="POST" enctype="multipart/form-data" id="templateForm">
        @csrf

        <div class="space-y-8">
            <!-- Basic Information -->
            <div>
                <h3 class="text-base font-semibold text-gray-900 mb-4">Basic Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Template Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e] focus:border-transparent outline-none transition duration-200"
                               placeholder="e.g., Professional Classic" required>
                        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
                        <select id="category" name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e] focus:border-transparent outline-none transition duration-200" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>{{ ucfirst($category) }}</option>
                            @endforeach
                        </select>
                        @error('category') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="style" class="block text-sm font-medium text-gray-700 mb-1">Style *</label>
                        <select id="style" name="style" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e] focus:border-transparent outline-none transition duration-200" required>
                            <option value="">Select Style</option>
                            @foreach($styles as $style)
                                <option value="{{ $style }}" {{ old('style') == $style ? 'selected' : '' }}>{{ ucfirst($style) }}</option>
                            @endforeach
                        </select>
                        @error('style') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="layout_type" class="block text-sm font-medium text-gray-700 mb-1">Layout Type *</label>
                        <select id="layout_type" name="layout_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e] focus:border-transparent outline-none transition duration-200" required>
                            <option value="">Select Layout</option>
                            @foreach($layoutTypes as $key => $name)
                                <option value="{{ $key }}" {{ old('layout_type') == $key ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-gray-500">Select the layout design for this template</p>
                        @error('layout_type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-1">Thumbnail</label>
                        <input type="file" id="thumbnail" name="thumbnail" accept="image/*"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e] focus:border-transparent outline-none transition duration-200 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-[#1a237e]/10 file:text-[#1a237e] hover:file:bg-[#1a237e]/20">
                        <p class="mt-1 text-xs text-gray-500">Recommended size: 600x400px, Max 2MB</p>
                        @error('thumbnail') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea id="description" name="description" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e] focus:border-transparent outline-none transition duration-200"
                              placeholder="Describe your template...">{{ old('description') }}</textarea>
                    @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Color Scheme -->
            <div>
                <h3 class="text-base font-semibold text-gray-900 mb-4">Color Scheme</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="primary_color" class="block text-sm font-medium text-gray-700 mb-1">Primary Color *</label>
                        <div class="flex items-center gap-3">
                            <input type="color" id="primary_color" name="primary_color" value="{{ old('primary_color', '#1a237e') }}"
                                   class="w-12 h-12 rounded-lg border border-gray-300 cursor-pointer p-1">
                            <input type="text" id="primary_color_hex" value="{{ old('primary_color', '#1a237e') }}"
                                   class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e] focus:border-transparent outline-none transition duration-200 font-mono text-sm">
                        </div>
                        @error('primary_color') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="secondary_color" class="block text-sm font-medium text-gray-700 mb-1">Secondary Color *</label>
                        <div class="flex items-center gap-3">
                            <input type="color" id="secondary_color" name="secondary_color" value="{{ old('secondary_color', '#0d1445') }}"
                                   class="w-12 h-12 rounded-lg border border-gray-300 cursor-pointer p-1">
                            <input type="text" id="secondary_color_hex" value="{{ old('secondary_color', '#0d1445') }}"
                                   class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e] focus:border-transparent outline-none transition duration-200 font-mono text-sm">
                        </div>
                        @error('secondary_color') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="accent_color" class="block text-sm font-medium text-gray-700 mb-1">Accent Color *</label>
                        <div class="flex items-center gap-3">
                            <input type="color" id="accent_color" name="accent_color" value="{{ old('accent_color', '#e8eaf6') }}"
                                   class="w-12 h-12 rounded-lg border border-gray-300 cursor-pointer p-1">
                            <input type="text" id="accent_color_hex" value="{{ old('accent_color', '#e8eaf6') }}"
                                   class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e] focus:border-transparent outline-none transition duration-200 font-mono text-sm">
                        </div>
                        @error('accent_color') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="text_color" class="block text-sm font-medium text-gray-700 mb-1">Text Color *</label>
                        <div class="flex items-center gap-3">
                            <input type="color" id="text_color" name="text_color" value="{{ old('text_color', '#1a1a1a') }}"
                                   class="w-12 h-12 rounded-lg border border-gray-300 cursor-pointer p-1">
                            <input type="text" id="text_color_hex" value="{{ old('text_color', '#1a1a1a') }}"
                                   class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e] focus:border-transparent outline-none transition duration-200 font-mono text-sm">
                        </div>
                        @error('text_color') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="background_color" class="block text-sm font-medium text-gray-700 mb-1">Background Color *</label>
                        <div class="flex items-center gap-3">
                            <input type="color" id="background_color" name="background_color" value="{{ old('background_color', '#ffffff') }}"
                                   class="w-12 h-12 rounded-lg border border-gray-300 cursor-pointer p-1">
                            <input type="text" id="background_color_hex" value="{{ old('background_color', '#ffffff') }}"
                                   class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e] focus:border-transparent outline-none transition duration-200 font-mono text-sm">
                        </div>
                        @error('background_color') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Fonts -->
            <div>
                <h3 class="text-base font-semibold text-gray-900 mb-4">Font Settings</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="heading_font" class="block text-sm font-medium text-gray-700 mb-1">Heading Font *</label>
                        <select id="heading_font" name="heading_font" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e] focus:border-transparent outline-none transition duration-200" required>
                            <option value="Inter, sans-serif" {{ old('heading_font') == 'Inter, sans-serif' ? 'selected' : '' }}>Inter</option>
                            <option value="Georgia, serif" {{ old('heading_font') == 'Georgia, serif' ? 'selected' : '' }}>Georgia</option>
                            <option value="Poppins, sans-serif" {{ old('heading_font') == 'Poppins, sans-serif' ? 'selected' : '' }}>Poppins</option>
                            <option value="Lora, serif" {{ old('heading_font') == 'Lora, serif' ? 'selected' : '' }}>Lora</option>
                            <option value="Space Grotesk, sans-serif" {{ old('heading_font') == 'Space Grotesk, sans-serif' ? 'selected' : '' }}>Space Grotesk</option>
                            <option value="Playfair Display, serif" {{ old('heading_font') == 'Playfair Display, serif' ? 'selected' : '' }}>Playfair Display</option>
                        </select>
                        @error('heading_font') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="body_font" class="block text-sm font-medium text-gray-700 mb-1">Body Font *</label>
                        <select id="body_font" name="body_font" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e] focus:border-transparent outline-none transition duration-200" required>
                            <option value="Inter, sans-serif" {{ old('body_font') == 'Inter, sans-serif' ? 'selected' : '' }}>Inter</option>
                            <option value="Arial, sans-serif" {{ old('body_font') == 'Arial, sans-serif' ? 'selected' : '' }}>Arial</option>
                            <option value="Open Sans, sans-serif" {{ old('body_font') == 'Open Sans, sans-serif' ? 'selected' : '' }}>Open Sans</option>
                            <option value="Poppins, sans-serif" {{ old('body_font') == 'Poppins, sans-serif' ? 'selected' : '' }}>Poppins</option>
                            <option value="Roboto, sans-serif" {{ old('body_font') == 'Roboto, sans-serif' ? 'selected' : '' }}>Roboto</option>
                            <option value="Lato, sans-serif" {{ old('body_font') == 'Lato, sans-serif' ? 'selected' : '' }}>Lato</option>
                        </select>
                        @error('body_font') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="font_size" class="block text-sm font-medium text-gray-700 mb-1">Font Size *</label>
                        <select id="font_size" name="font_size" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e] focus:border-transparent outline-none transition duration-200" required>
                            <option value="12px" {{ old('font_size') == '12px' ? 'selected' : '' }}>Small (12px)</option>
                            <option value="13px" {{ old('font_size') == '13px' ? 'selected' : '' }}>Medium Small (13px)</option>
                            <option value="14px" {{ old('font_size') == '14px' ? 'selected' : '' }} selected>Medium (14px)</option>
                            <option value="15px" {{ old('font_size') == '15px' ? 'selected' : '' }}>Medium Large (15px)</option>
                            <option value="16px" {{ old('font_size') == '16px' ? 'selected' : '' }}>Large (16px)</option>
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
                    @foreach($availableSections as $key => $name)
                        <label class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                            <input type="checkbox" name="sections[]" value="{{ $key }}"
                                   {{ in_array($key, old('sections', ['personal_info', 'summary', 'experience', 'education', 'skills'])) ? 'checked' : '' }}
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
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <label class="flex items-center gap-3 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                        <input type="checkbox" name="is_default" value="1" {{ old('is_default') ? 'checked' : '' }}
                               class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                        <span class="text-sm font-medium text-gray-700">Set as Default Template</span>
                    </label>

                    <label class="flex items-center gap-3 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                        <input type="checkbox" name="is_premium" value="1" {{ old('is_premium') ? 'checked' : '' }}
                               class="w-4 h-4 text-amber-600 border-gray-300 rounded focus:ring-amber-500">
                        <span class="text-sm font-medium text-gray-700">Premium Template</span>
                    </label>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center gap-4 pt-6 border-t border-gray-200">
                <button type="submit" class="px-6 py-2.5 bg-[#1a237e] text-white font-medium rounded-lg hover:bg-[#0d1445] transition-colors">
                    Create Template
                </button>
                <a href="{{ route('admin.cv-templates.index') }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors">
                    Cancel
                </a>
            </div>
        </div>
    </form>
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

    // Auto-generate slug from name
    document.getElementById('name').addEventListener('input', function() {
        // This is optional, can be used if you want to show slug preview
    });
</script>
@endsection