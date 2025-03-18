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
                    <h2 class="mb-4">All Subscribers</h2>

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>PLMN ID</th>
                            <th>UE ID</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($subscribers as $index => $subscriber)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $subscriber['plmnID'] }}</td>
                                <td>{{ $subscriber['ueId'] }}</td>
                                <td><a href="{{ route("get_subscriber", ["ueId"=>$subscriber["ueId"],"plmnId"=>$subscriber["plmnID"]]) }}" class="btn btn-sm btn-primary">View</a> </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

@endsection
