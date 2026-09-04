{{-- resources/views/admin/pages/cv-templates/layouts/minimal_clean.blade.php --}}
@props(['cvData' => [], 'template' => null])

@php
    $colors = $template->default_colors ?? ['primary' => '#2d3436', 'secondary' => '#636e72', 'accent' => '#dfe6e9', 'text' => '#1a1a1a', 'background' => '#ffffff'];
    $fonts = $template->default_fonts ?? ['heading' => 'Inter, sans-serif', 'body' => 'Inter, sans-serif', 'size' => '14px'];
    
    $hasEducation = isset($cvData['education']) && count($cvData['education']) > 0;
    $hasExperience = isset($cvData['experience']) && count($cvData['experience']) > 0;
    $hasSkills = isset($cvData['skills']) && count($cvData['skills']) > 0;
    $hasLanguages = isset($cvData['languages']) && count($cvData['languages']) > 0;
    $hasCertifications = isset($cvData['certifications']) && count($cvData['certifications']) > 0;
@endphp

<div class="cv-template minimal-clean" style="
    --primary: {{ $colors['primary'] }};
    --secondary: {{ $colors['secondary'] }};
    --accent: {{ $colors['accent'] }};
    --text: {{ $colors['text'] }};
    --background: {{ $colors['background'] }};
    --font-heading: {{ $fonts['heading'] }};
    --font-body: {{ $fonts['body'] }};
    --font-size: {{ $fonts['size'] }};
">
    <div class="minimal-container">
        <div class="minimal-header">
            <h1 class="minimal-name">{{ $cvData['full_name'] ?? 'John Doe' }}</h1>
            <h2 class="minimal-title">{{ $cvData['title'] ?? 'Software Engineer' }}</h2>
            <div class="minimal-contact">
                <span>{{ $cvData['email'] ?? 'john@example.com' }}</span>
                <span class="dot">•</span>
                <span>{{ $cvData['phone'] ?? '+1 234 567 890' }}</span>
                <span class="dot">•</span>
                <span>{{ $cvData['location'] ?? 'New York, NY' }}</span>
            </div>
        </div>

        @if(in_array('summary', $template->sections ?? []) || in_array('executive_summary', $template->sections ?? []))
        <div class="minimal-summary">
            <p>{{ $cvData['summary'] ?? 'No summary provided.' }}</p>
        </div>
        @endif

        <div class="minimal-grid">
            <div class="minimal-left">
                @if($hasSkills)
                <div class="minimal-section">
                    <h3>Skills</h3>
                    <ul class="minimal-list">
                        @foreach($cvData['skills'] as $skill)
                            <li>{{ $skill }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if($hasLanguages)
                <div class="minimal-section">
                    <h3>Languages</h3>
                    <ul class="minimal-list">
                        @foreach($cvData['languages'] as $language)
                            <li>{{ $language }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if($hasCertifications)
                <div class="minimal-section">
                    <h3>Certifications</h3>
                    <ul class="minimal-list">
                        @foreach($cvData['certifications'] as $cert)
                            <li>{{ $cert['name'] ?? '' }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>

            <div class="minimal-right">
                @if($hasExperience)
                <div class="minimal-section">
                    <h3>Experience</h3>
                    @foreach($cvData['experience'] as $exp)
                    <div class="minimal-item">
                        <div class="minimal-item-header">
                            <div>
                                <h4>{{ $exp['title'] ?? '' }}</h4>
                                <p class="minimal-sub">{{ $exp['company'] ?? '' }}</p>
                            </div>
                            <span class="minimal-date">{{ $exp['period'] ?? '' }}</span>
                        </div>
                        @if(!empty($exp['responsibilities']))
                        <ul class="minimal-list" style="margin-top: 5px;">
                            @foreach($exp['responsibilities'] as $responsibility)
                                @if(!empty($responsibility))
                                <li style="font-size: 13px; border-bottom: none; padding: 3px 0;">• {{ $responsibility }}</li>
                                @endif
                            @endforeach
                        </ul>
                        @endif
                    </div>
                    @endforeach
                </div>
                @endif

                @if($hasEducation)
                <div class="minimal-section">
                    <h3>Education</h3>
                    @foreach($cvData['education'] as $edu)
                    <div class="minimal-item">
                        <div class="minimal-item-header">
                            <div>
                                <h4>{{ $edu['degree'] ?? '' }}</h4>
                                <p class="minimal-sub">{{ $edu['institution'] ?? '' }}</p>
                            </div>
                            <span class="minimal-date">{{ $edu['period'] ?? '' }}</span>
                        </div>
                        @if(!empty($edu['gpa']))
                            <p class="minimal-sub" style="margin-top: 3px;">GPA: {{ $edu['gpa'] }}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.cv-template.minimal-clean {
    font-family: var(--font-body);
    font-size: var(--font-size);
    color: var(--text);
    background: var(--background);
    max-width: 1000px;
    margin: 0 auto;
    padding: 50px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}
.cv-template.minimal-clean .minimal-header {
    text-align: center;
    padding-bottom: 25px;
    border-bottom: 2px solid var(--accent);
    margin-bottom: 25px;
}
.cv-template.minimal-clean .minimal-name {
    font-size: 36px;
    font-weight: 700;
    font-family: var(--font-heading);
    color: var(--primary);
    letter-spacing: -1px;
}
.cv-template.minimal-clean .minimal-title {
    font-size: 18px;
    font-weight: 400;
    color: var(--secondary);
    margin-top: 5px;
}
.cv-template.minimal-clean .minimal-contact {
    font-size: 14px;
    color: #6b7280;
    margin-top: 10px;
    display: flex;
    justify-content: center;
    gap: 8px;
    flex-wrap: wrap;
}
.cv-template.minimal-clean .minimal-contact .dot { color: var(--accent); }
.cv-template.minimal-clean .minimal-summary {
    background: var(--accent);
    padding: 20px 25px;
    border-radius: 8px;
    margin-bottom: 30px;
    font-size: 15px;
    line-height: 1.6;
}
.cv-template.minimal-clean .minimal-grid {
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 40px;
}
.cv-template.minimal-clean .minimal-section h3 {
    font-size: 16px;
    font-weight: 600;
    font-family: var(--font-heading);
    color: var(--primary);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 15px;
    padding-bottom: 8px;
    border-bottom: 2px solid var(--accent);
}
.cv-template.minimal-clean .minimal-list {
    list-style: none;
    padding: 0;
}
.cv-template.minimal-clean .minimal-list li {
    padding: 6px 0;
    border-bottom: 1px solid var(--accent);
    font-size: 14px;
}
.cv-template.minimal-clean .minimal-item { margin-bottom: 20px; }
.cv-template.minimal-clean .minimal-item-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}
.cv-template.minimal-clean .minimal-item-header h4 {
    font-size: 16px;
    font-weight: 600;
    font-family: var(--font-heading);
}
.cv-template.minimal-clean .minimal-sub {
    font-size: 14px;
    color: #6b7280;
    margin-top: 2px;
}
.cv-template.minimal-clean .minimal-date {
    font-size: 13px;
    color: #9ca3af;
    font-weight: 500;
    white-space: nowrap;
    margin-left: 15px;
}
@media (max-width: 768px) {
    .cv-template.minimal-clean { padding: 30px 20px; }
    .cv-template.minimal-clean .minimal-grid { grid-template-columns: 1fr; gap: 25px; }
    .cv-template.minimal-clean .minimal-name { font-size: 28px; }
}
</style>