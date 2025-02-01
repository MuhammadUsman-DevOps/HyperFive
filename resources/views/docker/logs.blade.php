@extends('layouts.master')

@section('title', 'Service Logs')
@section('extra_styles')
    <style>
        pre {
            white-space: pre-wrap; /* Preserve line breaks and wrap text */
            word-wrap: break-word; /* Break long lines */
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
                    <h3 class="card-title">Logs for Container: {{ $containerId }}</h3>
                    <a href="{{ route('services.list') }}" class="btn btn-sm btn-light-primary float-end">Back to Services</a>
                </div>
                <div class="card-body">
                    <pre>{{ $logs }}</pre>
                </div>
            </div>
        </div>
    </div>
@endsection
