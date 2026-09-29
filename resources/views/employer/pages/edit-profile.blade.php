{{-- resources/views/employer/pages/edit-profile.blade.php --}}
@extends('employer.layouts.app')

@section('title', 'Edit Company Profile')
@section('page-title', 'Edit Company Profile')

@section('content')
<div class="max-w-7xl mx-auto">

    <!-- Back link -->
    <a href="{{ route('employer.profile') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#1a237e] hover:underline mb-4">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to profile
    </a>

    <form action="{{ route('employer.profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
        @csrf
        @method('PUT')

        <div class="space-y-4">

            <!-- ===== PAGE HEADER ===== -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h2 class="text-xl font-bold text-gray-900">Edit company profile</h2>
                <p class="text-sm text-gray-500 mt-1">Update your company information to attract the best talent</p>
            </div>

            <!-- ===== COMPANY LOGO + BASIC ===== -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Company information</h3>

                <!-- Logo -->
                <div class="flex items-center gap-5 pb-6 border-b border-gray-100">
                    <div class="relative">
                        <div class="w-24 h-24 rounded-2xl border-4 border-gray-100 bg-gray-100 overflow-hidden flex items-center justify-center" id="logoPreview">
                            @if($employer->logo_url)
                                <img src="{{ $employer->logo_url }}" alt="{{ $employer->company_name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-[#1a237e] flex items-center justify-center">
                                    <span class="text-2xl font-bold text-white">{{ $employer->initials }}</span>
                                </div>
                            @endif
                        </div>
                        <label for="company_logo" class="absolute -bottom-1 -right-1 w-8 h-8 rounded-full bg-white border border-gray-300 hover:bg-gray-50 flex items-center justify-center cursor-pointer shadow-sm transition-colors">
                            <svg class="w-3.5 h-3.5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </label>
                        <input type="file" id="company_logo" name="company_logo" accept="image/*" class="hidden">
                    </div>
                    <div>
                        <p class="text-sm text-gray-700 font-medium">Company logo</p>
                        <p class="text-xs text-gray-400">JPG, PNG, WEBP or SVG. Max 2MB</p>
                        @error('company_logo')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Basic fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Company name <span class="text-red-500">*</span></label>
                        <input type="text" name="company_name" value="{{ old('company_name', $employer->company_name) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e]/30 focus:border-[#1a237e] outline-none transition-all @error('company_name') border-red-500 @enderror">
                        @error('company_name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Industry</label>
                        <select name="industry" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e]/30 focus:border-[#1a237e] outline-none transition-all @error('industry') border-red-500 @enderror">
                            <option value="">Select industry</option>
                            @foreach(['Technology','Finance','Healthcare','Education','Manufacturing','Retail','Hospitality','Construction','Transportation','Marketing','Design','Engineering','Telecommunications','Energy','Other'] as $industry)
                                <option value="{{ $industry }}" @selected(old('industry', $employer->industry) === $industry)>{{ $industry }}</option>
                            @endforeach
                        </select>
                        @error('industry')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Contact email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $employer->email) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e]/30 focus:border-[#1a237e] outline-none transition-all @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone', $employer->phone) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e]/30 focus:border-[#1a237e] outline-none transition-all @error('phone') border-red-500 @enderror"
                               placeholder="e.g. +60 12-345-6789">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Company size</label>
                        <select name="company_size" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e]/30 focus:border-[#1a237e] outline-none transition-all @error('company_size') border-red-500 @enderror">
                            <option value="">Select size</option>
                            @foreach(['1-10','11-50','51-200','201-500','501-1000','1001-5000','5000+'] as $size)
                                <option value="{{ $size }}" @selected(old('company_size', $employer->company_size) === $size)>{{ $size }} employees</option>
                            @endforeach
                        </select>
                        @error('company_size')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Founded year</label>
                        <input type="number" name="founded_year" value="{{ old('founded_year', $employer->founded_year) }}"
                               min="1800" max="{{ date('Y') }}" placeholder="e.g. 2010"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e]/30 focus:border-[#1a237e] outline-none transition-all @error('founded_year') border-red-500 @enderror">
                        @error('founded_year')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Headquarters</label>
                        <input type="text" name="headquarters" value="{{ old('headquarters', $employer->headquarters) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e]/30 focus:border-[#1a237e] outline-none transition-all @error('headquarters') border-red-500 @enderror"
                               placeholder="e.g. Kuala Lumpur, Malaysia">
                        @error('headquarters')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- ===== DESCRIPTION ===== -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h3 class="text-base font-semibold text-gray-900 mb-4">About the company</h3>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Company description</label>
                    <textarea name="company_description" id="description-editor" rows="6"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e]/30 focus:border-[#1a237e] outline-none transition-all @error('company_description') border-red-500 @enderror"
                              placeholder="Tell candidates what your company does, its mission, culture, and why they should join...">{{ old('company_description', $employer->company_description) }}</textarea>
                    @error('company_description')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-400 mt-1">Max 5000 characters</p>
                </div>
            </div>

            <!-- ===== LINKS & SOCIAL ===== -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Links &amp; social media</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Website</label>
                        <input type="url" name="website" value="{{ old('website', $employer->website) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e]/30 focus:border-[#1a237e] outline-none transition-all @error('website') border-red-500 @enderror"
                               placeholder="https://your-company.com">
                        @error('website')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">LinkedIn URL</label>
                        <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $employer->linkedin_url) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e]/30 focus:border-[#1a237e] outline-none transition-all @error('linkedin_url') border-red-500 @enderror"
                               placeholder="https://linkedin.com/company/your-company">
                        @error('linkedin_url')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Twitter / X URL</label>
                        <input type="url" name="twitter_url" value="{{ old('twitter_url', $employer->twitter_url) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1a237e]/30 focus:border-[#1a237e] outline-none transition-all @error('twitter_url') border-red-500 @enderror"
                               placeholder="https://twitter.com/your-company">
                        @error('twitter_url')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- ===== SUBMIT ===== -->
            <div class="flex items-center gap-3 pb-2">
                <button type="submit" id="submitBtn"
                        class="inline-flex items-center gap-2 px-6 py-2.5 bg-[#1a237e] hover:bg-[#131b63] text-white text-sm font-semibold rounded-full transition-colors shadow-sm disabled:opacity-60 disabled:cursor-not-allowed">
                    <svg id="submitSpinner" class="w-4 h-4 animate-spin hidden" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span id="submitText">Save changes</span>
                </button>
                <a href="{{ route('employer.profile') }}"
                   class="px-6 py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-semibold rounded-full hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
            </div>

        </div>
    </form>
</div>

<!-- CKEditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

<script>
(function () {
    // ===== LOGO PREVIEW =====
    const logoInput = document.getElementById('company_logo');
    if (logoInput) {
        logoInput.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function (ev) {
                const preview = document.getElementById('logoPreview');
                preview.innerHTML = `<img src="${ev.target.result}" class="w-full h-full object-cover">`;
            };
            reader.readAsDataURL(file);
        });
    }

    // ===== CKEDITOR for description =====
    let descriptionEditor;
    if (document.querySelector('#description-editor')) {
        ClassicEditor
            .create(document.querySelector('#description-editor'), {
                toolbar: [
                    'heading', '|',
                    'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                    'blockQuote', 'undo', 'redo'
                ],
                placeholder: 'Tell candidates what your company does, its mission, culture...',
            })
            .then(editor => { descriptionEditor = editor; })
            .catch(error => console.error(error));
    }

    // ===== SYNC CKEDITOR BEFORE SUBMIT =====
    const form = document.getElementById('profileForm');
    const submitBtn = document.getElementById('submitBtn');
    const submitSpinner = document.getElementById('submitSpinner');
    const submitText = document.getElementById('submitText');

    form.addEventListener('submit', function () {
        if (descriptionEditor) {
            document.querySelector('#description-editor').value = descriptionEditor.getData();
        }
        submitBtn.disabled = true;
        submitSpinner.classList.remove('hidden');
        submitText.textContent = 'Saving...';
    });

    // ===== UNSAVED CHANGES WARNING =====
    let formChanged = false;
    form.querySelectorAll('input, select, textarea').forEach(input => {
        input.addEventListener('change', () => formChanged = true);
        input.addEventListener('input',  () => formChanged = true);
    });

    window.addEventListener('beforeunload', function (e) {
        if (formChanged) {
            e.preventDefault();
            e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
        }
    });

    form.addEventListener('submit', () => formChanged = false);
})();
</script>

@endsection