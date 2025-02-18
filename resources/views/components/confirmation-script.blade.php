@push('scripts')
<script>
    $(function () {
        $('.delete-confirmation').click(function (e) {
            e.preventDefault();
            var form = $(this).closest('form');
            swal({
                title: "{{ $title ?? 'Are you sure?' }}",
                text: "{{ $text ?? 'Once deleted, you will not be able to recover this item!' }}",
                type: "warning",
                buttons: ["Cancel", "Yes"],
                confirmButtonColor: "#DC3545",
                icon: "warning",
            }).then(function (result) {
                if (result) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
