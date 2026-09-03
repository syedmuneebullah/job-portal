<?php

namespace App\Http\Controllers\Auth\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function RegisterView()
    {
        return view('auth.user.register');
    }

    public function LoginView()
    {
        return view('auth.user.login');
    }

    /**
     * Register a new user
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'user_type' => 'required|in:admin,employer,recruiter,job_seeker',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => $request->user_type,
            'status' => $request->user_type === 'admin' ? 'active' : 'pending',
        ]);

        // Create profiles based on user type
        if ($request->user_type === 'employer') {
            $user->employer()->create([
                'company_name' => $request->company_name ?? 'My Company',
                'verification_status' => 'pending',
            ]);
        }

        if ($request->user_type === 'recruiter') {
            $user->recruiter()->create([
                'recruiter_type' => $request->recruiter_type ?? 'freelance',
                'approval_status' => 'pending',
            ]);
        }

        if ($request->user_type === 'job_seeker') {
            $user->applicantProfile()->create([
                'is_visible' => true,
            ]);
        }

        flash()->success('Registration successful! Please login.');
        return redirect()->route('auth.user.login');
    }

    /**
     * Login user
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if (!Auth::attempt($request->only('email', 'password'), $request->remember ?? false)) {
            return redirect()->back()
                ->withErrors(['email' => 'The provided credentials are incorrect.'])
                ->withInput();
        }

        $user = Auth::user();

        // Check user status
        if ($user->status === 'pending') {
            Auth::logout();
            return redirect()->back()
                ->withErrors(['email' => 'Your account is pending approval. Please wait for admin approval.']);
        }

        if ($user->status === 'suspended') {
            Auth::logout();
            return redirect()->back()
                ->withErrors(['email' => 'Your account has been suspended. Please contact admin.']);
        }

        if ($user->status === 'rejected') {
            Auth::logout();
            return redirect()->back()
                ->withErrors(['email' => 'Your account has been rejected. Please contact admin.']);
        }

        // Redirect based on user type
        if ($user->user_type === 'admin') {
            return redirect()->route('dashboard');
        } elseif ($user->user_type === 'employer') {
            return redirect()->route('employer.dashboard');
        } elseif ($user->user_type === 'recruiter') {
            return redirect()->route('recruiter.dashboard');
        }elseif ($user->user_type === 'job_seeker') {
            return redirect()->route('candidate.dashboard');
        } else {
            return redirect()->route('user.home');
        }
    }

    /**
     * Logout user (Web)
     */
    public function logout(Request $request)
    {
        // For web logout (session-based)
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        flash()->success('Logged out successfully!');
        return redirect()->route('auth.user.login');
    }

    /**
     * API Logout (Sanctum token-based)
     * This should be in a separate API controller ideally
     */
    public function apiLogout(Request $request)
    {
        try {
            $user = $request->user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            // Delete current access token
            $token = $user->currentAccessToken();
            if ($token) {
                $token->delete();
            }

            return response()->json([
                'success' => true,
                'message' => 'Logged out successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Logout failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get authenticated user (API)
     */
    public function user(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        // Load relationships based on user type
        if ($user->user_type === 'employer') {
            $user->load('employer');
        } elseif ($user->user_type === 'recruiter') {
            $user->load('recruiter');
        } elseif ($user->user_type === 'job_seeker') {
            $user->load('applicantProfile');
        }

        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }

    /**
     * Refresh token (API)
     */
    public function refresh(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        // Delete old token
        $currentToken = $user->currentAccessToken();
        if ($currentToken) {
            $currentToken->delete();
        }

        // Create new token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'data' => [
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]
        ]);
    }

    /**
     * Change password (API)
     */
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect'
            ], 400);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully'
        ]);
    }
}
