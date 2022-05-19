<div class="modal fade" id="edit_modal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Edit Bank Loan </h4>
            </div>
            {!! Form::open(['route' => 'bankloan.update']) !!}
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bank_name">Bank Name</label>
                            {!! Form::select('bank_name', makeDropDown($banklists),null,["class" => "form-control", "id" => "name", "style" => "width:100%"])!!}
                            <span class="text-danger">{{ $errors->first('bank_name') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="loan_term">Loan Term</label>
                            {!! Form::select('loan_term', getLoanTerm(),null,["class" => "form-control", "id" => "_loanterm", "style" => "width:100%"])!!}
                            <small class="text-danger">{{ $errors->first('loan_term') }}</small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="category">Category Type</label>
                            {!! Form::select('category', getLoanType(),null,["class" => "form-control", "id" => "category", "style" => "width:100%"])!!}
                            <small class="text-danger">{{ $errors->first('category') }}</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="loan_duration">Loan Duration Year/Month</label>
                            {!! Form::select('loan_duration', getLoanDuration(),null,["class" => "form-control", "id" => "duration", "style" => "width:100%"])!!}
                            <small class="text-danger">{{ $errors->first('loan_duration') }}</small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" name="amount" id="amount" placeholder="Enter Amount" class="form-control">
                            <span class="text-danger">{{ $errors->first('amount') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="interest">Interest</label>
                            <input type="number" name="interest" id="interest" placeholder="Enter Interest" class="form-control">
                            <span class="text-danger">{{ $errors->first('interest') }}</span>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="submited_date">Date</label>

                            <div class="input-group date">
                                <input type="text" name="submited_date" id="_date" placeholder="Enter Date" class="form-control pull-right date-picker" id="datepicker">
                                <span class="text-danger">{{ $errors->first('submited_date') }}</span>
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>

                            </div>
                            <!-- /.input group -->
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status</label>
                            {!! Form::select('status', getStatus() , null, ["class" => "form-control", "id" => "status"])!!}
                            <small class="text-danger">{{ $errors->first('status') }}</small>
                            <input type="hidden" name="bankloan_id" id="bankloan_hidden_id" value="">
                        </div>


                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">

                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" id="description" class="form-control" rows="3" placeholder="Enter Desciption ..."></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">


                    </div>
                </div>
            </div>
            <div class="modal-footer">
                     
                    <button type="submit" class="btn btn-success" onclick="submit_form(this, event)">Update</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
  </div>