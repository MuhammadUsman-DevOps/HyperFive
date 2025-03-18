<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class UserService
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

    public function createUser($tenantId, array $data)
    {
        $token = $this->getToken();

        if (!$token) {
            return null; // No token, user needs to log in
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Token' => $token,
            ])->post("{$this->baseUrl}/api/tenant/{$tenantId}/user", $data);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Failed to create user', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('API error while creating user: ' . $e->getMessage());
            return null;
        }
    }


    public function deleteUser($tenantId, $userId)
    {
        $token = $this->getToken();

        if (!$token) {
            return null; // No token, user needs to log in
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Token' => $token,
            ])->delete("{$this->baseUrl}/api/tenant/{$tenantId}/user/{$userId}");

            if ($response->successful()) {
                return true;
            }

            Log::error('Failed to delete user', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return false;
        } catch (\Exception $e) {
            Log::error('API error while deleting user: ' . $e->getMessage());
            return false;
        }
    }

    public function updateUser($tenantId, $userId, array $data)
    {
        $token = $this->getToken();

        if (!$token) {
            return null; // No token, user needs to log in
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Token' => $token,
            ])->put("{$this->baseUrl}/api/tenant/{$tenantId}/user/{$userId}", $data);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Failed to update user', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('API error while updating user: ' . $e->getMessage());
            return null;
        }
    }

    public function getUsers($tenantId)
    {
        $token = $this->getToken();

        if (!$token) {
            return null; // No token, user needs to log in
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Token' => $token,
            ])->get("{$this->baseUrl}/api/tenant/{$tenantId}/user");

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Failed to fetch users', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('API error while fetching users: ' . $e->getMessage());
            return null;
        }
    }

    public function getUser($tenantId, $userId)
    {
        $token = $this->getToken();

        if (!$token) {
            return null; // No token, user needs to log in
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Token' => $token,
            ])->get("{$this->baseUrl}/api/tenant/{$tenantId}/user/{$userId}");

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Failed to fetch user', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('API error while fetching user: ' . $e->getMessage());
            return null;
        }
    }
}
