<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head>
    <base href="">
    <title>@yield('title') -Hyper Five</title>
    <meta charset="utf-8"/>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta property="og:locale" content="en_US"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title" content=""/>
    <meta property="og:url" content=""/>
    <meta property="og:site_name" content=""/>
    <link rel="canonical" href=""/>
    <link rel="shortcut icon" href=""/>


    @include('partials.styles')

    @yield('extra_styles')
    <style>
        /*@media (min-width: 992px) {*/

        /*    .header-fixed.toolbar-fixed .wrapper {*/
        /*        padding-top: calc(5px + var(--kt-toolbar-height))*/
        /*    }*/
        /*}*/

    </style>
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body"
      class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed"
      style="--kt-toolbar-height:@yield('toolbar_height',2)px;--kt-toolbar-height-tablet-and-mobile:55px">
<!--begin::Main-->
<!--begin::Root-->
<div class="d-flex flex-column flex-root">
    <!--begin::Page-->
    <div class="page d-flex flex-row flex-column-fluid">
        <!--begin::Aside-->
        <div style="" id="kt_aside" class="aside aside-light aside-hoverable text-white" data-kt-drawer="true"
             data-kt-drawer-name="aside"
             data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
             data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
             data-kt-drawer-toggle="#kt_aside_mobile_toggle">
            <!--begin::Brand-->
            <div class="aside-logo flex-column-auto" id="kt_aside_logo">
                <!--begin::Logo-->
                <a href="#">
                    <img src="{{ asset('static/media/logo_dark.png') }}" class="h-50px logo">
                </a>
                <!--end::Logo-->
                <!--begin::Aside toggler-->
                <div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-toggle"
                     data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
                     data-kt-toggle-name="aside-minimize">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr079.svg') }}-->
                    <span class="svg-icon svg-icon-1 rotate-180">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none">
									<path opacity="0.5"
                                          d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z"
                                          fill="currentColor"/>
									<path
                                        d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z"
                                        fill="currentColor"/>
								</svg>
							</span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Aside toggler-->
            </div>
            <!--end::Brand-->
            @section('sidebar_menu')
                <!--begin::Aside menu-->
                <div class="aside-menu flex-column-fluid">
                    <!--begin::Aside Menu-->
                    <div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true"
                         data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto"
                         data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer"
                         data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="0">
                        <!--begin::Menu-->
                        <div
                            class="menu menu-column menu-title-white menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
                            id="#kt_aside_menu" data-kt-menu="true" data-kt-menu-expand="false">

                            <div class="menu-item ">
                                <a class="menu-link {{ Route::currentRouteName() == 'services.list' ? 'active' : '' }} "
                                   href="{{ route("services.list") }}">
                                    <span class="menu-icon">
                                    <span class="svg-icon svg-color svg-icon-2">
                                        <!-- https://feathericons.dev/?search=grid&iconset=feather -->
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                             height="24" class="main-grid-item-icon"
                                             fill="none" stroke="currentColor" stroke-linecap="round"
                                             stroke-linejoin="round" stroke-width="2">
                                          <rect height="7" width="7" x="3" y="3"/>
                                          <rect height="7" width="7" x="14" y="3"/>
                                          <rect height="7" width="7" x="14" y="14"/>
                                          <rect height="7" width="7" x="3" y="14"/>
                                        </svg>

                                    </span>
                                </span>
                                    <span class="menu-title">Dashboard</span>
                                </a>
                            </div>

                            <div class="menu-item ">
                                @php
                                    $activeBranchRoutes = [
                                        'system_configs',

                                    ];
                                @endphp
                                <a class="menu-link {{ in_array(Route::currentRouteName(), $activeBranchRoutes) ? 'active' : '' }} "
                                   href="{{ route("system_configs") }}">
                                    <span class="menu-icon">
                                    <span class="svg-icon svg-color svg-icon-2">
                                       <!-- https://feathericons.dev/?search=server&iconset=feather -->
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" class="main-grid-item-icon"
                                         fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                      <rect height="8" rx="2" ry="2" width="20" x="2" y="2" />
                                      <rect height="8" rx="2" ry="2" width="20" x="2" y="14" />
                                      <line x1="6" x2="6.01" y1="6" y2="6" />
                                      <line x1="6" x2="6.01" y1="18" y2="18" />
                                    </svg>
                                    </span>
                                </span>
                                    <span class="menu-title">System Configuration</span>
                                </a>
                            </div>


                            <div data-kt-menu-trigger="click"
                                 class="menu-item menu-accordion {{ Route::currentRouteName() == 'amf_configs' || Route::currentRouteName() == 'view_all_orders' ? 'hover show' : '' }} ">
									<span
                                        class="menu-link {{ Route::currentRouteName() == 'amf_configs' || Route::currentRouteName() == 'view_all_orders' ? 'active' : '' }}">
										<span class="menu-icon">
                                    <span class="svg-icon svg-color svg-icon-2">
                                       <!-- https://feathericons.dev/?search=server&iconset=feather -->
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" class="main-grid-item-icon"
                                         fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                      <rect height="8" rx="2" ry="2" width="20" x="2" y="2" />
                                      <rect height="8" rx="2" ry="2" width="20" x="2" y="14" />
                                      <line x1="6" x2="6.01" y1="6" y2="6" />
                                      <line x1="6" x2="6.01" y1="18" y2="18" />
                                    </svg>
                                    </span>
                                </span>
                                    <span class="menu-title">Services</span>
										<span class="menu-arrow"></span>
									</span>
                                <div class="menu-sub menu-sub-accordion  menu-active-bg"
                                    {{ Route::currentRouteName() == 'amf_configs' || Route::currentRouteName() == 'view_all_orders' ? '' : 'display: none; overflow: hidden;' }}>
                                    <div class="menu-item">
                                        <a class="menu-link" href="{{ route("amf_configs") }}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
                                            <span class="menu-title">AMF</span>
                                        </a>
                                    </div>


                                        <div class="menu-item">
                                            <a class="menu-link" href="{{ route("smf_configs") }}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
                                                <span class="menu-title">SMF</span>
                                            </a>
                                        </div>

                                    <div class="menu-item">
                                        <a class="menu-link" href="{{ route("udm_configs") }}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
                                            <span class="menu-title">UDM</span>
                                        </a>
                                    </div>

                                    <div class="menu-item">
                                        <a class="menu-link" href="{{ route("udr_configs") }}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
                                            <span class="menu-title">UDR</span>
                                        </a>
                                    </div>

                                    <div class="menu-item">
                                        <a class="menu-link" href="{{ route("ausf_configs") }}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
                                            <span class="menu-title">AUSF</span>
                                        </a>
                                    </div>

                                    <div class="menu-item">
                                        <a class="menu-link" href="{{ route("pcf_configs") }}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
                                            <span class="menu-title">PCF</span>
                                        </a>
                                    </div>

                                    <div class="menu-item">
                                        <a class="menu-link" href="{{ route("chf_configs") }}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
                                            <span class="menu-title">CHF</span>
                                        </a>
                                    </div>
                                    <div class="menu-item">
                                        <a class="menu-link" href="{{ route("ehr_configs") }}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
                                            <span class="menu-title">EHR</span>
                                        </a>
                                    </div>

                                    <div class="menu-item">
                                        <a class="menu-link" href="{{ route("nrf_configs") }}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
                                            <span class="menu-title">NRF</span>
                                        </a>
                                    </div>

                                    <div class="menu-item">
                                        <a class="menu-link" href="{{ route("upf_configs") }}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
                                            <span class="menu-title">UPF</span>
                                        </a>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                    <!--end::Menu-->
                </div>
                <!--end::Aside Menu-->
            @show
            <!--begin::Footer-->
            <div class="aside-footer flex-column-auto pt-5 pb-7 px-5" id="kt_aside_footer">
                <a class="btn btn-custom btn-white w-100" href="">

                    <!--begin::Svg Icon | path: icons/duotune/general/gen005.svg-->
                    <span class="svg-icon svg-icon-2 text-danger">
                    <!-- https://feathericons.dev/?search=power&iconset=feather -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                         class="main-grid-item-icon" fill="none" stroke="currentColor" stroke-linecap="round"
                         stroke-linejoin="round" stroke-width="2">
                        <path d="M18.36 6.64a9 9 0 1 1-12.73 0"/>
                        <line x1="12" x2="12" y1="2" y2="12"/>
                    </svg>
                    </span>
                    <span class="btn-label fw-bold text-black fs-5">Logout</span>

                    <!--end::Svg Icon-->
                </a>
            </div>
            <!--end::Footer-->
        </div>
        <!--end::Aside menu-->

        <!--end::Aside-->
        <!--begin::Wrapper-->
        <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
            <!--begin::Header-->
            <div id="kt_header" style="" class="header align-items-stretch">
                <!--begin::Container-->
                <div class="container-fluid d-flex align-items-stretch justify-content-between">
                    <!--begin::Aside mobile toggle-->
                    <div class="d-flex align-items-center d-lg-none ms-n2 me-2" title="Show aside menu">
                        <div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px"
                             id="kt_aside_mobile_toggle">
                            <!--begin::Svg Icon | path: icons/duotune/abstract/abs015.svg') }}-->
                            <span class="svg-icon svg-icon-1">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none">
											<path
                                                d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z"
                                                fill="currentColor"/>
											<path opacity="0.3"
                                                  d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z"
                                                  fill="currentColor"/>
										</svg>
									</span>
                            <!--end::Svg Icon-->
                        </div>
                    </div>
                    <!--end::Aside mobile toggle-->
                    <!--begin::Mobile logo-->
                    <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
                        <a href="#" class="d-lg-none">
                            <img alt="Logo" src="{{ asset('static/media/logos/logo-2.svg') }}" class="h-30px"/>
                        </a>
                    </div>
                    <!--end::Mobile logo-->
                    <!--begin::Wrapper-->
                    <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
                        <!--begin::Navbar-->
                        <div class="d-flex align-items-stretch" id="kt_header_nav">
                            <div class="d-flex align-items-center ms-1 ms-lg-3">
                                <a href="#" class="fs-2 fw-bold">
                                  {{ $page ?? "Hyper Five" }}
                                </a>
                            </div>
                        </div>
                        <!--end::Navbar-->
                        <!--begin::Toolbar wrapper-->
                        <!--begin::new tools search-->

                        <div class="d-flex align-items-stretch flex-shrink-0">


                            <div class="d-flex align-items-center ms-1 ms-lg-3" id="">

                            </div>

                            <!--end::new tools search-->

                            <!--begin::User menu-->

                            <div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
                                <!--begin::Menu wrapper-->
                                <div class="cursor-pointer symbol symbol-30px symbol-md-40px"
                                     data-kt-menu-trigger="click"
                                     data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                    <img src="{{asset('static/media/svg/avatars/blank.svg')}}" alt="user"/>
                                </div>
                                <!--begin::User account menu-->

                                <div
                                    class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-275px"
                                    data-kt-menu="true">
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <div class="menu-content d-flex align-items-center px-3">
                                            <!--begin::Avatar-->
                                            <div class="symbol symbol-50px me-5">
                                                <img alt="Logo"
                                                     src="{{asset('static/media/svg/avatars/blank.svg')}}"/>
                                            </div>
                                            <!--end::Avatar-->
                                            <!--begin::Username-->
                                            <div class="d-flex flex-column">
                                                <div
                                                    class="fw-bolder d-flex align-items-center fs-5">John Doe
                                                </div>
                                                <a href="#"
                                                   class="fw-bold text-muted text-hover-primary fs-7">johndoe@mail.com</a>
                                            </div>
                                            <!--end::Username-->
                                        </div>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu separator-->
                                    <div class="separator my-2"></div>
                                    <!--end::Menu separator-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-5">
                                        <a href="{{route("services.list")}}" class="menu-link px-5">Account Settings</a>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu separator-->
                                    <div class="separator my-2"></div>
                                    <!--end::Menu separator-->

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-5">
                                        <a href="{{ route("services.list") }}" class="menu-link px-5">Logout</a>
                                    </div>
                                    <!--end::Menu item-->

                                </div>
                                <!--end::User account menu-->
                                <!--end::Menu wrapper-->
                            </div>
                            <!--end::User menu-->

                        </div>
                        <!--end::Toolbar wrapper-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Container-->
            </div>
            <!--end::Header-->
            <!--begin::Content-->
            <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

                @yield('main_content')

            </div>
            <!--end::Content-->
        </div>
        {{--        <!--end::Wrapper-->--}}
    </div>
    {{--    <!--end::Page-->--}}
    {{--<!--end::Root-->--}}
    {{----}}
    @include('partials.scripts')


    <script>

    </script>
@yield('extra_scripts')
</body>
<!--end::Body-->
</html>
