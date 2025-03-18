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

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('subscribers.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="plmnID">PLMN ID:</label>
                    <input type="text" name="plmnID" id="plmnID" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="ueId">UE ID:</label>
                    <input type="text" name="ueId" id="ueId" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="authenticationMethod">Authentication Method:</label>
                    <input type="text" name="authenticationMethod" id="authenticationMethod" class="form-control" value="5G_AKA" required>
                </div>

                <div class="form-group">
                    <label for="sequenceNumber">Sequence Number:</label>
                    <input type="text" name="sequenceNumber" id="sequenceNumber" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="subscribedUeAmbr_uplink">Subscribed UE AMBR (Uplink):</label>
                    <input type="text" name="subscribedUeAmbr_uplink" id="subscribedUeAmbr_uplink" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="subscribedUeAmbr_downlink">Subscribed UE AMBR (Downlink):</label>
                    <input type="text" name="subscribedUeAmbr_downlink" id="subscribedUeAmbr_downlink" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Create Subscriber</button>
            </form>
        </div>
    </div>

@endsection
