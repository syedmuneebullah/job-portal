<?php
// app/Http/Controllers/Admin/CvTemplateController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CvTemplate;
use App\Models\CvTemplateColor;
use App\Models\CvTemplateSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CvTemplateController extends Controller
{
    public function index()
    {
        $templates = CvTemplate::withCount(['templateSections'])->paginate(15);
        return view('admin.pages.cv-templates.index', compact('templates'));
    }

    public function create()
    {
        $categories = ['professional', 'modern', 'creative', 'minimalist', 'executive'];
        $styles = ['classic', 'modern', 'creative', 'compact', 'detailed'];
        $layoutTypes = CvTemplate::getLayoutTypes();
        $availableSections = $this->getAvailableSections();
        
        return view('admin.pages.cv-templates.create', compact('categories', 'styles', 'layoutTypes', 'availableSections'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|in:professional,modern,creative,minimalist,executive',
            'style' => 'required|string|in:classic,modern,creative,compact,detailed',
            'layout_type' => 'required|string|in:classic_professional,modern_header,creative_portfolio,minimal_clean,executive_board,tech_innovator',
            'description' => 'nullable|string',
            'is_premium' => 'boolean',
            'sections' => 'required|array|min:1',
            'sections.*' => 'string',
            'primary_color' => 'required|string',
            'secondary_color' => 'required|string',
            'accent_color' => 'required|string',
            'text_color' => 'required|string',
            'background_color' => 'required|string',
            'heading_font' => 'required|string',
            'body_font' => 'required|string',
            'font_size' => 'required|string',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $validated['is_active'] = true;
        $validated['is_default'] = $request->has('is_default');
        $validated['slug'] = Str::slug($validated['name']);
        
        $validated['default_colors'] = [
            'primary' => $validated['primary_color'],
            'secondary' => $validated['secondary_color'],
            'accent' => $validated['accent_color'],
            'text' => $validated['text_color'],
            'background' => $validated['background_color'],
        ];
        
        unset($validated['primary_color'], $validated['secondary_color'], $validated['accent_color']);
        unset($validated['text_color'], $validated['background_color']);
        
        $validated['default_fonts'] = [
            'heading' => $validated['heading_font'],
            'body' => $validated['body_font'],
            'size' => $validated['font_size'],
        ];
        
        unset($validated['heading_font'], $validated['body_font'], $validated['font_size']);

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('cv-templates', 'public');
            $validated['thumbnail'] = $path;
        }

        // Set default layout config based on layout type
        $validated['layout_config'] = $this->getDefaultLayoutConfig($validated['layout_type']);

        $template = CvTemplate::create($validated);

        // Create default color scheme
        CvTemplateColor::create([
            'cv_template_id' => $template->id,
            'name' => 'Default',
            'primary_color' => $validated['default_colors']['primary'],
            'secondary_color' => $validated['default_colors']['secondary'],
            'accent_color' => $validated['default_colors']['accent'],
            'text_color' => $validated['default_colors']['text'],
            'background_color' => $validated['default_colors']['background'],
            'is_default' => true,
        ]);

        // Create sections
        foreach ($request->sections as $index => $sectionKey) {
            CvTemplateSection::create([
                'cv_template_id' => $template->id,
                'section_key' => $sectionKey,
                'section_name' => ucfirst(str_replace('_', ' ', $sectionKey)),
                'order' => $index + 1,
                'is_enabled' => true,
                'is_required' => in_array($sectionKey, ['personal_info', 'experience', 'education']),
            ]);
        }

        return redirect()->route('admin.cv-templates.index')
            ->with('success', 'Template created successfully!');
    }

    /**
     * Display the specified template.
     *
     * @param  \App\Models\CvTemplate  $cvTemplate
     * @return \Illuminate\View\View
     */
    public function show(CvTemplate $cvTemplate)
    {
        $cvTemplate->load(['templateSections', 'colors']);
        return view('admin.pages.cv-templates.show', compact('cvTemplate'));
    }

    public function edit(CvTemplate $cvTemplate)
    {
        $categories = ['professional', 'modern', 'creative', 'minimalist', 'executive'];
        $styles = ['classic', 'modern', 'creative', 'compact', 'detailed'];
        $layoutTypes = CvTemplate::getLayoutTypes();
        $availableSections = $this->getAvailableSections();
        
        return view('admin.pages.cv-templates.edit', compact('cvTemplate', 'categories', 'styles', 'layoutTypes', 'availableSections'));
    }

    public function update(Request $request, CvTemplate $cvTemplate)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|in:professional,modern,creative,minimalist,executive',
            'style' => 'required|string|in:classic,modern,creative,compact,detailed',
            'layout_type' => 'required|string|in:classic_professional,modern_header,creative_portfolio,minimal_clean,executive_board,tech_innovator',
            'description' => 'nullable|string',
            'is_premium' => 'boolean',
            'is_active' => 'boolean',
            'sections' => 'required|array|min:1',
            'sections.*' => 'string',
            'primary_color' => 'required|string',
            'secondary_color' => 'required|string',
            'accent_color' => 'required|string',
            'text_color' => 'required|string',
            'background_color' => 'required|string',
            'heading_font' => 'required|string',
            'body_font' => 'required|string',
            'font_size' => 'required|string',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $validated['is_default'] = $request->has('is_default');
        $validated['slug'] = Str::slug($validated['name']);
        
        $validated['default_colors'] = [
            'primary' => $validated['primary_color'],
            'secondary' => $validated['secondary_color'],
            'accent' => $validated['accent_color'],
            'text' => $validated['text_color'],
            'background' => $validated['background_color'],
        ];
        
        unset($validated['primary_color'], $validated['secondary_color'], $validated['accent_color']);
        unset($validated['text_color'], $validated['background_color']);
        
        $validated['default_fonts'] = [
            'heading' => $validated['heading_font'],
            'body' => $validated['body_font'],
            'size' => $validated['font_size'],
        ];
        
        unset($validated['heading_font'], $validated['body_font'], $validated['font_size']);

        if ($request->hasFile('thumbnail')) {
            if ($cvTemplate->thumbnail) {
                Storage::disk('public')->delete($cvTemplate->thumbnail);
            }
            $path = $request->file('thumbnail')->store('cv-templates', 'public');
            $validated['thumbnail'] = $path;
        }

        // Update layout config if layout type changed
        if ($request->layout_type != $cvTemplate->layout_type) {
            $validated['layout_config'] = $this->getDefaultLayoutConfig($request->layout_type);
        }

        $cvTemplate->update($validated);

        // Update sections
        $cvTemplate->templateSections()->delete();
        foreach ($request->sections as $index => $sectionKey) {
            CvTemplateSection::create([
                'cv_template_id' => $cvTemplate->id,
                'section_key' => $sectionKey,
                'section_name' => ucfirst(str_replace('_', ' ', $sectionKey)),
                'order' => $index + 1,
                'is_enabled' => true,
                'is_required' => in_array($sectionKey, ['personal_info', 'experience', 'education']),
            ]);
        }

        return redirect()->route('admin.cv-templates.index')
            ->with('success', 'Template updated successfully!');
    }

    public function destroy(CvTemplate $cvTemplate)
    {
        if ($cvTemplate->thumbnail) {
            Storage::disk('public')->delete($cvTemplate->thumbnail);
        }
        $cvTemplate->delete();
        
        return redirect()->route('admin.cv-templates.index')
            ->with('success', 'Template deleted successfully!');
    }

    /**
     * Preview the template (Admin preview)
     *
     * @param  \App\Models\CvTemplate  $cvTemplate
     * @return \Illuminate\View\View
     */
    public function preview(CvTemplate $cvTemplate)
    {
        $cvTemplate->load(['templateSections', 'colors']);
        
        // Check if layout view exists
        $layoutView = $cvTemplate->layout_view;
        if (!view()->exists($layoutView)) {
            // Fallback to default preview
            return view('admin.pages.cv-templates.preview', compact('cvTemplate'));
        }
        
        // Render the actual template with sample data
        $sampleData = $this->getSampleCVData();
        $renderedCV = $cvTemplate->render($sampleData);
        
        return view('admin.pages.cv-templates.preview', compact('cvTemplate', 'renderedCV'));
    }

    /**
     * Get sample CV data for preview
     */
    private function getSampleCVData()
    {
        return [
            'full_name' => 'John Doe',
            'title' => 'Senior Software Engineer',
            'email' => 'john.doe@email.com',
            'phone' => '+1 234 567 890',
            'location' => 'New York, NY',
            'website' => 'www.johndoe.com',
            'profile_photo' => null,
            'summary' => 'Experienced software engineer with 8+ years of expertise in full-stack development. Passionate about building scalable applications, mentoring junior developers, and driving technical innovation.',
            'executive_summary' => 'Strategic technology leader with a proven track record of delivering complex software solutions. Expertise in leading cross-functional teams and driving digital transformation.',
            'experience' => [
                [
                    'company' => 'TechCorp Inc.',
                    'title' => 'Senior Software Engineer',
                    'period' => '2020 - Present',
                    'responsibilities' => [
                        'Led a team of 12 developers on a major product redesign',
                        'Improved application performance by 45% through optimization',
                        'Implemented CI/CD pipeline reducing deployment time by 70%',
                        'Mentored 5 junior developers and conducted code reviews'
                    ]
                ],
                [
                    'company' => 'StartupXYZ',
                    'title' => 'Software Engineer',
                    'period' => '2018 - 2020',
                    'responsibilities' => [
                        'Developed microservices architecture for payment processing',
                        'Reduced API response time by 60% through caching strategies',
                        'Designed and implemented database schemas for 10+ services'
                    ]
                ],
                [
                    'company' => 'Innovation Labs',
                    'title' => 'Junior Developer',
                    'period' => '2016 - 2018',
                    'responsibilities' => [
                        'Built and maintained React-based web applications',
                        'Collaborated with design team on UI/UX improvements',
                        'Wrote unit tests and participated in agile ceremonies'
                    ]
                ]
            ],
            'education' => [
                [
                    'institution' => 'Stanford University',
                    'degree' => 'Master of Science in Computer Science',
                    'period' => '2014 - 2016',
                    'gpa' => '3.9/4.0'
                ],
                [
                    'institution' => 'MIT',
                    'degree' => 'Bachelor of Science in Software Engineering',
                    'period' => '2010 - 2014',
                    'gpa' => '3.8/4.0'
                ]
            ],
            'skills' => [
                'JavaScript', 'TypeScript', 'React', 'Next.js', 'Node.js',
                'Python', 'Django', 'AWS', 'Docker', 'Kubernetes',
                'PostgreSQL', 'MongoDB', 'Redis', 'Git', 'CI/CD'
            ],
            'projects' => [
                [
                    'name' => 'E-Commerce Platform',
                    'description' => 'Full-stack e-commerce platform with React, Node.js, and MongoDB',
                    'technologies' => ['React', 'Node.js', 'MongoDB', 'Redis']
                ],
                [
                    'name' => 'Real-time Analytics Dashboard',
                    'description' => 'Real-time analytics dashboard with WebSocket integration',
                    'technologies' => ['React', 'D3.js', 'WebSocket', 'Python']
                ]
            ],
            'certifications' => [
                'AWS Certified Solutions Architect - Professional',
                'Google Professional Cloud Architect',
                'Microsoft Certified: Azure Developer Associate'
            ],
            'languages' => [
                'English (Native)',
                'Spanish (Fluent)',
                'French (Intermediate)'
            ],
            'achievements' => [
                'Best Employee Award 2022',
                'Tech Innovation Award 2021',
                'Published 5 technical articles on Medium'
            ],
            'references' => [
                [
                    'name' => 'Dr. Sarah Johnson',
                    'title' => 'CTO, TechCorp Inc.',
                    'email' => 'sarah.johnson@techcorp.com',
                    'phone' => '+1 234 567 891'
                ],
                [
                    'name' => 'Prof. Michael Chen',
                    'title' => 'Professor, Stanford University',
                    'email' => 'michael.chen@stanford.edu',
                    'phone' => '+1 234 567 892'
                ]
            ]
        ];
    }

    /**
     * Get default layout configuration
     */
    private function getDefaultLayoutConfig($layoutType)
    {
        $configs = [
            'classic_professional' => [
                'sidebar_position' => 'left',
                'show_photo' => true,
                'photo_style' => 'circle',
                'show_contact' => true,
                'show_skills' => true,
                'show_languages' => true,
                'skill_style' => 'bar',
                'header_style' => 'standard',
            ],
            'modern_header' => [
                'sidebar_position' => 'none',
                'show_photo' => true,
                'photo_style' => 'circle',
                'show_contact' => true,
                'show_skills' => true,
                'show_languages' => true,
                'skill_style' => 'tags',
                'header_style' => 'hero',
                'show_hero_background' => true,
            ],
            'creative_portfolio' => [
                'sidebar_position' => 'left',
                'show_photo' => true,
                'photo_style' => 'rounded',
                'show_contact' => true,
                'show_skills' => true,
                'show_languages' => true,
                'skill_style' => 'tags',
                'header_style' => 'minimal',
                'show_portfolio' => true,
            ],
            'minimal_clean' => [
                'sidebar_position' => 'none',
                'show_photo' => false,
                'show_contact' => true,
                'show_skills' => true,
                'show_languages' => true,
                'skill_style' => 'list',
                'header_style' => 'minimal',
                'two_column' => true,
            ],
            'executive_board' => [
                'sidebar_position' => 'right',
                'show_photo' => true,
                'photo_style' => 'square',
                'show_contact' => true,
                'show_skills' => true,
                'show_languages' => true,
                'skill_style' => 'list',
                'header_style' => 'executive',
                'show_achievements' => true,
                'show_references' => true,
            ],
            'tech_innovator' => [
                'sidebar_position' => 'none',
                'show_photo' => true,
                'photo_style' => 'circle',
                'show_contact' => true,
                'show_skills' => true,
                'show_languages' => true,
                'skill_style' => 'tags',
                'header_style' => 'tech',
                'show_certifications' => true,
                'show_projects' => true,
            ],
        ];

        return $configs[$layoutType] ?? $configs['classic_professional'];
    }

    /**
     * Get available sections for CV templates.
     *
     * @return array
     */
    private function getAvailableSections()
    {
        return [
            'personal_info' => 'Personal Information',
            'summary' => 'Professional Summary',
            'executive_summary' => 'Executive Summary',
            'experience' => 'Work Experience',
            'education' => 'Education',
            'skills' => 'Skills',
            'projects' => 'Projects',
            'portfolio' => 'Portfolio',
            'achievements' => 'Achievements',
            'languages' => 'Languages',
            'certifications' => 'Certifications',
            'references' => 'References',
            'interests' => 'Interests',
            'volunteering' => 'Volunteering',
            'publications' => 'Publications',
            'awards' => 'Awards',
        ];
    }
}