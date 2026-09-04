<?php
// database/seeders/CvTemplateSeeder.php

namespace Database\Seeders;

use App\Models\CvTemplate;
use App\Models\CvTemplateColor;
use App\Models\CvTemplateSection;
use Illuminate\Database\Seeder;

class CvTemplateSeeder extends Seeder
{
    public function run()
    {
        $templates = [
            [
                'name' => 'Professional Classic',
                'slug' => 'professional-classic',
                'category' => 'professional',
                'style' => 'classic',
                'layout_type' => 'classic_professional',
                'description' => 'A timeless professional design with a left sidebar. Perfect for corporate and traditional roles. Features a profile photo, contact info, skills with progress bars, and a clean work experience layout.',
                'is_default' => true,
                'is_premium' => false,
                'sections' => ['personal_info', 'summary', 'experience', 'education', 'skills', 'languages'],
                'default_colors' => [
                    'primary' => '#1a237e',
                    'secondary' => '#0d1445',
                    'accent' => '#e8eaf6',
                    'text' => '#1a1a1a',
                    'background' => '#ffffff',
                ],
                'default_fonts' => [
                    'heading' => 'Georgia, serif',
                    'body' => 'Arial, sans-serif',
                    'size' => '14px',
                ],
                'layout_config' => [
                    'sidebar_position' => 'left',
                    'show_photo' => true,
                    'photo_style' => 'circle',
                    'show_contact' => true,
                    'show_skills' => true,
                    'show_languages' => true,
                    'skill_style' => 'bar',
                ],
            ],
            [
                'name' => 'Modern Header',
                'slug' => 'modern-header',
                'category' => 'modern',
                'style' => 'modern',
                'layout_type' => 'modern_header',
                'description' => 'A bold modern design with a hero-style header featuring a gradient background. Your profile photo, name, and contact info are prominently displayed at the top with a two-column layout for content.',
                'is_default' => false,
                'is_premium' => false,
                'sections' => ['personal_info', 'summary', 'experience', 'education', 'skills', 'projects', 'languages'],
                'default_colors' => [
                    'primary' => '#00b4d8',
                    'secondary' => '#0077b6',
                    'accent' => '#f0f9ff',
                    'text' => '#1a1a1a',
                    'background' => '#ffffff',
                ],
                'default_fonts' => [
                    'heading' => 'Inter, sans-serif',
                    'body' => 'Inter, sans-serif',
                    'size' => '14px',
                ],
                'layout_config' => [
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
            ],
            [
                'name' => 'Creative Portfolio',
                'slug' => 'creative-portfolio',
                'category' => 'creative',
                'style' => 'creative',
                'layout_type' => 'creative_portfolio',
                'description' => 'Stand out with this creative design featuring a colorful sidebar, modern typography, and a portfolio-style layout. Perfect for artists, designers, and creative professionals.',
                'is_default' => false,
                'is_premium' => true,
                'sections' => ['personal_info', 'summary', 'experience', 'education', 'skills', 'projects', 'portfolio', 'languages'],
                'default_colors' => [
                    'primary' => '#f72585',
                    'secondary' => '#7209b7',
                    'accent' => '#f8e8f0',
                    'text' => '#1a1a1a',
                    'background' => '#ffffff',
                ],
                'default_fonts' => [
                    'heading' => 'Poppins, sans-serif',
                    'body' => 'Poppins, sans-serif',
                    'size' => '14px',
                ],
                'layout_config' => [
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
            ],
            [
                'name' => 'Minimal Clean',
                'slug' => 'minimal-clean',
                'category' => 'minimalist',
                'style' => 'modern',
                'layout_type' => 'minimal_clean',
                'description' => 'A clean, minimalist design with a two-column layout. No photo required - focuses purely on content with clean typography and plenty of white space. Ideal for modern professionals.',
                'is_default' => false,
                'is_premium' => false,
                'sections' => ['personal_info', 'summary', 'experience', 'education', 'skills', 'projects', 'certifications'],
                'default_colors' => [
                    'primary' => '#2d3436',
                    'secondary' => '#636e72',
                    'accent' => '#dfe6e9',
                    'text' => '#1a1a1a',
                    'background' => '#ffffff',
                ],
                'default_fonts' => [
                    'heading' => 'Inter, sans-serif',
                    'body' => 'Inter, sans-serif',
                    'size' => '14px',
                ],
                'layout_config' => [
                    'sidebar_position' => 'none',
                    'show_photo' => false,
                    'show_contact' => true,
                    'show_skills' => true,
                    'show_languages' => true,
                    'skill_style' => 'list',
                    'header_style' => 'minimal',
                    'two_column' => true,
                ],
            ],
            [
                'name' => 'Executive Board',
                'slug' => 'executive-board',
                'category' => 'executive',
                'style' => 'detailed',
                'layout_type' => 'executive_board',
                'description' => 'Executive-level design with a right sidebar format. Emphasizes leadership, achievements, and references. Features a professional photo placement and structured sections for senior roles.',
                'is_default' => false,
                'is_premium' => true,
                'sections' => ['personal_info', 'executive_summary', 'experience', 'education', 'skills', 'achievements', 'languages', 'references'],
                'default_colors' => [
                    'primary' => '#2d3436',
                    'secondary' => '#636e72',
                    'accent' => '#dfe6e9',
                    'text' => '#1a1a1a',
                    'background' => '#ffffff',
                ],
                'default_fonts' => [
                    'heading' => 'Lora, serif',
                    'body' => 'Open Sans, sans-serif',
                    'size' => '14px',
                ],
                'layout_config' => [
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
            ],
            [
                'name' => 'Tech Innovator',
                'slug' => 'tech-innovator',
                'category' => 'modern',
                'style' => 'modern',
                'layout_type' => 'tech_innovator',
                'description' => 'Tech-focused design with a futuristic feel. Features a gradient header, skill tags, project highlights, and certification sections. Perfect for IT, software, and tech professionals.',
                'is_default' => false,
                'is_premium' => false,
                'sections' => ['personal_info', 'summary', 'experience', 'education', 'skills', 'projects', 'certifications', 'languages'],
                'default_colors' => [
                    'primary' => '#6c63ff',
                    'secondary' => '#3f3d9e',
                    'accent' => '#eef1ff',
                    'text' => '#1a1a1a',
                    'background' => '#ffffff',
                ],
                'default_fonts' => [
                    'heading' => 'Space Grotesk, sans-serif',
                    'body' => 'Space Grotesk, sans-serif',
                    'size' => '14px',
                ],
                'layout_config' => [
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
            ],
        ];

        foreach ($templates as $templateData) {
            // Extract sections and layout_config before creating
            $sections = $templateData['sections'];
            $layoutConfig = $templateData['layout_config'] ?? [];
            
            // Remove sections and layout_config from template data
            unset($templateData['sections']);
            unset($templateData['layout_config']);
            
            // Create template
            $template = CvTemplate::create($templateData);

            // Update layout_config if provided
            if (!empty($layoutConfig)) {
                $template->layout_config = $layoutConfig;
                $template->save();
            }

            // Create default color scheme
            CvTemplateColor::create([
                'cv_template_id' => $template->id,
                'name' => 'Default',
                'primary_color' => $templateData['default_colors']['primary'],
                'secondary_color' => $templateData['default_colors']['secondary'],
                'accent_color' => $templateData['default_colors']['accent'],
                'text_color' => $templateData['default_colors']['text'],
                'background_color' => $templateData['default_colors']['background'],
                'is_default' => true,
            ]);

            // Create sections
            foreach ($sections as $index => $sectionKey) {
                CvTemplateSection::create([
                    'cv_template_id' => $template->id,
                    'section_key' => $sectionKey,
                    'section_name' => ucfirst(str_replace('_', ' ', $sectionKey)),
                    'order' => $index + 1,
                    'is_enabled' => true,
                    'is_required' => in_array($sectionKey, ['personal_info', 'experience', 'education']),
                ]);
            }

            $this->command->info("✅ Created template: {$template->name} ({$template->layout_type})");
        }

        $this->command->info('🎉 All CV templates seeded successfully!');
    }
}