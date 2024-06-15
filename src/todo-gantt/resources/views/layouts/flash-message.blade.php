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

    @if(Session::has('flashError'))
    // エラーメッセージ用のオプションに一時変更
    const originalOptions = toastr.options; // 現在のオプションを保存
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
        "timeOut": "0",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    toastr.error("{{ session('flashError')}}");
    toastr.options = originalOptions; // 元のオプションに戻す
    @endif

    @if(Session::has('flashInfo'))
    toastr.info("{{ session('flashInfo') }}");
    @endif

    @if(Session::has('flashWarning'))
    toastr.warning("{{ session('flashWarning') }}");
    @endif
</script>
