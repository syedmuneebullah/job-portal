@extends('admin.layouts.app')

@section('title', 'Edit ' . $user->first_name . ' ' . $user->last_name . ' - User Profile')
@section('page-title', 'Edit User')

@section('content')
<div class="space-y-6">

    <!-- ===== HEADER ===== -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">Edit User</h2>
            <p class="text-sm text-gray-500">Update user information</p>
        </div>
        <div class="flex items-center gap-2">
            @if($user->trashed())
                <button onclick="restoreUser({{ $user->id }})"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 text-white text-sm font-medium rounded-lg hover:bg-emerald-600 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.418 0V4h-.582m-15.418 0a9 9 0 1118 0m-18 0a9 9 0 01-3.6 6.6m18-6.6a9 9 0 01-3.6 6.6"/>
                    </svg>
                    Restore User
                </button>
                <form id="restore-form-{{ $user->id }}"
                      action="{{ route('admin.users.restore', $user->id) }}"
                      method="POST" class="hidden">
                    @csrf
                </form>
            @endif
            <a href="{{ route('admin.users.show', $user->id) }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Profile
            </a>
            <a href="{{ route('admin.users.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                All Users
            </a>
        </div>
    </div>

    <!-- ===== EDIT FORM ===== -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')



            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- ===== LEFT COLUMN ===== -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Personal Information -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Personal Information
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- First Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    First Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('first_name') border-red-500 @enderror"
                                       placeholder="Enter first name" required>
                                @error('first_name')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Last Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Last Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('last_name') border-red-500 @enderror"
                                       placeholder="Enter last name" required>
                                @error('last_name')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('email') border-red-500 @enderror"
                                       placeholder="user@example.com" required>
                                @error('email')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Phone Number</label>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('phone') border-red-500 @enderror"
                                       placeholder="+1 234 567 890">
                                @error('phone')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            Change Password
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">New Password</label>
                                <input type="password" name="password"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('password') border-red-500 @enderror"
                                       placeholder="Enter new password">
                                @error('password')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Confirm Password</label>
                                <input type="password" name="password_confirmation"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all"
                                       placeholder="Confirm new password">
                            </div>
                        </div>
                        <p class="text-xs text-gray-400 mt-2">Leave blank to keep current password</p>
                    </div>
                </div>

                <!-- ===== RIGHT COLUMN ===== -->
                <div class="space-y-6">

                    <!-- Profile Photo -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Profile Photo
                        </h3>

                        <div class="space-y-4">
                            <!-- Current Photo -->
                            @if($user->profile_photo)
                                <div class="relative inline-block">
                                    <img src="{{ Storage::url($user->profile_photo) }}"
                                         alt="{{ $user->first_name }}"
                                         class="w-24 h-24 rounded-full object-cover border-2 border-gray-200">
                                    <button type="button" onclick="document.getElementById('remove_photo').value='1'"
                                            class="absolute -top-2 -right-2 p-1 bg-red-500 text-white rounded-full hover:bg-red-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                                <input type="hidden" name="remove_photo" id="remove_photo" value="0">
                            @else
                                <div class="w-24 h-24 rounded-full bg-gray-100 border-2 border-dashed border-gray-300 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                            @endif

                            <!-- Upload New Photo -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Upload New Photo</label>
                                <input type="file" name="profile_photo" accept="image/*"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-[#1a237e] file:text-white hover:file:bg-[#0d1445] cursor-pointer">
                                <p class="text-xs text-gray-400 mt-1">Recommended: Square image, max 2MB</p>
                                @error('profile_photo')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Account Settings -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Account Settings
                        </h3>

                        <div class="space-y-4">
                            <!-- User Type -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">User Type <span class="text-red-500">*</span></label>
                                <select name="user_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('user_type') border-red-500 @enderror">
                                    <option value="admin" {{ old('user_type', $user->user_type) == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="employer" {{ old('user_type', $user->user_type) == 'employer' ? 'selected' : '' }}>Employer</option>
                                    <option value="recruiter" {{ old('user_type', $user->user_type) == 'recruiter' ? 'selected' : '' }}>Recruiter</option>
                                    <option value="job_seeker" {{ old('user_type', $user->user_type) == 'job_seeker' ? 'selected' : '' }}>Job Seeker</option>
                                </select>
                                @error('user_type')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Account Status <span class="text-red-500">*</span></label>
                                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-[#1a237e] focus:ring-2 focus:ring-[#1a237e]/20 outline-none transition-all @error('status') border-red-500 @enderror">
                                    <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="pending" {{ old('status', $user->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="suspended" {{ old('status', $user->status) == 'suspended' ? 'selected' : '' }}>Suspended</option>
                                    <option value="rejected" {{ old('status', $user->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                                @error('status')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email Verification -->
                            <div>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="email_verified" value="1"
                                           {{ old('email_verified', $user->email_verified_at ? true : false) ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-[#1a237e] focus:ring-[#1a237e]">
                                    <span class="text-sm text-gray-700">Email Verified</span>
                                </label>
                                @if($user->email_verified_at)
                                    <p class="text-xs text-emerald-600 mt-1">Verified on {{ $user->email_verified_at->format('M d, Y H:i') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ===== FORM ACTIONS ===== -->
            <div class="flex flex-wrap items-center gap-3 pt-6 mt-6 border-t border-gray-200">
                <button type="submit" class="px-6 py-2.5 bg-[#1a237e] text-white font-medium rounded-lg hover:bg-[#0d1445] transition-all duration-200 shadow-sm hover:shadow-md flex items-center gap-2">
                    
                    Update User
                </button>
                <a href="{{ route('admin.users.show', $user->id) }}"
                   class="px-6 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-all duration-200">
                    Cancel
                </a>

               
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // ===== CONFIRM DELETE (Soft Delete) =====
    function confirmDelete(id) {
        Swal.fire({
            title: 'Move to Trash?',
            text: 'This user will be moved to trash. You can restore it later.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, move to trash',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            preConfirm: () => {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    // ===== RESTORE USER =====
    function restoreUser(id) {
        Swal.fire({
            title: 'Restore User?',
            text: 'This user will be restored from trash.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, restore it',
            cancelButtonText: 'Cancel',
            preConfirm: () => {
                document.getElementById('restore-form-' + id).submit();
            }
        });
    }
</script>

@endsection
