@extends('layouts.master')
@section('title', 'Services')
@section('extra_styles')
    <style>



    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection('extra_styles')
@section("extra_header_block")
    <div class="d-flex align-items-stretch">
        <div class="d-flex align-items-center ms-1 ms-lg-3">
            <span class="fs-3 fw-bold text-info">{{ count($services) }} Orders today so far</span>
        </div>
    </div>
@endsection
@section('main_content')
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-fluid h-100">

            @if($services)
                <div class="row mt-5">
                    @foreach($services as $service)

                        <!--begin::Item-->
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 order-card">
                            <div class="card rounded border-gray-300 border-1 border-dashed px-7 py-3 mb-6">

                                    <!--begin::Wrapper-->
                                    <div class="d-flex justify-content-between">
                                        <!--begin::Title-->
                                        <span class="text-gray-800 text-hover-primary fw-bold fs-3"> {{$service["name"]}}  </span>
                                        <span class="badge @if($service["state"] == "running") badge-light-success @else badge-light-danger @endif fs-4 fw-bold">
                                            <i class="bi   @if($service["state"] == "running")
            bi-check-circle-fill text-success
        @elseif($service["state"] == "exited")
            bi-x-circle-fill text-danger
        @else
            bi-exclamation-circle-fill text-warning
        @endif  me-2"></i>
                                             {{ $service["state"] }}</span>


                                    </div>
                                    <!--end::Wrapper-->

                                <div class="mt-5 d-flex justify-content-between">
                                <span
                                    class="text-black">Status </span>
                                    <span
                                        class="text-black">{{ $service["status"] }}</span>
                                </div>

                                <div class="mt-2 d-flex justify-content-between">
                                    <span class="text-black">IPAddress</span>
                                    <span class="text-black">{{ $service["ip"] }}</span>


                                </div>

                                <div class="separator separator-dashed mt-3 mb-3 border-gray-500"></div>

{{--                                <div class="mt-3 d-flex justify-content-between">--}}
{{--                                    <button class="btn btn-sm btn-light-success"--}}
{{--                                    >See Logs--}}
{{--                                    </button>--}}
{{--                                    <a class="btn btn-sm btn-primary"--}}
{{--                                       href="" >View Details--}}
{{--                                    </a>--}}

{{--                                </div>--}}

                                <div class="mt-3 d-flex justify-content-between">
                                    <a href="{{ route('command_execution', $service['id']) }}" class="btn btn-sm btn-light-success">Run Command</a>
                                    <a href="{{ route('view_logs', $service['id']) }}" class="btn btn-sm btn-light-success">View Logs</a>
                                    <div>
                                        @if($service['state'] == 'running')
                                            <!-- Stop Service -->
                                            <form action="{{ route('stop_service', $service['id']) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-warning me-2">Stop</button>
                                            </form>

                                            <!-- Restart Service -->
                                            <form action="{{ route('restart_service', $service['id']) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger">Restart</button>
                                            </form>
                                        @elseif($service['state'] == 'exited' || $service['state'] == 'stopped')
                                            <!-- Start Service -->
                                            <form action="{{ route('start_service', $service['id']) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-primary">Start</button>
                                            </form>
                                        @else
                                            <!-- Unknown State -->
                                            <span class="text-muted">No actions available</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Item-->

                    @endforeach

                </div>




            @else
                <div class="row mt-20 justify-content-center align-items-center">
                    <div class="col-12 text-center">
                        <iframe src="https://lottie.host/embed/92787ad9-5de7-4213-8018-d71a7b2c516a/mKe8CyuvzR.json"
                                style="border: none;"></iframe>
                        <div class="fs-7 text-black mt-5">No Services found</div>
                    </div>
                </div>
            @endif

        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->



@endsection

@section('extra_scripts')

@endsection
