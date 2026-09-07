<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Client\ConnectionException;

class ZoomService
{
    private $accountId;
    private $clientId;
    private $clientSecret;
    private $baseUrl;

    public function __construct()
    {
        $this->accountId    = config('services.zoom.account_id');
        $this->clientId     = config('services.zoom.client_id');
        $this->clientSecret = config('services.zoom.client_secret');
        $this->baseUrl      = config('services.zoom.base_url', 'https://api.zoom.us/v2');
    }

    // Get Access Token (cached) with retry logic
    private function getAccessToken()
    {
        return Cache::remember('zoom_access_token', 3300, function () {
            $maxAttempts = 3;
            $attempt = 0;
            
            while ($attempt < $maxAttempts) {
                try {
                    $response = Http::asForm()
                        ->withBasicAuth($this->clientId, $this->clientSecret)
                        ->timeout(30) // 30 second timeout
                        ->retry(2, 100) // Retry 2 times with 100ms delay
                        ->post("https://zoom.us/oauth/token", [
                            'grant_type' => 'account_credentials',
                            'account_id' => $this->accountId,
                        ]);

                    if ($response->failed()) {
                        throw new \Exception('Zoom Auth failed: ' . $response->body());
                    }

                    return $response->json()['access_token'];
                    
                } catch (ConnectionException $e) {
                    $attempt++;
                    if ($attempt >= $maxAttempts) {
                        throw new \Exception('Failed to connect to Zoom after ' . $maxAttempts . ' attempts: ' . $e->getMessage());
                    }
                    sleep(1); // Wait 1 second before retry
                }
            }
        });
    }

    // Create Meeting
    public function createMeeting($userId = 'me', $data = [])
    {
        try {
            $response = Http::withToken($this->getAccessToken())
                ->timeout(30) // 30 second timeout
                ->retry(3, 200) // Retry 3 times with 200ms delay
                ->post("{$this->baseUrl}/users/{$userId}/meetings", $data);

            if ($response->failed()) {
                return [
                    'error' => true,
                    'code' => $response->status(),
                    'message' => $response->json()['message'] ?? 'Unknown error',
                    'details' => $response->body()
                ];
            }

            return $response->json();
            
        } catch (ConnectionException $e) {
            return [
                'error' => true,
                'message' => 'Network error: Unable to reach Zoom API. Please check your internet connection.',
                'details' => $e->getMessage()
            ];
        }
    }

    // Update Meeting
    public function updateMeeting($meetingId, $data = [])
    {
        try {
            $response = Http::withToken($this->getAccessToken())
                ->timeout(30)
                ->retry(3, 200)
                ->patch("{$this->baseUrl}/meetings/{$meetingId}", $data);

            if ($response->failed()) {
                return [
                    'error' => true,
                    'code' => $response->status(),
                    'message' => $response->json()['message'] ?? 'Unknown error'
                ];
            }

            return $response->json();
            
        } catch (ConnectionException $e) {
            return [
                'error' => true,
                'message' => 'Network error: Unable to reach Zoom API.',
                'details' => $e->getMessage()
            ];
        }
    }

    // Delete Meeting
    public function deleteMeeting($meetingId)
    {
        try {
            $response = Http::withToken($this->getAccessToken())
                ->timeout(30)
                ->retry(3, 200)
                ->delete("{$this->baseUrl}/meetings/{$meetingId}");

            return $response->status() === 204;
            
        } catch (ConnectionException $e) {
            return false;
        }
    }

    // List Meetings
    public function listMeetings($userId = 'me')
    {
        try {
            $response = Http::withToken($this->getAccessToken())
                ->timeout(30)
                ->retry(3, 200)
                ->get("{$this->baseUrl}/users/{$userId}/meetings");

            if ($response->failed()) {
                return [
                    'error' => true,
                    'code' => $response->status(),
                    'message' => $response->json()['message'] ?? 'Unknown error'
                ];
            }

            return $response->json();
            
        } catch (ConnectionException $e) {
            return [
                'error' => true,
                'message' => 'Network error: Unable to reach Zoom API.',
                'details' => $e->getMessage()
            ];
        }
    }

    // Add this method to refresh token
    public function refreshToken()
    {
        Cache::forget('zoom_access_token');
        return $this->getAccessToken();
    }
}