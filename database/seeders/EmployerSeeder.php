<?php

namespace Database\Seeders;

use App\Models\Employer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EmployerSeeder extends Seeder
{
    /**
     * Realistic Malaysian / global companies with theme data.
     */
    public function run(): void
    {
        // Realistic company datasets
        $companies = [
            // ==== TECHNOLOGY ====
            ['name' => 'TechCorp Malaysia',       'industry' => 'Technology',      'size' => '201-500',   'hq' => 'Kuala Lumpur',  'founded' => 2012, 'web' => 'techcorp.com.my'],
            ['name' => 'Innovate Labs',           'industry' => 'Technology',      'size' => '51-200',    'hq' => 'Penang',        'founded' => 2016, 'web' => 'innovatelabs.io'],
            ['name' => 'CloudSystems Sdn Bhd',    'industry' => 'Technology',      'size' => '501-1000',  'hq' => 'Selangor',      'founded' => 2008, 'web' => 'cloudsystems.com'],
            ['name' => 'DataInsights Asia',       'industry' => 'Technology',      'size' => '11-50',     'hq' => 'Johor',         'founded' => 2019, 'web' => 'datainsights.asia'],
            ['name' => 'NexGen Solutions',        'industry' => 'Technology',      'size' => '51-200',    'hq' => 'Kuala Lumpur',  'founded' => 2015, 'web' => 'nexgensolutions.my'],
            ['name' => 'Quantum Bytes',           'industry' => 'Technology',      'size' => '11-50',     'hq' => 'Remote',        'founded' => 2020, 'web' => 'quantumbytes.dev'],
            ['name' => 'Apex Digital',            'industry' => 'Technology',      'size' => '201-500',   'hq' => 'Selangor',      'founded' => 2010, 'web' => 'apexdigital.com.my'],
            ['name' => 'SwiftSoft Technologies',  'industry' => 'Technology',      'size' => '51-200',    'hq' => 'Penang',        'founded' => 2014, 'web' => 'swiftsoft.io'],

            // ==== DESIGN ====
            ['name' => 'DesignStudio KL',         'industry' => 'Design',          'size' => '11-50',     'hq' => 'Penang',        'founded' => 2017, 'web' => 'designstudiokl.com'],
            ['name' => 'PixelPerfect Creative',   'industry' => 'Design',          'size' => '1-10',      'hq' => 'Kuala Lumpur',  'founded' => 2018, 'web' => 'pixelperfect.my'],
            ['name' => 'Artisan Collective',      'industry' => 'Design',          'size' => '11-50',     'hq' => 'Selangor',      'founded' => 2016, 'web' => 'artisancollective.co'],
            ['name' => 'Vivid Media House',       'industry' => 'Design',          'size' => '51-200',    'hq' => 'Kuala Lumpur',  'founded' => 2013, 'web' => 'vividmedia.com.my'],

            // ==== FINANCE ====
            ['name' => 'Maybank Digital',         'industry' => 'Finance',         'size' => '1000+',     'hq' => 'Kuala Lumpur',  'founded' => 1960, 'web' => 'maybank.com'],
            ['name' => 'CIMB Ventures',           'industry' => 'Finance',         'size' => '1000+',     'hq' => 'Kuala Lumpur',  'founded' => 1974, 'web' => 'cimb.com'],
            ['name' => 'FinEdge Capital',         'industry' => 'Finance',         'size' => '51-200',    'hq' => 'Selangor',      'founded' => 2015, 'web' => 'finedgecapital.com'],
            ['name' => 'Zenith Wealth Advisory',  'industry' => 'Finance',         'size' => '11-50',     'hq' => 'Penang',        'founded' => 2017, 'web' => 'zenithwealth.my'],
            ['name' => 'TrustBank Malaysia',      'industry' => 'Finance',         'size' => '501-1000',  'hq' => 'Kuala Lumpur',  'founded' => 1985, 'web' => 'trustbank.com.my'],

            // ==== MARKETING ====
            ['name' => 'BrandAgency MY',          'industry' => 'Marketing',       'size' => '51-200',    'hq' => 'Kuala Lumpur',  'founded' => 2014, 'web' => 'brandagency.my'],
            ['name' => 'Reach Digital',           'industry' => 'Marketing',       'size' => '11-50',     'hq' => 'Selangor',      'founded' => 2019, 'web' => 'reachdigital.co'],
            ['name' => 'Buzzworks Malaysia',      'industry' => 'Marketing',       'size' => '11-50',     'hq' => 'Penang',        'founded' => 2018, 'web' => 'buzzworks.my'],
            ['name' => 'Amplify Consulting',      'industry' => 'Marketing',       'size' => '51-200',    'hq' => 'Kuala Lumpur',  'founded' => 2011, 'web' => 'amplify.com.my'],

            // ==== HEALTHCARE ====
            ['name' => 'MediCare Plus',           'industry' => 'Healthcare',      'size' => '201-500',   'hq' => 'Kuala Lumpur',  'founded' => 2009, 'web' => 'medicareplus.com.my'],
            ['name' => 'Wellness First',          'industry' => 'Healthcare',      'size' => '51-200',    'hq' => 'Selangor',      'founded' => 2016, 'web' => 'wellnessfirst.my'],
            ['name' => 'BioGen Research',         'industry' => 'Healthcare',      'size' => '11-50',     'hq' => 'Penang',        'founded' => 2020, 'web' => 'biogenresearch.com'],
            ['name' => 'CarePoint Hospitals',     'industry' => 'Healthcare',      'size' => '1000+',     'hq' => 'Johor',         'founded' => 1995, 'web' => 'carepoint.com.my'],

            // ==== EDUCATION ====
            ['name' => 'EduTech Academy',         'industry' => 'Education',       'size' => '51-200',    'hq' => 'Kuala Lumpur',  'founded' => 2015, 'web' => 'edutechacademy.my'],
            ['name' => 'Learning Hub Malaysia',   'industry' => 'Education',       'size' => '11-50',     'hq' => 'Selangor',      'founded' => 2018, 'web' => 'learninghub.com.my'],
            ['name' => 'BrightMinds Institute',   'industry' => 'Education',       'size' => '201-500',   'hq' => 'Penang',        'founded' => 2005, 'web' => 'brightminds.edu.my'],
            ['name' => 'NextGen Skills Center',   'industry' => 'Education',       'size' => '51-200',    'hq' => 'Johor',         'founded' => 2017, 'web' => 'nextgenskills.my'],

            // ==== ENGINEERING ====
            ['name' => 'Precision Engineering',   'industry' => 'Engineering',     'size' => '501-1000',  'hq' => 'Selangor',      'founded' => 2000, 'web' => 'precisioneng.com.my'],
            ['name' => 'BuildTech Construction',  'industry' => 'Engineering',     'size' => '1000+',     'hq' => 'Kuala Lumpur',  'founded' => 1992, 'web' => 'buildtech.com.my'],
            ['name' => 'GreenEnergy Solutions',   'industry' => 'Engineering',     'size' => '51-200',    'hq' => 'Sarawak',       'founded' => 2016, 'web' => 'greenenergy.my'],
            ['name' => 'Aero Dynamics MY',        'industry' => 'Engineering',     'size' => '201-500',   'hq' => 'Selangor',      'founded' => 2008, 'web' => 'aerodynamics.com.my'],

            // ==== RETAIL / ECOMMERCE ====
            ['name' => 'ShopEasy Malaysia',       'industry' => 'E-Commerce',      'size' => '201-500',   'hq' => 'Kuala Lumpur',  'founded' => 2014, 'web' => 'shopeasy.my'],
            ['name' => 'RetailHub Sdn Bhd',       'industry' => 'Retail',          'size' => '501-1000',  'hq' => 'Selangor',      'founded' => 2005, 'web' => 'retailhub.com.my'],
            ['name' => 'Fashion Forward',         'industry' => 'Retail',          'size' => '11-50',     'hq' => 'Penang',        'founded' => 2019, 'web' => 'fashionforward.my'],

            // ==== HOSPITALITY / FOOD ====
            ['name' => 'Gourmet Group MY',        'industry' => 'Hospitality',     'size' => '501-1000',  'hq' => 'Kuala Lumpur',  'founded' => 2010, 'web' => 'gourmetgroup.my'],
            ['name' => 'Hotel Seri Malaysia',     'industry' => 'Hospitality',     'size' => '201-500',   'hq' => 'Selangor',      'founded' => 1998, 'web' => 'hotelserimalaysia.com'],
            ['name' => 'Taste of Asia',           'industry' => 'Hospitality',     'size' => '51-200',    'hq' => 'Penang',        'founded' => 2016, 'web' => 'tasteofasia.my'],

            // ==== LOGISTICS ====
            ['name' => 'SwiftLogistics MY',       'industry' => 'Logistics',       'size' => '501-1000',  'hq' => 'Selangor',      'founded' => 2007, 'web' => 'swiftlogistics.com.my'],
            ['name' => 'CargoMaster Asia',        'industry' => 'Logistics',       'size' => '201-500',   'hq' => 'Johor',         'founded' => 2012, 'web' => 'cargomaster.asia'],
            ['name' => 'PortLink Services',       'industry' => 'Logistics',       'size' => '51-200',    'hq' => 'Penang',        'founded' => 2015, 'web' => 'portlink.my'],

            // ==== CONSULTING ====
            ['name' => 'StratEdge Consulting',    'industry' => 'Consulting',      'size' => '51-200',    'hq' => 'Kuala Lumpur',  'founded' => 2013, 'web' => 'stratedge.com.my'],
            ['name' => 'Prime Advisory Group',    'industry' => 'Consulting',      'size' => '11-50',     'hq' => 'Selangor',      'founded' => 2018, 'web' => 'primeadvisory.my'],
            ['name' => 'Insight Partners MY',     'industry' => 'Consulting',      'size' => '201-500',   'hq' => 'Kuala Lumpur',  'founded' => 2006, 'web' => 'insightpartners.my'],

            // ==== TELECOM ====
            ['name' => 'ConnectTel Malaysia',     'industry' => 'Telecommunications', 'size' => '1000+',  'hq' => 'Kuala Lumpur',  'founded' => 1995, 'web' => 'connecttel.com.my'],
            ['name' => 'FiberNet Asia',           'industry' => 'Telecommunications', 'size' => '201-500', 'hq' => 'Selangor',      'founded' => 2011, 'web' => 'fibernet.asia'],

            // ==== MEDIA ====
            ['name' => 'MediaWorks MY',           'industry' => 'Media',           'size' => '201-500',   'hq' => 'Kuala Lumpur',  'founded' => 2003, 'web' => 'mediaworks.my'],
            ['name' => 'Studio X Productions',    'industry' => 'Media',           'size' => '11-50',     'hq' => 'Penang',        'founded' => 2019, 'web' => 'studiox.my'],
        ];

        // Company description templates
        $descriptionTemplates = [
            "A leading {industry} company based in {hq}, delivering innovative solutions to clients across Malaysia and Southeast Asia.",
            "{name} is a fast-growing {industry} firm committed to excellence. We pride ourselves on our talented team and customer-first approach.",
            "Founded in {founded}, {name} has become a trusted name in the {industry} sector, serving both local and international clients.",
            "We are a dynamic {industry} company headquartered in {hq}. Our mission is to empower businesses through cutting-edge technology and services.",
            "At {name}, we believe in innovation, integrity, and impact. We're building the future of {industry} in Malaysia, one project at a time.",
            "{name} is a {size}-employee {industry} organization dedicated to delivering top-tier results. Join us and grow your career.",
            "With over a decade of experience in {industry}, {name} helps organizations thrive. We're always looking for passionate talent.",
        ];

        // Verification statuses distribution
        // Roughly: 70% verified, 20% pending, 10% rejected
        $totalCompanies = count($companies);

        foreach ($companies as $index => $company) {
            // Create a User for this employer
            $emailLocal = Str::slug($company['name'], '.');
            $user = User::create([
                'first_name'     => $company['name'],
                'last_name'     => '-',
                'email'    => $emailLocal . '@example.com',
                'password' => Hash::make('password'),
                'user_type'     => 'employer',
            ]);

            // Decide verification status
            if ($index < 35) {
                $status      = 'verified';
                $verifiedAt  = now()->subDays(rand(5, 300));
            } elseif ($index < 45) {
                $status      = 'pending';
                $verifiedAt  = null;
            } else {
                $status      = 'rejected';
                $verifiedAt  = null;
            }

            // Pick a random description template and interpolate
            $descTemplate = $descriptionTemplates[array_rand($descriptionTemplates)];
            $description = str_replace(
                ['{name}', '{industry}', '{hq}', '{founded}', '{size}'],
                [
                    $company['name'],
                    $company['industry'],
                    $company['hq'],
                    $company['founded'],
                    $company['size'],
                ],
                $descTemplate
            );

            // Generate LinkedIn / Twitter
            $slug = Str::slug($company['name']);
            $linkedin = rand(0, 100) < 75
                ? "https://www.linkedin.com/company/{$slug}"
                : null;
            $twitter = rand(0, 100) < 50
                ? "https://twitter.com/{$slug}"
                : null;

            // Random phone (Malaysian format)
            $phone = '+60 ' . rand(10, 19) . '-' . rand(1000000, 9999999);

            Employer::create([
                'user_id'             => $user->id,
                'email'               => $emailLocal . '@' . $company['web'],
                'phone'               => $phone,
                'company_name'        => $company['name'],
                'company_logo'        => null, // We'll set placeholders below if you want
                'company_description' => $description,
                'website'             => 'https://' . $company['web'],
                'industry'            => $company['industry'],
                'company_size'        => $company['size'],
                'founded_year'        => $company['founded'],
                'headquarters'        => $company['hq'],
                'linkedin_url'        => $linkedin,
                'twitter_url'         => $twitter,
                'verification_status' => $status,
                'verified_at'         => $verifiedAt,
            ]);
        }

        $this->command->info('✅ Seeded ' . $totalCompanies . ' employers successfully.');
    }
}
