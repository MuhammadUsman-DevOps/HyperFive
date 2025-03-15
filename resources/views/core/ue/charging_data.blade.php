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

                        <h2>Charging Data</h2>

                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>UE ID</th>
                                <th>Charging Method</th>
                                <th>DNN</th>
                                <th>Filter</th>
                                <th>QoS Ref</th>
                                <th>Quota</th>
                                <th>Rating Group</th>
                                <th>Serving PLMN ID</th>
                                <th>SNSSAI</th>
                                <th>Unit Cost</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($chargingData as $data)
                                <tr>
                                    <td>{{ $data['ueId'] }}</td>
                                    <td>{{ $data['chargingMethod'] }}</td>
                                    <td>{{ $data['dnn'] }}</td>
                                    <td>{{ $data['filter'] }}</td>
                                    <td>{{ $data['qosRef'] ?? 'N/A' }}</td>
                                    <td>{{ $data['quota'] }}</td>
                                    <td>{{ $data['ratingGroup'] }}</td>
                                    <td>{{ $data['servingPlmnId'] }}</td>
                                    <td>{{ $data['snssai'] }}</td>
                                    <td>{{ $data['unitCost'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
@endsection
