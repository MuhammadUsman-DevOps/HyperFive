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

//@extends('layouts.app')
//
//@section('content')
//<h2>UE PDU Session Info</h2>
//
//@if(session('error'))
//<p class="text-danger">{{ session('error') }}</p>
//@endif
//
//    @if($sessionInfo)
//        <ul>
//            <li><strong>AnType:</strong> {{ $sessionInfo['AnType'] }}</li>
//            <li><strong>Dnn:</strong> {{ $sessionInfo['Dnn'] }}</li>
//            <li><strong>PDUAddress:</strong> {{ $sessionInfo['PDUAddress'] }}</li>
//            <li><strong>PDUSessionID:</strong> {{ $sessionInfo['PDUSessionID'] }}</li>
//            <li><strong>Sd:</strong> {{ $sessionInfo['Sd'] }}</li>
//            <li><strong>Supi:</strong> {{ $sessionInfo['Supi'] }}</li>
//            <li><strong>UpCnxState:</strong> {{ $sessionInfo['UpCnxState'] }}</li>
//        </ul>
//@else
//        <p>No session info found.</p>
//@endif
//@endsection


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

//@extends('layouts.app')
//
//@section('content')
//<h2>All Registered UE Contexts</h2>
//
//@if(session('error'))
//<p class="text-danger">{{ session('error') }}</p>
//@endif
//
//    @if($ueContexts)
//        <table border="1">
//            <tr>
//                <th>SUPI</th>
//                <th>Access Type</th>
//                <th>CM State</th>
//                <th>GUTI</th>
//                <th>MCC</th>
//                <th>MNC</th>
//                <th>PDU Sessions</th>
//            </tr>
//@foreach($ueContexts as $context)
//                <tr>
//                    <td>{{ $context['Supi'] }}</td>
//                    <td>{{ $context['AccessType'] }}</td>
//                    <td>{{ $context['CmState'] }}</td>
//                    <td>{{ $context['Guti'] }}</td>
//                    <td>{{ $context['Mcc'] }}</td>
//                    <td>{{ $context['Mnc'] }}</td>
//                    <td>
//                        <ul>
//@foreach($context['PduSessions'] as $session)
//                                <li>Session ID: {{ $session['PduSessionId'] }} | DNN: {{ $session['Dnn'] }} | SmContextRef: {{ $session['SmContextRef'] }}</li>
//@endforeach
//                        </ul>
//                    </td>
//                </tr>
//@endforeach
//        </table>
//@else
//        <p>No registered UE contexts found.</p>
//@endif
//@endsection


    public function getAllRegisteredUEContexts()
    {
        $ueContexts = $this->ueService->getAllRegisteredUEContexts();

        if (!$ueContexts) {
            return redirect()->route('ue.contexts')->with('error', 'Failed to fetch registered UE contexts.');
        }

        return view('ue.contexts', compact('ueContexts'));
    }


//@extends('layouts.app')
//
//@section('content')
//<h2>Charging Records</h2>
//
//@if(session('error'))
//<p class="text-danger">{{ session('error') }}</p>
//@endif
//
//    @if($chargingRecords)
//        <table border="1">
//            <tr>
//                <th>SUPI</th>
//                <th>Snssai</th>
//                <th>Dnn</th>
//                <th>Filter</th>
//                <th>DL Volume</th>
//                <th>UL Volume</th>
//                <th>Total Volume</th>
//                <th>Usage</th>
//                <th>Quota Left</th>
//            </tr>
//@foreach($chargingRecords as $record)
//                <tr>
//                    <td>{{ $record['Supi'] }}</td>
//                    <td>{{ $record['Snssai'] }}</td>
//                    <td>{{ $record['Dnn'] }}</td>
//                    <td>{{ $record['Filter'] }}</td>
//                    <td>{{ $record['DlVol'] }}</td>
//                    <td>{{ $record['UlVol'] }}</td>
//                    <td>{{ $record['TotalVol'] }}</td>
//                    <td>{{ $record['Usage'] }}</td>
//                    <td>{{ $record['QuotaLeft'] }}</td>
//                </tr>
//@endforeach
//        </table>
//@else
//        <p>No charging records found.</p>
//@endif
//@endsection

    public function getChargingRecords()
    {
        $chargingRecords = $this->ueService->getChargingRecords();

        if (!$chargingRecords) {
            return redirect()->route('charging.records')->with('error', 'Failed to fetch charging records.');
        }

        return view('charging.records', compact('chargingRecords'));
    }


//@extends('layouts.app')
//
//@section('content')
//<h2>Charging Data</h2>
//
//@if(session('error'))
//<p class="text-danger">{{ session('error') }}</p>
//@endif
//
//    @if($chargingData)
//        <table border="1">
//            <tr>
//                <th>UE ID</th>
//                <th>Charging Method</th>
//                <th>Snssai</th>
//                <th>Dnn</th>
//                <th>Filter</th>
//                <th>Rating Group</th>
//                <th>Serving PLMN ID</th>
//                <th>Unit Cost</th>
//                <th>Quota</th>
//            </tr>
//@foreach($chargingData as $data)
//                <tr>
//                    <td>{{ $data['ueId'] }}</td>
//                    <td>{{ $data['chargingMethod'] }}</td>
//                    <td>{{ $data['snssai'] }}</td>
//                    <td>{{ $data['dnn'] }}</td>
//                    <td>{{ $data['filter'] }}</td>
//                    <td>{{ $data['ratingGroup'] }}</td>
//                    <td>{{ $data['servingPlmnId'] }}</td>
//                    <td>{{ $data['unitCost'] }}</td>
//                    <td>{{ $data['quota'] }}</td>
//                </tr>
//@endforeach
//        </table>
//@else
//        <p>No charging data found.</p>
//@endif
//@endsection

    public function getChargingData($chargingMethod)
    {
        $chargingData = $this->ueService->getChargingData($chargingMethod);

        if (!$chargingData) {
            return redirect()->route('charging.data')->with('error', 'Failed to fetch charging data.');
        }

        return view('charging.data', compact('chargingData'));
    }

}
