<script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": false,
        "positionClass": "toast-bottom-center",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "3000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    @if(Session::has('flashSuccess'))
    toastr.success("{{ session('flashSuccess') }}");
    @endif

    @if($errors->any())
    @foreach($errors->all() as $error)
    toastr.error("{{ $error }}");
    @endforeach
    @endif

    @if(Session::has('flashInfo'))
    toastr.info("{{ session('flashInfo') }}");
    @endif

    @if(Session::has('flashWarning'))
    toastr.warning("{{ session('flashWarning') }}");
    @endif
</script>
