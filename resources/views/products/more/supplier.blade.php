<div class="modal fade" id="add_supplier" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Add Supplier</h4>
            </div>
            {!! Form::open(['route' => 'add-more.supplier', 'id' => 'moreSupplier']) !!}
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="supplier_name" id="" placeholder="Enter Supplier name" class="form-control">
                    <span class="text-danger">{{ $errors->first('supplier_name') }}</span>
                </div>
                <div class="form-group">
                    <label for="name">Phone</label>
                    <input type="tel" maxlength="11" name="phone" id="" placeholder="Enter Supplier phone" class="form-control">
                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                </div>
                <div class="form-group">
                    <label for="name">Email</label>
                    <input type="email" name="email" id="" placeholder="Enter Supplier email" class="form-control">
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                </div>
                <div class="form-group">
                    <label for="name">Address</label>
                    <input type="text" name="address" id="" placeholder="Enter Supplier address" class="form-control">
                    <span class="text-danger">{{ $errors->first('address') }}</span>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    {!! Form::select('status', getStatus() , null, ["class" => "form-control"])!!}
                    <small class="text-danger">{{ $errors->first('status') }}</small>
                </div>
            </div>
            <div class="modal-footer">
                    <button type="submit" class="btn btn-success" onclick="submit_form(this, event)">Add Supplier</button>
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

            //add_more_category
            $('#moreSupplier').on('submit', function(e) {
                e.preventDefault();

                const action = $(this).attr("action");
                const method = $(this).attr("method");
                const formData = $(this).serialize();

                $.ajax({
                    type: method,
                    url: action,
                    data: formData,
                    success: function(ret) {
                        let type = ret.type;
                        let title = ret.title;
                        if(type='success') {
                          $('.modal').modal('hide');
                        }swal({
                            type: type,
                            title: title,
                            text: ret.message,
                            timer: 5000
                        }).then(function (res){
                            if (ret.data && res) {
                                $('#supplier_list').append( '<option value="'+ret.data.id+'">'+ret.data.name+'</option>' );
                            }
                        })                        
                    },
                    error: function(res) {
                        var errors = res.responseJSON;
                        if (errors) {
                            $.each(errors, function (index, error) {
                                $("[name=" + index + "]").parents('.form-group').find('.text-danger').text(error);
                                $("[name=" + index + "]").parent().addClass('has-error');
                                $(this).find("." + index).text(error);
                            });
                        }
                    }
                });
            });

        });

    }(jQuery));

</script>
@endpush
