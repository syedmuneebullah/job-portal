<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\ScheduleInterview;
use App\Models\JobPost;
use App\Models\Employer;
use App\Services\ZoomService;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class InterviewController extends Controller
{
    protected $zoomService;
    protected $notificationService;

    public function __construct(ZoomService $zoomService, NotificationService $notificationService)
    {
        $this->zoomService = $zoomService;
        $this->notificationService = $notificationService;
    }

    /**
     * Display all applications with interview status
     */
    public function Applications(Request $request)
    {
        // Get the authenticated user ID
        $authUserId = auth()->id();

        // Find the employer associated with this user
        $employer = Employer::where('user_id', $authUserId)->first();

        if (!$employer) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Employer not found for this user'
                ], 404);
            }
            abort(404, 'Employer not found');
        }

        // Base query for applications through employer's jobs
        $query = Application::query()
            ->with([
                'jobPost' => function($q) use ($employer) {
                    $q->where('employer_id', $employer->id)
                      ->select('id', 'title', 'department', 'employer_id');
                },
                'applicant' => function($q) {
                    $q->select('id', 'first_name', 'last_name', 'email', 'phone');
                },
                'jobPost.employer' => function($q) {
                    $q->select('id', 'company_name');
                },
                'scheduleInterview' => function($q) {
                    $q->select('id', 'application_id', 'meeting_link', 'meeting_id', 'interview_datetime', 'status', 'platform');
                }
            ])
            ->whereHas('jobPost', function($q) use ($employer) {
                $q->where('employer_id', $employer->id);
            })
            ->whereIn('status', ['interview', 'scheduled']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('status', 'LIKE', "%{$search}%")
                  ->orWhereHas('applicant', function($subQ) use ($search) {
                      $subQ->where('first_name', 'LIKE', "%{$search}%")
                           ->orWhere('last_name', 'LIKE', "%{$search}%")
                           ->orWhere('email', 'LIKE', "%{$search}%");
                  })
                  ->orWhereHas('jobPost', function($subQ) use ($search) {
                      $subQ->where('title', 'LIKE', "%{$search}%")
                           ->orWhere('department', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by job post
        if ($request->filled('job_post_id')) {
            $query->where('job_post_id', $request->job_post_id);
        }

        // Filter by date range
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        // Sort by
        $sortBy = $request->sort_by ?? 'created_at';
        $sortOrder = $request->sort_order ?? 'desc';
        $allowedSorts = ['id', 'status', 'created_at', 'updated_at', 'applied_at'];

        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        // Paginate
        $perPage = $request->per_page ?? 15;
        $applications = $query->paginate($perPage);

        // Get job posts for filtering
        $jobPosts = JobPost::where('employer_id', $employer->id)
            ->select('id', 'title')
            ->orderBy('title')
            ->get();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $applications,
                'job_posts' => $jobPosts
            ]);
        }

        return view('employer.pages.applications.interview', compact('applications', 'jobPosts'));
    }

    /**
     * Schedule an interview with Zoom meeting
     */
    public function scheduleInterview(Request $request, $applicationId)
    {
        try {
            // Validate the request
            $request->validate([
                'interview_datetime' => 'required|date|after:now',
                'duration' => 'nullable|integer|min:15|max:300',
                'timezone' => 'nullable|string',
                'notes' => 'nullable|string|max:1000'
            ]);

            // Find the application
            $application = Application::with(['applicant', 'jobPost'])->findOrFail($applicationId);

            // Check if user owns this application
            $employer = Employer::where('user_id', auth()->id())->first();
            if (!$employer || $application->jobPost->employer_id !== $employer->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }

            // Parse the datetime
            $interviewDateTime = Carbon::parse($request->interview_datetime);
            $duration = $request->duration ?? 60;
            $timezone = $request->timezone ?? 'Asia/Kolkata';

            // Prepare meeting data with custom datetime
            $meetingData = [
                'topic' => 'Interview for ' . $application->jobPost->title . ' - ' . $application->applicant->first_name,
                'type' => 2,
                'start_time' => $interviewDateTime->toIso8601String(),
                'duration' => $duration,
                'timezone' => $timezone,
                'settings' => [
                    'host_video' => true,
                    'participant_video' => true,
                    'join_before_host' => false,
                    'mute_upon_entry' => true,
                    'waiting_room' => true,
                ]
            ];

            // Create Zoom meeting
            $meeting = $this->zoomService->createMeeting('me', $meetingData);

            // Check for errors
            if (isset($meeting['error']) && $meeting['error'] === true) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create Zoom meeting: ' . ($meeting['message'] ?? 'Unknown error')
                ], 500);
            }

            // Create or update schedule interview record
            $scheduleInterview = ScheduleInterview::updateOrCreate(
                ['application_id' => $applicationId],
                [
                    'employer_id' => $employer->id,
                    'job_post_id' => $application->job_post_id,
                    'interview_datetime' => $interviewDateTime,
                    'duration' => $duration,
                    'timezone' => $timezone,
                    'platform' => 'zoom',
                    'meeting_id' => $meeting['id'] ?? null,
                    'meeting_link' => $meeting['join_url'] ?? null,
                    'meeting_password' => $meeting['password'] ?? null,
                    'meeting_join_url' => $meeting['join_url'] ?? null,
                    'status' => 'scheduled',
                    'notes' => $request->notes ?? 'Zoom interview scheduled via system',
                ]
            );

            // Update application with meeting details
            $application->update([
                'status' => 'scheduled',
                'scheduled_at' => $interviewDateTime,
            ]);

            // ✅ Send notification to applicant
            $this->notificationService->interviewScheduled($application, $scheduleInterview);
            
            // ✅ Also send meeting link notification
            $this->notificationService->sendMeetingLink($application, $scheduleInterview);

            // ✅ Send notification to employer (optional)
            $employerUser = $employer->user;
            if ($employerUser) {
                $this->notificationService->createNotification(
                    $employerUser->id,
                    'interview_scheduled_employer',
                    '📅 Interview Scheduled',
                    "Interview scheduled for {$application->applicant->first_name} {$application->applicant->last_name} for {$application->jobPost->title}.",
                    [
                        'application_id' => $application->id,
                        'job_title' => $application->jobPost->title,
                        'applicant_name' => $application->applicant->first_name . ' ' . $application->applicant->last_name,
                        'interview_datetime' => $interviewDateTime,
                    ]
                );
            }

            Log::info('Interview scheduled successfully with notifications', [
                'application_id' => $applicationId,
                'schedule_interview_id' => $scheduleInterview->id,
                'meeting_id' => $meeting['id'] ?? null,
                'interview_datetime' => $interviewDateTime
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Interview scheduled successfully!',
                'meeting_link' => $meeting['join_url'],
                'meeting_id' => $meeting['id'],
                'meeting' => $meeting,
                'schedule' => $scheduleInterview,
                'interview_datetime' => $interviewDateTime->format('Y-m-d H:i:s')
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to schedule interview: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to schedule interview: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show all scheduled interviews in a view
     */
    public function scheduledInterviews(Request $request)
    {
        $authUserId = auth()->id();
        $employer = Employer::where('user_id', $authUserId)->first();

        if (!$employer) {
            abort(404, 'Employer not found');
        }

        // Get all scheduled interviews with their relations
        $scheduledInterviews = ScheduleInterview::with(['application', 'application.applicant', 'jobPost'])
            ->where('employer_id', $employer->id)
            ->when($request->status, function($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->from_date, function($query, $date) {
                return $query->whereDate('interview_datetime', '>=', $date);
            })
            ->when($request->to_date, function($query, $date) {
                return $query->whereDate('interview_datetime', '<=', $date);
            })
            ->when($request->search, function($query, $search) {
                return $query->whereHas('application.applicant', function($q) use ($search) {
                    $q->where('first_name', 'LIKE', "%{$search}%")
                      ->orWhere('last_name', 'LIKE', "%{$search}%")
                      ->orWhere('email', 'LIKE', "%{$search}%");
                })->orWhereHas('jobPost', function($q) use ($search) {
                    $q->where('title', 'LIKE', "%{$search}%");
                });
            })
            ->orderBy('interview_datetime', 'asc')
            ->paginate($request->per_page ?? 15);

        // Get upcoming interviews count
        $upcomingCount = ScheduleInterview::where('employer_id', $employer->id)
            ->where('status', 'scheduled')
            ->where('interview_datetime', '>', now())
            ->count();

        // Get today's interviews count
        $todayCount = ScheduleInterview::where('employer_id', $employer->id)
            ->where('status', 'scheduled')
            ->whereDate('interview_datetime', today())
            ->count();

        // Get completed interviews count
        $completedCount = ScheduleInterview::where('employer_id', $employer->id)
            ->where('status', 'completed')
            ->count();

        return view('employer.pages.applications.scheduled-interviews', compact(
            'scheduledInterviews',
            'upcomingCount',
            'todayCount',
            'completedCount'
        ));
    }

    /**
     * Get all scheduled interviews as JSON (for API/AJAX)
     */
    public function getScheduledInterviews(Request $request)
    {
        $employer = Employer::where('user_id', auth()->id())->first();
        
        if (!$employer) {
            return response()->json([
                'success' => false,
                'message' => 'Employer not found'
            ], 404);
        }

        $interviews = ScheduleInterview::with(['application', 'application.applicant', 'jobPost'])
            ->where('employer_id', $employer->id)
            ->when($request->status, function($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->from_date, function($query, $date) {
                return $query->whereDate('interview_datetime', '>=', $date);
            })
            ->when($request->to_date, function($query, $date) {
                return $query->whereDate('interview_datetime', '<=', $date);
            })
            ->when($request->search, function($query, $search) {
                return $query->whereHas('application.applicant', function($q) use ($search) {
                    $q->where('first_name', 'LIKE', "%{$search}%")
                      ->orWhere('last_name', 'LIKE', "%{$search}%")
                      ->orWhere('email', 'LIKE', "%{$search}%");
                });
            })
            ->orderBy('interview_datetime', 'asc')
            ->paginate($request->per_page ?? 15);

        return response()->json([
            'success' => true,
            'data' => $interviews
        ]);
    }

    /**
     * Cancel an interview
     */
    public function cancelInterview($id)
    {
        try {
            $interview = ScheduleInterview::with(['application', 'application.applicant', 'jobPost'])->findOrFail($id);
            $employer = Employer::where('user_id', auth()->id())->first();
            
            if ($interview->employer_id !== $employer->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }

            // Update interview status
            $interview->update([
                'status' => 'cancelled',
                'notes' => 'Interview cancelled by employer'
            ]);

            // Update application status
            $interview->application->update([
                'status' => 'shortlisted'
            ]);

            // ✅ Send notification to applicant
            $this->notificationService->notifyInterviewCancelled(
                $interview->application,
                'Cancelled by employer'
            );

            Log::info('Interview cancelled', [
                'schedule_interview_id' => $id,
                'application_id' => $interview->application_id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Interview cancelled successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to cancel interview: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel interview: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reschedule an interview
     */
    public function rescheduleInterview(Request $request, $id)
    {
        try {
            $interview = ScheduleInterview::with(['application', 'application.applicant', 'jobPost'])->findOrFail($id);
            $employer = Employer::where('user_id', auth()->id())->first();
            
            if ($interview->employer_id !== $employer->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }

            $request->validate([
                'interview_datetime' => 'required|date|after:now',
                'duration' => 'nullable|integer|min:15|max:300',
                'notes' => 'nullable|string|max:1000'
            ]);

            $oldDateTime = $interview->interview_datetime;
            $newDateTime = Carbon::parse($request->interview_datetime);
            $duration = $request->duration ?? $interview->duration;

            // Store original datetime
            $interview->original_datetime = $interview->interview_datetime;
            $interview->reschedule_reason = $request->notes ?? 'Rescheduled by employer';
            
            // Update interview
            $interview->update([
                'interview_datetime' => $newDateTime,
                'duration' => $duration,
                'status' => 'rescheduled',
                'notes' => $request->notes ?? $interview->notes
            ]);

            // Update Zoom meeting if needed
            if ($interview->meeting_id && $interview->platform === 'zoom') {
                $this->zoomService->updateMeeting($interview->meeting_id, [
                    'start_time' => $newDateTime->toIso8601String(),
                    'duration' => $duration
                ]);
            }

            // Update application
            $interview->application->update([
                'scheduled_at' => $newDateTime,
            ]);

            // ✅ Send notification to applicant
            $this->notificationService->notifyInterviewRescheduled(
                $interview->application,
                $oldDateTime,
                $newDateTime
            );

            Log::info('Interview rescheduled', [
                'schedule_interview_id' => $id,
                'application_id' => $interview->application_id,
                'new_datetime' => $newDateTime
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Interview rescheduled successfully',
                'data' => $interview
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to reschedule interview: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to reschedule interview: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mark interview as completed
     */
    public function completeInterview($id)
    {
        try {
            $interview = ScheduleInterview::findOrFail($id);
            $employer = Employer::where('user_id', auth()->id())->first();
            
            if ($interview->employer_id !== $employer->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }

            $interview->update([
                'status' => 'completed'
            ]);

            // Update application status
            $interview->application->update([
                'status' => 'hired'
            ]);

            // ✅ Send notification to applicant
            $this->notificationService->applicationStatusUpdated(
                $interview->application,
                'interview',
                'hired'
            );

            Log::info('Interview completed', [
                'schedule_interview_id' => $id,
                'application_id' => $interview->application_id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Interview marked as completed'
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to complete interview: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to complete interview: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get interview details for a specific application
     */
    public function getInterviewDetails($applicationId)
    {
        try {
            $application = Application::with(['applicant', 'jobPost', 'scheduleInterview'])->findOrFail($applicationId);
            
            $employer = Employer::where('user_id', auth()->id())->first();
            if (!$employer || $application->jobPost->employer_id !== $employer->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'application' => $application,
                    'schedule' => $application->scheduleInterview,
                    'meeting_link' => $application->scheduleInterview?->meeting_link
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send reminder for upcoming interviews (can be called by cron job)
     */
    public function sendReminders()
    {
        try {
            // Get interviews that are scheduled for tomorrow and haven't had reminders sent
            $interviews = ScheduleInterview::where('status', 'scheduled')
                ->where('reminder_sent', false)
                ->whereDate('interview_datetime', now()->addDay())
                ->get();

            $sentCount = 0;
            foreach ($interviews as $interview) {
                // Send email reminder to both employer and candidate
                // Mail::to($interview->application->applicant->email)->send(new InterviewReminder($interview));
                // Mail::to($interview->employer->email)->send(new InterviewReminder($interview));
                
                // Send in-app notification
                $this->notificationService->interviewReminder($interview);
                
                $interview->update([
                    'reminder_sent' => true,
                    'reminder_sent_at' => now()
                ]);
                
                $sentCount++;
            }

            return response()->json([
                'success' => true,
                'message' => "Reminders sent to {$sentCount} interviews"
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to send reminders: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to send reminders: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get upcoming interviews (for dashboard widget)
     */
    public function getUpcomingInterviews()
    {
        $employer = Employer::where('user_id', auth()->id())->first();
        
        if (!$employer) {
            return response()->json([
                'success' => false,
                'message' => 'Employer not found'
            ], 404);
        }

        $interviews = ScheduleInterview::with(['application', 'application.applicant', 'jobPost'])
            ->where('employer_id', $employer->id)
            ->where('status', 'scheduled')
            ->where('interview_datetime', '>', now())
            ->orderBy('interview_datetime', 'asc')
            ->limit(5)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $interviews
        ]);
    }
}