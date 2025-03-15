<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Services\UEService;
use Illuminate\Http\Request;

class UEController extends Controller
{
    protected $ueService;

    public function __construct(UEService $ueService)
    {
        $this->ueService = $ueService;
    }


    public function getPduSessionInfo($smContextRef)
    {
        $sessionInfo = $this->ueService->getPduSessionInfo($smContextRef);

        if (!$sessionInfo) {
            return redirect()->route('ue.sessions')->with('error', 'Failed to fetch PDU session info.');
        }

        return view('ue.session_info', compact('sessionInfo'));
    }

    public function getRegisteredUEContext($supi)
    {
        $ueContext = $this->ueService->getRegisteredUEContext($supi);

        if (!$ueContext) {
            return redirect()->route('ue.contexts')->with('error', 'Failed to fetch UE context.');
        }

        return view('ue.context_info', compact('ueContext'));
    }

    public function getAllRegisteredUEContexts()
    {
        $ueContexts = $this->ueService->getAllRegisteredUEContexts();

        if (!$ueContexts) {
            return redirect()->route('ue.contexts')->with('error', 'Failed to fetch registered UE contexts.');
        }

        return view('ue.contexts', compact('ueContexts'));
    }


    public function getChargingRecords()
    {
        $chargingRecords = $this->ueService->getChargingRecords();

        if (!$chargingRecords) {
            return redirect()->route('charging.records')->with('error', 'Failed to fetch charging records.');
        }

        return view('charging.records', compact('chargingRecords'));
    }


    public function getChargingData($chargingMethod)
    {
        $chargingData = $this->ueService->getChargingData($chargingMethod);

        if (!$chargingData) {
            return redirect()->route('charging.data')->with('error', 'Failed to fetch charging data.');
        }

        return view('charging.data', compact('chargingData'));
    }

}
