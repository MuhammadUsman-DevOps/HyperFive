@extends('layouts.master')
@section('title', 'Services')
@section('extra_styles')
    <style>


    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection('extra_styles')

@section('main_content')
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-fluid h-100">

            <form action="" method="POST">
                @csrf

                @php
                    function renderCards($content, $parentKey = '')
                    {
                        if (!is_array($content)) {
                            // Handle cases where $content is not an array
                            echo "<div class='mb-3'>";
                            echo "<label for='$parentKey' class='form-label'>" . ucfirst($parentKey) . "</label>";
                            echo "<input type='text' class='form-control' name='$parentKey' value='" . htmlspecialchars($content, ENT_QUOTES) . "'>";
                            echo "</div>";
                            return;
                        }

                        foreach ($content as $key => $value) {
                            $fieldName = $parentKey ? $parentKey . '[' . $key . ']' : $key;

                            if (is_array($value)) {
                                echo "<div class='card mb-4'>";
                                if (!is_numeric($key)) {
                                    echo "<div class='card-header bg-dark text-white fs-4 fw-bold'><div class='card-title text-white'>" . ucfirst(preg_replace('/([a-z])([A-Z])/', '$1 $2', $key)) . "</div></div>";
                                }
                                echo "<div class='card-body'>";
                                renderCards($value, $fieldName);
                                echo "</div>";
                                echo "</div>";
                            } else {
                                echo "<div class='mb-3'>";
                                if (!is_numeric($key)) {
                                    echo "<label for='$fieldName' class='form-label'>" . ucfirst(preg_replace('/([a-z])([A-Z])/', '$1 $2', $key)) . "</label>";
                                }
                                echo "<input type='text' class='form-control' name='$fieldName' value='" . htmlspecialchars($value, ENT_QUOTES) . "'>";
                                echo "</div>";
                            }
                        }
                    }
                @endphp

                    <!-- Main Tabs -->
                <ul class="nav nav-tabs bg-dark border-1 rounded" id="configTabs" role="tablist">
                    @php
                        $tabIndex = 0; // Track the active tab
                        foreach ($yamlContent as $mainKey => $mainValue) {
                            if (!is_numeric($mainKey)) {
                                $isActive = $tabIndex === 0 ? 'active' : ''; // Activate the first tab
                                echo "<li class='nav-item' role='presentation'>";
                                echo "<button class='nav-link $isActive text-white text-active-dark' id='$mainKey-tab' data-bs-toggle='tab' data-bs-target='#$mainKey' type='button' role='tab' aria-controls='$mainKey' aria-selected='true'>"
                                    . ucfirst(preg_replace('/([a-z])([A-Z])/', '$1 $2', $mainKey)) . "</button>";
                                echo "</li>";
                                $tabIndex++;
                            }
                        }
                    @endphp
                </ul>

                <!-- Main Tab Content -->
                <div class="tab-content mt-3" id="configTabsContent">
                    @php
                        $tabIndex = 0; // Reset for content
                        foreach ($yamlContent as $mainKey => $mainValue) {
                            if (!is_numeric($mainKey)) {
                                $isActive = $tabIndex === 0 ? 'show active' : ''; // Activate the first tab content
                                echo "<div class='tab-pane fade $isActive' id='$mainKey' role='tabpanel' aria-labelledby='$mainKey-tab'>";

                                if ($mainKey === 'configuration' && is_array($mainValue)) {
                                    // Nested tabs for "configuration"
                                    echo "<ul class='nav nav-tabs mt-3 bg-dark ' id='configSubTabs' role='tablist'>";
                                    $subTabIndex = 0;
                                    foreach ($mainValue as $subKey => $subValue) {
                                        if (!is_numeric($subKey)) {
                                            $subActive = $subTabIndex === 0 ? 'active' : ''; // Activate first sub-tab
                                            echo "<li class='nav-item' role='presentation'>";
                                            echo "<button class='nav-link $subActive text-white text-active-dark' id='$subKey-tab' data-bs-toggle='tab' data-bs-target='#$subKey' type='button' role='tab' aria-controls='$subKey' aria-selected='true'>"
                                                . ucfirst(preg_replace('/([a-z])([A-Z])/', '$1 $2', $subKey)) . "</button>";
                                            echo "</li>";
                                            $subTabIndex++;
                                        }
                                    }
                                    echo "</ul>";

                                    // Sub-tab content for "configuration"
                                    echo "<div class='tab-content mt-3' id='configSubTabsContent'>";
                                    $subTabIndex = 0;
                                    foreach ($mainValue as $subKey => $subValue) {
                                        if (!is_numeric($subKey)) {
                                            $subActive = $subTabIndex === 0 ? 'show active' : ''; // Activate first sub-tab content
                                            echo "<div class='tab-pane fade $subActive' id='$subKey' role='tabpanel' aria-labelledby='$subKey-tab'>";

                                            // Render cards for subsections
                                            renderCards($subValue, $subKey);

                                            echo "</div>";
                                            $subTabIndex++;
                                        }
                                    }
                                    echo "</div>";
                                } else {
                                    // Render cards for non-"configuration" main tabs
                                    renderCards($mainValue, $mainKey);
                                }

                                echo "</div>";
                                $tabIndex++;
                            }
                        }
                    @endphp
                </div>
                <button type="submit" class="btn btn-primary float-end">Save Config</button>
            </form>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->

@endsection

@section('extra_scripts')

@endsection
