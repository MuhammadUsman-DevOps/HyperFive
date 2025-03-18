<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;


class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function showCreateUserForm(Request $request){
        return view('core.users.create');
    }
    public function createUser(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'encryptedPassword' => 'required|string',
        ]);

        $data = $request->only(['email', 'encryptedPassword', 'tenantId']);
        $tenantId = $data['tenantId'];

        $user = $this->userService->createUser($tenantId, $data);

        if (!$user) {
            return redirect()->route('all_tenants')->with('error', 'Failed to create user.');
        }

        return redirect()->route('users')->with('success', 'User created successfully.');
    }

    public function deleteUser($tenantId, $userId)
    {
        $deleted = $this->userService->deleteUser($tenantId, $userId);

        if (!$deleted) {
            return redirect()->route('users')->with('error', 'Failed to delete user.');
        }

        return redirect()->route('users')->with('success', 'User deleted successfully.');
    }


    public function updateUser(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'encryptedPassword' => 'nullable|string|min:6',
        ]);

        $data = $request->only(['email', 'tenantId', 'userId']);
        $tenantId = $data['tenantId'];
        $userId = $data['userId'];

        if ($request->filled('encryptedPassword')) {
            $data['encryptedPassword'] = bcrypt($request->encryptedPassword);
        } else {
            unset($data['encryptedPassword']);
        }

        $user = $this->userService->updateUser($tenantId, $userId, $data);

        if (!$user) {
            return redirect()->route('users')->with('error', 'Failed to update user.');
        }

        return redirect()->route('users')->with('success', 'User updated successfully.');
    }
    public function getUsers($tenantId)
    {
        $users = $this->userService->getUsers($tenantId);


        if (!$users) {
            return redirect()->route('users')->with('error', 'Failed to fetch users.');
        }

        return view('core.users.users', ['users'=>$users,'tenantId'=>$tenantId]);
    }

    public function getUser($tenantId, $userId)
    {
        $user = $this->userService->getUser($tenantId, $userId);

        if (!$user) {
            return redirect()->route('users')->with('error', 'User not found.');
        }

        return view('users.show', compact('user'));
    }
}
