<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Employer;
use App\Models\JobPost;
use App\Models\JobPostQuestion;
use Carbon\Carbon;

class JobPostSeeder extends Seeder
{
    /**
     * Job templates per industry.
     * Each = [title, department, experience_level, salary_min, salary_max]
     * Salaries in RM (monthly).
     */
    protected array $jobTemplates = [
        'Technology' => [
            ['Senior Frontend Developer',     'Engineering', 'senior',     8000, 14000],
            ['Backend Engineer (PHP/Laravel)', 'Engineering', 'mid',        6000, 10000],
            ['Full Stack Developer',          'Engineering', 'mid',        7000, 12000],
            ['DevOps Engineer',               'Engineering', 'senior',     9000, 15000],
            ['Mobile Developer (Flutter)',    'Engineering', 'mid',        6500, 11000],
            ['QA Engineer',                   'Engineering', 'junior',     4000,  7000],
            ['Data Analyst',                  'Data',        'mid',        5500,  9000],
            ['Data Scientist',                'Data',        'senior',     9000, 16000],
            ['Machine Learning Engineer',     'Data',        'senior',    10000, 18000],
            ['Product Manager',               'Product',     'senior',    10000, 17000],
            ['UI/UX Designer',                'Design',      'mid',        5000,  9000],
            ['Technical Lead',                'Engineering', 'lead',      12000, 20000],
            ['Cybersecurity Analyst',         'Security',    'mid',        7000, 12000],
            ['Cloud Architect',               'Engineering', 'senior',    12000, 20000],
            ['Software Engineer Intern',      'Engineering', 'internship', 1500,  2500],
        ],
        'Banking' => [
            ['Relationship Manager',      'Sales',      'mid',     6000, 10000],
            ['Credit Analyst',            'Risk',       'mid',     5500,  9000],
            ['Investment Analyst',        'Investment', 'senior',  9000, 15000],
            ['Branch Manager',            'Operations', 'senior', 10000, 16000],
            ['Compliance Officer',        'Compliance', 'mid',     6500, 11000],
            ['Risk Management Executive', 'Risk',       'junior',  4000,  6500],
            ['Financial Advisor',         'Sales',      'mid',     5000,  9000],
            ['Treasury Analyst',          'Treasury',   'mid',     6000, 10000],
        ],
        'Healthcare' => [
            ['Registered Nurse',       'Nursing',    'mid',    3500,  6000],
            ['Medical Officer',        'Medical',    'mid',    7000, 12000],
            ['Pharmacist',             'Pharmacy',   'mid',    5000,  8000],
            ['Lab Technician',         'Laboratory', 'junior', 3000,  5000],
            ['Hospital Administrator', 'Admin',      'mid',    4500,  7500],
            ['Physiotherapist',        'Rehab',      'mid',    4000,  7000],
        ],
        'Manufacturing' => [
            ['Production Supervisor',    'Production',  'mid',     4500,  7500],
            ['Quality Control Engineer', 'QC',          'mid',     5000,  8000],
            ['Mechanical Engineer',      'Engineering', 'mid',     5500,  9000],
            ['Plant Manager',            'Operations',  'senior', 12000, 18000],
            ['Maintenance Technician',   'Maintenance', 'junior',  3000,  5000],
        ],
        'E-Commerce' => [
            ['Category Manager',            'Merchandising', 'mid',    6000, 10000],
            ['Warehouse Supervisor',        'Logistics',     'mid',    4000,  6500],
            ['Customer Success Manager',    'Customer',      'mid',    5000,  8500],
            ['Digital Marketing Executive', 'Marketing',     'junior', 3500,  6000],
            ['Livestream Host',             'Marketing',     'junior', 3000,  5500],
            ['Logistics Coordinator',       'Logistics',     'junior', 3500,  5500],
        ],
        'Education' => [
            ['Mathematics Teacher',    'Teaching',   'mid',    3500,  6000],
            ['Academic Counselor',     'Counseling', 'mid',    4000,  6500],
            ['Curriculum Developer',   'Academic',   'senior', 6500, 10000],
            ['Primary School Teacher', 'Teaching',   'junior', 3000,  5000],
        ],
        'Design' => [
            ['Graphic Designer',         'Creative', 'mid',    4000,  7000],
            ['Brand Designer',           'Creative', 'mid',    5000,  8000],
            ['Motion Graphics Designer', 'Creative', 'mid',    5000,  8500],
            ['Art Director',             'Creative', 'senior', 9000, 14000],
        ],
        'Consulting' => [
            ['Business Analyst',      'Consulting', 'mid',     6000, 10000],
            ['Strategy Consultant',   'Consulting', 'senior',  9000, 15000],
            ['Management Consultant', 'Consulting', 'senior', 10000, 16000],
            ['Junior Consultant',     'Consulting', 'junior',  4000,  6000],
        ],
        // Fallback when the employer's industry isn't mapped
        'General' => [
            ['Marketing Executive',        'Marketing',  'junior', 3500,  6000],
            ['HR Executive',               'HR',         'junior', 3500,  6000],
            ['Admin Executive',            'Admin',      'junior', 3000,  5000],
            ['Sales Executive',            'Sales',      'junior', 3500,  6000],
            ['Account Executive',          'Finance',    'junior', 3800,  6500],
            ['Operations Manager',         'Operations', 'mid',    6500, 10000],
            ['Customer Service Executive', 'Customer',   'junior', 3000,  5000],
        ],
    ];

    /**
     * Malaysian cities for job locations.
     */
    protected array $locations = [
        'Kuala Lumpur', 'Petaling Jaya', 'Shah Alam', 'Subang Jaya',
        'Penang', 'George Town', 'Johor Bahru', 'Ipoh',
        'Kuching', 'Kota Kinabalu', 'Melaka', 'Cyberjaya', 'Putrajaya',
    ];

    /**
     * Skills pool — random picks per job.
     */
    protected array $skillsPool = [
        'Communication', 'Teamwork', 'Problem Solving', 'Time Management',
        'Leadership', 'Critical Thinking', 'Adaptability', 'Project Management',
        'Microsoft Office', 'Data Analysis', 'Customer Service', 'Negotiation',
        'PHP', 'Laravel', 'JavaScript', 'React', 'Vue.js', 'Node.js',
        'Python', 'Java', 'MySQL', 'PostgreSQL', 'Docker', 'Kubernetes',
        'AWS', 'Azure', 'Git', 'Agile', 'Scrum', 'Figma', 'Adobe Creative Suite',
    ];

    /**
     * Run the seeder.
     */
    public function run(): void
    {
        $employers = Employer::all();

        if ($employers->isEmpty()) {
            $this->command->error('❌ No employers found. Run EmployerWithUserSeeder first.');
            return;
        }

        DB::transaction(function () use ($employers) {
            $totalJobs = 0;
            $totalQuestions = 0;

            foreach ($employers as $employer) {
                $jobCount = rand(3, 10);

                $templates = $this->jobTemplates[$employer->industry]
                    ?? $this->jobTemplates['General'];

                shuffle($templates);

                for ($i = 0; $i < $jobCount; $i++) {
                    $template = $templates[$i % count($templates)];
                    [$title, $department, $expLevel, $salMin, $salMax] = $template;

                    $publishedAt = Carbon::now()->subDays(rand(1, 60));
                    $closingAt   = rand(0, 1)
                        ? $publishedAt->copy()->addDays(rand(30, 90))
                        : null;

                    $job = JobPost::create([
                        'title'                 => $title,
                        'description'           => $this->generateDescription($title, $employer->company_name),
                        'requirements'          => $this->generateRequirements($expLevel),
                        'benefits'              => $this->generateBenefits(),
                        'department'            => $department,
                        'location'              => $employer->headquarters
                                                    ?: $this->locations[array_rand($this->locations)],
                        'work_type'             => $this->pickWorkType(),
                        'employment_type'       => $this->mapEmploymentType($expLevel),
                        'experience_level'      => $expLevel,
                        'salary_min'            => $salMin,
                        'salary_max'            => $salMax,
                        'currency'              => 'RM',
                        'required_skills'       => $this->pickSkills(4, 7),
                        'preferred_skills'      => $this->pickSkills(2, 4),
                        'education_requirement' => $this->pickEducation($expLevel),
                        'employer_id'           => $employer->id,
                        'recruiter_id'          => null,
                        'visibility'            => $this->pickVisibility(),
                        'status'                => $this->pickStatus(),
                        'is_ai_generated'       => false,
                        'published_at'          => $publishedAt,
                        'closing_at'            => $closingAt,
                        'max_applications'      => rand(0, 1) ? rand(50, 200) : null,
                        'application_questions' => null,
                        'created_at'            => $publishedAt,
                        'updated_at'            => $publishedAt,
                    ]);

                    $totalJobs++;

                    // 30% of jobs get 2–5 screening questions
                    if (rand(1, 100) <= 30) {
                        $qCount = rand(2, 5);
                        $this->seedQuestions($job, $qCount);
                        $totalQuestions += $qCount;
                    }
                }
            }

            $this->command->info("✅ Seeded {$totalJobs} job posts and {$totalQuestions} job questions.");
        });
    }

    // ===== QUESTION SEEDER =====

    protected function seedQuestions(JobPost $job, int $count): void
    {
        $pool = $this->questionPool();
        shuffle($pool);

        for ($i = 0; $i < $count; $i++) {
            $q = $pool[$i % count($pool)];

            JobPostQuestion::create([
                'job_post_id' => $job->id,
                'question'    => $q['question'],
                'type'        => $q['type'],
                'required'    => $q['required'] ?? true,
                'options'     => $q['options'] ?? null,
                'order'       => $i + 1,
            ]);
        }
    }

    /**
     * All types match the ENUM:
     * 'text', 'textarea', 'select', 'checkbox', 'file'
     */
    protected function questionPool(): array
    {
        return [
            [
                'question' => 'Do you have the legal right to work in Malaysia?',
                'type'     => 'select',
                'required' => true,
                'options'  => ['Yes', 'No'],
            ],
            [
                'question' => 'How many years of relevant experience do you have?',
                'type'     => 'select',
                'required' => true,
                'options'  => ['Less than 1 year', '1–3 years', '3–5 years', '5–10 years', '10+ years'],
            ],
            [
                'question' => 'What is your expected monthly salary (RM)?',
                'type'     => 'text',
                'required' => true,
            ],
            [
                'question' => 'What is your notice period?',
                'type'     => 'select',
                'required' => true,
                'options'  => ['Immediately', '2 weeks', '1 month', '2 months', '3 months or more'],
            ],
            [
                'question' => 'Are you willing to work on-site?',
                'type'     => 'select',
                'required' => true,
                'options'  => ['Yes', 'No'],
            ],
            [
                'question' => 'Tell us why you want to join our company.',
                'type'     => 'textarea',
                'required' => false,
            ],
            [
                'question' => 'Do you have experience in our industry?',
                'type'     => 'select',
                'required' => false,
                'options'  => ['Yes', 'No'],
            ],
            [
                'question' => 'Which of the following languages are you fluent in?',
                'type'     => 'checkbox',
                'required' => true,
                'options'  => ['English', 'Bahasa Malaysia', 'Mandarin', 'Tamil'],
            ],
            [
                'question' => 'What is your highest education level?',
                'type'     => 'select',
                'required' => true,
                'options'  => ['SPM', 'Diploma', "Bachelor's Degree", "Master's Degree", 'PhD'],
            ],
            [
                'question' => 'Upload your portfolio (PDF, optional)',
                'type'     => 'file',
                'required' => false,
            ],
            [
                'question' => 'Portfolio / LinkedIn / GitHub URL (optional)',
                'type'     => 'text',
                'required' => false,
            ],
            [
                'question' => 'Describe a challenging project you worked on.',
                'type'     => 'textarea',
                'required' => false,
            ],
        ];
    }

    // ===== TEXT GENERATORS =====

    protected function generateDescription(string $title, string $company): string
    {
        return "We are looking for a talented {$title} to join {$company}. "
             . "In this role, you will work closely with cross-functional teams to deliver high-quality results. "
             . "You will have the opportunity to grow your skills, take ownership of projects, and make a real impact. "
             . "If you are passionate, driven, and eager to learn, we want to hear from you.";
    }

    protected function generateRequirements(string $expLevel): string
    {
        $lines = match ($expLevel) {
            'internship' => [
                "Currently pursuing a Diploma or Bachelor's Degree",
                'Strong willingness to learn and adapt',
                'Good communication skills in English and Bahasa Malaysia',
                'Able to commit to a 3–6 month internship',
            ],
            'junior' => [
                '0–2 years of relevant experience',
                "Bachelor's Degree or Diploma in a related field",
                'Strong communication and teamwork skills',
                'Willingness to learn and take initiative',
            ],
            'mid' => [
                '3–5 years of relevant experience',
                "Bachelor's Degree in a related field",
                'Proven track record in a similar role',
                'Strong problem-solving and analytical skills',
            ],
            'senior' => [
                '5+ years of relevant experience',
                "Bachelor's or Master's Degree in a related field",
                'Demonstrated leadership and mentoring capabilities',
                'Strong stakeholder management skills',
            ],
            'lead' => [
                '8+ years of relevant experience',
                'Proven experience leading teams and delivering projects',
                'Excellent communication and strategic thinking',
                "Bachelor's or Master's Degree in a related field",
            ],
            default => ['Relevant experience and education'],
        };

        return implode("\n", array_map(fn ($l) => "• {$l}", $lines));
    }

    protected function generateBenefits(): string
    {
        $all = [
            'Competitive salary', 'EPF & SOCSO contribution', 'Medical insurance',
            'Dental & optical allowance', 'Annual bonus', 'Performance bonus',
            'Flexible working hours', 'Work from home options', 'Free parking',
            'Gym membership subsidy', 'Annual leave above statutory',
            'Training & development budget', 'Career growth opportunities',
            'Team building activities', 'Company retreat', 'Free snacks & drinks',
            'Phone & internet allowance', 'Relocation assistance',
        ];
        shuffle($all);
        $picked = array_slice($all, 0, rand(4, 7));
        return implode("\n", array_map(fn ($b) => "• {$b}", $picked));
    }

    // ===== ENUM PICKERS =====

    /**
     * work_type ENUM: 'remote', 'onsite', 'hybrid'
     * Weighted: 50% onsite, 30% hybrid, 20% remote
     */
    protected function pickWorkType(): string
    {
        $roll = rand(1, 100);
        if ($roll <= 50) return 'onsite';
        if ($roll <= 80) return 'hybrid';
        return 'remote';
    }

    /**
     * employment_type ENUM:
     * 'full_time', 'part_time', 'contract', 'internship', 'freelance'
     */
    protected function mapEmploymentType(string $expLevel): string
    {
        if ($expLevel === 'internship') {
            return 'internship';
        }

        // 75% full_time, 10% contract, 10% part_time, 5% freelance
        $roll = rand(1, 100);
        if ($roll <= 75) return 'full_time';
        if ($roll <= 85) return 'contract';
        if ($roll <= 95) return 'part_time';
        return 'freelance';
    }

    /**
     * visibility ENUM: 'public', 'private', 'agency_only'
     * Weighted: 85% public, 10% private, 5% agency_only
     */
    protected function pickVisibility(): string
    {
        $roll = rand(1, 100);
        if ($roll <= 85) return 'public';
        if ($roll <= 95) return 'private';
        return 'agency_only';
    }

    /**
     * status ENUM: 'draft', 'published', 'closed', 'paused'
     * Weighted: 80% published, 8% draft, 7% paused, 5% closed
     * (So most jobs show on listings but some are hidden/closing)
     */
    protected function pickStatus(): string
    {
        $roll = rand(1, 100);
        if ($roll <= 80) return 'published';
        if ($roll <= 88) return 'draft';
        if ($roll <= 95) return 'paused';
        return 'closed';
    }

    // ===== OTHER HELPERS =====

    protected function pickEducation(string $expLevel): string
    {
        if ($expLevel === 'internship') return "Bachelor's Degree";

        return match (rand(1, 4)) {
            1       => 'SPM',
            2       => 'Diploma',
            3       => "Bachelor's Degree",
            default => "Master's Degree",
        };
    }

    protected function pickSkills(int $min, int $max): array
    {
        $count = rand($min, $max);
        $pool  = $this->skillsPool;
        shuffle($pool);
        return array_values(array_slice($pool, 0, $count));
    }
}
