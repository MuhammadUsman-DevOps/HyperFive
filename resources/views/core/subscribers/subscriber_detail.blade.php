@extends('layouts.master')
@section('title', 'All Registered UE Context')
@section('extra_styles')

    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection('extra_styles')

@section('main_content')
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-fluid">

            <h2 class="mb-5">Subscriber Details</h2>

            <!-- Authentication Subscription -->
            <h3>Authentication Subscription</h3>
            <p><strong>PLMN ID:</strong> {{ $subscriber['plmnID'] }}</p>
            <p><strong>UE ID:</strong> {{ $subscriber['ueId'] }}</p>
            <p><strong>Authentication Method:</strong> {{ $subscriber['AuthenticationSubscription']['authenticationMethod'] }}</p>
            <p><strong>Permanent Key:</strong> {{ $subscriber['AuthenticationSubscription']['permanentKey']['permanentKeyValue'] }}</p>
            <p><strong>Sequence Number:</strong> {{ $subscriber['AuthenticationSubscription']['sequenceNumber'] }}</p>
<hr>
            <!-- Access and Mobility Subscription Data -->
            <h3>Access and Mobility Subscription Data</h3>
            <p><strong>GPSIS:</strong> {{ implode(', ', $subscriber['AccessAndMobilitySubscriptionData']['gpsis']) }}</p>
            <p><strong>Subscribed UE AMBR (Uplink):</strong> {{ $subscriber['AccessAndMobilitySubscriptionData']['subscribedUeAmbr']['uplink'] }}</p>
            <p><strong>Subscribed UE AMBR (Downlink):</strong> {{ $subscriber['AccessAndMobilitySubscriptionData']['subscribedUeAmbr']['downlink'] }}</p>
            <hr>
            <!-- NSSAI -->
            <h3>Network Slice Selection Assistance Information</h3>
            <ul>
                @foreach ($subscriber['AccessAndMobilitySubscriptionData']['nssai']['defaultSingleNssais'] as $nssai)
                    <li>SST: {{ $nssai['sst'] }}, SD: {{ $nssai['sd'] }}</li>
                @endforeach
            </ul>
            <hr>
            <!-- Session Management Subscription Data -->
            <h3>Session Management Subscription Data</h3>
            @foreach ($subscriber['SessionManagementSubscriptionData'] as $session)
                <h4>Single NSSAI</h4>
                <p><strong>SST:</strong> {{ $session['singleNssai']['sst'] }}</p>
                <p><strong>SD:</strong> {{ $session['singleNssai']['sd'] }}</p>

                <h4>DNN Configurations</h4>
                @foreach ($session['dnnConfigurations'] as $dnn => $config)
                    <p><strong>DNN:</strong> {{ $dnn }}</p>
                    <p><strong>Default Session Type:</strong> {{ $config['pduSessionTypes']['defaultSessionType'] }}</p>
                    <p><strong>Allowed Session Types:</strong> {{ implode(', ', $config['pduSessionTypes']['allowedSessionTypes']) }}</p>
                @endforeach
            @endforeach
            <hr>
            <!-- QoS Flows -->
            <h3>QoS Flows</h3>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>SNSSAI</th>
                    <th>DNN</th>
                    <th>QoS Ref</th>
                    <th>5QI</th>
                    <th>MBR UL</th>
                    <th>MBR DL</th>
                    <th>GBR UL</th>
                    <th>GBR DL</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($subscriber['QosFlows'] as $flow)
                    <tr>
                        <td>{{ $flow['snssai'] }}</td>
                        <td>{{ $flow['dnn'] }}</td>
                        <td>{{ $flow['qosRef'] }}</td>
                        <td>{{ $flow['5qi'] }}</td>
                        <td>{{ $flow['mbrUL'] }}</td>
                        <td>{{ $flow['mbrDL'] }}</td>
                        <td>{{ $flow['gbrUL'] }}</td>
                        <td>{{ $flow['gbrDL'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <hr>
            <!-- Charging Data -->
            <h3>Charging Data</h3>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>SNSSAI</th>
                    <th>DNN</th>
                    <th>Charging Method</th>
                    <th>Quota</th>
                    <th>Unit Cost</th>
                    <th>UE ID</th>
                </tr>
                </thead>
                <tbody>
                @if(isset($subscriber['ChargingDatas']) && is_array($subscriber['ChargingDatas']))
                    @php $seen = []; @endphp
                    @foreach ($subscriber['ChargingDatas'] as $index => $charging)
                        @if(!in_array($charging['snssai'] . $charging['dnn'] . $charging['chargingMethod'], $seen))
                            @php $seen[] = $charging['snssai'] . $charging['dnn'] . $charging['chargingMethod']; @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $charging['snssai'] }}</td>
                                <td>{{ $charging['dnn'] ?: 'N/A' }}</td>
                                <td>{{ $charging['chargingMethod'] }}</td>
                                <td>{{ $charging['quota'] }}</td>
                                <td>{{ $charging['unitCost'] }}</td>
                                <td>{{ $charging['ueId'] }}</td>
                            </tr>
                        @endif
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" class="text-center">No Charging Data Available</td>
                    </tr>
                @endif
                </tbody>
            </table>

        </div>
    </div>
@endsection
