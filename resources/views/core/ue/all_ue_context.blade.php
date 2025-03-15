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

                    @if($ueContexts)
                        <table border="1">
                            <tr>
                                <th>SUPI</th>
                                <th>Access Type</th>
                                <th>CM State</th>
                                <th>GUTI</th>
                                <th>MCC</th>
                                <th>MNC</th>
                                <th>PDU Sessions</th>
                            </tr>
                            @foreach($ueContexts as $context)
                                <tr>
                                    <td>{{ $context['Supi'] }}</td>
                                    <td>{{ $context['AccessType'] }}</td>
                                    <td>{{ $context['CmState'] }}</td>
                                    <td>{{ $context['Guti'] }}</td>
                                    <td>{{ $context['Mcc'] }}</td>
                                    <td>{{ $context['Mnc'] }}</td>
                                    <td>
                                        <ul>
                                            @foreach($context['PduSessions'] as $session)
                                                <li>Session ID: {{ $session['PduSessionId'] }} |
                                                    DNN: {{ $session['Dnn'] }} |
                                                    SmContextRef: {{ $session['SmContextRef'] }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @else
                        <p>No registered UE contexts found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
