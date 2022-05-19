<div class="modal fade" id="back_stock">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Back Product to Stock</h4>
            </div>
            {!! Form::open(['route' => 'product.stock.store', 'method' => 'post']) !!}
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="row" id="kitchen_products">
                    <div class="col-md-7">
                        <div class="form-group">
                            <label for="">Product</label>
                            {!! Form::select('product', makeDropDown($products) , null, ["class" => "form-control", "id" => "w_product_id"])!!}
                            <small class="text-danger">{{ $errors->first('product') }}</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Quantity</label>
                            <input type="number" name="quantity" value="0" id="w_product_quantity" class="form-control">
                            <small class="text-danger">{{ $errors->first('quantity') }}</small>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Unit</label>
                            <input type="text" name="unit"  id="w_product_unit" class="form-control" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" onclick="submit_form(this, event)">Back to Stock</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@push('footer-scripts')
<script>
        (function ($) {
            "use strict";

            /*at document loading time*/
            jQuery(document).ready(function ($) {
                
                $(document).on('change', '#w_product_id', function() {
                    var product_id = $(this).val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ url('products/get-kitchen-quantity') }}",
                        method: 'POST',
                        data: {product_id:product_id, _token:_token},
                        dataType:"json",
                        success: function(data) {
                            $('#w_product_quantity').val(data.quantity);
                            $('#w_product_unit').val(data.unit);
                        }

                    });
                })
                
            });

        }(jQuery));

    </script>
@endpush

