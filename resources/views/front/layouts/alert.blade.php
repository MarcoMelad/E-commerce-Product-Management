<script>
    toastr.options = {
        "positionClass": 'toast-top-left',
    };

    // Success Message
    @if (session('success'))
    toastr.success("{{ session('success') }}", "Success");
    @endif

    // Info Message
    @if (session('info'))
    toastr.info("{{ session('info') }}", "Information");
    @endif

    // Warning Message
    @if (session('warning'))
    toastr.warning("{{ session('warning') }}", "Warning");
    @endif

    // Error Messages
    @if ($errors->any())
    @foreach ($errors->all() as $error)
    toastr.error("{{ $error }}", "Error");
    @endforeach
    @endif

    // Common error handler
    function commonError() {
        toastr.error("Something went wrong. Please try again.", "Error");
    }
</script>
