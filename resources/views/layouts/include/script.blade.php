<script src="{{ asset('dist/js/all.js') }}"></script>
<script src="{{ asset('dist/js/theme.js') }}"></script>
<script src="{{ asset('js/toaster.js') }}"></script>
<script src="{{ asset('js/sweetalert.min.js') }}"></script>
<script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{ asset('plugins/lazy/jquery.lazy.min.js') }}"></script>
<script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
@livewireScripts
<script src="{{asset('dist/js/livewire.js')}}"></script>

<script>
    // Show success message using Toastr
    @if(Session::has('success'))
        toastr.success("{{ session('success') }}");
    @endif

    // Show error message using Toastr
    @if(Session::has('error'))
        toastr.error("{{ session('error') }}");
    @endif

    // Display validation errors using Toastr
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}");
        @endforeach
    @endif
</script>

@stack('script')
