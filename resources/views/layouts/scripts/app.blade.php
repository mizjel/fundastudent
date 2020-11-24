<!-- Scripts -->
<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>
<!-- flash_msg -->
<script>
    @if(session()->has('toastr'))
    var type = '{{ session('toastr')['type'] }}' ? '{{ session('toastr')['type'] }}' : 'info';
    var message = '{!! session('toastr')['message'] !!}';
    switch(type){
        case 'info':
            toastr.info(message);
            break;
        case 'warning':
            toastr.warning(message);
            break;
        case 'success':
            toastr.success(message);
            break;
        case 'error':
            toastr.error(message);
            break;
    }
    @endif
</script>
@stack('scripts')