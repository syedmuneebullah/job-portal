{{-- resources/views/admin/pages/cv-templates/layouts/classic_professional.blade.php --}}
@props(['cvData' => [], 'template' => null])

@php
    $colors = $template->default_colors ?? ['primary' => '#1a237e', 'secondary' => '#0d1445', 'accent' => '#e8eaf6', 'text' => '#1a1a1a', 'background' => '#ffffff'];
    $fonts = $template->default_fonts ?? ['heading' => 'Georgia, serif', 'body' => 'Arial, sans-serif', 'size' => '14px'];
    
    // Check if data exists
    $hasEducation = isset($cvData['education']) && count($cvData['education']) > 0;
    $hasExperience = isset($cvData['experience']) && count($cvData['experience']) > 0;
    $hasSkills = isset($cvData['skills']) && count($cvData['skills']) > 0;
    $hasLanguages = isset($cvData['languages']) && count($cvData['languages']) > 0;
    $hasCertifications = isset($cvData['certifications']) && count($cvData['certifications']) > 0;
    $hasInterests = isset($cvData['interests']) && count($cvData['interests']) > 0;
@endphp

<div class="cv-template classic-professional" style="
    --primary: {{ $colors['primary'] }};
    --secondary: {{ $colors['secondary'] }};
    --accent: {{ $colors['accent'] }};
    --text: {{ $colors['text'] }};
    --background: {{ $colors['background'] }};
    --font-heading: {{ $fonts['heading'] }};
    --font-body: {{ $fonts['body'] }};
    --font-size: {{ $fonts['size'] }};
">
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="profile-photo">
                @if(isset($cvData['profile_photo']) && $cvData['profile_photo'])
                    <img src="{{ $cvData['profile_photo'] }}" alt="Profile Photo">
                @else
                    <div class="placeholder-photo">
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                @endif
            </div>

            <div class="personal-info">
                <h1 class="name">{{ $cvData['full_name'] ?? 'John Doe' }}</h1>
                <h2 class="title">{{ $cvData['title'] ?? 'Software Engineer' }}</h2>
                
                <div class="contact-info">
                    <p>📧 {{ $cvData['email'] ?? 'john@example.com' }}</p>
                    <p>📱 {{ $cvData['phone'] ?? '+1 234 567 890' }}</p>
                    <p>📍 {{ $cvData['location'] ?? 'New York, NY' }}</p>
                </div>
            </div>

            @if($hasSkills)
            <div class="skills-section">
                <h3>Skills</h3>
                <div class="skills-list">
                    @foreach($cvData['skills'] as $skill)
                        <div class="skill-item">
                            <span>{{ $skill }}</span>
                            <div class="skill-bar"><div class="skill-progress" style="width: 85%"></div></div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            @if($hasLanguages)
            <div class="languages-section">
                <h3>Languages</h3>
                <div class="languages-list">
                    @foreach($cvData['languages'] as $language)
                        <p>{{ $language }}</p>
                    @endforeach
                </div>
            </div>
            @endif

            @if($hasInterests)
            <div class="interests-section">
                <h3>Interests</h3>
                <div class="interests-list">
                    @foreach($cvData['interests'] as $interest)
                        <p>{{ $interest }}</p>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Main Content -->
        <div class="main-content">
            @if(in_array('summary', $template->sections ?? []) || in_array('executive_summary', $template->sections ?? []))
            <div class="summary-section">
                <h3>Professional Summary</h3>
                <p>{{ $cvData['summary'] ?? 'No summary provided.' }}</p>
            </div>
            @endif

            @if($hasExperience)
            <div class="experience-section">
                <h3>Work Experience</h3>
                @foreach($cvData['experience'] as $exp)
                <div class="experience-item">
                    <div class="exp-header">
                        <h4>{{ $exp['title'] ?? '' }}</h4>
                        <span>{{ $exp['period'] ?? '' }}</span>
                    </div>
                    <p class="company">{{ $exp['company'] ?? '' }}</p>
                    @if(!empty($exp['responsibilities']) && count($exp['responsibilities']) > 0)
                    <ul>
                        @foreach($exp['responsibilities'] as $responsibility)
                            @if(!empty($responsibility))
                            <li>{{ $responsibility }}</li>
                            @endif
                        @endforeach
                    </ul>
                    @endif
                    @if(!empty($exp['description']))
                    <p class="description">{{ $exp['description'] }}</p>
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
                        <h4>{{ $edu['degree'] ?? '' }}</h4>
                        <span>{{ $edu['period'] ?? '' }}</span>
                    </div>
                    <p class="institution">{{ $edu['institution'] ?? '' }}</p>
                    @if(!empty($edu['gpa']))
                        <p class="gpa">GPA: {{ $edu['gpa'] }}</p>
                    @endif
                    @if(!empty($edu['description']))
                        <p class="description">{{ $edu['description'] }}</p>
                    @endif
                </div>
                @endforeach
            </div>
            @endif

            @if($hasCertifications)
            <div class="certifications-section">
                <h3>Certifications</h3>
                @foreach($cvData['certifications'] as $cert)
                <div class="certification-item">
                    <h4>{{ $cert['name'] ?? '' }}</h4>
                    <p class="institution">{{ $cert['institution'] ?? '' }}</p>
                    <span class="period">{{ $cert['period'] ?? '' }}</span>
                    @if(!empty($cert['description']))
                        <p class="description">{{ $cert['description'] }}</p>
                    @endif
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.cv-template.classic-professional {
    font-family: var(--font-body);
    font-size: var(--font-size);
    color: var(--text);
    background: var(--background);
    max-width: 1100px;
    margin: 0 auto;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}
.cv-template.classic-professional .container {
    display: grid;
    grid-template-columns: 280px 1fr;
    min-height: 100vh;
}
.cv-template.classic-professional .sidebar {
    background: var(--primary);
    color: white;
    padding: 40px 25px;
}
.cv-template.classic-professional .profile-photo {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    overflow: hidden;
    margin: 0 auto 25px;
    border: 4px solid white;
}
.cv-template.classic-professional .profile-photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.cv-template.classic-professional .placeholder-photo {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255,255,255,0.2);
}
.cv-template.classic-professional .name {
    font-size: 24px;
    font-weight: bold;
    font-family: var(--font-heading);
    text-align: center;
}
.cv-template.classic-professional .title {
    font-size: 16px;
    text-align: center;
    opacity: 0.9;
    margin-bottom: 20px;
}
.cv-template.classic-professional .contact-info p {
    font-size: 13px;
    margin-bottom: 8px;
}
.cv-template.classic-professional .sidebar h3 {
    font-size: 16px;
    font-weight: bold;
    font-family: var(--font-heading);
    margin: 25px 0 15px;
    border-bottom: 2px solid rgba(255,255,255,0.3);
    padding-bottom: 8px;
}
.cv-template.classic-professional .skills-list .skill-item {
    margin-bottom: 10px;
}
.cv-template.classic-professional .skills-list .skill-item span {
    display: block;
    font-size: 13px;
    margin-bottom: 3px;
}
.cv-template.classic-professional .skill-bar {
    width: 100%;
    height: 6px;
    background: rgba(255,255,255,0.2);
    border-radius: 3px;
    overflow: hidden;
}
.cv-template.classic-professional .skill-progress {
    height: 100%;
    background: white;
    border-radius: 3px;
}
.cv-template.classic-professional .languages-list p,
.cv-template.classic-professional .interests-list p {
    font-size: 13px;
    margin-bottom: 5px;
}
.cv-template.classic-professional .main-content {
    padding: 40px;
}
.cv-template.classic-professional .main-content h3 {
    font-size: 18px;
    font-family: var(--font-heading);
    color: var(--primary);
    font-weight: bold;
    margin-bottom: 12px;
    border-bottom: 2px solid var(--accent);
    padding-bottom: 8px;
}
.cv-template.classic-professional .summary-section p {
    font-size: 14px;
    line-height: 1.6;
}
.cv-template.classic-professional .experience-item,
.cv-template.classic-professional .education-item,
.cv-template.classic-professional .certification-item {
    margin-bottom: 20px;
}
.cv-template.classic-professional .exp-header,
.cv-template.classic-professional .edu-header {
    display: flex;
    justify-content: space-between;
    align-items: baseline;
}
.cv-template.classic-professional .exp-header h4,
.cv-template.classic-professional .edu-header h4 {
    font-size: 16px;
    font-weight: 600;
    font-family: var(--font-heading);
}
.cv-template.classic-professional .exp-header span,
.cv-template.classic-professional .edu-header span,
.cv-template.classic-professional .certification-item .period {
    font-size: 13px;
    color: #6b7280;
}
.cv-template.classic-professional .company,
.cv-template.classic-professional .institution {
    font-size: 14px;
    color: #6b7280;
    margin: 3px 0 8px;
}
.cv-template.classic-professional .experience-item ul {
    list-style: disc;
    padding-left: 20px;
    font-size: 14px;
    line-height: 1.6;
}
.cv-template.classic-professional .description,
.cv-template.classic-professional .gpa {
    font-size: 14px;
    color: #4b5563;
    margin-top: 5px;
}
@media (max-width: 768px) {
    .cv-template.classic-professional .container {
        grid-template-columns: 1fr;
    }
}
</style>