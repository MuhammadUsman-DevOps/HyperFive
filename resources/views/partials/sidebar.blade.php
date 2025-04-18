@section('sidebar_menu')
    <!--begin::Aside menu-->
    <div class="aside-menu flex-column-fluid">
        <!--begin::Aside Menu-->
        <div class="hover-scroll-overlay-y my-4 my-lg-6" id="kt_aside_menu_wrapper" data-kt-scroll="true"
             data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto"
             data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer"
             data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="0">
            <!--begin::Menu-->
            <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
                 id="kt_aside_menu" data-kt-menu="true" data-kt-menu-expand="false">
                
                <!-- Dashboard -->
                <div class="menu-item">
                    <a class="menu-link {{ Route::currentRouteName() == 'services.list' ? 'active' : '' }}"
                       href="{{ route('services.list') }}">
                        <span class="menu-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"
                                 fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                <rect x="3" y="3" width="7" height="7" />
                                <rect x="14" y="3" width="7" height="7" />
                                <rect x="14" y="14" width="7" height="7" />
                                <rect x="3" y="14" width="7" height="7" />
                            </svg>
                        </span>
                        <span class="menu-title fw-semibold fs-6">Dashboard</span>
                    </a>
                </div>

                <!-- Subscribers -->
                <div class="menu-item">
                    <a class="menu-link {{ Route::currentRouteName() == 'subscribers' ? 'active' : '' }}"
                       href="{{ route('subscribers') }}">
                        <span class="menu-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"
                                 fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                            </svg>
                        </span>
                        <span class="menu-title fw-semibold fs-6">Subscribers</span>
                    </a>
                </div>

                <!-- System Configuration -->
                <div class="menu-item">
                    @php
                        $activeBranchRoutes = ['system_configs'];
                    @endphp
                    <a class="menu-link {{ in_array(Route::currentRouteName(), $activeBranchRoutes) ? 'active' : '' }}"
                       href="{{ route('system_configs') }}">
                        <span class="menu-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"
                                 fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                <circle cx="12" cy="12" r="3" />
                                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z" />
                            </svg>
                        </span>
                        <span class="menu-title fw-semibold fs-6">System Configuration</span>
                    </a>
                </div>

                <!-- Services Accordion -->
                <div data-kt-menu-trigger="click"
                     class="menu-item menu-accordion {{ in_array(Route::currentRouteName(), ['amf_configs', 'view_all_orders', 'smf_configs', 'udm_configs', 'udr_configs', 'ausf_configs', 'pcf_configs', 'chf_configs', 'ehr_configs', 'nrf_configs', 'upf_configs']) ? 'hover show' : '' }}">
                     <span class="menu-link">
            <span class="menu-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"
                     fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                    <polyline points="3.27 6.96 12 12.01 20.73 6.96" />
                    <line x1="12" y1="22.08" x2="12" y2="12" />
                </svg>
            </span>
            <span class="menu-title fw-semibold fs-6">Services</span>
            <span class="menu-arrow">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                </svg>
            </span>
        </span>
                    <div class="menu-sub menu-sub-accordion">
                        @foreach(['amf_configs' => 'AMF', 'smf_configs' => 'SMF', 'udm_configs' => 'UDM', 'udr_configs' => 'UDR', 'ausf_configs' => 'AUSF', 'pcf_configs' => 'PCF', 'chf_configs' => 'CHF', 'ehr_configs' => 'EHR', 'nrf_configs' => 'NRF', 'upf_configs' => 'UPF'] as $route => $title)
                            <div class="menu-item">
                                <a class="menu-link {{ Route::currentRouteName() == $route ? 'active' : '' }}"
                                   href="{{ route($route) }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title fw-medium fs-7">{{ $title }}</span>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!--end::Menu-->
        </div>
        <!--end::Aside Menu-->
    </div>
    <!--end::Aside menu-->

    <!--begin::Footer-->
    <div class="aside-footer flex-column-auto pt-5 pb-7 px-5" id="kt_aside_footer">
        <a class="btn btn-custom btn-outline w-100 logout-btn" href="{{ route('logout') }}">
            <span class="svg-icon svg-icon-2 me-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"
                     fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    <polyline points="16 17 21 12 16 7" />
                    <line x1="21" y1="12" x2="9" y2="12" />
                </svg>
            </span>
            <span class="btn-label fw-semibold fs-6">Logout</span>
        </a>
    </div>
    <!--end::Footer-->
@show