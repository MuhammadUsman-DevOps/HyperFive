@extends('layouts.master')
@section('title', 'Import Subscribers')

@section('extra_styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('main_content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-fluid">
            <h2>Import Subscribers</h2>

            <form id="importForm" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="json_file" class="form-label">Select JSON File</label>
                    <input type="file" name="json_file" id="json_file" class="form-control" accept=".json" required>
                </div>
                <button type="submit" class="btn btn-primary">Import</button>
            </form>

            <div id="result" class="mt-4"></div>
        </div>
    </div>
@endsection

@section('extra_scripts')
    <script>
        document.getElementById('importForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            const response = await fetch("{{ route('import_subscriber') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            });

            const resultDiv = document.getElementById('result');
            resultDiv.innerHTML = '';

            if (response.ok) {
                const data = await response.json();
                const resultHtml = data.results.map(item =>
                    `<li><strong>${item.ueId}</strong>: ${item.status}</li>`
                ).join('');
                resultDiv.innerHTML = `<div class="alert alert-success"><ul>${resultHtml}</ul></div>`;
            } else {
                const errorText = await response.text();
                resultDiv.innerHTML = `<div class="alert alert-danger">Error: ${errorText}</div>`;
            }
        });
    </script>
@endsection
