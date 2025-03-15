<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class ProfileService
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = env('API_BASE_URL');
    }

    private function getToken()
    {
        return Session::get('access_token');
    }

    public function addProfile(array $data)
    {
        $token = $this->getToken();

        if (!$token) {
            return null; // No token, user needs to log in
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Token' => $token,
            ])->post("{$this->baseUrl}/api/profile", $data);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Failed to create profile', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('API error while creating profile: ' . $e->getMessage());
            return null;
        }
    }


    public function updateProfile($profileName, array $data)
    {
        $token = $this->getToken();

        if (!$token) {
            return null; // No token, user needs to log in
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Token' => $token,
            ])->put("{$this->baseUrl}/api/profile/{$profileName}", $data);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Failed to update profile', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('API error while updating profile: ' . $e->getMessage());
            return null;
        }
    }


    public function getAllProfiles()
    {
        $token = $this->getToken();

        if (!$token) {
            return null; // No token, user needs to log in
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Token' => $token,
            ])->get("{$this->baseUrl}/api/profile");

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Failed to fetch profiles', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('API error while fetching profiles: ' . $e->getMessage());
            return null;
        }
    }

    public function deleteProfile($profileName)
    {
        $token = $this->getToken();

        if (!$token) {
            return null; // No token, user needs to log in
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Token' => $token,
            ])->delete("{$this->baseUrl}/api/profile/{$profileName}");

            if ($response->successful()) {
                return true;
            }

            Log::error('Failed to delete profile', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return false;
        } catch (\Exception $e) {
            Log::error('API error while deleting profile: ' . $e->getMessage());
            return false;
        }
    }
}
