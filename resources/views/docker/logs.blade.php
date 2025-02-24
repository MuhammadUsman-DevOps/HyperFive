{{--@extends('layouts.master')--}}

{{--@section('title', 'Service Logs')--}}
{{--@section('extra_styles')--}}
{{--    <style>--}}
{{--        pre {--}}
{{--            white-space: pre-wrap; /* Preserve line breaks and wrap text */--}}
{{--            word-wrap: break-word; /* Break long lines */--}}
{{--            background-color: #f8f9fa;--}}
{{--            padding: 1rem;--}}
{{--            border-radius: 0.5rem;--}}
{{--            border: 1px solid #e9ecef;--}}
{{--            max-height: 70vh;--}}
{{--            overflow-y: auto;--}}
{{--        }--}}
{{--    </style>--}}
{{--@endsection--}}
{{--@section('main_content')--}}
{{--    <div class="post d-flex flex-column-fluid" id="kt_post">--}}
{{--        <div id="kt_content_container" class="container-fluid h-100">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">--}}
{{--                    <h3 class="card-title">Logs</h3>--}}
{{--                    <a href="{{ route('services.list') }}" class="btn btn-sm btn-light-primary float-end">Back to Services</a>--}}
{{--                </div>--}}
{{--                <div class="card-body scroll-y scroll-x">--}}
{{--                    <pre>{{ $logs }}</pre>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endsection--}}
@extends('layouts.master')

@section('title', 'Service Logs')

@section('extra_styles')
    <style>
        pre {
            white-space: pre-wrap;
            word-wrap: break-word;
            background-color: #f8f9fa;
            padding: 1rem;
            border-radius: 0.5rem;
            border: 1px solid #e9ecef;
            max-height: 70vh;
            overflow-y: auto;
        }
    </style>
@endsection

@section('main_content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-fluid h-100">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Logs</h3>
                    <a href="{{ route('services.list') }}" class="btn btn-sm btn-light-primary float-end">Back to Services</a>
                </div>
                <div class="card-body scroll-y scroll-x">
                    <pre id="log-output">Connecting...</pre>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const logOutput = document.getElementById("log-output");

            const eventSource = new EventSource("{{ url('/containers/' . $containerId . '/logs/stream') }}");

            eventSource.onmessage = function(event) {
                if (event.data !== "ERROR: Failed to stream logs") {
                    logOutput.textContent += event.data + "\n";
                    logOutput.scrollTop = logOutput.scrollHeight; // Auto-scroll
                } else {
                    logOutput.textContent = "Error: Unable to fetch logs.";
                    eventSource.close();
                }
            };

            eventSource.onerror = function () {
                logOutput.textContent += "\n[Disconnected. Trying to reconnect...]";
                setTimeout(() => {
                    eventSource.close();
                    location.reload();
                }, 5000);
            };
        });
    </script>
@endsection
