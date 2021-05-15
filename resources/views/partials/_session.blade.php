@if (session('success'))

    <script>
        new Noty({
            type: 'success',
            layout: 'topRight',
            text: "{{ session('success') }}",
            timeout: 2000,
            killer: true
        }).show();
    </script>

@endif
@if (session('failed'))

    <script>
        new Noty({
            type: 'error',
            layout: 'topRight',
            text: "{{ session('failed') }}",
            timeout: 4000,
            killer: true
        }).show();
    </script>

@endif
