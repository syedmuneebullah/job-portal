{{-- resources/views/admin/pages/cv-templates/layouts/modern_header.blade.php --}}
@props(['cvData' => [], 'template' => null])

@php
    $colors = $template->default_colors ?? ['primary' => '#00b4d8', 'secondary' => '#0077b6', 'accent' => '#f0f9ff', 'text' => '#1a1a1a', 'background' => '#ffffff'];
    $fonts = $template->default_fonts ?? ['heading' => 'Inter, sans-serif', 'body' => 'Inter, sans-serif', 'size' => '14px'];
    
    $hasEducation = isset($cvData['education']) && count($cvData['education']) > 0;
    $hasExperience = isset($cvData['experience']) && count($cvData['experience']) > 0;
    $hasSkills = isset($cvData['skills']) && count($cvData['skills']) > 0;
    $hasLanguages = isset($cvData['languages']) && count($cvData['languages']) > 0;
    $hasCertifications = isset($cvData['certifications']) && count($cvData['certifications']) > 0;
@endphp

<div class="cv-template modern-header" style="
    --primary: {{ $colors['primary'] }};
    --secondary: {{ $colors['secondary'] }};
    --accent: {{ $colors['accent'] }};
    --text: {{ $colors['text'] }};
    --background: {{ $colors['background'] }};
    --font-heading: {{ $fonts['heading'] }};
    --font-body: {{ $fonts['body'] }};
    --font-size: {{ $fonts['size'] }};
">
    <div class="hero-header">
        <div class="hero-content">
            <div class="profile-image">
                @if(isset($cvData['profile_photo']) && $cvData['profile_photo'])
                    <img src="{{ $cvData['profile_photo'] }}" alt="Profile Photo">
                @else
                    <div class="placeholder-image">
                        <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                @endif
            </div>
            <h1 class="name">{{ $cvData['full_name'] ?? 'John Doe' }}</h1>
            <h2 class="title">{{ $cvData['title'] ?? 'Software Engineer' }}</h2>
            <div class="contact-row">
                <span>{{ $cvData['email'] ?? 'john@example.com' }}</span>
                <span class="separator">|</span>
                <span>{{ $cvData['phone'] ?? '+1 234 567 890' }}</span>
                <span class="separator">|</span>
                <span>{{ $cvData['location'] ?? 'New York, NY' }}</span>
            </div>
        </div>
    </div>

    <div class="main-container">
        @if(in_array('summary', $template->sections ?? []) || in_array('executive_summary', $template->sections ?? []))
        <div class="summary-section">
            <h3>About Me</h3>
            <p>{{ $cvData['summary'] ?? 'No summary provided.' }}</p>
        </div>
        @endif

        <div class="two-column">
            <div class="left-column">
                @if($hasSkills)
                <div class="skills-section">
                    <h3>Core Skills</h3>
                    <div class="skill-tags">
                        @foreach($cvData['skills'] as $skill)
                            <span class="skill-tag">{{ $skill }}</span>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($hasLanguages)
                <div class="languages-section">
                    <h3>Languages</h3>
                    @foreach($cvData['languages'] as $language)
                        <div class="language-item">{{ $language }}</div>
                    @endforeach
                </div>
                @endif

                @if($hasCertifications)
                <div class="certifications-section">
                    <h3>Certifications</h3>
                    @foreach($cvData['certifications'] as $cert)
                        <div class="cert-item">✅ {{ $cert['name'] ?? '' }}</div>
                    @endforeach
                </div>
                @endif
            </div>

            <div class="right-column">
                @if($hasExperience)
                <div class="experience-section">
                    <h3>Work Experience</h3>
                    @foreach($cvData['experience'] as $exp)
                    <div class="experience-item">
                        <div class="exp-header">
                            <div>
                                <h4>{{ $exp['title'] ?? '' }}</h4>
                                <p class="company">{{ $exp['company'] ?? '' }}</p>
                            </div>
                            <span class="period">{{ $exp['period'] ?? '' }}</span>
                        </div>
                        @if(!empty($exp['responsibilities']) && count($exp['responsibilities']) > 0)
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
                <div class="education-section">
                    <h3>Education</h3>
                    @foreach($cvData['education'] as $edu)
                    <div class="education-item">
                        <div class="edu-header">
                            <div>
                                <h4>{{ $edu['degree'] ?? '' }}</h4>
                                <p class="institution">{{ $edu['institution'] ?? '' }}</p>
                            </div>
                            <span class="period">{{ $edu['period'] ?? '' }}</span>
                        </div>
                        @if(!empty($edu['gpa']))
                            <p class="gpa">GPA: {{ $edu['gpa'] }}</p>
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
.cv-template.modern-header {
    font-family: var(--font-body);
    font-size: var(--font-size);
    color: var(--text);
    background: var(--background);
    max-width: 1100px;
    margin: 0 auto;
    box-shadow: 0 2px 20px rgba(0,0,0,0.1);
}
.cv-template.modern-header .hero-header {
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    padding: 60px 40px 50px;
    color: white;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.cv-template.modern-header .hero-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 60%;
    height: 200%;
    background: rgba(255,255,255,0.05);
    transform: rotate(20deg);
}
.cv-template.modern-header .hero-content {
    position: relative;
    z-index: 1;
}
.cv-template.modern-header .profile-image {
    width: 130px;
    height: 130px;
    border-radius: 50%;
    overflow: hidden;
    margin: 0 auto 20px;
    border: 4px solid white;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}
.cv-template.modern-header .profile-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.cv-template.modern-header .placeholder-image {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255,255,255,0.2);
}
.cv-template.modern-header .name {
    font-size: 32px;
    font-weight: 700;
    font-family: var(--font-heading);
}
.cv-template.modern-header .title {
    font-size: 18px;
    font-weight: 400;
    opacity: 0.95;
    margin-bottom: 15px;
}
.cv-template.modern-header .contact-row {
    font-size: 14px;
    opacity: 0.9;
    display: flex;
    justify-content: center;
    gap: 10px;
    flex-wrap: wrap;
}
.cv-template.modern-header .contact-row .separator {
    opacity: 0.5;
}
.cv-template.modern-header .main-container {
    padding: 40px;
}
.cv-template.modern-header .summary-section {
    margin-bottom: 30px;
}
.cv-template.modern-header .summary-section h3 {
    font-size: 20px;
    font-weight: 700;
    font-family: var(--font-heading);
    color: var(--primary);
    margin-bottom: 10px;
}
.cv-template.modern-header .two-column {
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 40px;
}
.cv-template.modern-header .left-column h3,
.cv-template.modern-header .right-column h3 {
    font-size: 18px;
    font-weight: 700;
    font-family: var(--font-heading);
    color: var(--primary);
    margin-bottom: 15px;
    border-bottom: 3px solid var(--accent);
    padding-bottom: 8px;
}
.cv-template.modern-header .skill-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}
.cv-template.modern-header .skill-tag {
    background: var(--accent);
    color: var(--primary);
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 500;
}
.cv-template.modern-header .language-item,
.cv-template.modern-header .cert-item {
    padding: 8px 12px;
    background: #f9fafb;
    border-radius: 6px;
    font-size: 14px;
    margin-bottom: 8px;
}
.cv-template.modern-header .experience-item,
.cv-template.modern-header .education-item {
    margin-bottom: 25px;
}
.cv-template.modern-header .exp-header,
.cv-template.modern-header .edu-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}
.cv-template.modern-header .exp-header h4,
.cv-template.modern-header .edu-header h4 {
    font-size: 16px;
    font-weight: 600;
    font-family: var(--font-heading);
}
.cv-template.modern-header .company,
.cv-template.modern-header .institution {
    font-size: 14px;
    color: #6b7280;
}
.cv-template.modern-header .period {
    font-size: 13px;
    color: #9ca3af;
    font-weight: 500;
    white-space: nowrap;
    margin-left: 15px;
}
.cv-template.modern-header .experience-item ul {
    list-style: disc;
    padding-left: 20px;
    font-size: 14px;
    line-height: 1.8;
}
.cv-template.modern-header .gpa {
    font-size: 13px;
    color: #6b7280;
    margin-top: 5px;
}
@media (max-width: 768px) {
    .cv-template.modern-header .two-column {
        grid-template-columns: 1fr;
        gap: 25px;
    }
    .cv-template.modern-header .hero-header {
        padding: 40px 20px 30px;
    }
    .cv-template.modern-header .name {
        font-size: 26px;
    }
}
</style>