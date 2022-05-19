<div class="modal fade" id="send_kitchen">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Send Product to Kitchen</h4>
            </div>
            {!! Form::open(['route' => 'product.kitchen.store', 'method' => 'post']) !!}
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="row" id="kitchen_products">
                    <div class="col-md-7">
                        <div class="form-group">
                            <label for="">Product</label>
                            {!! Form::select('product', makeDropDown($products) , null, ["class" => "form-control", "id" => "product_id"])!!}
                            <small class="text-danger">{{ $errors->first('product') }}</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Quantity</label>
                            <input type="number" name="quantity" value="0" id="product_quantity" class="form-control">
                            <small class="text-danger">{{ $errors->first('quantity') }}</small>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Unit</label>
                            <input type="text" name="unit"  id="product_unit" class="form-control" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" onclick="submit_form(this, event)">Send to Kitchen</button>
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
                // $(document).on('click', '#add_more', function() {

                // });
                
                $(document).on('change', '#product_id', function() {
                    var product_id = $(this).val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ url('products/get-quanitity') }}",
                        method: 'POST',
                        data: {product_id:product_id, _token:_token},
                        dataType:"json",
                        success: function(data) {
                            $('#product_quantity').val(data.quantity);
                            $('#product_unit').val(data.unit);
                        }

                    });
                })
                
            });

        }(jQuery));

    </script>
@endpush

