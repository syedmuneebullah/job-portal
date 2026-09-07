<?php

namespace App\Http\Controllers;

use App\Services\ZoomService;
use Illuminate\Http\Request;

class ZoomController extends Controller
{
    protected $zoom;

    public function __construct(ZoomService $zoom)
    {
        $this->zoom = $zoom;
    }

    // Create
    public function create()
    {
        $meeting = $this->zoom->createMeeting('me', [
            'topic' => 'My Laravel Zoom Meeting',
            'type' => 2, // Scheduled
            'start_time' => now()->addHour()->toIso8601String(),
            'duration' => 40,
            'timezone' => 'Asia/Kolkata',
            'settings' => [
                'host_video' => true,
                'participant_video' => false,
            ]
        ]);

        return response()->json($meeting);
    }

    // Update
    public function update($id)
    {
        $meeting = $this->zoom->updateMeeting($id, [
            'topic' => 'Updated Laravel Zoom Meeting',
            'duration' => 60,
        ]);

        return response()->json($meeting);
    }

    // Delete
    public function delete($id)
    {
        $deleted = $this->zoom->deleteMeeting($id);

        return response()->json(['deleted' => $deleted]);
    }

    // List
    public function list()
    {
        return response()->json($this->zoom->listMeetings('me'));
    }

    public function refreshToken()
    {
        Cache::forget('zoom_access_token');
        
        // This will force a new token to be generated
        return $this->getAccessToken();
    }
}