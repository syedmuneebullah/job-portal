<?php

namespace App\Services;

use App\Models\JobPost;
use App\Models\Application;
use App\Models\ApplicantProfile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ScreeningService
{
    protected array $defaultWeights = [
        'skills'     => 35,
        'experience' => 25,
        'education'  => 15,
        'location'   => 10,
        'salary'     => 10,
        'answers'    => 5,
    ];

    /**
     * Score a single application.
     */
    public function score(Application $application): array
    {
        $job       = $application->jobPost;
        $applicant = $application->applicant;
        $profile   = $applicant?->applicantProfile ?? new ApplicantProfile();

        $weights = $job->effective_weights;

        $breakdown = [
            'skills'     => $this->scoreSkills($job, $profile, $weights['skills']),
            'experience' => $this->scoreExperience($job, $applicant, $weights['experience']),
            'education'  => $this->scoreEducation($job, $applicant, $weights['education']),
            'location'   => $this->scoreLocation($job, $profile, $weights['location']),
            'salary'     => $this->scoreSalary($job, $profile, $weights['salary']),
            'answers'    => $this->scoreAnswers($job, $application, $weights['answers']),
        ];

        $total = round(array_sum($breakdown), 2);

        [$knocked, $reason] = $this->checkKnockouts($job, $profile, $application);

        return [
            'score'           => $total,
            'band'            => $this->band($total),
            'breakdown'       => $breakdown,
            'knockout'        => $knocked,
            'knockout_reason' => $reason,
        ];
    }

    /**
     * Score every application for a job.
     */
    public function screenJob(JobPost $job): int
    {
        $count = 0;

        $job->applications()
            ->with(['applicant.applicantProfile', 'applicant.experiences', 'applicant.educations', 'jobPost'])
            ->chunk(100, function ($apps) use (&$count) {
                foreach ($apps as $app) {
                    $result = $this->score($app);
                    $app->update([
                        'screening_score'     => $result['score'],
                        'screening_band'      => $result['band'],
                        'screening_breakdown' => $result['breakdown'],
                        'auto_knocked_out'    => $result['knockout'],
                        'knockout_reason'     => $result['knockout_reason'],
                        'screened_at'         => now(),
                    ]);
                    $count++;
                }
            });

        return $count;
    }

    // ============================================================
    // CATEGORY SCORERS
    // ============================================================

    protected function scoreSkills(JobPost $job, ApplicantProfile $profile, int $max): float
    {
        $required  = $this->toArray($job->required_skills);
        $preferred = $this->toArray($job->preferred_skills);
        $candidate = array_map('strtolower', $this->toArray($profile->skills));

        if (empty($required) && empty($preferred)) return $max;

        $matchCount = fn(array $arr) => count(array_filter(
            $arr,
            fn($s) => in_array(strtolower(trim($s)), $candidate, true)
        ));

        $reqRatio = count($required)  ? $matchCount($required)  / count($required)  : 1;
        $preRatio = count($preferred) ? $matchCount($preferred) / count($preferred) : 1;

        // 70% required, 30% preferred
        $ratio = ($reqRatio * 0.7) + ($preRatio * 0.3);

        return round($ratio * $max, 2);
    }

    protected function scoreExperience(JobPost $job, $applicant, int $max): float
    {
        $requiredYears = $this->requiredYears($job);
        if ($requiredYears <= 0) return $max;

        $candidateYears = $this->totalExperienceYears($applicant);
        if ($candidateYears >= $requiredYears) return $max;

        return round(min($candidateYears / $requiredYears, 1) * $max, 2);
    }

    protected function scoreEducation(JobPost $job, $applicant, int $max): float
    {
        $required = strtolower($job->education_requirement ?? '');
        if (!$required) return $max;

        $levels = [
            'phd' => 5, 'doctorate' => 5,
            'master' => 4, 'mba' => 4, 'msc' => 4,
            'bachelor' => 3, 'degree' => 3, 'bsc' => 3, 'ba' => 3,
            'diploma' => 2,
            'certificate' => 1, 'high school' => 1, 'spm' => 1,
        ];

        $requiredRank = $this->detectLevel($required, $levels);
        if ($requiredRank === 0) return $max;

        $candidateRank = 0;
        foreach (($applicant->educations ?? collect()) as $edu) {
            $candidateRank = max(
                $candidateRank,
                $this->detectLevel(strtolower($edu->education_title ?? ''), $levels)
            );
        }

        if ($candidateRank >= $requiredRank) return $max;

        return round(($candidateRank / $requiredRank) * $max, 2);
    }

    protected function scoreLocation(JobPost $job, ApplicantProfile $profile, int $max): float
    {
        if (strtolower($job->work_type ?? '') === 'remote') return $max;

        $jobLoc = strtolower(trim($job->location ?? ''));
        if (!$jobLoc) return $max;

        $preferredLocations = array_map('strtolower', $this->toArray($profile->preferred_locations));
        $candidateLocation  = strtolower(trim($profile->current_location ?? ''));

        // Exact or partial match
        foreach (array_merge([$candidateLocation], $preferredLocations) as $loc) {
            if ($loc && str_contains($jobLoc, $loc)) return $max;
        }

        // Hybrid → partial
        if (strtolower($job->work_type ?? '') === 'hybrid') {
            return round($max * 0.4, 2);
        }

        return 0;
    }

    protected function scoreSalary(JobPost $job, ApplicantProfile $profile, int $max): float
    {
        $jobMin = (float) ($job->salary_min ?? 0);
        $jobMax = (float) ($job->salary_max ?? 0);
        $expMin = (float) ($profile->salary_expectation_min ?? 0);
        $expMax = (float) ($profile->salary_expectation_max ?? 0);

        if (!$jobMin || !$jobMax || !$expMin) return $max;

        if ($expMin >= $jobMin && $expMin <= $jobMax) return $max;

        if ($expMin <= $jobMax && $expMax >= $jobMin) return round($max * 0.7, 2);

        if ($expMin > $jobMax && $expMin <= $jobMax * 1.15) return round($max * 0.4, 2);

        return 0;
    }

    protected function scoreAnswers(JobPost $job, Application $application, int $max): float
    {
        $questions = $job->questions ?? collect();
        if ($questions->isEmpty()) return $max;

        $answers = is_array($application->answers)
            ? $application->answers
            : json_decode($application->answers ?? '[]', true);

        $scored = 0;
        $total  = 0;

        foreach ($questions as $q) {
            if (!$q->required) continue;
            $total++;
            $given = $answers[(string) $q->id] ?? $answers[$q->id] ?? null;

            if ($given === null || $given === '') continue;

            $expected = $q->expected_answer ?? null;
            if ($expected === null || strtolower((string) $given) === strtolower((string) $expected)) {
                $scored++;
            }
        }

        return $total === 0 ? $max : round(($scored / $total) * $max, 2);
    }

    // ============================================================
    // KNOCKOUTS
    // ============================================================

    protected function checkKnockouts(JobPost $job, ApplicantProfile $profile, Application $application): array
    {
        $rules = $job->knockout_rules ?? [];

        // 1. Mandatory question wrong
        if (!empty($rules['require_correct_answers'])) {
            $answers = is_array($application->answers)
                ? $application->answers
                : json_decode($application->answers ?? '[]', true);

            foreach (($job->questions ?? collect()) as $q) {
                if (!$q->required || !$q->expected_answer) continue;
                $given = $answers[(string) $q->id] ?? null;
                if (strtolower((string) $given) !== strtolower((string) $q->expected_answer)) {
                    return [true, 'Failed mandatory question: ' . $q->question];
                }
            }
        }

        // 2. Salary too high
        if (!empty($rules['salary_buffer_percent'])) {
            $jobMax = (float) ($job->salary_max ?? 0);
            $expMin = (float) ($profile->salary_expectation_min ?? 0);
            $buffer = (float) $rules['salary_buffer_percent'];

            if ($jobMax > 0 && $expMin > $jobMax * (1 + $buffer / 100)) {
                return [true, sprintf(
                    'Expected salary %.0f%% above range',
                    (($expMin / $jobMax) - 1) * 100
                )];
            }
        }

        // 3. Min experience
        if (!empty($rules['min_experience_years'])) {
            $years = $this->totalExperienceYears($application->applicant);
            if ($years < (float) $rules['min_experience_years']) {
                return [true, sprintf(
                    'Only %.1f yrs experience (min %s)',
                    $years,
                    $rules['min_experience_years']
                )];
            }
        }

        return [false, null];
    }

    // ============================================================
    // HELPERS
    // ============================================================

    /**
     * Extract required years from job's experience_level or a custom field.
     */
    protected function requiredYears(JobPost $job): float
    {
        // If you have an explicit field, use it. Otherwise infer from experience_level.
        if (isset($job->experience_years)) return (float) $job->experience_years;

        return match (strtolower($job->experience_level ?? '')) {
            'entry', 'entry_level', 'internship', 'fresher' => 0,
            'junior', 'junior_level', '1_2_years', '1-2'    => 1.5,
            'mid', 'mid_level', '2_4_years', '3-5'          => 3,
            'senior', 'senior_level', '5_plus', '5+'       => 5,
            'lead', 'principal', 'manager', '10_plus'       => 8,
            default                                          => 0,
        };
    }

    /**
     * Total years of work experience from applicant's experiences.
     */
    protected function totalExperienceYears($applicant): float
    {
        if (!$applicant) return 0;

        $months = 0;
        foreach (($applicant->experiences ?? collect()) as $exp) {
            $start = $exp->start_date ? Carbon::parse($exp->start_date) : null;
            $end   = ($exp->on_going === 'yes' || !$exp->end_date)
                ? now()
                : Carbon::parse($exp->end_date);

            if ($start && $end->gt($start)) {
                $months += $start->diffInMonths($end);
            }
        }

        return round($months / 12, 1);
    }

    protected function band(float $score): string
    {
        if ($score >= 80) return Application::BAND_STRONG;
        if ($score >= 60) return Application::BAND_GOOD;
        if ($score >= 40) return Application::BAND_AVERAGE;
        return Application::BAND_WEAK;
    }

    protected function toArray($value): array
    {
        if (is_array($value)) return $value;
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : array_filter(array_map('trim', explode(',', $value)));
        }
        return [];
    }

    protected function detectLevel(string $text, array $levels): int
    {
        foreach ($levels as $keyword => $rank) {
            if (str_contains($text, $keyword)) return $rank;
        }
        return 0;
    }
}