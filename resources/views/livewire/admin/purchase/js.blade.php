@push('js')
    <script>
        $('#add-form').submit(function() {
            @this.set('state.provider_id', $('#provider_id').val());
            @this.set('state.product_id', $('#product_id').val());
            @this.set('state.stock_id', $('#stock_id').val());
        })
    </script>
    @endpush
