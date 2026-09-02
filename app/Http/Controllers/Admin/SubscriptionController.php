<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of subscription plans
     */
    public function index(Request $request)
    {
        $query = SubscriptionPlan::query();

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by user type
        if ($request->filled('user_type')) {
            $query->byUserType($request->user_type);
        }

        // Filter by active status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->active();
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Sort
        $sortBy = $request->sort_by ?? 'sort_order';
        $sortOrder = $request->sort_order ?? 'asc';
        $allowedSorts = ['id', 'name', 'price', 'billing_period', 'target_user_type', 'sort_order', 'created_at'];
        
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        // Paginate
        $perPage = $request->per_page ?? 10;
        $plans = $query->paginate($perPage);

        // Get statistics
        $stats = [
            'total' => SubscriptionPlan::count(),
            'active' => SubscriptionPlan::active()->count(),
            'inactive' => SubscriptionPlan::where('is_active', false)->count(),
            'free' => SubscriptionPlan::where('price', 0)->count(),
            'paid' => SubscriptionPlan::where('price', '>', 0)->count(),
            'employer' => SubscriptionPlan::byUserType('employer')->count(),
            'recruiter' => SubscriptionPlan::byUserType('recruiter')->count(),
            'applicant' => SubscriptionPlan::byUserType('applicant')->count(),
        ];

        // Get user types for filter
        $userTypes = [
            'employer' => 'Employer',
            'recruiter' => 'Recruiter',
            'applicant' => 'Applicant',
            'admin' => 'Admin',
        ];

        return view('admin.pages.subscriptions.index', compact('plans', 'stats', 'userTypes'));
    }

    /**
     * Show the form for creating a new subscription plan
     */
    public function create()
    {
        $userTypes = [
            'employer' => 'Employer',
            'recruiter' => 'Recruiter',
            'applicant' => 'Applicant',
            'admin' => 'Admin',
        ];

        $billingPeriods = [
            'monthly' => 'Monthly',
            'quarterly' => 'Quarterly',
            'yearly' => 'Yearly',
            'one_time' => 'One Time',
        ];

        return view('admin.pages.subscriptions.create', compact('userTypes', 'billingPeriods'));
    }

    /**
     * Store a newly created subscription plan
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:subscription_plans,name',
            'description' => 'nullable|string',
            'target_user_type' => 'required|in:admin,employer,recruiter,applicant',
            'price' => 'required|numeric|min:0|max:999999.99',
            'currency' => 'required|string|size:3|in:USD,GBP,EUR',
            'billing_period' => 'required|in:monthly,quarterly,yearly,one_time',
            'features' => 'nullable|array',
            'features.*' => 'string|max:255',
            'limits' => 'nullable|array',
            'limits.*' => 'string|max:255',
            'is_active' => 'nullable|boolean',
            'trial_days' => 'nullable|integer|min:0',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['trial_days'] = $validated['trial_days'] ?? 0;
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        // Process features and limits
        if (isset($validated['features'])) {
            $validated['features'] = array_filter($validated['features']);
        }
        if (isset($validated['limits'])) {
            $validated['limits'] = array_filter($validated['limits']);
        }

        $plan = SubscriptionPlan::create($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Subscription plan created successfully',
                'data' => $plan
            ], 201);
        }

        flash()->success('Subscription plan created successfully');
        return redirect()->route('admin.subscription-plans.index');
    }

    /**
     * Display the specified subscription plan
     */
    public function show($id)
    {
        $plan = SubscriptionPlan::withCount('subscriptions')->findOrFail($id);
        
        // Get subscription statistics
        $subscriptionStats = [
            'total' => $plan->subscriptions()->count(),
            'active' => $plan->subscriptions()->where('status', 'active')->count(),
            'expired' => $plan->subscriptions()->where('status', 'expired')->count(),
            'cancelled' => $plan->subscriptions()->where('status', 'cancelled')->count(),
        ];

        return view('admin.pages.subscriptions.show', compact('plan', 'subscriptionStats'));
    }

    /**
     * Show the form for editing the specified subscription plan
     */
    public function edit($id)
    {
        $plan = SubscriptionPlan::findOrFail($id);

        $userTypes = [
            'employer' => 'Employer',
            'recruiter' => 'Recruiter',
            'applicant' => 'Applicant',
            'admin' => 'Admin',
        ];

        $billingPeriods = [
            'monthly' => 'Monthly',
            'quarterly' => 'Quarterly',
            'yearly' => 'Yearly',
            'one_time' => 'One Time',
        ];

        return view('admin.pages.subscriptions.edit', compact('plan', 'userTypes', 'billingPeriods'));
    }

    /**
     * Update the specified subscription plan
     */
    public function update(Request $request, $id)
    {
        $plan = SubscriptionPlan::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:subscription_plans,name,' . $id,
            'description' => 'nullable|string',
            'target_user_type' => 'required|in:admin,employer,recruiter,applicant',
            'price' => 'required|numeric|min:0|max:999999.99',
            'currency' => 'required|string|size:3|in:USD,GBP,EUR',
            'billing_period' => 'required|in:monthly,quarterly,yearly,one_time',
            'features' => 'nullable|array',
            'features.*' => 'string|max:255',
            'limits' => 'nullable|array',
            'limits.*' => 'string|max:255',
            'is_active' => 'nullable|boolean',
            'trial_days' => 'nullable|integer|min:0',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['trial_days'] = $validated['trial_days'] ?? 0;
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        // Process features and limits
        if (isset($validated['features'])) {
            $validated['features'] = array_filter($validated['features']);
        }
        if (isset($validated['limits'])) {
            $validated['limits'] = array_filter($validated['limits']);
        }

        $plan->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Subscription plan updated successfully',
                'data' => $plan
            ]);
        }

        flash()->success('Subscription plan updated successfully');
        return redirect()->route('admin.subscription-plans.index');
    }

    /**
     * Remove the specified subscription plan
     */
    public function destroy($id)
    {
        $plan = SubscriptionPlan::findOrFail($id);

        // Check if plan has active subscriptions
        if ($plan->subscriptions()->where('status', 'active')->exists()) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete plan with active subscriptions'
                ], 422);
            }
            
            flash()->error('Cannot delete plan with active subscriptions');
            return redirect()->back();
        }

        $plan->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Subscription plan deleted successfully'
            ]);
        }

        flash()->success('Subscription plan deleted successfully');
        return redirect()->route('admin.subscription-plans.index');
    }

    /**
     * Toggle plan status (PATCH)
     */
    public function toggleStatus(Request $request, $id)
    {
        $plan = SubscriptionPlan::findOrFail($id);
        $plan->is_active = !$plan->is_active;
        $plan->save();

        // Check if request expects JSON
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $plan->is_active ? 'Plan activated successfully' : 'Plan deactivated successfully',
                'data' => $plan
            ]);
        }

        flash()->success($plan->is_active ? 'Plan activated successfully' : 'Plan deactivated successfully');
        return redirect()->route('admin.subscription-plans.index');
    }

    /**
     * Bulk delete plans (POST)
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:subscription_plans,id'
        ]);

        // Check if any plan has active subscriptions
        $hasActiveSubscriptions = SubscriptionPlan::whereIn('id', $request->ids)
            ->whereHas('subscriptions', function($q) {
                $q->where('status', 'active');
            })
            ->exists();

        if ($hasActiveSubscriptions) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete plans with active subscriptions'
                ], 422);
            }
            
            flash()->error('Cannot delete plans with active subscriptions');
            return redirect()->back();
        }

        $deleted = SubscriptionPlan::whereIn('id', $request->ids)->delete();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "{$deleted} plans deleted successfully"
            ]);
        }

        flash()->success($deleted . ' plans deleted successfully');
        return redirect()->route('admin.subscription-plans.index');
    }

    /**
     * Bulk update status (POST)
     */
    public function bulkStatusUpdate(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:subscription_plans,id',
            'status' => 'required|boolean'
        ]);

        $updated = SubscriptionPlan::whereIn('id', $request->ids)
            ->update(['is_active' => $request->status]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "{$updated} plans updated successfully"
            ]);
        }

        flash()->success($updated . ' plans updated successfully');
        return redirect()->route('admin.subscription-plans.index');
    }

    /**
     * Duplicate a plan (POST)
     */
    public function duplicate(Request $request, $id)
    {
        $originalPlan = SubscriptionPlan::findOrFail($id);
        
        $newPlan = $originalPlan->replicate();
        $newPlan->name = $originalPlan->name . ' (Copy)';
        $newPlan->is_active = false;
        $newPlan->sort_order = 0;
        $newPlan->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Plan duplicated successfully',
                'data' => $newPlan
            ]);
        }

        flash()->success('Plan duplicated successfully');
        return redirect()->route('admin.subscription-plans.index');
    }

     /**
     * Display a listing of all user subscriptions
     */
    public function subscriptions(Request $request)
    {
        $query = UserSubscription::with(['user', 'plan']);

        // Search by user name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('first_name', 'LIKE', "%{$search}%")
                  ->orWhere('last_name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            })->orWhereHas('plan', function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by plan
        if ($request->filled('plan_id')) {
            $query->where('subscription_plan_id', $request->plan_id);
        }

        // Filter by date range
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        // Sort
        $sortBy = $request->sort_by ?? 'created_at';
        $sortOrder = $request->sort_order ?? 'desc';
        $allowedSorts = ['id', 'status', 'created_at', 'updated_at', 'ends_at', 'trial_ends_at'];
        
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        // Paginate
        $perPage = $request->per_page ?? 15;
        $subscriptions = $query->paginate($perPage);

        // Get statistics
        $stats = [
            'total' => UserSubscription::count(),
            'active' => UserSubscription::where('status', 'active')->count(),
            'trial' => UserSubscription::where('status', 'trial')->count(),
            'expired' => UserSubscription::where('status', 'expired')->count(),
            'cancelled' => UserSubscription::where('status', 'cancelled')->count(),
            'inactive' => UserSubscription::where('status', 'inactive')->count(),
        ];

        // Get plans for filter
        $plans = SubscriptionPlan::select('id', 'name')->orderBy('name')->get();

        // Status options for filter
        $statuses = [
            'active' => 'Active',
            'trial' => 'Trial',
            'expired' => 'Expired',
            'cancelled' => 'Cancelled',
            'inactive' => 'Inactive',
        ];

        return view('admin.pages.user-subscriptions.subscriptions', compact('subscriptions', 'stats', 'plans', 'statuses'));
    }

    /**
     * Display a specific user subscription details
     */
    public function showSubscription($id)
    {
        $subscription = UserSubscription::with(['user', 'plan', 'transactions'])->findOrFail($id);

        // Get transaction history
        $transactions = $subscription->transactions()->latest()->paginate(10);

        // Get subscription timeline
        $timeline = [
            'created_at' => $subscription->created_at,
            'trial_started' => $subscription->trial_ends_at ? $subscription->created_at : null,
            'trial_ends_at' => $subscription->trial_ends_at,
            'active_since' => $subscription->status === 'active' ? $subscription->updated_at : null,
            'ends_at' => $subscription->ends_at,
            'cancelled_at' => $subscription->status === 'cancelled' ? $subscription->updated_at : null,
        ];

        return view('admin.pages.user-subscriptions.show-subscription', compact('subscription', 'transactions', 'timeline'));
    }

    /**
     * Update a user subscription (admin action)
     */
    public function updateSubscription(Request $request, $id)
    {
        $subscription = UserSubscription::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:active,trial,expired,cancelled,inactive',
            'subscription_plan_id' => 'required|exists:subscription_plans,id',
            'trial_ends_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after:trial_ends_at',
            'next_billing_at' => 'nullable|date',
            'custom_features' => 'nullable|array',
            'custom_features.*' => 'string|max:255',
        ]);

        $subscription->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Subscription updated successfully',
                'data' => $subscription
            ]);
        }

        flash()->success('Subscription updated successfully');
        return redirect()->route('admin.subscriptions.show', $subscription->id);
    }

    /**
     * Cancel a user subscription
     */
    public function cancelSubscription($id)
    {
        $subscription = UserSubscription::findOrFail($id);
        $subscription->cancel();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Subscription cancelled successfully'
            ]);
        }

        flash()->success('Subscription cancelled successfully');
        return redirect()->back();
    }

    /**
     * Activate a user subscription
     */
    public function activateSubscription($id)
    {
        $subscription = UserSubscription::findOrFail($id);
        $subscription->activate();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Subscription activated successfully'
            ]);
        }

        flash()->success('Subscription activated successfully');
        return redirect()->back();
    }

    /**
     * Extend a user subscription
     */
    public function extendSubscription(Request $request, $id)
    {
        $request->validate([
            'days' => 'required|integer|min:1|max:3650',
            'reason' => 'nullable|string|max:255',
        ]);

        $subscription = UserSubscription::findOrFail($id);

        // Extend the end date
        if ($subscription->ends_at) {
            $subscription->ends_at = $subscription->ends_at->addDays((int) $request->days);
        } else {
            $subscription->ends_at = now()->addDays((int) $request->days);
        }

        // If status is expired, change to active
        if ($subscription->status === 'expired') {
            $subscription->status = 'active';
        }

        $subscription->save();

        // Log the extension (you can create a history table for this)
        // SubscriptionHistory::create([...]);

        // if ($request->ajax()) {
        //     return response()->json([
        //         'success' => true,
        //         'message' => "Subscription extended by {$request->days} days",
        //         'data' => $subscription
        //     ]);
        // }

        flash()->success("Subscription extended by {$request->days} days");
        return redirect()->back();
    }

    /**
     * Bulk update subscription status
     */
    public function bulkSubscriptionUpdate(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:user_subscriptions,id',
            'status' => 'required|in:active,trial,expired,cancelled,inactive'
        ]);

        $updated = UserSubscription::whereIn('id', $request->ids)
            ->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => "{$updated} subscriptions updated successfully"
        ]);
    }
}