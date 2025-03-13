<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
class TenantService
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

    public function addTenant(array $data)
    {
        $token = $this->getToken();

        if (!$token) {
            return null; // No token, user needs to log in
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Token' => $token,
            ])->post("{$this->baseUrl}/api/tenant/", $data);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Failed to create tenant', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('API error while creating tenant: ' . $e->getMessage());
            return null;
        }
    }


    public function deleteTenant($tenantId)
    {
        $token = $this->getToken();

        if (!$token) {
            return null; // No token, user needs to log in
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Token' => $token,
            ])->delete("{$this->baseUrl}/api/tenant/{$tenantId}");

            if ($response->successful()) {
                return true;
            }

            Log::error('Failed to delete tenant', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return false;
        } catch (\Exception $e) {
            Log::error('API error while deleting tenant: ' . $e->getMessage());
            return false;
        }
    }


    public function updateTenant($tenantId, array $data)
    {
        $token = $this->getToken();

        if (!$token) {
            return null; // No token, user needs to log in
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Token' => $token,
            ])->put("{$this->baseUrl}/api/tenant/{$tenantId}", $data);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Failed to update tenant', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('API error while updating tenant: ' . $e->getMessage());
            return null;
        }
    }

    public function getAllTenants()
    {
        $token = $this->getToken();

        if (!$token) {
            return null; // No token, user needs to log in
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Token' => $token,
            ])->get("{$this->baseUrl}/api/tenant/");

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Failed to fetch tenants', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('API error while fetching tenants: ' . $e->getMessage());
            return null;
        }
    }


    public function getTenant($tenantId)
    {
        $token = $this->getToken();

        if (!$token) {
            return null; // No token, user needs to log in
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Token' => $token,
            ])->get("{$this->baseUrl}/api/tenant/{$tenantId}");

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Failed to fetch tenant', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('API error while fetching tenant: ' . $e->getMessage());
            return null;
        }
    }
}
