<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class UEService
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

    public function getPduSessionInfo($smContextRef)
    {
        $token = $this->getToken();

        if (!$token) {
            return null; // No token, user needs to log in
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Token' => $token,
            ])->get("{$this->baseUrl}/api/ue-pdu-session-info/{$smContextRef}");

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Failed to fetch UE PDU session info', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('API error while fetching UE PDU session info: ' . $e->getMessage());
            return null;
        }
    }

    public function getRegisteredUEContext($supi)
    {
        $token = $this->getToken();

        if (!$token) {
            return null; // No token, user needs to log in
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Token' => $token,
            ])->get("{$this->baseUrl}/api/registered-ue-context/{$supi}");

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Failed to fetch registered UE context', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('API error while fetching registered UE context: ' . $e->getMessage());
            return null;
        }
    }


    public function getAllRegisteredUEContexts()
    {
        $token = $this->getToken();

        if (!$token) {
            return null; // No token, user needs to log in
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'token' => $token,
            ])->get("{$this->baseUrl}/api/registered-ue-context");

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Failed to fetch registered UE contexts', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('API error while fetching registered UE contexts: ' . $e->getMessage());
            return null;
        }
    }



    public function getChargingRecords()
    {
        $token = $this->getToken();

        if (!$token) {
            return null; // No token, user needs to log in
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Token' => $token,
            ])->get("{$this->baseUrl}/api/charging-record");

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Failed to fetch charging records', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('API error while fetching charging records: ' . $e->getMessage());
            return null;
        }
    }


    public function getChargingData($chargingMethod)
    {
        $token = $this->getToken();

        if (!$token) {
            return null; // No token, user needs to log in
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Token' => $token,
            ])->get("{$this->baseUrl}/api/charging-data/{$chargingMethod}");

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Failed to fetch charging data', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('API error while fetching charging data: ' . $e->getMessage());
            return null;
        }
    }
}
