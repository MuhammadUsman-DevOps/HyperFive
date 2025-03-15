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
                    @if(session('error'))
                        <p class="text-danger">{{ session('error') }}</p>
                    @endif

                        <h2>UE Context Information</h2>

                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">UE Details</h5>
                                <p><strong>SUPI:</strong> {{ $ueContext['Supi'] }}</p>
                                <p><strong>Access Type:</strong> {{ $ueContext['AccessType'] }}</p>
                                <p><strong>CM State:</strong> {{ $ueContext['CmState'] }}</p>
                                <p><strong>MCC:</strong> {{ $ueContext['Mcc'] }}</p>
                                <p><strong>MNC:</strong> {{ $ueContext['Mnc'] }}</p>
                                <p><strong>GUTI:</strong> {{ $ueContext['Guti'] }}</p>
                                <p><strong>TAC:</strong> {{ $ueContext['Tac'] }}</p>
                            </div>
                        </div>

                        <h3 class="mt-4">PDU Sessions</h3>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>PDU Session ID</th>
                                <th>DNN</th>
                                <th>SD</th>
                                <th>SM Context Ref</th>
                                <th>SST</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($ueContext['PduSessions'] as $session)
                                <tr>
                                    <td>{{ $session['PduSessionId'] }}</td>
                                    <td>{{ $session['Dnn'] }}</td>
                                    <td>{{ $session['Sd'] }}</td>
                                    <td>{{ $session['SmContextRef'] }}</td>
                                    <td>{{ $session['Sst'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
@endsection
