@extends('layouts.master')
@section('title', 'All Registered UE Context')
@section('extra_styles')

    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection('extra_styles')

@section('main_content')
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-fluid h-100">
            <div class="row ">
                <div class="col-xl-12 col-lg-12 col-md-12  col-sm-12 d-flex">
                    <h2>Subscriber Details</h2>

                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th>PLMN ID</th>
                            <td>{{ $subscriber['plmnID'] }}</td>
                        </tr>
                        <tr>
                            <th>UE ID</th>
                            <td>{{ $subscriber['ueId'] }}</td>
                        </tr>
                        </tbody>
                    </table>

                    <h4>Authentication Subscription</h4>
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th>Authentication Method</th>
                            <td>{{ $subscriber['AuthenticationSubscription']['authenticationMethod'] }}</td>
                        </tr>
                        <tr>
                            <th>Permanent Key</th>
                            <td>{{ $subscriber['AuthenticationSubscription']['permanentKey']['permanentKeyValue'] }}</td>
                        </tr>
                        <tr>
                            <th>Sequence Number</th>
                            <td>{{ $subscriber['AuthenticationSubscription']['sequenceNumber'] }}</td>
                        </tr>
                        </tbody>
                    </table>

                    <h4>Access & Mobility Subscription Data</h4>
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th>MSISDN</th>
                            <td>{{ implode(', ', $subscriber['AccessAndMobilitySubscriptionData']['gpsis']) }}</td>
                        </tr>
                        <tr>
                            <th>Uplink AMBR</th>
                            <td>{{ $subscriber['AccessAndMobilitySubscriptionData']['subscribedUeAmbr']['uplink'] }}</td>
                        </tr>
                        <tr>
                            <th>Downlink AMBR</th>
                            <td>{{ $subscriber['AccessAndMobilitySubscriptionData']['subscribedUeAmbr']['downlink'] }}</td>
                        </tr>
                        </tbody>
                    </table>

                    <h4>Session Management Subscription Data</h4>
                    @foreach ($subscriber['SessionManagementSubscriptionData'] as $sessionData)
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th>SST</th>
                                <td>{{ $sessionData['singleNssai']['sst'] }}</td>
                            </tr>
                            <tr>
                                <th>SD</th>
                                <td>{{ $sessionData['singleNssai']['sd'] }}</td>
                            </tr>
                            <tr>
                                <th>Uplink AMBR</th>
                                <td>{{ $sessionData['dnnConfigurations']['internet']['sessionAmbr']['uplink'] }}</td>
                            </tr>
                            <tr>
                                <th>Downlink AMBR</th>
                                <td>{{ $sessionData['dnnConfigurations']['internet']['sessionAmbr']['downlink'] }}</td>
                            </tr>
                            </tbody>
                        </table>
                    @endforeach

                    <a href="{{ route('subscribers') }}" class="btn btn-primary">Back to Subscribers</a>
                </div>
            </div>
        </div>
    </div>
@endsection
