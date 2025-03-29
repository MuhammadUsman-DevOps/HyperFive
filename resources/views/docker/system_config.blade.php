@extends('layouts.master')
@section('title', $page)
@section('extra_styles')
    <style>
        .accordion-button {
            font-weight: bold;
            background-color: #f8f9fa;
            color: #6c757d;
            border: 1px solid #d1d1d1;
        }
        .accordion-button:not(.collapsed) {
            background-color: #e0e0e0;
            color: #333;
        }
        .accordion-body {
            background: #ffffff;
            padding: 15px;
            border: 1px solid #ddd;
        }
        .form-label {
            font-weight: bold;
            color: #333;
        }
        .btn-save {
            margin-top: 20px;
        }
        .textarea-field {
            min-height: 100px;
            font-family: monospace;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('main_content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-fluid h-100">
            <form action="" method="POST">
                @csrf

                @php
                    function renderAccordionItems($content, $parentKey = '') {
                        if (empty($content) || !is_array($content)) {
                            echo "<p class='text-muted'>No data available.</p>";
                            return;
                        }

                        foreach ($content as $key => $value) {
                            $fieldName = $parentKey ? $parentKey . '[' . $key . ']' : $key;

                            echo "<div class='mb-3'>";
                            echo "<label class='form-label'>" . ucfirst(str_replace('_', ' ', $key)) . "</label>";

                            if (is_array($value)) {
                                echo "<textarea class='form-control textarea-field' name='$fieldName'>" . htmlspecialchars(json_encode($value, JSON_PRETTY_PRINT), ENT_QUOTES) . "</textarea>";
                            } else {
                                echo "<input type='text' class='form-control' name='$fieldName' value='" . htmlspecialchars($value, ENT_QUOTES) . "'>";
                            }

                            echo "</div>";
                        }
                    }
                @endphp

                @if(!empty($yamlContent) && is_array($yamlContent))
                    <!-- Main Tabs -->
                    <ul class="nav nav-tabs bg-secondary text-white border-1 rounded" id="configTabs" role="tablist">
                        @php
                            $tabIndex = 0;
                            foreach ($yamlContent as $mainKey => $mainValue) {
                                if (!is_numeric($mainKey) && strtolower($mainKey) !== 'version') {
                                    $isActive = $tabIndex === 0 ? 'active' : '';
                                    echo "<li class='nav-item'>";
                                    echo "<button class='nav-link $isActive text-white' id='$mainKey-tab' data-bs-toggle='tab' data-bs-target='#$mainKey' type='button' role='tab' aria-controls='$mainKey' aria-selected='true'>"
                                        . ucfirst(str_replace('_', ' ', $mainKey)) . "</button>";
                                    echo "</li>";
                                    $tabIndex++;
                                }
                            }
                        @endphp
                    </ul>

                    <!-- Main Tab Content -->
                    <div class="tab-content mt-3" id="configTabsContent">
                        @php
                            $tabIndex = 0;
                            foreach ($yamlContent as $mainKey => $mainValue) {
                                if (!is_numeric($mainKey) && strtolower($mainKey) !== 'version') {
                                    $isActive = $tabIndex === 0 ? 'show active' : '';
                                    echo "<div class='tab-pane fade $isActive' id='$mainKey' role='tabpanel' aria-labelledby='$mainKey-tab'>";
                                    
                                    // Start Accordion
                                    echo "<div class='accordion' id='accordion-$mainKey'>";

                                    $accordionIndex = 0;
                                    foreach ($mainValue as $sectionKey => $sectionValue) {
                                        if (!is_numeric($sectionKey)) {
                                            $collapseID = "$mainKey-$sectionKey-collapse";
                                            $headerID = "$mainKey-$sectionKey-header";
                                            $showClass = $accordionIndex === 0 ? 'show' : '';

                                            echo "
                                            <div class='accordion-item'>
                                                <h2 class='accordion-header' id='$headerID'>
                                                    <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#$collapseID' aria-expanded='false' aria-controls='$collapseID'>
                                                        " . ucfirst(str_replace('_', ' ', $sectionKey)) . "
                                                    </button>
                                                </h2>
                                                <div id='$collapseID' class='accordion-collapse collapse $showClass' aria-labelledby='$headerID' data-bs-parent='#accordion-$mainKey'>
                                                    <div class='accordion-body'>";
                                                    
                                            renderAccordionItems($sectionValue, $sectionKey);

                                            echo "
                                                    </div>
                                                </div>
                                            </div>";

                                            $accordionIndex++;
                                        }
                                    }

                                    echo "</div>"; // End Accordion
                                    echo "</div>";
                                    $tabIndex++;
                                }
                            }
                        @endphp
                    </div>
                @else
                    <div class="alert alert-warning mt-4">
                        <strong>Warning:</strong> No configuration data available. Please check your YAML files.
                    </div>
                @endif

                <button type="submit" class="btn btn-primary float-end btn-save">Save Config</button>
            </form>
        </div>
    </div>
@endsection

@section('extra_scripts')
@endsection
