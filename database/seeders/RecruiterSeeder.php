<?php

namespace Database\Seeders;

use App\Models\Employer;
use App\Models\Recruiter;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RecruiterSeeder extends Seeder
{
    public function run(): void
    {
        $employers = Employer::all();

        if ($employers->isEmpty()) {
            $this->command->warn('⚠️  No employers found. Run EmployerSeeder first.');
            return;
        }

        $specializations = [
            'Technology & Engineering',
            'Finance & Accounting',
            'Sales & Marketing',
            'Healthcare & Life Sciences',
            'Design & Creative',
            'Education & Training',
            'Logistics & Supply Chain',
            'General Recruitment',
        ];

        $certifications = [
            'CIPD Certified',
            'SHRM-CP',
            'Recruiter Academy Certified',
            'LinkedIn Talent Solutions',
            'AIRP Certified',
            'HRDF Certified Trainer',
        ];

        $positions = [
            'HR Manager',
            'Talent Acquisition Lead',
            'Recruitment Specialist',
            'Hiring Manager',
            'HR Executive',
            'People Operations Manager',
        ];

        $totalRecruiters = 0;

        foreach ($employers as $employer) {
            // Each employer gets 1–2 recruiters
            $count = rand(1, 2);

            for ($i = 0; $i < $count; $i++) {
                $firstName = fake()->firstName();
                $lastName  = fake()->lastName();
                $fullName  = "{$firstName} {$lastName}";
                $slug      = Str::slug($employer->company_name) . '.' . Str::slug($firstName) . rand(1, 99);

                // Create the User
                $user = User::create([
                    'name'     => $fullName,
                    'email'    => $slug . '@example.com',
                    'password' => Hash::make('password'),
                    'role'     => 'recruiter',
                ]);

                // 80% internal, 20% agency
                $type = (rand(1, 100) <= 80) ? 'internal' : 'agency';

                // Approval: 85% approved, 10% pending, 5% rejected
                $r = rand(1, 100);
                if ($r <= 85) {
                    $approvalStatus = 'approved';
                    $approvedAt     = now()->subDays(rand(1, 300));
                    $approvedBy     = 1; // assume admin user id 1
                } elseif ($r <= 95) {
                    $approvalStatus = 'pending';
                    $approvedAt     = null;
                    $approvedBy     = null;
                } else {
                    $approvalStatus = 'rejected';
                    $approvedAt     = null;
                    $approvedBy     = null;
                }

                // Agency fields only if agency type
                $agencyName    = $type === 'agency' ? fake()->company() . ' Recruitment' : null;
                $agencyWebsite = $type === 'agency' ? 'https://' . Str::slug($agencyName) . '.com' : null;

                // Pick 1–3 certifications
                shuffle($certifications);
                $certs = array_slice($certifications, 0, rand(1, 3));

                Recruiter::create([
                    'user_id'        => $user->id,
                    'recruiter_type' => $type,
                    'agency_name'    => $agencyName,
                    'agency_website' => $agencyWebsite,
                    'specialization' => $specializations[array_rand($specializations)],
                    'years_experience' => rand(1, 15),
                    'certifications' => $certs,
                    'approval_status' => $approvalStatus,
                    'approved_at'    => $approvedAt,
                    'approved_by'    => $approvedBy,
                ]);

                $totalRecruiters++;
            }
        }

        $this->command->info("✅ Seeded {$totalRecruiters} recruiters for {$employers->count()} employers.");
    }
}
