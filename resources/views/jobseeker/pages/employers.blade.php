{{-- resources/views/jobseeker/pages/employers.blade.php --}}
@extends('jobseeker.layouts.app')

@section('title', 'Find Employers')
@section('page-title', 'Find Employers')

@section('content')

<div class="bg-slate-50/50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- ===== PAGE HEADER ===== -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-[#1A237E]">Find <span class="text-[#ff7543]">Employers</span></h1>
                <p class="text-sm text-gray-500 mt-1">Discover top companies hiring in Malaysia</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-sm text-gray-500">{{ $employers->total() }} employers found</span>
            </div>
        </div>

        <!-- ===== STATS CARDS ===== -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 text-center">
                <p class="text-2xl font-bold text-[#1A237E]">{{ $stats['total'] }}</p>
                <p class="text-xs text-gray-500">Total Employers</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 text-center">
                <p class="text-2xl font-bold text-blue-600">{{ $stats['industries'] }}</p>
                <p class="text-xs text-gray-500">Industries</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 text-center">
                <p class="text-2xl font-bold text-emerald-600">{{ $stats['featured'] }}</p>
                <p class="text-xs text-gray-500">Featured Employers</p>
            </div>
        </div>

        <!-- ===== FILTERS ===== -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-4 md:p-5 mb-6">
            <form action="{{ route('candidate.employers.index') }}" method="GET" class="flex flex-wrap items-center gap-3">
                <!-- Search -->
                <div class="flex-1 min-w-[200px]">
                    <div class="relative">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Search by company name or industry..."
                               class="w-full pl-11 pr-4 py-2.5 border border-gray-200 rounded-lg focus:border-[#ff7543] focus:ring-2 focus:ring-[#ff7543]/20 outline-none transition-all text-sm">
                    </div>
                </div>

                <!-- Industry Filter -->
                <div class="w-40">
                    <select name="industry" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:border-[#ff7543] focus:ring-2 focus:ring-[#ff7543]/20 outline-none transition-all text-sm appearance-none cursor-pointer bg-white">
                        <option value="">All Industries</option>
                        @foreach($industries as $industry)
                            <option value="{{ $industry }}" {{ request('industry') == $industry ? 'selected' : '' }}>
                                {{ $industry }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Company Size -->
                <div class="w-40">
                    <select name="company_size" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:border-[#ff7543] focus:ring-2 focus:ring-[#ff7543]/20 outline-none transition-all text-sm appearance-none cursor-pointer bg-white">
                        <option value="">Company Size</option>
                        @foreach($companySizes as $size)
                            <option value="{{ $size }}" {{ request('company_size') == $size ? 'selected' : '' }}>
                                {{ $size }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Sort By -->
                <div class="w-40">
                    <select name="sort_by" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:border-[#ff7543] focus:ring-2 focus:ring-[#ff7543]/20 outline-none transition-all text-sm appearance-none cursor-pointer bg-white">
                        <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Newest</option>
                        <option value="company_name" {{ request('sort_by') == 'company_name' ? 'selected' : '' }}>Company Name</option>
                        <option value="industry" {{ request('sort_by') == 'industry' ? 'selected' : '' }}>Industry</option>
                    </select>
                </div>

                <button type="submit" class="px-6 py-2.5 bg-[#ff7543] hover:bg-[#B71C1C] text-white font-semibold rounded-lg transition-all duration-300 shadow-md hover:shadow-lg">
                    <i class="fas fa-filter mr-2"></i> Filter
                </button>
                <a href="{{ route('candidate.employers.index') }}" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition-all duration-300">
                    Reset
                </a>
            </form>
        </div>

        <!-- ===== EMPLOYERS GRID ===== -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            @forelse($employers as $employer)
                <div class="group bg-white rounded-2xl shadow-sm border border-gray-100/80 hover:shadow-xl transition-all duration-300 p-5 hover:-translate-y-1">
                    <a href="{{ route('candidate.employers.show', $employer->id) }}" class="block">
                        <!-- Company Logo -->
                        <div class="w-20 h-20 rounded-xl bg-gray-100/70 flex items-center justify-center mx-auto mb-4 overflow-hidden">
                            @if($employer->company_logo)
                                <img src="{{ Storage::url($employer->company_logo) }}" 
                                     alt="{{ $employer->company_name }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <span class="text-2xl font-bold text-[#1A237E]">
                                    {{ substr($employer->company_name, 0, 2) }}
                                </span>
                            @endif
                        </div>

                        <!-- Company Info -->
                        <h3 class="text-base font-bold text-gray-900 text-center group-hover:text-[#1A237E] transition-colors">
                            {{ $employer->company_name }}
                        </h3>
                        <p class="text-sm text-gray-500 text-center">{{ $employer->industry ?? 'N/A' }}</p>

                        <!-- Location -->
                        @if($employer->location)
                            <p class="text-xs text-gray-400 text-center mt-1">
                                <i class="fas fa-map-marker-alt text-[#ff7543] mr-1"></i>
                                {{ $employer->location }}
                            </p>
                        @endif

                        <!-- Company Size -->
                        @if($employer->company_size)
                            <p class="text-xs text-gray-400 text-center">
                                <i class="fas fa-users text-[#ff7543] mr-1"></i>
                                {{ $employer->company_size }} employees
                            </p>
                        @endif

                        <!-- Rating / Verification -->
                        <div class="flex items-center justify-center gap-2 mt-3">
                            @if($employer->verification_status === 'verified')
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-emerald-50 text-emerald-700 text-xs rounded-full">
                                    <i class="fas fa-check-circle text-[10px]"></i>
                                    Verified
                                </span>
                            @endif
                            @if($employer->is_featured)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-amber-50 text-amber-700 text-xs rounded-full">
                                    <i class="fas fa-star text-[10px]"></i>
                                    Featured
                                </span>
                            @endif
                        </div>

                        <!-- View Button -->
                        <div class="mt-4 text-center">
                            <span class="inline-block px-4 py-1.5 bg-[#1A237E] hover:bg-[#0D1445] text-white text-xs font-semibold rounded-full transition-colors">
                                View Company
                            </span>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-12 text-center">
                        <div class="w-20 h-20 rounded-full bg-gray-100 mx-auto flex items-center justify-center mb-4">
                            <i class="fas fa-building text-gray-400 text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">No employers found</h3>
                        <p class="text-sm text-gray-500 max-w-sm mx-auto mt-1">
                            Try adjusting your search or filters
                        </p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- ===== PAGINATION ===== -->
        <div class="mt-6">
            {{ $employers->appends(request()->except('page'))->links() }}
        </div>
    </div>
</div>

@endsection