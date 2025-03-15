<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head>
    <base href="">
    <title>@yield('title')</title>
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
    <link rel="shortcut icon" href="{{ asset('static/media/logos/favicon.ico') }}"/>

    @include('partials.styles')
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" class="bg-body">
<!--begin::Main-->
@yield("main_content")

<!--end::Main-->
<!--begin::Javascript-->

<!--begin::Global Javascript Bundle(used by all pages)-->
<script src="{{ asset('static/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('static/js/scripts.bundle.js') }}"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Page Custom Javascript(used by this page)-->
<script src="{{ asset('static/js/custom/authentication/sign-in/general.js') }}"></script>

<!--end::Page Custom Javascript-->
<!--end::Javascript-->
@yield('extra_js')
</body>
<!--end::Body-->

</html>
