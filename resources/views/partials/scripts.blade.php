<!--begin::Javascript-->
<script>var hostUrl = "assets/";</script>
<!--begin::Global Javascript Bundle(used by all pages)-->
<script src="{{ asset('static/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('static/js/scripts.bundle.js') }}"></script>
<script src="{{ asset('static/plugins/custom/datatables/datatables.bundle.js') }}"></script>


{{--<script src="{{asset('static/js/custom/tool/custom.js')}}"></script>--}}

{{--<script>--}}
{{--    $.extend(true, $.fn.dataTable.defaults, {--}}
{{--        "ordering": false,--}}
{{--    });--}}
{{--</script>--}}
<script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toastr-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    @if(Session::has("success"))
    toastr.success("{{ Session::get("success") }}");
    @endif
    @if(Session::has("error"))
    console.log("error");
    toastr.error("{{ Session::get("error") }}");
    @endif
    @if(Session::has("info"))
    toastr.info("{{ Session::get("info") }}");
    @endif
    @if(Session::has("warning"))
    toastr.warning("{{ Session::get("warning") }}");
    @endif
</script>
<!--end::Page Custom Javascript-->
<!--end::Javascript-->
