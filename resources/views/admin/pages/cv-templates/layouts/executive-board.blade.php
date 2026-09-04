{{-- resources/views/admin/pages/cv-templates/layouts/executive_board.blade.php --}}
@props(['cvData' => [], 'template' => null])

@php
    $colors = $template->default_colors ?? ['primary' => '#2d3436', 'secondary' => '#636e72', 'accent' => '#dfe6e9', 'text' => '#1a1a1a', 'background' => '#ffffff'];
    $fonts = $template->default_fonts ?? ['heading' => 'Lora, serif', 'body' => 'Open Sans, sans-serif', 'size' => '14px'];
    
    $hasEducation = isset($cvData['education']) && count($cvData['education']) > 0;
    $hasExperience = isset($cvData['experience']) && count($cvData['experience']) > 0;
    $hasSkills = isset($cvData['skills']) && count($cvData['skills']) > 0;
    $hasLanguages = isset($cvData['languages']) && count($cvData['languages']) > 0;
    $hasCertifications = isset($cvData['certifications']) && count($cvData['certifications']) > 0;
@endphp

<div class="cv-template executive-board" style="
    --primary: {{ $colors['primary'] }};
    --secondary: {{ $colors['secondary'] }};
    --accent: {{ $colors['accent'] }};
    --text: {{ $colors['text'] }};
    --background: {{ $colors['background'] }};
    --font-heading: {{ $fonts['heading'] }};
    --font-body: {{ $fonts['body'] }};
    --font-size: {{ $fonts['size'] }};
">
    <div class="executive-container">
        <div class="executive-main">
            <div class="executive-header">
                <h1 class="executive-name">{{ $cvData['full_name'] ?? 'John Doe' }}</h1>
                <h2 class="executive-title">{{ $cvData['title'] ?? 'Executive Director' }}</h2>
            </div>

            @if(in_array('executive_summary', $template->sections ?? []) || in_array('summary', $template->sections ?? []))
            <div class="executive-summary">
                <h3>Executive Summary</h3>
                <p>{{ $cvData['executive_summary'] ?? $cvData['summary'] ?? 'No summary provided.' }}</p>
            </div>
            @endif

            @if($hasExperience)
            <div class="executive-section">
                <h3>Professional Experience</h3>
                @foreach($cvData['experience'] as $exp)
                <div class="executive-item">
                    <div class="executive-item-header">
                        <div>
                            <h4>{{ $exp['title'] ?? '' }}</h4>
                            <p class="executive-company">{{ $exp['company'] ?? '' }}</p>
                        </div>
                        <span class="executive-period">{{ $exp['period'] ?? '' }}</span>
                    </div>
                    @if(!empty($exp['responsibilities']))
                    <ul>
                        @foreach($exp['responsibilities'] as $responsibility)
                            @if(!empty($responsibility))
                            <li>{{ $responsibility }}</li>
                            @endif
                        @endforeach
                    </ul>
                    @endif
                </div>
                @endforeach
            </div>
            @endif

            @if($hasEducation)
            <div class="executive-section">
                <h3>Education</h3>
                @foreach($cvData['education'] as $edu)
                <div class="executive-item">
                    <div class="executive-item-header">
                        <div>
                            <h4>{{ $edu['degree'] ?? '' }}</h4>
                            <p class="executive-company">{{ $edu['institution'] ?? '' }}</p>
                        </div>
                        <span class="executive-period">{{ $edu['period'] ?? '' }}</span>
                    </div>
                    @if(!empty($edu['gpa']))
                        <p style="font-size: 13px; color: #6b7280; margin-top: 3px;">GPA: {{ $edu['gpa'] }}</p>
                    @endif
                </div>
                @endforeach
            </div>
            @endif

            @if($hasCertifications)
            <div class="executive-section">
                <h3>Certifications</h3>
                @foreach($cvData['certifications'] as $cert)
                <div class="executive-item">
                    <div class="executive-item-header">
                        <div>
                            <h4>{{ $cert['name'] ?? '' }}</h4>
                            <p class="executive-company">{{ $cert['institution'] ?? '' }}</p>
                        </div>
                        <span class="executive-period">{{ $cert['period'] ?? '' }}</span>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        <div class="executive-sidebar">
            @if(isset($cvData['profile_photo']) && $cvData['profile_photo'])
            <div class="executive-photo">
                <img src="{{ $cvData['profile_photo'] }}" alt="Profile Photo">
            </div>
            @endif

            <div class="executive-contact">
                <h3>Contact</h3>
                <ul>
                    <li><strong>Email</strong><br>{{ $cvData['email'] ?? 'john@example.com' }}</li>
                    <li><strong>Phone</strong><br>{{ $cvData['phone'] ?? '+1 234 567 890' }}</li>
                    <li><strong>Location</strong><br>{{ $cvData['location'] ?? 'New York, NY' }}</li>
                </ul>
            </div>

            @if($hasSkills)
            <div class="executive-contact">
                <h3>Expertise</h3>
                <ul>
                    @foreach($cvData['skills'] as $skill)
                        <li>{{ $skill }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if($hasLanguages)
            <div class="executive-contact">
                <h3>Languages</h3>
                <ul>
                    @foreach($cvData['languages'] as $language)
                        <li>{{ $language }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.cv-template.executive-board {
    font-family: var(--font-body);
    font-size: var(--font-size);
    color: var(--text);
    background: var(--background);
    max-width: 1100px;
    margin: 0 auto;
    box-shadow: 0 2px 20px rgba(0,0,0,0.1);
}
.cv-template.executive-board .executive-container {
    display: grid;
    grid-template-columns: 2fr 1fr;
    min-height: 100vh;
}
.cv-template.executive-board .executive-main { padding: 50px; }
.cv-template.executive-board .executive-sidebar {
    background: var(--primary);
    color: white;
    padding: 40px 30px;
}
.cv-template.executive-board .executive-header {
    border-bottom: 3px solid var(--primary);
    padding-bottom: 20px;
    margin-bottom: 25px;
}
.cv-template.executive-board .executive-name {
    font-size: 36px;
    font-weight: 700;
    font-family: var(--font-heading);
    color: var(--primary);
}
.cv-template.executive-board .executive-title {
    font-size: 18px;
    color: var(--secondary);
    font-weight: 400;
    margin-top: 5px;
}
.cv-template.executive-board .executive-summary {
    background: var(--accent);
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 30px;
}
.cv-template.executive-board .executive-summary h3 {
    font-size: 14px;
    font-weight: 600;
    color: var(--primary);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 8px;
}
.cv-template.executive-board .executive-section h3 {
    font-size: 16px;
    font-weight: 600;
    font-family: var(--font-heading);
    color: var(--primary);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 20px;
    border-bottom: 2px solid var(--accent);
    padding-bottom: 8px;
}
.cv-template.executive-board .executive-item { margin-bottom: 25px; }
.cv-template.executive-board .executive-item-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}
.cv-template.executive-board .executive-item-header h4 {
    font-size: 17px;
    font-weight: 600;
    font-family: var(--font-heading);
}
.cv-template.executive-board .executive-company {
    font-size: 14px;
    color: #6b7280;
}
.cv-template.executive-board .executive-period {
    font-size: 13px;
    color: #9ca3af;
    font-weight: 500;
    white-space: nowrap;
    margin-left: 15px;
}
.cv-template.executive-board .executive-item ul {
    list-style: disc;
    padding-left: 20px;
    font-size: 14px;
    line-height: 1.8;
}
.cv-template.executive-board .executive-sidebar h3 {
    font-size: 14px;
    font-weight: 600;
    font-family: var(--font-heading);
    text-transform: uppercase;
    letter-spacing: 1px;
    border-bottom: 2px solid rgba(255,255,255,0.2);
    padding-bottom: 8px;
    margin: 25px 0 15px;
}
.cv-template.executive-board .executive-sidebar h3:first-of-type { margin-top: 0; }
.cv-template.executive-board .executive-photo {
    width: 150px;
    height: 150px;
    border-radius: 8px;
    overflow: hidden;
    margin: 0 auto 25px;
    border: 3px solid rgba(255,255,255,0.2);
}
.cv-template.executive-board .executive-photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.cv-template.executive-board .executive-contact ul {
    list-style: none;
    padding: 0;
}
.cv-template.executive-board .executive-contact ul li {
    padding: 8px 0;
    border-bottom: 1px solid rgba(255,255,255,0.1);
    font-size: 13px;
}
.cv-template.executive-board .executive-contact ul li strong {
    display: block;
    font-weight: 600;
}
@media (max-width: 768px) {
    .cv-template.executive-board .executive-container { grid-template-columns: 1fr; }
    .cv-template.executive-board .executive-main { padding: 30px 20px; }
    .cv-template.executive-board .executive-sidebar { padding: 30px 20px; }
    .cv-template.executive-board .executive-name { font-size: 28px; }
}
</style>