@extends('layouts.master')
@section('title', 'Services')

@section('extra_styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('main_content')
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-fluid h-100 py-6">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Service Configuration</h1>

                <form action="" method="POST">
                    @csrf

                    @php
                        function renderCards($content, $parentKey = '')
                        {
                            if (!is_array($content)) {
                                echo "<div class='mb-4'>";
                                echo "<label for='$parentKey' class='form-label form-label-config'>" . ucfirst(preg_replace('/([a-z])([A-Z])/', '$1 $2', $parentKey)) . "</label>";
                                echo "<input type='text' class='form-control form-control-config' name='$parentKey' value='" . htmlspecialchars($content, ENT_QUOTES) . "'>";
                                echo "</div>";
                                return;
                            }

                            foreach ($content as $key => $value) {
                                $fieldName = $parentKey ? $parentKey . '[' . $key . ']' : $key;

                                if (is_array($value)) {
                                    echo "<div class='" . ($key == 0 ? "card card-config" : "") . "mb-4 '>";
                                    if (!is_numeric($key)) {
                                        echo "<div class='card-header card-header-config'>";
                                        echo "<div class='card-title'>" . ucfirst(preg_replace('/([a-z])([A-Z])/', '$1 $2', $key)) . "</div>";
                                        echo "</div>";
                                    }
                                    echo "<div class='card-body-config'>";
                                    renderCards($value, $fieldName);
                                    echo "</div>";
                                    echo "</div>";
                                } else {
                                    echo "<div class='mb-4'>";
                                    if (!is_numeric($key)) {
                                        echo "<label for='$fieldName' class='form-label form-label-config'>" . ucfirst(preg_replace('/([a-z])([A-Z])/', '$1 $2', $key)) . "</label>";
                                    }
                                    echo "<input type='text' class='form-control form-control-config' name='$fieldName' value='" . htmlspecialchars($value, ENT_QUOTES) . "'>";
                                    echo "</div>";
                                }
                            }
                        }
                    @endphp

                    <!-- Main Tabs -->
                    <ul class="nav nav-tabs nav-tabs-config mb-6" id="configTabs" role="tablist">
                        @php
                            $tabIndex = 0;
                            foreach ($yamlContent as $mainKey => $mainValue) {
                                if (!is_numeric($mainKey)) {
                                    $isActive = $tabIndex === 0 ? 'active' : '';
                                    echo "<li class='nav-item' role='presentation'>";
                                    echo "<button class='nav-link $isActive' id='$mainKey-tab' data-bs-toggle='tab' data-bs-target='#$mainKey' type='button' role='tab' aria-controls='$mainKey' aria-selected='true'>"
                                        . ucfirst(preg_replace('/([a-z])([A-Z])/', '$1 $2', $mainKey)) . "</button>";
                                    echo "</li>";
                                    $tabIndex++;
                                }
                            }
                        @endphp
                    </ul>

                    <!-- Main Tab Content -->
                    <div class="tab-content tab-content-config" id="configTabsContent">
                        @php
                            $tabIndex = 0;
                            foreach ($yamlContent as $mainKey => $mainValue) {
                                if (!is_numeric($mainKey)) {
                                    $isActive = $tabIndex === 0 ? 'show active' : '';
                                    echo "<div class='tab-pane fade $isActive' id='$mainKey' role='tabpanel' aria-labelledby='$mainKey-tab'>";

                                    if ($mainKey === 'configuration' && is_array($mainValue)) {
                                        // Nested tabs for "configuration"
                                        echo "<ul class='nav nav-tabs nav-tabs-config mb-4' id='configSubTabs' role='tablist'>";
                                        $subTabIndex = 0;
                                        foreach ($mainValue as $subKey => $subValue) {
                                            if (!is_numeric($subKey)) {
                                                $subActive = $subTabIndex === 0 ? 'active' : '';
                                                echo "<li class='nav-item' role='presentation'>";
                                                echo "<button class='nav-link $subActive' id='$subKey-tab' data-bs-toggle='tab' data-bs-target='#$subKey' type='button' role='tab' aria-controls='$subKey' aria-selected='true'>"
                                                    . ucfirst(preg_replace('/([a-z])([A-Z])/', '$1 $2', $subKey)) . "</button>";
                                                echo "</li>";
                                                $subTabIndex++;
                                            }
                                        }
                                        echo "</ul>";

                                        // Sub-tab content for "configuration"
                                        echo "<div class='tab-content tab-content-config' id='configSubTabsContent'>";
                                        $subTabIndex = 0;
                                        foreach ($mainValue as $subKey => $subValue) {
                                            if (!is_numeric($subKey)) {
                                                $subActive = $subTabIndex === 0 ? 'show active' : '';
                                                echo "<div class='tab-pane fade $subActive' id='$subKey' role='tabpanel' aria-labelledby='$subKey-tab'>";
                                                renderCards($subValue, $subKey);
                                                echo "</div>";
                                                $subTabIndex++;
                                            }
                                        }
                                        echo "</div>";
                                    } else {
                                        renderCards($mainValue, $mainKey);
                                    }

                                    echo "</div>";
                                    $tabIndex++;
                                }
                            }
                        @endphp
                        <button type="submit" class="btn app_btns">Save Configuration</button>

                    </div>

                </form>
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
@endsection

@section('extra_scripts')
    <script>
        // Ensure Bootstrap's tab functionality is initialized
        document.addEventListener('DOMContentLoaded', function () {
            var triggerTabList = [].slice.call(document.querySelectorAll('#configTabs .nav-link, #configSubTabs .nav-link'));
            triggerTabList.forEach(function (triggerEl) {
                var tabTrigger = new bootstrap.Tab(triggerEl);
                triggerEl.addEventListener('click', function (event) {
                    event.preventDefault();
                    tabTrigger.show();
                });
            });
        });
    </script>
@endsection