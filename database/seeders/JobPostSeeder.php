<?php

namespace Database\Seeders;

use App\Models\Employer;
use App\Models\JobPost;
use App\Models\JobPostQuestion;
use Illuminate\Database\Seeder;

class JobPostSeeder extends Seeder
{
    public function run(): void
    {
        $employers = Employer::all();

        if ($employers->isEmpty()) {
            $this->command->warn('⚠️  No employers found. Run EmployerSeeder first.');
            return;
        }

        // Job templates by industry
        $jobsByIndustry = [
            'Technology' => [
                ['title' => 'Senior Frontend Developer',  'level' => 'Senior',   'min' => 8000,  'max' => 12000],
                ['title' => 'Backend Engineer (PHP)',     'level' => 'Mid',      'min' => 6000,  'max' => 9500],
                ['title' => 'Full Stack Developer',       'level' => 'Senior',   'min' => 9000,  'max' => 14000],
                ['title' => 'DevOps Engineer',            'level' => 'Mid',      'min' => 9000,  'max' => 14000],
                ['title' => 'Mobile Developer (Flutter)', 'level' => 'Mid',      'min' => 7000,  'max' => 11000],
                ['title' => 'QA Engineer',                'level' => 'Junior',   'min' => 4000,  'max' => 6500],
                ['title' => 'Cloud Architect',            'level' => 'Lead',     'min' => 15000, 'max' => 22000],
                ['title' => 'Laravel Developer',          'level' => 'Mid',      'min' => 6500,  'max' => 10000],
                ['title' => 'React Native Developer',     'level' => 'Mid',      'min' => 7000,  'max' => 11000],
                ['title' => 'Data Engineer',              'level' => 'Senior',   'min' => 10000, 'max' => 16000],
                ['title' => 'Software Engineer Intern',   'level' => 'Intern',   'min' => 1200,  'max' => 2000],
                ['title' => 'Technical Lead',             'level' => 'Lead',     'min' => 14000, 'max' => 20000],
            ],
            'Design' => [
                ['title' => 'Senior UI/UX Designer',      'level' => 'Senior',   'min' => 7000,  'max' => 11000],
                ['title' => 'Graphic Designer',           'level' => 'Junior',   'min' => 3500,  'max' => 5500],
                ['title' => 'Product Designer',           'level' => 'Mid',      'min' => 6000,  'max' => 9500],
                ['title' => 'Motion Graphics Designer',   'level' => 'Mid',      'min' => 5500,  'max' => 8500],
                ['title' => 'Brand Designer',             'level' => 'Senior',   'min' => 8000,  'max' => 12000],
            ],
            'Finance' => [
                ['title' => 'Financial Analyst',          'level' => 'Mid',      'min' => 6000,  'max' => 9000],
                ['title' => 'Senior Accountant',          'level' => 'Senior',   'min' => 7500,  'max' => 11000],
                ['title' => 'Investment Analyst',         'level' => 'Mid',      'min' => 8000,  'max' => 13000],
                ['title' => 'Risk Manager',               'level' => 'Senior',   'min' => 10000, 'max' => 16000],
                ['title' => 'Audit Associate',            'level' => 'Junior',   'min' => 4000,  'max' => 6000],
            ],
            'Marketing' => [
                ['title' => 'Digital Marketing Manager',  'level' => 'Senior',   'min' => 8000,  'max' => 12000],
                ['title' => 'SEO Specialist',             'level' => 'Mid',      'min' => 4500,  'max' => 7000],
                ['title' => 'Content Writer',             'level' => 'Junior',   'min' => 3000,  'max' => 5000],
                ['title' => 'Social Media Manager',       'level' => 'Mid',      'min' => 5000,  'max' => 8000],
                ['title' => 'Brand Manager',              'level' => 'Senior',   'min' => 9000,  'max' => 13000],
            ],
            'Healthcare' => [
                ['title' => 'Registered Nurse',           'level' => 'Mid',      'min' => 4000,  'max' => 6500],
                ['title' => 'Medical Laboratory Tech',    'level' => 'Mid',      'min' => 3800,  'max' => 5800],
                ['title' => 'Pharmacist',                 'level' => 'Mid',      'min' => 5500,  'max' => 8500],
                ['title' => 'Healthcare Administrator',   'level' => 'Senior',   'min' => 7000,  'max' => 11000],
                ['title' => 'Clinical Research Associate','level' => 'Mid',      'min' => 5000,  'max' => 8000],
            ],
            'Education' => [
                ['title' => 'Mathematics Teacher',        'level' => 'Mid',      'min' => 4000,  'max' => 6500],
                ['title' => 'Curriculum Developer',       'level' => 'Senior',   'min' => 6500,  'max' => 9500],
                ['title' => 'Academic Counselor',         'level' => 'Mid',      'min' => 4500,  'max' => 7000],
                ['title' => 'Online Course Instructor',   'level' => 'Mid',      'min' => 4000,  'max' => 7000],
                ['title' => 'Education Technology Lead',  'level' => 'Senior',   'min' => 8000,  'max' => 12000],
            ],
            'Engineering' => [
                ['title' => 'Civil Engineer',             'level' => 'Mid',      'min' => 5500,  'max' => 8500],
                ['title' => 'Mechanical Engineer',        'level' => 'Mid',      'min' => 5500,  'max' => 8500],
                ['title' => 'Project Engineer',           'level' => 'Senior',   'min' => 8000,  'max' => 12000],
                ['title' => 'Electrical Engineer',        'level' => 'Mid',      'min' => 5500,  'max' => 8500],
                ['title' => 'Site Supervisor',            'level' => 'Mid',      'min' => 5000,  'max' => 7500],
            ],
            'E-Commerce' => [
                ['title' => 'E-Commerce Manager',         'level' => 'Senior',   'min' => 8000,  'max' => 13000],
                ['title' => 'Marketplace Specialist',     'level' => 'Mid',      'min' => 5000,  'max' => 8000],
                ['title' => 'Product Listing Executive',  'level' => 'Junior',   'min' => 3200,  'max' => 5000],
                ['title' => 'Customer Success Manager',   'level' => 'Mid',      'min' => 5500,  'max' => 8500],
            ],
            'Retail' => [
                ['title' => 'Store Manager',              'level' => 'Senior',   'min' => 5500,  'max' => 8500],
                ['title' => 'Retail Sales Associate',     'level' => 'Junior',   'min' => 2200,  'max' => 3500],
                ['title' => 'Visual Merchandiser',        'level' => 'Mid',      'min' => 3500,  'max' => 5500],
            ],
            'Hospitality' => [
                ['title' => 'Hotel Manager',              'level' => 'Senior',   'min' => 7000,  'max' => 11000],
                ['title' => 'Front Desk Officer',         'level' => 'Junior',   'min' => 2500,  'max' => 4000],
                ['title' => 'Chef de Partie',             'level' => 'Mid',      'min' => 4000,  'max' => 6500],
                ['title' => 'F&B Supervisor',             'level' => 'Mid',      'min' => 3500,  'max' => 5500],
            ],
            'Logistics' => [
                ['title' => 'Logistics Coordinator',      'level' => 'Mid',      'min' => 4000,  'max' => 6500],
                ['title' => 'Supply Chain Manager',       'level' => 'Senior',   'min' => 9000,  'max' => 14000],
                ['title' => 'Warehouse Supervisor',       'level' => 'Mid',      'min' => 3500,  'max' => 5500],
                ['title' => 'Fleet Operations Executive', 'level' => 'Junior',   'min' => 3000,  'max' => 4500],
            ],
            'Consulting' => [
                ['title' => 'Business Consultant',        'level' => 'Senior',   'min' => 9000,  'max' => 15000],
                ['title' => 'Strategy Analyst',           'level' => 'Mid',      'min' => 6500,  'max' => 10000],
                ['title' => 'Management Trainee',         'level' => 'Junior',   'min' => 3500,  'max' => 5500],
            ],
            'Telecommunications' => [
                ['title' => 'Network Engineer',           'level' => 'Mid',      'min' => 6000,  'max' => 9500],
                ['title' => 'Telecom Sales Executive',    'level' => 'Junior',   'min' => 3000,  'max' => 5000],
                ['title' => 'RF Engineer',                'level' => 'Mid',      'min' => 6500,  'max' => 10000],
            ],
            'Media' => [
                ['title' => 'Video Editor',               'level' => 'Mid',      'min' => 4000,  'max' => 6500],
                ['title' => 'Content Producer',           'level' => 'Mid',      'min' => 5000,  'max' => 8000],
                ['title' => 'Journalist',                 'level' => 'Mid',      'min' => 3500,  'max' => 6000],
                ['title' => 'Social Media Executive',     'level' => 'Junior',   'min' => 3000,  'max' => 5000],
            ],
        ];

        $locations       = ['Kuala Lumpur', 'Selangor', 'Penang', 'Johor', 'Sarawak', 'Sabah', 'Remote'];
        $workTypes       = ['On-site', 'Remote', 'Hybrid'];
        $employmentTypes = ['Full-time', 'Part-time', 'Contract', 'Internship', 'Temporary'];

        $educationReqs = [
            'SPM / O-Level',
            'Diploma',
            "Bachelor's Degree",
            "Master's Degree",
            'PhD',
            'Any',
        ];

        $departments = [
            'Technology'         => ['Engineering', 'IT', 'Product', 'DevOps'],
            'Design'             => ['Design', 'Creative', 'Product'],
            'Finance'            => ['Finance', 'Accounting', 'Risk'],
            'Marketing'          => ['Marketing', 'Growth', 'Content'],
            'Healthcare'         => ['Clinical', 'Medical', 'Operations'],
            'Education'          => ['Academic', 'Teaching', 'Curriculum'],
            'Engineering'        => ['Engineering', 'Operations', 'Projects'],
            'E-Commerce'         => ['E-Commerce', 'Marketplace', 'Operations'],
            'Retail'             => ['Retail', 'Store Operations', 'Merchandising'],
            'Hospitality'        => ['Front Office', 'F&B', 'Housekeeping'],
            'Logistics'          => ['Logistics', 'Supply Chain', 'Warehouse'],
            'Consulting'         => ['Consulting', 'Strategy', 'Advisory'],
            'Telecommunications' => ['Network', 'Engineering', 'Sales'],
            'Media'              => ['Production', 'Editorial', 'Content'],
        ];

        $totalJobs = 0;

        foreach ($employers as $employer) {
            $industry = $employer->industry ?? 'Technology';
            $jobs     = $jobsByIndustry[$industry] ?? $jobsByIndustry['Technology'];
            $deptList = $departments[$industry] ?? ['General'];

            $count = rand(2, 6);

            shuffle($jobs);
            $selectedJobs = array_slice($jobs, 0, min($count, count($jobs)));

            foreach ($selectedJobs as $job) {
                $workType       = $workTypes[array_rand($workTypes)];
                $employmentType = ($job['level'] === 'Intern')
                    ? 'Internship'
                    : $employmentTypes[array_rand([0, 0, 0, 1, 2])];
                $department     = $deptList[array_rand($deptList)];
                $location       = $employer->headquarters ?: $locations[array_rand($locations)];

                $salaryMin = $job['min'] + rand(-500, 500);
                $salaryMax = $job['max'] + rand(-500, 1000);
                if ($salaryMax < $salaryMin) {
                    $salaryMax = $salaryMin + 1500;
                }

                $r = rand(1, 100);
                if ($r <= 85) {
                    $status      = 'published';
                    $publishedAt = now()->subDays(rand(1, 60));
                } elseif ($r <= 95) {
                    $status      = 'draft';
                    $publishedAt = null;
                } else {
                    $status      = 'closed';
                    $publishedAt = now()->subDays(rand(60, 180));
                }

                $visibility = (rand(1, 100) <= 90) ? 'public' : 'private';

                [$requiredSkills, $preferredSkills] = $this->skillsFor($industry);

                $description  = $this->buildDescription($employer, $job, $workType, $employmentType);
                $requirements = $this->buildRequirements($job, $requiredSkills);
                $benefits     = $this->buildBenefits();

                $closingAt = $status === 'published'
                    ? now()->addDays(rand(20, 90))
                    : null;

                $maxApplications = rand(0, 100) < 40 ? rand(50, 300) : null;
                $isAiGenerated   = rand(0, 100) < 30;

                $jobPost = JobPost::create([
                    'title'                 => $job['title'],
                    'description'           => $description,
                    'requirements'          => $requirements,
                    'benefits'              => $benefits,
                    'department'            => $department,
                    'location'              => $location,
                    'work_type'             => $workType,
                    'employment_type'       => $employmentType,
                    'experience_level'      => $job['level'],
                    'salary_min'            => $salaryMin,
                    'salary_max'            => $salaryMax,
                    'currency'              => 'MYR',
                    'required_skills'       => $requiredSkills,
                    'preferred_skills'      => $preferredSkills,
                    'education_requirement' => $educationReqs[array_rand($educationReqs)],
                    'employer_id'           => $employer->id,
                    'recruiter_id'          => null, // ✅ no recruiter — relies on nullable column
                    'visibility'            => $visibility,
                    'status'                => $status,
                    'is_ai_generated'       => $isAiGenerated,
                    'published_at'          => $publishedAt,
                    'closing_at'            => $closingAt,
                    'max_applications'      => $maxApplications,
                    'application_questions' => null,
                ]);

                $totalJobs++;

                if (rand(1, 100) <= 60) {
                    $this->seedQuestions($jobPost);
                }
            }
        }

        $this->command->info("✅ Seeded {$totalJobs} job posts across {$employers->count()} employers.");
    }

    private function skillsFor(string $industry): array
    {
        $skillMap = [
            'Technology' => [
                'required'  => ['PHP', 'Laravel', 'MySQL', 'Git', 'REST API', 'JavaScript'],
                'preferred' => ['Docker', 'AWS', 'Redis', 'React', 'Vue', 'TypeScript', 'Livewire'],
            ],
            'Design' => [
                'required'  => ['Figma', 'Adobe XD', 'Photoshop', 'Illustrator'],
                'preferred' => ['Sketch', 'After Effects', 'InVision', 'HTML', 'CSS'],
            ],
            'Finance' => [
                'required'  => ['Excel', 'Financial Analysis', 'Accounting'],
                'preferred' => ['SQL', 'Power BI', 'Tableau', 'SAP'],
            ],
            'Marketing' => [
                'required'  => ['SEO', 'Google Analytics', 'Content Marketing', 'Social Media'],
                'preferred' => ['Google Ads', 'Facebook Ads', 'HubSpot', 'Mailchimp'],
            ],
            'Healthcare' => [
                'required'  => ['Patient Care', 'Medical Records', 'Communication'],
                'preferred' => ['EMR Systems', 'Clinical Research', 'CPR Certified'],
            ],
            'Education' => [
                'required'  => ['Teaching', 'Lesson Planning', 'Classroom Management'],
                'preferred' => ['Google Classroom', 'LMS', 'Curriculum Design'],
            ],
            'Engineering' => [
                'required'  => ['AutoCAD', 'Project Management', 'Problem Solving'],
                'preferred' => ['SolidWorks', 'MATLAB', 'Primavera'],
            ],
            'E-Commerce' => [
                'required'  => ['E-Commerce Platforms', 'Excel', 'Customer Service'],
                'preferred' => ['Shopify', 'WooCommerce', 'SEO', 'Google Analytics'],
            ],
            'Retail' => [
                'required'  => ['Customer Service', 'Sales', 'POS Systems'],
                'preferred' => ['Inventory Management', 'Visual Merchandising'],
            ],
            'Hospitality' => [
                'required'  => ['Customer Service', 'Communication', 'Hospitality'],
                'preferred' => ['Food Safety', 'Barista Skills', 'POS Systems'],
            ],
            'Logistics' => [
                'required'  => ['Inventory Management', 'Excel', 'Logistics'],
                'preferred' => ['SAP', 'WMS', 'Supply Chain'],
            ],
            'Consulting' => [
                'required'  => ['Business Analysis', 'Communication', 'Excel'],
                'preferred' => ['PowerPoint', 'SQL', 'Tableau', 'Project Management'],
            ],
            'Telecommunications' => [
                'required'  => ['Networking', 'TCP/IP', 'Communication'],
                'preferred' => ['Cisco', 'Linux', 'Python'],
            ],
            'Media' => [
                'required'  => ['Content Creation', 'Communication', 'Editing'],
                'preferred' => ['Adobe Premiere', 'Photoshop', 'SEO'],
            ],
        ];

        $base = $skillMap[$industry] ?? $skillMap['Technology'];
        return [$base['required'], $base['preferred']];
    }

    private function buildDescription($employer, array $job, string $workType, string $employmentType): string
    {
        $companyName = $employer->company_name;
        $title       = $job['title'];
        $level       = $job['level'];

        return "We are looking for a talented {$level} {$title} to join our growing team at {$companyName}. "
             . "This is a {$employmentType} position with {$workType} working arrangement.\n\n"
             . "As part of our team, you'll collaborate with passionate professionals to deliver high-quality results "
             . "for our clients and stakeholders. You'll have the opportunity to work on exciting projects, grow your skills, "
             . "and make a real impact.\n\n"
             . "We value innovation, integrity, and teamwork. If you're ready to take the next step in your career, "
             . "we'd love to hear from you!";
    }

    private function buildRequirements(array $job, array $requiredSkills): string
    {
        $skillsList = implode(', ', array_slice($requiredSkills, 0, 5));

        return "• Minimum {$job['level']} level experience in a similar role\n"
             . "• Strong proficiency in: {$skillsList}\n"
             . "• Excellent communication and teamwork skills\n"
             . "• Ability to work independently and meet deadlines\n"
             . "• Problem-solving mindset with attention to detail\n"
             . "• Willingness to learn and adapt to new technologies\n"
             . "• Relevant certifications or portfolio are a plus";
    }

    private function buildBenefits(): string
    {
        $benefits = [
            'Competitive salary package',
            'EPF, SOCSO, and EIS contributions',
            'Medical and dental insurance',
            'Annual leave and medical leave',
            'Flexible working hours',
            'Career development opportunities',
            'Team building activities',
            'Performance bonus',
            'Professional certification support',
            'Modern office environment',
            'Free snacks and beverages',
            'Work-from-home allowance',
        ];

        shuffle($benefits);
        $selected = array_slice($benefits, 0, rand(5, 8));

        return '• ' . implode("\n• ", $selected);
    }

    private function seedQuestions(JobPost $jobPost): void
    {
        $questionPool = [
            ['q' => 'Why are you interested in this position?',                 'type' => 'textarea', 'required' => true],
            ['q' => 'How many years of relevant experience do you have?',       'type' => 'text',     'required' => true],
            ['q' => 'What is your expected monthly salary (MYR)?',              'type' => 'text',     'required' => true],
            ['q' => 'When can you start?',                                      'type' => 'text',     'required' => true],
            ['q' => 'Are you legally authorized to work in Malaysia?',          'type' => 'radio',    'required' => true, 'options' => ['Yes', 'No']],
            ['q' => 'Do you require visa sponsorship?',                         'type' => 'radio',    'required' => false, 'options' => ['Yes', 'No']],
            ['q' => 'What is your highest education level?',                    'type' => 'select',   'required' => true, 'options' => ['SPM', 'Diploma', "Bachelor's Degree", "Master's Degree", 'PhD']],
            ['q' => 'Describe a challenging project you worked on.',            'type' => 'textarea', 'required' => false],
            ['q' => 'Are you comfortable with the working arrangement?',        'type' => 'radio',    'required' => true, 'options' => ['Yes', 'No']],
            ['q' => 'Portfolio or GitHub URL (if applicable):',                 'type' => 'text',     'required' => false],
        ];

        shuffle($questionPool);
        $count    = rand(2, 4);
        $selected = array_slice($questionPool, 0, $count);

        foreach ($selected as $order => $q) {
            JobPostQuestion::create([
                'job_post_id' => $jobPost->id,
                'question'    => $q['q'],
                'type'        => $q['type'],
                'required'    => $q['required'],
                'options'     => $q['options'] ?? null,
                'order'       => $order + 1,
            ]);
        }
    }
}
