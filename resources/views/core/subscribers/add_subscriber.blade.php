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
            <h2>Create Subscriber</h2>
            <form action="{{ route('subscriber.store') }}" method="POST">
                @csrf

                {{-- Basic Subscriber Information --}}
                <div class="mb-3">
                    <label for="plmnID" class="form-label">PLMN ID</label>
                    <input type="text" class="form-control" id="plmnID" name="plmnID" required>
                </div>

                <div class="mb-3">
                    <label for="ueId" class="form-label">SUPI (IMSI)</label>
                    <input type="text" class="form-control" id="ueId" name="ueId" required>
                </div>

                {{-- Authentication Subscription --}}
                <h4>Authentication Subscription</h4>
                <div class="mb-3">
                    <label for="authenticationManagementField" class="form-label">Authentication Management Field (AMF)</label>
                    <input type="text" class="form-control" id="authenticationManagementField" name="AuthenticationSubscription[authenticationManagementField]" required>
                </div>

                <div class="mb-3">
                    <label for="authenticationMethod" class="form-label">Authentication Method</label>
                    <select class="form-select" id="authenticationMethod" name="AuthenticationSubscription[authenticationMethod]" required>
                        <option value="5G_AKA" selected>5G_AKA</option>
                        <option value="EAP_AKA">EAP_AKA</option>
                    </select>
                </div>

                {{-- Milenage OP Data --}}
                <h4>Milenage OP</h4>
                <div class="mb-3">
                    <label for="opValue" class="form-label">OP Value</label>
                    <input type="text" class="form-control" id="opValue" name="AuthenticationSubscription[milenage][op][opValue]" required>
                </div>

                {{-- OPC Data --}}
                <h4>OPC</h4>
                <div class="mb-3">
                    <label for="opcValue" class="form-label">OPC Value</label>
                    <input type="text" class="form-control" id="opcValue" name="AuthenticationSubscription[opc][opcValue]">
                </div>

                {{-- Permanent Key --}}
                <h4>Permanent Key</h4>
                <div class="mb-3">
                    <label for="permanentKeyValue" class="form-label">Permanent Key Value</label>
                    <input type="text" class="form-control" id="permanentKeyValue" name="AuthenticationSubscription[permanentKey][permanentKeyValue]" required>
                </div>

                {{-- Sequence Number --}}
                <div class="mb-3">
                    <label for="sequenceNumber" class="form-label">Sequence Number (SQN)</label>
                    <input type="text" class="form-control" id="sequenceNumber" name="AuthenticationSubscription[sequenceNumber]" required>
                </div>

                {{-- Access and Mobility Subscription Data --}}
                <h4>Access & Mobility Subscription Data</h4>
                <div class="mb-3">
                    <label for="gpsis" class="form-label">GPSI (MSISDN)</label>
                    <input type="text" class="form-control" id="gpsis" name="AccessAndMobilitySubscriptionData[gpsis][]" required>
                </div>

                {{-- NSSAI Configuration --}}
                <h4>NSSAI Configuration</h4>
                <div class="mb-3">
                    <label for="sst" class="form-label">SST</label>
                    <input type="number" class="form-control" id="sst" name="AccessAndMobilitySubscriptionData[nssai][defaultSingleNssais][0][sst]" required>
                </div>

                <div class="mb-3">
                    <label for="sd" class="form-label">SD</label>
                    <input type="text" class="form-control" id="sd" name="AccessAndMobilitySubscriptionData[nssai][defaultSingleNssais][0][sd]" required>
                </div>

                {{-- Subscribed UE AMBR --}}
                <h4>Subscribed UE AMBR</h4>
                <div class="mb-3">
                    <label for="uplinkAmbr" class="form-label">Uplink</label>
                    <input type="text" class="form-control" id="uplinkAmbr" name="AccessAndMobilitySubscriptionData[subscribedUeAmbr][uplink]" required>
                </div>

                <div class="mb-3">
                    <label for="downlinkAmbr" class="form-label">Downlink</label>
                    <input type="text" class="form-control" id="downlinkAmbr" name="AccessAndMobilitySubscriptionData[subscribedUeAmbr][downlink]" required>
                </div>

                {{-- Session Management Subscription Data --}}
                <h4>Session Management Subscription Data</h4>
                <div class="mb-3">
                    <label for="dnn" class="form-label">DNN</label>
                    <input type="text" class="form-control" id="dnn" name="SessionManagementSubscriptionData[0][dnnConfigurations][internet][dnn]" required>
                </div>

                <div class="mb-3">
                    <label for="sessionType" class="form-label">Default Session Type</label>
                    <select class="form-select" id="sessionType" name="SessionManagementSubscriptionData[0][dnnConfigurations][internet][pduSessionTypes][defaultSessionType]" required>
                        <option value="IPV4" selected>IPV4</option>
                        <option value="IPV6">IPV6</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="uplinkSession" class="form-label">Session Uplink AMBR</label>
                    <input type="text" class="form-control" id="uplinkSession" name="SessionManagementSubscriptionData[0][dnnConfigurations][internet][sessionAmbr][uplink]" required>
                </div>

                <div class="mb-3">
                    <label for="downlinkSession" class="form-label">Session Downlink AMBR</label>
                    <input type="text" class="form-control" id="downlinkSession" name="SessionManagementSubscriptionData[0][dnnConfigurations][internet][sessionAmbr][downlink]" required>
                </div>

                {{-- Smf Selection Subscription Data --}}
                <h4>SMF Selection Subscription Data</h4>
                <div class="mb-3">
                    <label for="dnnInfo" class="form-label">DNN Information</label>
                    <input type="text" class="form-control" id="dnnInfo" name="SmfSelectionSubscriptionData[subscribedSnssaiInfos][01010203][dnnInfos][0][dnn]" required>
                </div>

                {{-- AM Policy Data --}}
                <h4>AM Policy Data</h4>
                <div class="mb-3">
                    <label for="subscCats" class="form-label">Subscription Category</label>
                    <input type="text" class="form-control" id="subscCats" name="AmPolicyData[subscCats][]" required>
                </div>

                {{-- Flow Rules --}}
                <h4>Flow Rules</h4>
                <div class="mb-3">
                    <label for="flowSnssai" class="form-label">SNSSAI</label>
                    <input type="text" class="form-control" id="flowSnssai" name="FlowRules[0][snssai]" required>
                </div>

                <div class="mb-3">
                    <label for="filter" class="form-label">Filter</label>
                    <input type="text" class="form-control" id="filter" name="FlowRules[0][filter]" required>
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="btn btn-primary">Create Subscriber</button>
            </form>
        </div>
    </div>

@endsection
