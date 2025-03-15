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
                        <h2>Charging Records</h2>

                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>SUPI</th>
                                <th>DNN</th>
                                <th>Filter</th>
                                <th>SNSSAI</th>
                                <th>Download Volume (DL)</th>
                                <th>Upload Volume (UL)</th>
                                <th>Total Volume</th>
                                <th>Usage</th>
                                <th>Quota Left</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($chargingRecords as $record)
                                <tr>
                                    <td>{{ $record['Supi'] }}</td>
                                    <td>{{ $record['Dnn'] }}</td>
                                    <td>{{ $record['Filter'] }}</td>
                                    <td>{{ $record['Snssai'] }}</td>
                                    <td>{{ $record['DlVol'] }}</td>
                                    <td>{{ $record['UlVol'] }}</td>
                                    <td>{{ $record['TotalVol'] }}</td>
                                    <td>{{ $record['Usage'] }}</td>
                                    <td>{{ $record['QuotaLeft'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
@endsection
