<?php

namespace App\Services;

use http\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthenticationService
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = env('API_BASE_URL');
    }

    public function login($username, $password)
    {
        $response = Http::post("{$this->baseUrl}/api/login/", [
            'Username' => $username,
            'Password' => $password,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            Session::put('access_token', $data['access_token']);
            return true; // Login success
        }

        return false; // Login failed


        $client = new Client();
        $headers = [
            'Content-Type' => 'application/json'
        ];
        $body = '{
  "username": "admin",
  "password": "free5gc"
}';
        $request = new Request('POST', 'http://192.168.11.131:5000/api/login', $headers, $body);
        $res = $client->sendAsync($request)->wait();
        echo $res->getBody();
    }

    public function logout()
    {
        Session::forget('access_token');
    }

    public function getToken()
    {
        return Session::get('access_token');
    }
}
