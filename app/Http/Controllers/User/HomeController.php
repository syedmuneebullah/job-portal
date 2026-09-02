<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use App\Models\JobPost;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    //
    public function index()
    {
        // Get featured/published jobs with eager loading
        $featuredJobs = JobPost::with(['employer' => function($query) {
            $query->select('id', 'company_name', 'company_logo', 'industry');
        }])
        ->where('status', 'published')
        ->whereNull('deleted_at')
        ->orderBy('created_at', 'desc')
        ->take(6) // Show 6 jobs on homepage
        ->get();

        // Get total job count for the "View All Jobs" button
        $totalJobs = JobPost::where('status', 'published')
            ->whereNull('deleted_at')
            ->count();

        return view('user.pages.index', compact('featuredJobs', 'totalJobs'));
    }

    public function Landing()
    {
        return view('user.pages.landing');
    }

    public function JobListings()
    {
        return view('user.pages.jobs.listings');
    }

    public function JobDetails($id)
    {
       $job = JobPost::with(['employer', 'questions'])
            ->where('status', 'published')
            ->whereNull('deleted_at')
            ->findOrFail($id);

        // Get similar jobs (based on category or location)
        $similarJobs = JobPost::with(['employer'])
            ->where('status', 'published')
            ->whereNull('deleted_at')
            ->where('id', '!=', $job->id)
            ->where(function($query) use ($job) {
                $query->where('location', $job->location)
                      ->orWhere('work_type', $job->work_type)
                      ->orWhere('employment_type', $job->employment_type);
            })
            ->take(3)
            ->get();

        return view('user.pages.jobs.job-details', compact('job', 'similarJobs'));
    }

    public function About()
    {
        return view('user.pages.about');
    }

    public function Contact()
    {
        return view('user.pages.contact');
    }

        public function pricing()
    {
        // Get active subscription plans
        $plans = SubscriptionPlan::active()
            ->orderBy('sort_order', 'asc')
            ->orderBy('price', 'asc')
            ->get();
        
        // If no active plans, get all plans
        if ($plans->isEmpty()) {
            $plans = SubscriptionPlan::orderBy('sort_order', 'asc')
                ->orderBy('price', 'asc')
                ->get();
        }

        return view('user.pages.pricing', compact('plans'));
    }

    /**
     * Subscribe to a plan
     */
    public function subscribe(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:subscription_plans,id'
        ]);

        $plan = SubscriptionPlan::findOrFail($request->plan_id);
        $user = auth()->user();

        // Check if user already has an active subscription
        $existingSubscription = $user->subscriptions()
            ->whereIn('status', ['active', 'trial'])
            ->first();

        if ($existingSubscription) {
            return response()->json([
                'success' => false,
                'message' => 'You already have an active subscription.'
            ], 422);
        }

        // Check if user has an expired subscription that can be reactivated
        $expiredSubscription = $user->subscriptions()
            ->where('status', 'expired')
            ->first();

        // If plan is free, create subscription directly
        if ($plan->price == 0) {
            // If there's an expired subscription, reactivate it
            if ($expiredSubscription) {
                $expiredSubscription->update([
                    'subscription_plan_id' => $plan->id,
                    'status' => 'active',
                    'trial_ends_at' => null,
                    'ends_at' => null,
                    'next_billing_at' => null,
                ]);
                
                $subscription = $expiredSubscription;
            } else {
                $subscription = $user->subscriptions()->create([
                    'subscription_plan_id' => $plan->id,
                    'status' => 'active',
                    'trial_ends_at' => null,
                    'ends_at' => null,
                    'next_billing_at' => null,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Subscribed successfully to ' . $plan->name,
                'redirect' => route('user.dashboard')
            ]);
        }

        // For paid plans - check if plan has trial period
        $trialDays = $plan->trial_days ?? 0;
        $status = $trialDays > 0 ? 'trial' : 'active';
        
        // Calculate trial end date if trial is available
        $trialEndsAt = $trialDays > 0 ? now()->addDays($trialDays) : null;
        
        // Calculate subscription end date (for paid plans)
        $endsAt = $this->calculateEndDate($plan->billing_period);

        // Create subscription
        $subscription = $user->subscriptions()->create([
            'subscription_plan_id' => $plan->id,
            'status' => $status,
            'trial_ends_at' => $trialEndsAt,
            'ends_at' => $trialDays > 0 ? null : $endsAt,
            'next_billing_at' => $trialDays > 0 ? $trialEndsAt : $endsAt,
        ]);

        // If trial is available, return trial started message
        if ($trialDays > 0) {
            return response()->json([
                'success' => true,
                'message' => "Trial started! You have {$trialDays} days free. You will be charged after the trial period.",
                'redirect' => route('user.home'),
                'trial_days' => $trialDays,
                'trial_ends_at' => $trialEndsAt
            ]);
        }

        // For paid plans without trial, redirect to payment gateway
        return response()->json([
            'success' => true,
            'message' => 'Redirecting to payment...',
            'redirect' => route('user.checkout', ['plan' => $plan->id])
        ]);
    }

    /**
     * Calculate end date based on billing period
     */
    private function calculateEndDate($billingPeriod)
    {
        switch ($billingPeriod) {
            case 'monthly':
                return now()->addMonth();
            case 'quarterly':
                return now()->addMonths(3);
            case 'yearly':
                return now()->addYear();
            case 'one_time':
                return null; // One-time payment doesn't expire
            default:
                return now()->addMonth();
        }
    }

    /**
     * Checkout page for paid plans
     */
    public function checkout($planId)
    {
        $plan = SubscriptionPlan::findOrFail($planId);
        $user = auth()->user();
        
        return view('user.pages.checkout', compact('plan', 'user'));
    }

    /**
     * Cancel subscription
     */
    public function cancelSubscription($id)
    {
        $subscription = UserSubscription::findOrFail($id);
        
        // Ensure the subscription belongs to the authenticated user
        if ($subscription->user_id != auth()->id()) {
            abort(403);
        }

        $subscription->cancel();

        return response()->json([
            'success' => true,
            'message' => 'Subscription cancelled successfully.'
        ]);
    }

    /**
     * Get user's current subscription status
     */
    public function subscriptionStatus()
    {
        $user = auth()->user();
        $subscription = $user->subscriptions()
            ->whereIn('status', ['active', 'trial'])
            ->first();

        if (!$subscription) {
            return response()->json([
                'has_subscription' => false,
                'message' => 'No active subscription found.'
            ]);
        }

        return response()->json([
            'has_subscription' => true,
            'subscription' => [
                'id' => $subscription->id,
                'plan_name' => $subscription->plan?->name,
                'status' => $subscription->status,
                'is_active' => $subscription->is_active,
                'is_trial' => $subscription->is_trial,
                'is_expired' => $subscription->is_expired,
                'trial_ends_at' => $subscription->trial_ends_at,
                'ends_at' => $subscription->ends_at,
                'remaining_days' => $subscription->remaining_days,
                'next_billing_at' => $subscription->next_billing_at,
            ]
        ]);
    }


}
