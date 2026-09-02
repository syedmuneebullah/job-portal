{{-- resources/views/admin/pages/employers/edit.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Edit ' . $employer->company_name . ' - Company Profile')
@section('page-title', 'Edit Company')

@section('content')
<div class="space-y-6">
    
    <!-- ===== HEADER ===== -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">Edit Company</h2>
            <p class="text-sm text-gray-500">Update company information</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.employers.show', $employer->id) }}" 
               class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Profile
            </a>
            <a href="{{ route('admin.employers.index') }}" 
               class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                All Companies
            </a>
        </div>
    </div>
    
    <!-- ===== EDIT FORM ===== -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="{{ route('admin.employers.update', $employer->id) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- ===== LEFT COLUMN ===== -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Company Information Section -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            Company Information
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Company Name -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Company Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="company_name" value="{{ old('company_name', $employer->company_name) }}" 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('company_name') border-red-500 @enderror"
                                       placeholder="Enter company name" required>
                                @error('company_name')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Industry -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Industry</label>
                                <input type="text" name="industry" value="{{ old('industry', $employer->industry) }}" 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('industry') border-red-500 @enderror"
                                       placeholder="e.g. Technology">
                                @error('industry')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Company Size -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Company Size</label>
                                <select name="company_size" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('company_size') border-red-500 @enderror">
                                    <option value="">Select Size</option>
                                    <option value="1-10" {{ old('company_size', $employer->company_size) == '1-10' ? 'selected' : '' }}>1-10 employees</option>
                                    <option value="11-50" {{ old('company_size', $employer->company_size) == '11-50' ? 'selected' : '' }}>11-50 employees</option>
                                    <option value="51-200" {{ old('company_size', $employer->company_size) == '51-200' ? 'selected' : '' }}>51-200 employees</option>
                                    <option value="201-500" {{ old('company_size', $employer->company_size) == '201-500' ? 'selected' : '' }}>201-500 employees</option>
                                    <option value="501-1000" {{ old('company_size', $employer->company_size) == '501-1000' ? 'selected' : '' }}>501-1000 employees</option>
                                    <option value="1000+" {{ old('company_size', $employer->company_size) == '1000+' ? 'selected' : '' }}>1000+ employees</option>
                                </select>
                                @error('company_size')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Founded Year -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Founded Year</label>
                                <input type="number" name="founded_year" value="{{ old('founded_year', $employer->founded_year) }}" 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('founded_year') border-red-500 @enderror"
                                       placeholder="e.g. 2020" min="1900" max="{{ date('Y') }}">
                                @error('founded_year')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Headquarters -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Headquarters</label>
                                <input type="text" name="headquarters" value="{{ old('headquarters', $employer->headquarters) }}" 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('headquarters') border-red-500 @enderror"
                                       placeholder="e.g. New York, NY">
                                @error('headquarters')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Website -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Website</label>
                                <input type="url" name="website" value="{{ old('website', $employer->website) }}" 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('website') border-red-500 @enderror"
                                       placeholder="https://example.com">
                                @error('website')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Company Description</label>
                        <textarea name="company_description" rows="5" 
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('company_description') border-red-500 @enderror"
                                  placeholder="Describe your company...">{{ old('company_description', $employer->company_description) }}</textarea>
                        @error('company_description')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Social Links -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            Social Links
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- LinkedIn -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">LinkedIn URL</label>
                                <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $employer->linkedin_url) }}" 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('linkedin_url') border-red-500 @enderror"
                                       placeholder="https://linkedin.com/company/...">
                                @error('linkedin_url')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Twitter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Twitter URL</label>
                                <input type="url" name="twitter_url" value="{{ old('twitter_url', $employer->twitter_url) }}" 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('twitter_url') border-red-500 @enderror"
                                       placeholder="https://twitter.com/...">
                                @error('twitter_url')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- ===== RIGHT COLUMN ===== -->
                <div class="space-y-6">
                    
                    <!-- Company Logo -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Company Logo
                        </h3>
                        
                        <div class="space-y-4">
                            <!-- Current Logo -->
                            @if($employer->company_logo)
                                <div class="relative inline-block">
                                    <img src="{{ Storage::url($employer->company_logo) }}" 
                                         alt="{{ $employer->company_name }}" 
                                         class="w-32 h-32 rounded-xl object-cover border border-gray-200">
                                    <button type="button" onclick="document.getElementById('remove_logo').value='1'" 
                                            class="absolute -top-2 -right-2 p-1 bg-red-500 text-white rounded-full hover:bg-red-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                                <input type="hidden" name="remove_logo" id="remove_logo" value="0">
                            @else
                                <div class="w-32 h-32 rounded-xl bg-gray-100 border-2 border-dashed border-gray-300 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                            
                            <!-- Upload New Logo -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Upload New Logo</label>
                                <input type="file" name="company_logo" accept="image/*" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-[#1a237e] file:text-white hover:file:bg-[#0d1445] cursor-pointer">
                                <p class="text-xs text-gray-400 mt-1">Recommended: Square image, max 2MB</p>
                                @error('company_logo')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Status & Verification -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Status & Verification
                        </h3>
                        
                        <div class="space-y-4">
                            <!-- Verification Status -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Verification Status</label>
                                <select name="verification_status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('verification_status') border-red-500 @enderror">
                                    <option value="pending" {{ old('verification_status', $employer->verification_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="verified" {{ old('verification_status', $employer->verification_status) == 'verified' ? 'selected' : '' }}>Verified</option>
                                    <option value="rejected" {{ old('verification_status', $employer->verification_status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                                @error('verification_status')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Account Status -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Account Status</label>
                                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('status') border-red-500 @enderror">
                                    <option value="active" {{ old('status', $employer->user->status ?? 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="pending" {{ old('status', $employer->user->status ?? 'active') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="suspended" {{ old('status', $employer->user->status ?? 'active') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                                    <option value="rejected" {{ old('status', $employer->user->status ?? 'active') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                                @error('status')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            @if($employer->verified_at)
                                <div class="p-3 bg-emerald-50 rounded-lg border border-emerald-100">
                                    <p class="text-xs text-emerald-600 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Verified on {{ $employer->verified_at->format('M d, Y H:i') }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Contact Info -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            Contact Information
                        </h3>
                        
                        <div class="space-y-4">
                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Email Address <span class="text-red-500">*</span></label>
                                <input type="email" name="email" value="{{ old('email', $employer->email ?? '') }}" 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('email') border-red-500 @enderror"
                                       placeholder="company@example.com" required>
                                @error('email')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Phone -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Phone Number</label>
                                <input type="text" name="phone" value="{{ old('phone', $employer->phone ?? '') }}" 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('phone') border-red-500 @enderror"
                                       placeholder="+1 234 567 890">
                                @error('phone')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- ===== FORM ACTIONS ===== -->
            <div class="flex flex-wrap items-center gap-3 pt-6 mt-6 border-t border-gray-200">
                <button type="submit" class="px-6 py-2.5 bg-[#1a237e] text-white font-medium rounded-lg hover:bg-[#0d1445] transition-all duration-200 shadow-sm hover:shadow-md flex items-center gap-2">
                    
                    Update Company
                </button>
                <a href="{{ route('admin.employers.show', $employer->id) }}" 
                   class="px-6 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-all duration-200">
                    Cancel
                </a>
                @if($employer->verification_status !== 'verified')
                    <button type="button" onclick="verifyCompany({{ $employer->id }})" 
                            class="ml-auto px-6 py-2.5 bg-emerald-500 text-white font-medium rounded-lg hover:bg-emerald-600 transition-all duration-200 shadow-sm hover:shadow-md flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Verify Company
                    </button>
                @endif
            </div>
        </form>
    </div>
</div>

<script>
    function verifyCompany(id) {
        if (confirm('Verify this company?')) {
            document.getElementById('verify-form-' + id).submit();
        }
    }
</script>

<form id="verify-form-{{ $employer->id }}" action="" method="POST" class="hidden">
    @csrf
</form>

@endsection