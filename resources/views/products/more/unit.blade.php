<div class="modal fade" id="add_unit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Add Units</h4>
            </div>
            {!! Form::open(['route' => 'add-more.unit', 'id' => 'moreUnit']) !!}
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="unit_name" id="unit_name" placeholder="Enter an unit Name" class="form-control">
                    <span class="text-danger">{{ $errors->first('unit_name') }}</span>
                </div>
                <div class="form-group">
                    <label for="shortname">Short name</label>
                    <input type="text" name="shortname" id="unit_shortname" placeholder="Enter short name/short form" class="form-control">
                    <span class="text-danger">{{ $errors->first('shortname') }}</span>
                </div>
            </div>
            <div class="modal-footer">
                    <button type="submit" class="btn btn-success" onclick="submit_form(this, event)">Add Category</button>
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
              $('#moreUnit').on('submit', function(e) {
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
                                  $('#unit_list').append( '<option value="'+ret.data.id+'">'+ret.data.name+'</option>' );
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
  
  