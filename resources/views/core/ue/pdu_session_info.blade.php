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

                        @if($sessionInfo)
                                <ul>
                                        <li><strong>AnType:</strong> {{ $sessionInfo['AnType'] }}</li>
                                        <li><strong>Dnn:</strong> {{ $sessionInfo['Dnn'] }}</li>
                                       <li><strong>PDUAddress:</strong> {{ $sessionInfo['PDUAddress'] }}</li>
                                        <li><strong>PDUSessionID:</strong> {{ $sessionInfo['PDUSessionID'] }}</li>
                                        <li><strong>Sd:</strong> {{ $sessionInfo['Sd'] }}</li>
                                        <li><strong>Supi:</strong> {{ $sessionInfo['Supi'] }}</li>
                                        <li><strong>UpCnxState:</strong> {{ $sessionInfo['UpCnxState'] }}</li>
                                    </ul>
                        @else
                                <p>No session info found.</p>
                        @endif
                </div>
            </div>
        </div>
    </div>
@endsection
