{{-- resources/views/admin/pages/cv-templates/preview.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Preview - ' . $cvTemplate->name)
@section('page-title', 'Template Preview')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">{{ $cvTemplate->name }}</h2>
            <p class="text-sm text-gray-500 mt-1">{{ $cvTemplate->description }}</p>
            <div class="flex items-center gap-3 mt-1">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    Layout: {{ ucfirst(str_replace('_', ' ', $cvTemplate->layout_type)) }}
                </span>
                <span class="text-xs text-gray-500">Category: {{ ucfirst($cvTemplate->category) }}</span>
                <span class="text-xs text-gray-500">Style: {{ ucfirst($cvTemplate->style) }}</span>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.cv-templates.show', $cvTemplate) }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Details
            </a>
            <a href="{{ route('admin.cv-templates.edit', $cvTemplate) }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-[#1a237e] text-white text-sm font-medium rounded-lg hover:bg-[#0d1445] transition-all duration-200 shadow-sm hover:shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Template
            </a>
        </div>
    </div>

    <!-- Preview -->
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="p-4 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="text-sm font-medium text-gray-700">Live Preview</span>
                <span class="text-xs text-gray-500">|</span>
                <div class="flex items-center gap-2">
                    <button onclick="toggleZoom()" class="px-3 py-1 bg-gray-200 rounded-lg text-xs font-medium hover:bg-gray-300 transition-colors">
                        Toggle Zoom
                    </button>
                    <button onclick="window.print()" class="px-3 py-1 bg-gray-200 rounded-lg text-xs font-medium hover:bg-gray-300 transition-colors">
                        Print Preview
                    </button>
                </div>
            </div>
            <div class="flex items-center gap-4 text-xs text-gray-500">
                <span>Layout: {{ ucfirst(str_replace('_', ' ', $cvTemplate->layout_type)) }}</span>
            </div>
        </div>
        <div class="p-8 overflow-auto max-h-[800px] preview-container">
            @if(isset($renderedCV))
                {!! $renderedCV !!}
            @else
                <!-- Fallback: Use the layout view directly -->
                @php
                    $layoutView = $cvTemplate->layout_view;
                    $sampleData = $cvTemplate->getSampleCVData ? $cvTemplate->getSampleCVData() : [];
                @endphp
                @if(view()->exists($layoutView))
                    @include($layoutView, ['template' => $cvTemplate, 'cvData' => $sampleData])
                @else
                    <div class="text-center py-12 text-gray-500">
                        <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium">Preview Not Available</h3>
                        <p class="mt-2">The layout view for this template could not be found.</p>
                        <p class="text-sm mt-1">Layout: {{ $layoutView }}</p>
                    </div>
                @endif
            @endif
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
        const container = document.querySelector('.preview-container');
        isZoomed = !isZoomed;
        if (isZoomed) {
            container.classList.add('zoomed');
        } else {
            container.classList.remove('zoomed');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Add print styles
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