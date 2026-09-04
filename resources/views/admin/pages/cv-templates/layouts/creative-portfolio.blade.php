{{-- resources/views/admin/pages/cv-templates/layouts/creative_portfolio.blade.php --}}
@props(['cvData' => [], 'template' => null])

@php
    $colors = $template->default_colors ?? ['primary' => '#f72585', 'secondary' => '#7209b7', 'accent' => '#f8e8f0', 'text' => '#1a1a1a', 'background' => '#ffffff'];
    $fonts = $template->default_fonts ?? ['heading' => 'Poppins, sans-serif', 'body' => 'Poppins, sans-serif', 'size' => '14px'];
    
    $hasEducation = isset($cvData['education']) && count($cvData['education']) > 0;
    $hasExperience = isset($cvData['experience']) && count($cvData['experience']) > 0;
    $hasSkills = isset($cvData['skills']) && count($cvData['skills']) > 0;
    $hasLanguages = isset($cvData['languages']) && count($cvData['languages']) > 0;
    $hasCertifications = isset($cvData['certifications']) && count($cvData['certifications']) > 0;
@endphp

<div class="cv-template creative-portfolio" style="
    --primary: {{ $colors['primary'] }};
    --secondary: {{ $colors['secondary'] }};
    --accent: {{ $colors['accent'] }};
    --text: {{ $colors['text'] }};
    --background: {{ $colors['background'] }};
    --font-heading: {{ $fonts['heading'] }};
    --font-body: {{ $fonts['body'] }};
    --font-size: {{ $fonts['size'] }};
">
    <div class="creative-container">
        <div class="left-panel">
            <div class="profile-section">
                <div class="profile-image-wrapper">
                    @if(isset($cvData['profile_photo']) && $cvData['profile_photo'])
                        <img src="{{ $cvData['profile_photo'] }}" alt="Profile Photo">
                    @else
                        <div class="placeholder-creative">
                            <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                    @endif
                </div>
                <h1 class="creative-name">{{ $cvData['full_name'] ?? 'John Doe' }}</h1>
                <h2 class="creative-title">{{ $cvData['title'] ?? 'Creative Developer' }}</h2>
            </div>

            <div class="info-section">
                <h3>Contact</h3>
                <div class="info-items">
                    <div class="info-item"><span class="info-label">Email</span><span>{{ $cvData['email'] ?? 'john@example.com' }}</span></div>
                    <div class="info-item"><span class="info-label">Phone</span><span>{{ $cvData['phone'] ?? '+1 234 567 890' }}</span></div>
                    <div class="info-item"><span class="info-label">Location</span><span>{{ $cvData['location'] ?? 'New York, NY' }}</span></div>
                </div>
            </div>

            @if($hasSkills)
            <div class="info-section">
                <h3>Expertise</h3>
                <div class="expertise-items">
                    @foreach($cvData['skills'] as $skill)
                        <span class="expertise-tag">{{ $skill }}</span>
                    @endforeach
                </div>
            </div>
            @endif

            @if($hasLanguages)
            <div class="info-section">
                <h3>Languages</h3>
                @foreach($cvData['languages'] as $language)
                    <div class="info-item" style="border-bottom: none;">{{ $language }}</div>
                @endforeach
            </div>
            @endif
        </div>

        <div class="right-panel">
            @if(in_array('summary', $template->sections ?? []) || in_array('executive_summary', $template->sections ?? []))
            <div class="content-section">
                <h3>About Me</h3>
                <p>{{ $cvData['summary'] ?? 'No summary provided.' }}</p>
            </div>
            @endif

            @if($hasExperience)
            <div class="content-section">
                <h3>Experience</h3>
                @foreach($cvData['experience'] as $exp)
                <div class="experience-item">
                    <div class="exp-header">
                        <h4>{{ $exp['title'] ?? '' }}</h4>
                        <span class="period">{{ $exp['period'] ?? '' }}</span>
                    </div>
                    <p class="company">{{ $exp['company'] ?? '' }}</p>
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
            <div class="content-section">
                <h3>Education</h3>
                @foreach($cvData['education'] as $edu)
                <div class="education-item">
                    <div class="edu-header">
                        <h4>{{ $edu['degree'] ?? '' }}</h4>
                        <span class="period">{{ $edu['period'] ?? '' }}</span>
                    </div>
                    <p class="institution">{{ $edu['institution'] ?? '' }}</p>
                    @if(!empty($edu['gpa']))
                        <p class="gpa">GPA: {{ $edu['gpa'] }}</p>
                    @endif
                </div>
                @endforeach
            </div>
            @endif

            @if($hasCertifications)
            <div class="content-section">
                <h3>Certifications</h3>
                @foreach($cvData['certifications'] as $cert)
                <div class="cert-item">
                    <h4>{{ $cert['name'] ?? '' }}</h4>
                    <p class="institution">{{ $cert['institution'] ?? '' }}</p>
                    <span class="period">{{ $cert['period'] ?? '' }}</span>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.cv-template.creative-portfolio {
    font-family: var(--font-body);
    font-size: var(--font-size);
    color: var(--text);
    background: var(--background);
    max-width: 1100px;
    margin: 0 auto;
    box-shadow: 0 2px 20px rgba(0,0,0,0.1);
}
.cv-template.creative-portfolio .creative-container {
    display: grid;
    grid-template-columns: 300px 1fr;
    min-height: 100vh;
}
.cv-template.creative-portfolio .left-panel {
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    padding: 40px 25px;
    color: white;
}
.cv-template.creative-portfolio .profile-image-wrapper {
    width: 180px;
    height: 180px;
    border-radius: 50%;
    overflow: hidden;
    margin: 0 auto 20px;
    border: 4px solid rgba(255,255,255,0.3);
    box-shadow: 0 4px 20px rgba(0,0,0,0.2);
}
.cv-template.creative-portfolio .profile-image-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.cv-template.creative-portfolio .placeholder-creative {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255,255,255,0.1);
}
.cv-template.creative-portfolio .creative-name {
    font-size: 28px;
    font-weight: 700;
    font-family: var(--font-heading);
    text-align: center;
}
.cv-template.creative-portfolio .creative-title {
    font-size: 16px;
    text-align: center;
    opacity: 0.9;
    margin-bottom: 30px;
}
.cv-template.creative-portfolio .info-section h3 {
    font-size: 16px;
    font-weight: 600;
    font-family: var(--font-heading);
    margin-bottom: 15px;
    border-bottom: 2px solid rgba(255,255,255,0.2);
    padding-bottom: 8px;
}
.cv-template.creative-portfolio .info-item {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    border-bottom: 1px solid rgba(255,255,255,0.1);
    font-size: 13px;
}
.cv-template.creative-portfolio .info-label { opacity: 0.7; }
.cv-template.creative-portfolio .expertise-items {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}
.cv-template.creative-portfolio .expertise-tag {
    background: rgba(255,255,255,0.15);
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
}
.cv-template.creative-portfolio .right-panel {
    padding: 40px;
}
.cv-template.creative-portfolio .content-section {
    margin-bottom: 30px;
}
.cv-template.creative-portfolio .content-section h3 {
    font-size: 18px;
    font-weight: 700;
    font-family: var(--font-heading);
    color: var(--primary);
    margin-bottom: 15px;
    border-bottom: 3px solid var(--accent);
    padding-bottom: 8px;
}
.cv-template.creative-portfolio .experience-item,
.cv-template.creative-portfolio .education-item,
.cv-template.creative-portfolio .cert-item {
    margin-bottom: 20px;
}
.cv-template.creative-portfolio .exp-header,
.cv-template.creative-portfolio .edu-header {
    display: flex;
    justify-content: space-between;
    align-items: baseline;
}
.cv-template.creative-portfolio .exp-header h4,
.cv-template.creative-portfolio .edu-header h4 {
    font-size: 16px;
    font-weight: 600;
    font-family: var(--font-heading);
}
.cv-template.creative-portfolio .period {
    font-size: 13px;
    color: #6b7280;
}
.cv-template.creative-portfolio .company,
.cv-template.creative-portfolio .institution {
    font-size: 14px;
    color: #6b7280;
    margin: 3px 0 8px;
}
.cv-template.creative-portfolio .experience-item ul {
    list-style: disc;
    padding-left: 20px;
    font-size: 14px;
    line-height: 1.6;
}
.cv-template.creative-portfolio .gpa {
    font-size: 13px;
    color: #6b7280;
    margin-top: 5px;
}
@media (max-width: 768px) {
    .cv-template.creative-portfolio .creative-container {
        grid-template-columns: 1fr;
    }
    .cv-template.creative-portfolio .profile-image-wrapper {
        width: 140px;
        height: 140px;
    }
}
</style>