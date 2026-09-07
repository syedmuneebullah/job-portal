<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * Create a notification for a user
     */
    public function createNotification($userId, $type, $title, $message, $data = [], $channel = 'in_app')
    {
        try {
            return Notification::create([
                'user_id' => $userId,
                'type' => $type,
                'title' => $title,
                'message' => $message,
                'data' => $data,
                'channel' => $channel,
                'is_read' => false,
                'sent_at' => now(),
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to create notification: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Send application status update notification
     */
    public function applicationStatusUpdated($application, $oldStatus, $newStatus)
    {
        $applicant = $application->applicant;
        $jobTitle = $application->jobPost->title ?? 'Job';

        $statusMessages = [
            'shortlisted' => [
                'title' => '🎉 Congratulations! You\'ve been Shortlisted',
                'message' => "Great news! You've been shortlisted for the position of {$jobTitle}. The employer will contact you soon for the next steps."
            ],
            'interview' => [
                'title' => '📅 Interview Scheduled',
                'message' => "An interview has been scheduled for the position of {$jobTitle}. Please check your dashboard for details."
            ],
            'scheduled' => [
                'title' => '📅 Interview Scheduled',
                'message' => "An interview has been scheduled for the position of {$jobTitle}. Please check your dashboard for details."
            ],
            'hired' => [
                'title' => '🎊 Congratulations! You\'ve Been Hired',
                'message' => "Congratulations! You've been selected for the position of {$jobTitle}. The employer will reach out with further details."
            ],
            'rejected' => [
                'title' => 'Application Update',
                'message' => "Thank you for your interest in the {$jobTitle} position. Unfortunately, your application has not been selected this time."
            ]
        ];

        $statusMessage = $statusMessages[$newStatus] ?? [
            'title' => 'Application Status Updated',
            'message' => "Your application for {$jobTitle} has been updated to " . ucfirst($newStatus) . "."
        ];

        return $this->createNotification(
            $applicant->id,
            'application_status_update',
            $statusMessage['title'],
            $statusMessage['message'],
            [
                'application_id' => $application->id,
                'job_title' => $jobTitle,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'job_post_id' => $application->job_post_id,
            ]
        );
    }

    /**
     * Send interview scheduled notification
     */
    public function interviewScheduled($application, $scheduleInterview)
    {
        $applicant = $application->applicant;
        $jobTitle = $application->jobPost->title ?? 'Job';

        return $this->createNotification(
            $applicant->id,
            'interview_scheduled',
            '📅 Interview Scheduled',
            "An interview has been scheduled for the position of {$jobTitle} on {$scheduleInterview->interview_datetime->format('M d, Y h:i A')}.",
            [
                'application_id' => $application->id,
                'job_title' => $jobTitle,
                'interview_datetime' => $scheduleInterview->interview_datetime,
                'meeting_link' => $scheduleInterview->meeting_link,
                'meeting_id' => $scheduleInterview->meeting_id,
                'platform' => $scheduleInterview->platform,
                'schedule_interview_id' => $scheduleInterview->id,
            ]
        );
    }

    /**
     * Send meeting link notification
     */
    public function sendMeetingLink($application, $scheduleInterview)
    {
        $applicant = $application->applicant;
        $jobTitle = $application->jobPost->title ?? 'Job';

        return $this->createNotification(
            $applicant->id,
            'meeting_link',
            '🔗 Interview Meeting Link',
            "Your interview meeting link for {$jobTitle} is now available. Click to join the meeting.",
            [
                'application_id' => $application->id,
                'job_title' => $jobTitle,
                'meeting_link' => $scheduleInterview->meeting_link,
                'schedule_interview_id' => $scheduleInterview->id,
            ]
        );
    }

    /**
     * Send interview reminder notification
     */
    public function interviewReminder($scheduleInterview)
    {
        $application = $scheduleInterview->application;
        $applicant = $application->applicant;
        $jobTitle = $application->jobPost->title ?? 'Job';

        return $this->createNotification(
            $applicant->id,
            'interview_reminder',
            '⏰ Interview Reminder',
            "Reminder: Your interview for {$jobTitle} is scheduled for {$scheduleInterview->interview_datetime->format('M d, Y h:i A')}.",
            [
                'application_id' => $application->id,
                'job_title' => $jobTitle,
                'interview_datetime' => $scheduleInterview->interview_datetime,
                'meeting_link' => $scheduleInterview->meeting_link,
                'schedule_interview_id' => $scheduleInterview->id,
            ]
        );
    }

    /**
     * Send interview cancelled notification
     */
    public function notifyInterviewCancelled($application, $reason = null)
    {
        $applicant = $application->applicant;
        $jobTitle = $application->jobPost->title ?? 'Job';

        $message = "Your interview for {$jobTitle} has been cancelled.";
        if ($reason) {
            $message .= " Reason: " . $reason;
        }

        return $this->createNotification(
            $applicant->id,
            'interview_cancelled',
            '❌ Interview Cancelled',
            $message,
            [
                'application_id' => $application->id,
                'job_title' => $jobTitle,
                'reason' => $reason,
            ]
        );
    }

    /**
     * Send interview rescheduled notification
     */
    public function notifyInterviewRescheduled($application, $oldDateTime, $newDateTime)
    {
        $applicant = $application->applicant;
        $jobTitle = $application->jobPost->title ?? 'Job';

        return $this->createNotification(
            $applicant->id,
            'interview_rescheduled',
            '🔄 Interview Rescheduled',
            "Your interview for {$jobTitle} has been rescheduled from " . 
            $oldDateTime->format('M d, Y h:i A') . " to " . 
            $newDateTime->format('M d, Y h:i A') . ".",
            [
                'application_id' => $application->id,
                'job_title' => $jobTitle,
                'old_datetime' => $oldDateTime,
                'new_datetime' => $newDateTime,
            ]
        );
    }
}