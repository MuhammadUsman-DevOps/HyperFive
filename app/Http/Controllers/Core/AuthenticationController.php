<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Services\AuthenticationService;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    protected $authService;

    public function __construct(AuthenticationService $authService)
    {
        $this->authService = $authService;
    }

    public function showLoginForm()
    {
        return view('core.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($this->authService->login($request->email, $request->password)) {
            return redirect()->route('dashboard')->with('success', 'Login successful!');
        }

        return redirect()->back()->with('error', 'Invalid credentials');
    }

    public function logout()
    {
        $this->authService->logout();
        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }
}
