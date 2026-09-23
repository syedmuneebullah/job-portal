<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Employer;
use Carbon\Carbon;

class EmployerWithUserSeeder extends Seeder
{
    /**
     * Realistic Malaysian + regional companies data pool.
     */
    protected array $companies = [
        // [company_name, industry, size, founded, headquarters, website]
        ['Petronas Digital',        'Oil & Gas',      '1000+',   1974, 'Kuala Lumpur',  'https://petronas.com'],
        ['Maybank',                 'Banking',        '1000+',   1960, 'Kuala Lumpur',  'https://maybank.com'],
        ['CIMB Group',              'Banking',        '1000+',   1924, 'Kuala Lumpur',  'https://cimb.com'],
        ['AirAsia Digital',         'Aviation',       '500-1000',2001, 'Sepang',        'https://airasia.com'],
        ['Grab Malaysia',           'Technology',     '1000+',   2012, 'Kuala Lumpur',  'https://grab.com'],
        ['Shopee Malaysia',         'E-Commerce',     '500-1000',2015, 'Kuala Lumpur',  'https://shopee.com.my'],
        ['Maxis Berhad',            'Telecommunications','1000+', 1993, 'Kuala Lumpur',  'https://maxis.com.my'],
        ['Tenaga Nasional',         'Energy',         '1000+',   1990, 'Kuala Lumpur',  'https://tnb.com.my'],
        ['Public Bank',             'Banking',        '1000+',   1966, 'Kuala Lumpur',  'https://publicbank.com.my'],
        ['Genting Group',           'Hospitality',    '1000+',   1965, 'Kuala Lumpur',  'https://genting.com'],
        ['Axiata Group',            'Telecommunications','1000+', 1992, 'Kuala Lumpur',  'https://axiata.com'],
        ['Dialog Group',            'Oil & Gas',      '500-1000',1979, 'Kuala Lumpur',  'https://dialogasia.com'],
        ['Top Glove',               'Manufacturing',  '1000+',   1991, 'Shah Alam',     'https://topglove.com'],
        ['Hartalega',               'Manufacturing',  '1000+',   1991, 'Kuala Lumpur',  'https://hartalega.com.my'],
        ['IHH Healthcare',          'Healthcare',     '1000+',   2011, 'Kuala Lumpur',  'https://ihhhealthcare.com'],
        ['KPJ Healthcare',          'Healthcare',     '1000+',   1981, 'Johor Bahru',   'https://kpjhealth.com.my'],
        ['Sunway Group',            'Conglomerate',   '1000+',   1974, 'Subang Jaya',   'https://sunway.com.my'],
        ['YTL Corporation',         'Conglomerate',   '1000+',   1955, 'Kuala Lumpur',  'https://ytl.com'],
        ['Nestlé Malaysia',         'FMCG',           '1000+',   1912, 'Petaling Jaya', 'https://nestle.com.my'],
        ['Carlsberg Malaysia',      'FMCG',           '500-1000',1969, 'Shah Alam',     'https://carlsbergmalaysia.com.my'],
        ['Astro Malaysia',          'Media',          '1000+',   1996, 'Kuala Lumpur',  'https://astro.com.my'],
        ['Media Prima',             'Media',          '1000+',   2003, 'Petaling Jaya', 'https://mediaprima.com.my'],
        ['Zalora Malaysia',         'E-Commerce',     '100-500', 2012, 'Kuala Lumpur',  'https://zalora.com.my'],
        ['Lazada Malaysia',         'E-Commerce',     '500-1000',2012, 'Kuala Lumpur',  'https://lazada.com.my'],
        ['Foodpanda Malaysia',      'Food Delivery',  '500-1000',2012, 'Kuala Lumpur',  'https://foodpanda.com.my'],
        ['Boost Holdings',          'Fintech',        '100-500', 2017, 'Kuala Lumpur',  'https://boost.com.my'],
        ['Touch n Go Digital',      'Fintech',        '100-500', 2017, 'Kuala Lumpur',  'https://tngdigital.com.my'],
        ['Silverlake Group',        'Technology',     '500-1000',1989, 'Kuala Lumpur',  'https://silverlake.com.my'],
        ['VitalClick Solutions',    'Technology',     '1-50',    2019, 'Cyberjaya',     'https://vitalclick.com'],
        ['Kabel Technik Sdn Bhd',   'Engineering',    '50-100',  2008, 'Penang',        'https://kabeltechnik.com'],
        ['Bright Future Academy',   'Education',      '50-100',  2010, 'Johor Bahru',   'https://brightfuture.edu.my'],
        ['Green Leaf Organics',     'Agriculture',    '1-50',    2015, 'Cameron Highlands','https://greenleaf.my'],
        ['Urban Design Studio',     'Design',         '1-50',    2018, 'Kuala Lumpur',  'https://urbandesign.my'],
        ['Cloud Nine Consultancy',  'Consulting',     '50-100',  2014, 'Selangor',      'https://cloudnine.com.my'],
        ['Penang Softworks',        'Technology',     '100-500', 2011, 'George Town',   'https://penangsoftworks.com'],
        ['Sarawak Energy',          'Energy',         '1000+',   1921, 'Kuching',       'https://sarawakenergy.com'],
        ['Sabah Ports',             'Logistics',      '500-1000',2004, 'Kota Kinabalu', 'https://sabahports.com'],
        ['Iskandar Investment',     'Real Estate',    '100-500', 2006, 'Johor Bahru',   'https://iskandarinvestment.com'],
        ['Malaysia Airlines',       'Aviation',       '1000+',   1947, 'Sepang',        'https://malaysiaairlines.com'],
        ['Velocity Ventures',       'Venture Capital','1-50',    2016, 'Kuala Lumpur',  'https://velocity.vc'],
    ];

    protected array $industries = [
        'Technology', 'Banking', 'Healthcare', 'Manufacturing',
        'E-Commerce', 'Education', 'Design', 'Consulting',
    ];

    protected array $states = [
        'Kuala Lumpur', 'Selangor', 'Penang', 'Johor',
        'Sarawak', 'Sabah', 'Perak', 'Kedah', 'Melaka',
    ];

    /**
     * Run the seeder.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $password = Hash::make('password123');

            foreach ($this->companies as $index => $company) {
                [$name, $industry, $size, $founded, $hq, $website] = $company;

                // Unique email based on company name
                $slug = Str::slug($name);
                $email = "careers@{$slug}.my";

                // Skip if user already exists
                if (User::where('email', $email)->exists()) {
                    $this->command->warn("Skipping existing: {$email}");
                    continue;
                }

                // 1) Create the User
                $user = User::create([
                    'first_name'        => $this->pickFirstName($name),
                    'last_name'         => $this->pickLastName($name),
                    'email'             => $email,
                    'password'          => $password,
                    'user_type'         => 'employer',
                    'status'            => 'active',
                    'phone'             => $this->randomMalaysianPhone(),
                    'profile_photo'     => null,
                    'email_verified_at' => now(),
                ]);

                // 2) Create the Employer profile
                $verificationStatus = $this->weightedVerification();
                $createdAt = Carbon::now()->subDays(rand(30, 400));

                Employer::create([
                    'user_id'              => $user->id,
                    'email'                => $email,
                    'phone'                => $user->phone,
                    'company_name'         => $name,
                    'company_logo'         => null,
                    'company_description'  => $this->generateDescription($name, $industry),
                    'website'              => $website,
                    'industry'             => $industry,
                    'company_size'         => $size,
                    'founded_year'         => $founded,
                    'headquarters'         => $hq,
                    'linkedin_url'         => 'https://linkedin.com/company/' . $slug,
                    'twitter_url'          => rand(0, 1) ? 'https://twitter.com/' . $slug : null,
                    'verification_status'  => $verificationStatus,
                    'verified_at'          => $verificationStatus === 'verified'
                                                ? $createdAt->copy()->addDays(rand(1, 14))
                                                : null,
                    'created_at'           => $createdAt,
                    'updated_at'           => now(),
                ]);
            }

            $this->command->info('✅ Seeded ' . count($this->companies) . ' employers with users.');
        });
    }

    // ===== HELPERS =====

    protected function pickFirstName(string $companyName): string
    {
        $firstWords = ['Ahmad', 'Siti', 'Lim', 'Tan', 'Raj', 'Kumar', 'Nurul', 'Wong',
                       'Farah', 'Hafiz', 'Wei', 'Jian', 'Anis', 'Zaid', 'Chong'];
        return $firstWords[array_rand($firstWords)];
    }

    protected function pickLastName(string $companyName): string
    {
        $lastWords = ['Abdullah', 'Ibrahim', 'Hassan', 'Omar', 'Rahman', 'Lee', 'Ng',
                      'Lim', 'Tan', 'Chua', 'Kumar', 'Rao', 'Ahmad', 'Yusof'];
        return $lastWords[array_rand($lastWords)];
    }

    protected function randomMalaysianPhone(): string
    {
        // Malaysian mobile format: 01X-XXXXXXX
        $prefixes = ['010', '011', '012', '013', '014', '016', '017', '018', '019'];
        $prefix = $prefixes[array_rand($prefixes)];
        return $prefix . '-' . rand(1000000, 9999999);
    }

    protected function weightedVerification(): string
    {
        // 70% verified, 20% pending, 10% rejected
        $roll = rand(1, 100);
        if ($roll <= 70) return 'verified';
        if ($roll <= 90) return 'pending';
        return 'rejected';
    }

    protected function generateDescription(string $name, string $industry): string
    {
        $openings = [
            "{$name} is a leading {$industry} company in Malaysia, committed to innovation and excellence.",
            "Join {$name}, one of Malaysia's fastest growing companies in the {$industry} sector.",
            "{$name} has been a trusted name in the {$industry} industry for decades, delivering world-class solutions.",
            "At {$name}, we believe in empowering talent. We're shaping the future of {$industry} in Southeast Asia.",
            "{$name} is a pioneer in {$industry}, driving digital transformation across the region.",
        ];
        return $openings[array_rand($openings)];
    }
}
