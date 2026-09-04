{{-- resources/views/admin/pages/cv-templates/layouts/tech_innovator.blade.php --}}
@props(['cvData' => [], 'template' => null])

@php
    $colors = $template->default_colors ?? ['primary' => '#6c63ff', 'secondary' => '#3f3d9e', 'accent' => '#eef1ff', 'text' => '#1a1a1a', 'background' => '#ffffff'];
    $fonts = $template->default_fonts ?? ['heading' => 'Space Grotesk, sans-serif', 'body' => 'Space Grotesk, sans-serif', 'size' => '14px'];
    
    $hasEducation = isset($cvData['education']) && count($cvData['education']) > 0;
    $hasExperience = isset($cvData['experience']) && count($cvData['experience']) > 0;
    $hasSkills = isset($cvData['skills']) && count($cvData['skills']) > 0;
    $hasLanguages = isset($cvData['languages']) && count($cvData['languages']) > 0;
    $hasCertifications = isset($cvData['certifications']) && count($cvData['certifications']) > 0;
@endphp

<div class="cv-template tech-innovator" style="
    --primary: {{ $colors['primary'] }};
    --secondary: {{ $colors['secondary'] }};
    --accent: {{ $colors['accent'] }};
    --text: {{ $colors['text'] }};
    --background: {{ $colors['background'] }};
    --font-heading: {{ $fonts['heading'] }};
    --font-body: {{ $fonts['body'] }};
    --font-size: {{ $fonts['size'] }};
">
    <div class="tech-container">
        <div class="tech-header">
            <div class="tech-header-content">
                <div class="tech-profile">
                    @if(isset($cvData['profile_photo']) && $cvData['profile_photo'])
                        <img src="{{ $cvData['profile_photo'] }}" alt="Profile Photo">
                    @else
                        <div class="tech-placeholder">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="tech-title">
                    <h1 class="tech-name">{{ $cvData['full_name'] ?? 'John Doe' }}</h1>
                    <h2 class="tech-subtitle">{{ $cvData['title'] ?? 'Innovation Engineer' }}</h2>
                    <div class="tech-tags">
                        <span class="tech-tag">{{ $cvData['location'] ?? 'Remote' }}</span>
                        <span class="tech-tag">{{ $cvData['email'] ?? 'john@example.com' }}</span>
                        <span class="tech-tag">{{ $cvData['phone'] ?? '+1 234 567 890' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="tech-body">
            <div class="tech-grid">
                <div class="tech-sidebar">
                    @if($hasSkills)
                    <div class="tech-section">
                        <h3 class="tech-section-title">⚡ Tech Stack</h3>
                        <div class="tech-skills">
                            @foreach($cvData['skills'] as $skill)
                                <span class="tech-skill">{{ $skill }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($hasCertifications)
                    <div class="tech-section">
                        <h3 class="tech-section-title">📜 Certifications</h3>
                        <div class="tech-cert-list">
                            @foreach($cvData['certifications'] as $cert)
                                <div class="tech-cert">{{ $cert['name'] ?? '' }}</div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($hasLanguages)
                    <div class="tech-section">
                        <h3 class="tech-section-title">🌐 Languages</h3>
                        <div class="tech-lang-list">
                            @foreach($cvData['languages'] as $lang)
                                <div class="tech-lang">{{ $lang }}</div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <div class="tech-content">
                    @if(in_array('summary', $template->sections ?? []) || in_array('executive_summary', $template->sections ?? []))
                    <div class="tech-section">
                        <h3 class="tech-section-title">🚀 About</h3>
                        <p class="tech-text">{{ $cvData['summary'] ?? 'No summary provided.' }}</p>
                    </div>
                    @endif

                    @if($hasExperience)
                    <div class="tech-section">
                        <h3 class="tech-section-title">💼 Experience</h3>
                        @foreach($cvData['experience'] as $exp)
                        <div class="tech-exp-item">
                            <div class="tech-exp-header">
                                <div>
                                    <h4>{{ $exp['title'] ?? '' }}</h4>
                                    <p class="tech-company">{{ $exp['company'] ?? '' }}</p>
                                </div>
                                <span class="tech-period">{{ $exp['period'] ?? '' }}</span>
                            </div>
                            @if(!empty($exp['responsibilities']))
                            <ul class="tech-list">
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
                    <div class="tech-section">
                        <h3 class="tech-section-title">🎓 Education</h3>
                        @foreach($cvData['education'] as $edu)
                        <div class="tech-edu-item">
                            <div class="tech-exp-header">
                                <div>
                                    <h4>{{ $edu['degree'] ?? '' }}</h4>
                                    <p class="tech-company">{{ $edu['institution'] ?? '' }}</p>
                                </div>
                                <span class="tech-period">{{ $edu['period'] ?? '' }}</span>
                            </div>
                            @if(!empty($edu['gpa']))
                                <p style="font-size: 13px; color: #6b7280; margin-top: 3px;">GPA: {{ $edu['gpa'] }}</p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.cv-template.tech-innovator {
    font-family: var(--font-body);
    font-size: var(--font-size);
    color: var(--text);
    background: var(--background);
    max-width: 1100px;
    margin: 0 auto;
    box-shadow: 0 2px 20px rgba(0,0,0,0.1);
}
.cv-template.tech-innovator .tech-header {
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    padding: 40px 50px;
    color: white;
}
.cv-template.tech-innovator .tech-header-content {
    display: flex;
    align-items: center;
    gap: 30px;
}
.cv-template.tech-innovator .tech-profile {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    overflow: hidden;
    border: 3px solid rgba(255,255,255,0.3);
    flex-shrink: 0;
}
.cv-template.tech-innovator .tech-profile img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.cv-template.tech-innovator .tech-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255,255,255,0.1);
}
.cv-template.tech-innovator .tech-name {
    font-size: 32px;
    font-weight: 700;
    font-family: var(--font-heading);
    margin: 0;
}
.cv-template.tech-innovator .tech-subtitle {
    font-size: 16px;
    font-weight: 400;
    opacity: 0.9;
    margin: 5px 0 10px;
}
.cv-template.tech-innovator .tech-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}
.cv-template.tech-innovator .tech-tag {
    background: rgba(255,255,255,0.15);
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
}
.cv-template.tech-innovator .tech-body { padding: 40px 50px; }
.cv-template.tech-innovator .tech-grid {
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 40px;
}
.cv-template.tech-innovator .tech-section-title {
    font-size: 16px;
    font-weight: 600;
    font-family: var(--font-heading);
    color: var(--primary);
    margin-bottom: 15px;
    padding-bottom: 8px;
    border-bottom: 2px solid var(--accent);
}
.cv-template.tech-innovator .tech-skills {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}
.cv-template.tech-innovator .tech-skill {
    background: var(--accent);
    color: var(--primary);
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 500;
}
.cv-template.tech-innovator .tech-text { line-height: 1.8; font-size: 14px; }
.cv-template.tech-innovator .tech-exp-item,
.cv-template.tech-innovator .tech-edu-item { margin-bottom: 20px; }
.cv-template.tech-innovator .tech-exp-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}
.cv-template.tech-innovator .tech-exp-header h4 {
    font-size: 16px;
    font-weight: 600;
    font-family: var(--font-heading);
    margin: 0;
}
.cv-template.tech-innovator .tech-company {
    font-size: 14px;
    color: #6b7280;
    margin: 2px 0;
}
.cv-template.tech-innovator .tech-period {
    font-size: 13px;
    color: #9ca3af;
    font-weight: 500;
    white-space: nowrap;
    margin-left: 15px;
}
.cv-template.tech-innovator .tech-list {
    list-style: none;
    padding: 0;
    margin: 8px 0 0;
}
.cv-template.tech-innovator .tech-list li {
    padding: 4px 0;
    font-size: 14px;
    color: #4b5563;
}
.cv-template.tech-innovator .tech-list li::before {
    content: "▹ ";
    color: var(--primary);
}
.cv-template.tech-innovator .tech-cert,
.cv-template.tech-innovator .tech-lang {
    padding: 6px 0;
    border-bottom: 1px solid var(--accent);
    font-size: 14px;
}
@media (max-width: 768px) {
    .cv-template.tech-innovator .tech-header { padding: 30px 20px; }
    .cv-template.tech-innovator .tech-header-content {
        flex-direction: column;
        text-align: center;
    }
    .cv-template.tech-innovator .tech-body { padding: 30px 20px; }
    .cv-template.tech-innovator .tech-grid { grid-template-columns: 1fr; gap: 25px; }
    .cv-template.tech-innovator .tech-name { font-size: 26px; }
    .cv-template.tech-innovator .tech-tags { justify-content: center; }
}
</style>