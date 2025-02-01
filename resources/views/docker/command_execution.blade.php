@extends('layouts.master')

@section('title', 'Command Execution')
@section('extra_styles')
    <style>
        pre {
            white-space: pre-wrap; /* Preserve line breaks and wrap text */
            word-wrap: break-word; /* Break long lines */
            background-color: #f8f9fa;
            padding: 1rem;
            border-radius: 0.5rem;
            border: 1px solid #e9ecef;
            max-height: 50vh;
            overflow-y: auto;
        }
    </style>
@endsection
@section('main_content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-fluid h-100">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Command Execution for Container: {{ $containerId }}</h3>
                    <a href="{{ route('services.list') }}" class="btn btn-sm btn-light-primary float-end">Back to Services</a>
                </div>
                <div class="card-body">
                    <!-- Command Execution Form -->
                    <form action="{{ route('execute_command', $containerId) }}" method="POST">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" name="command" class="form-control" placeholder="Enter command to execute" required>
                            <button type="submit" class="btn btn-primary">Execute</button>
                        </div>
                    </form>

                    <!-- Command Output -->
                    @if(session('output'))
                        <div class="mt-4">
                            <h5>Command Output:</h5>
                            <pre class="bg-light p-3 rounded">{{ session('output') }}</pre>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
