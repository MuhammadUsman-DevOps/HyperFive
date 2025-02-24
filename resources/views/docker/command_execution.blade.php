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
                    <form id="command-form">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" name="command" class="form-control" placeholder="Enter command to execute" required>
                            <button type="submit" class="btn btn-primary">Execute</button>
{{--                            <button type="button" id="stop-button" class="btn btn-danger" disabled>Stop</button>--}}
                        </div>
                    </form>


                    <!-- Command Output -->
                    <div class="mt-4">
                        <h5>Command Output:</h5>
                        <pre id="command-output" class="bg-light p-3 rounded"></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra_scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('command-form');
            const outputElement = document.getElementById('command-output');
            // const stopButton = document.getElementById('stop-button');

            form.addEventListener('submit', function (event) {
                event.preventDefault(); // Prevent the form from submitting normally

                // Clear previous output
                outputElement.textContent = '';

                // Enable the stop button
                // stopButton.disabled = false;

                // Get the command from the form
                const formData = new FormData(form);
                const command = formData.get('command');

                // Send the command to the backend
                fetch("{{ route('execute_command', $containerId) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ command: command }),
                })
                    .then(response => {
                        const reader = response.body.getReader();
                        const decoder = new TextDecoder();

                        function readStream() {
                            return reader.read().then(({ done, value }) => {
                                if (done) {
                                    console.log('Stream complete');
                                    stopButton.disabled = true; // Disable the stop button when the stream ends
                                    return;
                                }

                                // Decode the stream chunk and append it to the output
                                const chunk = decoder.decode(value, { stream: true });
                                outputElement.textContent += chunk;

                                // Scroll to the bottom of the output
                                outputElement.scrollTop = outputElement.scrollHeight;

                                // Continue reading the stream
                                return readStream();
                            });
                        }

                        // Start reading the stream
                        return readStream();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        outputElement.textContent = 'Failed to execute command.';
                        stopButton.disabled = true;
                    });
            });

            // Handle the stop button click
            {{--stopButton.addEventListener('click', function () {--}}
            {{--    fetch("{{ route('stop_command', $containerId) }}", {--}}
            {{--        method: 'POST',--}}
            {{--        headers: {--}}
            {{--            'Content-Type': 'application/json',--}}
            {{--            'X-CSRF-TOKEN': '{{ csrf_token() }}',--}}
            {{--        },--}}
            {{--    })--}}
            {{--        .then(response => response.json())--}}
            {{--        .then(data => {--}}
            {{--            console.log(data.message);--}}
            {{--            stopButton.disabled = true; // Disable the stop button after stopping--}}
            {{--        })--}}
            {{--        .catch(error => {--}}
            {{--            console.error('Error:', error);--}}
            {{--        });--}}
            {{--});--}}
        });
    </script>
@endsection
