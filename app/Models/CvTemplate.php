<?php
// app/Models/CvTemplate.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class CvTemplate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'thumbnail',
        'description',
        'design_config',
        'structure',
        'styling',
        'category',
        'style',
        'layout_type',
        'layout_view_path',
        'layout_config',
        'default_colors',
        'default_fonts',
        'sections',
        'is_active',
        'is_premium',
        'is_default',
        'usage_count',
        'download_count',
        'preview_view',
        'template_view',
    ];

    protected $casts = [
        'design_config' => 'array',
        'structure' => 'array',
        'styling' => 'array',
        'default_colors' => 'array',
        'default_fonts' => 'array',
        'sections' => 'array',
        'layout_config' => 'array',
        'is_active' => 'boolean',
        'is_premium' => 'boolean',
        'is_default' => 'boolean',
        'usage_count' => 'integer',
        'download_count' => 'integer',
    ];

    /**
     * Boot method to handle model events
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($template) {
            if (empty($template->slug)) {
                $template->slug = Str::slug($template->name);
            }
            
            // Set default layout if not set
            if (empty($template->layout_type)) {
                $template->layout_type = 'classic_professional';
            }
            
            // If this template is set as default, remove default flag from others
            if ($template->is_default) {
                static::where('is_default', true)->update(['is_default' => false]);
            }
        });

        static::updating(function ($template) {
            if ($template->is_default) {
                static::where('is_default', true)
                    ->where('id', '!=', $template->id)
                    ->update(['is_default' => false]);
            }
        });
    }

    /**
     * Get the template sections relationship
     */
    public function templateSections()
    {
        return $this->hasMany(CvTemplateSection::class, 'cv_template_id')->orderBy('order');
    }

    /**
     * Get the template color schemes relationship
     */
    public function colors()
    {
        return $this->hasMany(CvTemplateColor::class);
    }

    /**
     * Get the default color scheme
     */
    public function getDefaultColorAttribute()
    {
        return $this->colors()->where('is_default', true)->first();
    }

    /**
     * Get the layout view path
     * FIXED: Using admin.pages.cv-templates.layouts path
     */
    public function getLayoutViewAttribute()
    {
        if ($this->layout_view_path) {
            return $this->layout_view_path;
        }
        
        // Map layout types to view paths
        // YOUR VIEWS ARE IN: admin.pages.cv-templates.layouts
        $layoutMap = [
            'classic_professional' => 'admin.pages.cv-templates.layouts.classic-professional',
            'modern_header' => 'admin.pages.cv-templates.layouts.modern-header',
            'creative_portfolio' => 'admin.pages.cv-templates.layouts.creative-portfolio',
            'minimal_clean' => 'admin.pages.cv-templates.layouts.minimal-clean',
            'executive_board' => 'admin.pages.cv-templates.layouts.executive-board',
            'tech_innovator' => 'admin.pages.cv-templates.layouts.tech-innovator',
        ];
        
        return $layoutMap[$this->layout_type] ?? 'admin.pages.cv-templates.layouts.classic_professional';
    }

    /**
     * Get available layout types
     */
    public static function getLayoutTypes()
    {
        return [
            'classic_professional' => 'Classic Professional (Left Sidebar)',
            'modern_header' => 'Modern Header (Hero Style)',
            'creative_portfolio' => 'Creative Portfolio (Grid Style)',
            'minimal_clean' => 'Minimal Clean (Two Column)',
            'executive_board' => 'Executive Board (Leadership Focus)',
            'tech_innovator' => 'Tech Innovator (Tech Focus)',
        ];
    }

    /**
     * Get layout configuration
     */
    public function getLayoutConfigAttribute($value)
    {
        $defaultConfig = $this->getDefaultLayoutConfig();
        $savedConfig = $value ? json_decode($value, true) : [];
        return array_merge($defaultConfig, $savedConfig);
    }

    /**
     * Get default layout configuration based on layout type
     */
    private function getDefaultLayoutConfig()
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

        return $configs[$this->layout_type] ?? $configs['classic_professional'];
    }

    /**
     * Scope for active templates
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for free templates
     */
    public function scopeFree($query)
    {
        return $query->where('is_premium', false);
    }

    /**
     * Scope for premium templates
     */
    public function scopePremium($query)
    {
        return $query->where('is_premium', true);
    }

    /**
     * Scope for default template
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    /**
     * Scope by category
     */
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope by layout type
     */
    public function scopeLayout($query, $layoutType)
    {
        return $query->where('layout_type', $layoutType);
    }

    /**
     * Get the template preview URL
     */
    public function getPreviewUrlAttribute()
    {
        return route('admin.cv-templates.preview', $this);
    }

    /**
     * Get the template thumbnail URL
     */
    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail) {
            return asset('storage/' . $this->thumbnail);
        }
        return asset('images/templates/default-' . $this->category . '.jpg');
    }

    /**
     * Increment usage count
     */
    public function incrementUsage()
    {
        $this->increment('usage_count');
    }

    /**
     * Increment download count
     */
    public function incrementDownloads()
    {
        $this->increment('download_count');
    }

    /**
     * Check if template has a specific section
     */
    public function hasSection($sectionKey)
    {
        if ($this->sections) {
            return in_array($sectionKey, $this->sections);
        }
        return false;
    }

    /**
     * Get template sections as a formatted array
     */
    public function getSectionsListAttribute()
    {
        $sections = [];
        $availableSections = $this->sections ?: config('cv.default_sections', []);
        
        foreach ($availableSections as $sectionKey) {
            $sections[] = [
                'key' => $sectionKey,
                'name' => ucfirst(str_replace('_', ' ', $sectionKey)),
                'enabled' => true,
            ];
        }
        
        return $sections;
    }

    /**
     * Get CSS variables for template styling
     */
    public function getCssVariablesAttribute()
    {
        $colors = $this->default_colors ?? [
            'primary' => '#1a237e',
            'secondary' => '#0d1445',
            'accent' => '#f5f5f5',
            'text' => '#1a1a1a',
            'background' => '#ffffff',
        ];

        $fonts = $this->default_fonts ?? [
            'heading' => 'Inter, sans-serif',
            'body' => 'Inter, sans-serif',
            'size' => '14px',
        ];

        return [
            '--cv-primary' => $colors['primary'],
            '--cv-secondary' => $colors['secondary'],
            '--cv-accent' => $colors['accent'],
            '--cv-text' => $colors['text'],
            '--cv-background' => $colors['background'],
            '--cv-font-heading' => $fonts['heading'],
            '--cv-font-body' => $fonts['body'],
            '--cv-font-size' => $fonts['size'],
        ];
    }

    /**
     * Get the template's CSS stylesheet
     */
    public function getStylesheetAttribute()
    {
        $cssVars = $this->css_variables;
        $customStyles = $this->styling['custom_css'] ?? '';

        return "
            :root {
                " . implode('; ', array_map(function ($key, $value) {
                    return "{$key}: {$value}";
                }, array_keys($cssVars), $cssVars)) . ";
            }
            .cv-template-{$this->id} {
                font-family: var(--cv-font-body);
                font-size: var(--cv-font-size);
                color: var(--cv-text);
                background: var(--cv-background);
            }
            .cv-template-{$this->id} h1,
            .cv-template-{$this->id} h2,
            .cv-template-{$this->id} h3,
            .cv-template-{$this->id} h4 {
                font-family: var(--cv-font-heading);
            }
            " . ($customStyles ?: '') . "
        ";
    }

    /**
 * Render the template with CV data
 */
public function render(array $cvData = [])
{
    // Debug: Log what we're trying to render
    \Log::info('Rendering template', [
        'template_id' => $this->id,
        'template_name' => $this->name,
        'layout_type' => $this->layout_type,
        'layout_view' => $this->layout_view,
    ]);
    
    $layoutView = $this->layout_view;
    
    // Check all possible view paths
    $possibleViews = [
        $layoutView,
        'admin.pages.cv-templates.layouts.' . $this->layout_type,
        'admin.pages.cv-templates.layouts.' . str_replace('_', '-', $this->layout_type),
        'cv-templates.layouts.' . $this->layout_type,
        'cv-templates.layouts.' . str_replace('_', '-', $this->layout_type),
    ];
    
    foreach ($possibleViews as $view) {
        if (view()->exists($view)) {
            \Log::info('Found view: ' . $view);
            return view($view, [
                'template' => $this,
                'cvData' => $cvData,
            ])->render();
        }
    }
    
    // If no view found, use fallback
    \Log::warning('No layout view found for template: ' . $this->id);
    return $this->renderFallback($cvData);
}

/**
 * Fallback render when no layout view exists
 */
private function renderFallback(array $cvData = [])
{
    $html = '<div style="padding:40px;font-family:Arial,sans-serif;max-width:900px;margin:0 auto;background:#fff;border:1px solid #ddd;border-radius:8px;">';
    $html .= '<h1 style="color:#1a237e;border-bottom:2px solid #1a237e;padding-bottom:10px;">' . htmlspecialchars($cvData['full_name'] ?? 'CV') . '</h1>';
    
    if (!empty($cvData['email']) || !empty($cvData['phone']) || !empty($cvData['location'])) {
        $html .= '<div style="margin:10px 0;padding:10px;background:#f5f5f5;border-radius:5px;">';
        if (!empty($cvData['email'])) $html .= '<span style="margin-right:20px;">📧 ' . htmlspecialchars($cvData['email']) . '</span>';
        if (!empty($cvData['phone'])) $html .= '<span style="margin-right:20px;">📱 ' . htmlspecialchars($cvData['phone']) . '</span>';
        if (!empty($cvData['location'])) $html .= '<span>📍 ' . htmlspecialchars($cvData['location']) . '</span>';
        $html .= '</div>';
    }
    
    if (!empty($cvData['summary'])) {
        $html .= '<h3 style="color:#1a237e;margin:20px 0 10px;">Summary</h3>';
        $html .= '<p>' . nl2br(htmlspecialchars($cvData['summary'])) . '</p>';
    }
    
    if (!empty($cvData['experience'])) {
        $html .= '<h3 style="color:#1a237e;margin:20px 0 10px;">Experience</h3>';
        foreach ($cvData['experience'] as $exp) {
            $html .= '<div style="margin-bottom:15px;">';
            $html .= '<h4>' . htmlspecialchars($exp['title'] ?? '') . '</h4>';
            $html .= '<p style="color:#666;">' . htmlspecialchars($exp['company'] ?? '') . ' | ' . htmlspecialchars($exp['period'] ?? '') . '</p>';
            if (!empty($exp['responsibilities'])) {
                $html .= '<ul style="padding-left:20px;">';
                foreach ($exp['responsibilities'] as $resp) {
                    if (!empty($resp)) $html .= '<li>' . htmlspecialchars($resp) . '</li>';
                }
                $html .= '</ul>';
            }
            $html .= '</div>';
        }
    }
    
    if (!empty($cvData['education'])) {
        $html .= '<h3 style="color:#1a237e;margin:20px 0 10px;">Education</h3>';
        foreach ($cvData['education'] as $edu) {
            $html .= '<div style="margin-bottom:10px;">';
            $html .= '<h4>' . htmlspecialchars($edu['degree'] ?? '') . '</h4>';
            $html .= '<p style="color:#666;">' . htmlspecialchars($edu['institution'] ?? '') . ' | ' . htmlspecialchars($edu['period'] ?? '') . '</p>';
            $html .= '</div>';
        }
    }
    
    if (!empty($cvData['skills'])) {
        $html .= '<h3 style="color:#1a237e;margin:20px 0 10px;">Skills</h3>';
        $html .= '<div style="display:flex;flex-wrap:wrap;gap:8px;">';
        foreach ($cvData['skills'] as $skill) {
            $html .= '<span style="background:#e8eaf6;padding:4px 12px;border-radius:20px;">' . htmlspecialchars($skill) . '</span>';
        }
        $html .= '</div>';
    }
    
    $html .= '</div>';
    return $html;
}
}