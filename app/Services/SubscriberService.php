<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
class SubscriberService
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = env('API_BASE_URL');
    }

    public function getSubscribers()
    {
        $token = Session::get('access_token');

        if (!$token) {
            return null; // No token, user needs to log in
        }

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Token' => $token,
        ])->get("{$this->baseUrl}/api/subscriber/");

        if ($response->successful()) {
            return $response->json(); // Return subscriber data
        }

        return null; // Request failed
    }

    public function getSubscriber($ueId, $plmnId)
    {
        $token = Session::get('access_token');

        if (!$token) {
            return null; // No token, user needs to log in
        }

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Token' => $token,
        ])->get("{$this->baseUrl}/api/subscriber/{$ueId}/{$plmnId}");

        if ($response->successful()) {
            return $response->json(); // Return subscriber data
        }

        return null; // Request failed
    }

    private function getToken()
    {
        return Session::get('access_token');
    }

    public function addSubscriber($ueId, $plmnId, array $data)
    {
        $token = $this->getToken();

        if (!$token) {
            return null; // No token, user needs to log in
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Token' => $token,
            ])->post("{$this->baseUrl}/api/subscriber/{$ueId}/{$plmnId}", $data);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Failed to add subscriber', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('API error while adding subscriber: ' . $e->getMessage());
            return null;
        }
    }


    public function updateSubscriber($ueId, $plmnId, array $data)
    {
        $token = $this->getToken();

        if (!$token) {
            return null; // No token, user needs to log in
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Token' => $token,
            ])->put("{$this->baseUrl}/api/subscriber/{$ueId}/{$plmnId}", $data);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Failed to update subscriber', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('API error while updating subscriber: ' . $e->getMessage());
            return null;
        }
    }

    public function deleteSubscriber($ueId, $plmnId)
    {
        $token = $this->getToken();

        if (!$token) {
            return null; // No token, user needs to log in
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Token' => $token,
            ])->delete("{$this->baseUrl}/api/subscriber/{$ueId}/{$plmnId}");

            if ($response->successful()) {
                return true;
            }

            Log::error('Failed to delete subscriber', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return false;
        } catch (\Exception $e) {
            Log::error('API error while deleting subscriber: ' . $e->getMessage());
            return false;
        }
    }




}
