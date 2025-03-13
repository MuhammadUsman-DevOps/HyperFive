<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Services\TenantService;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    protected $tenantService;

    public function __construct(TenantService $tenantService)
    {
        $this->tenantService = $tenantService;
    }

    public function addTenant(Request $request)
    {
        $request->validate([
            'tenantName' => 'required|string|max:255',
        ]);

        $data = $request->only(['tenantName']);

        $tenant = $this->tenantService->addTenant($data);

        if (!$tenant) {
            return redirect()->route('tenants')->with('error', 'Failed to create tenant.');
        }

        return redirect()->route('tenants')->with('success', 'Tenant created successfully.');
    }

    public function deleteTenant($tenantId)
    {
        $deleted = $this->tenantService->deleteTenant($tenantId);

        if (!$deleted) {
            return redirect()->route('tenants')->with('error', 'Failed to delete tenant.');
        }

        return redirect()->route('tenants')->with('success', 'Tenant deleted successfully.');
    }

    public function updateTenant(Request $request, $tenantId)
    {
        $request->validate([
            'tenantName' => 'required|string|max:255',
        ]);

        $data = $request->only(['tenantName']);

        $tenant = $this->tenantService->updateTenant($tenantId, $data);

        if (!$tenant) {
            return redirect()->route('tenants')->with('error', 'Failed to update tenant.');
        }

        return redirect()->route('tenants')->with('success', 'Tenant updated successfully.');
    }

    public function getAllTenants()
    {
        $tenants = $this->tenantService->getAllTenants();

        if (!$tenants) {
            return redirect()->route('tenants')->with('error', 'Failed to fetch tenants.');
        }

        return view('tenants.index', compact('tenants'));
    }


    public function getTenant($tenantId)
    {
        $tenant = $this->tenantService->getTenant($tenantId);

        if (!$tenant) {
            return redirect()->route('tenants')->with('error', 'Tenant not found.');
        }

        return view('tenants.show', compact('tenant'));
    }
}
