@push('js')
    <script>
        $('#add-form').submit(function() {
            @this.set('state.provider_id', $('#provider_id').val());
            @this.set('state.inventory_id', $('#inventory_id').val());
        })
    </script>
    @endpush
