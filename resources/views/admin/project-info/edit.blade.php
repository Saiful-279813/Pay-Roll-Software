@extends('layouts.admin-master')
@section('title') Project Information @endsection
@section('content')

<div class="row bread_part">
    <div class="col-sm-12 bread_col">
        <h4 class="pull-left page-title bread_title">Update Project Information</h4>
        <ol class="breadcrumb pull-right">
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('project-info') }}">Project Information</a></li>
            <li class="active"> Update Project Information</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <form class="form-horizontal" id="projectform" method="post" action="{{ route('update-project-info') }}">
          @csrf
          <div class="card">
              <div class="card-header">
                  <div class="row">
                      <div class="col-md-8">
                          <h3 class="card-title card_top_title"><i class="fab fa-gg-circle"></i> Update Project Information</h3>
                      </div>
                      <div class="col-md-4 text-right">
                          <a href="{{ route('project-info') }}" class="btn btn-md btn-primary waves-effect card_top_button"><i class="fa fa-th"></i> Project Information</a>
                      </div>
                      <div class="clearfix"></div>
                  </div>
              </div>
              <div class="card-body card_form">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-7">
                        @if(Session::has('error'))
                          <div class="alert alert-warning alerterror" role="alert" style="margin-left: -20px">
                             <strong>Opps!</strong> please try again.
                          </div>
                        @endif
                    </div>
                    <div class="col-md-2"></div>
                </div>

                <input type="hidden" name="id" value="{{ $edit->proj_id }}">
                <div class="form-group row custom_form_group{{ $errors->has('proj_name') ? ' has-error' : '' }}">
                    <label class="col-sm-3 control-label">Project Name:<span class="req_star">*</span></label>
                    <div class="col-sm-7">
                      <input type="text" placeholder="project name" class="form-control" id="proj_name" name="proj_name" value="{{ $edit->proj_name }}" required>
                      @if ($errors->has('proj_name'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('proj_name') }}</strong>
                          </span>
                      @endif
                    </div>
                </div>
                <div class="form-group row custom_form_group{{ $errors->has('starting_date') ? ' has-error' : '' }}">
                    <label class="col-sm-3 control-label">Starting Date:<span class="req_star">*</span></label>
                    <div class="col-sm-7">
                      <input type="date" placeholder="starting date" class="form-control" id="starting_date" name="starting_date" value="{{ $edit->starting_date }}" required>
                      @if ($errors->has('starting_date'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('starting_date') }}</strong>
                          </span>
                      @endif
                    </div>
                </div>
                <div class="form-group row custom_form_group{{ $errors->has('address') ? ' has-error' : '' }}" >
                    <label class="col-sm-3 control-label">Project Location:<span class="req_star">*</span></label>
                    <div class="col-sm-7">
                      <textarea id="address" name="address" class="form-control" required>{{ $edit->address }}</textarea>
                      @if ($errors->has('address'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('address') }}</strong>
                          </span>
                      @endif
                    </div>
                </div>
                <div class="form-group row custom_form_group{{ $errors->has('proj_code') ? ' has-error' : '' }}">
                    <label class="col-sm-3 control-label">Project Code:</label>
                    <div class="col-sm-7">
                      <input type="text" placeholder="project code" class="form-control" id="proj_code" name="proj_code" value="{{ $edit->proj_code }}" required>
                      @if ($errors->has('proj_code'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('proj_code') }}</strong>
                          </span>
                      @endif
                    </div>
                </div>
                <div class="form-group row custom_form_group{{ $errors->has('proj_budget') ? ' has-error' : '' }}">
                    <label class="col-sm-3 control-label">Project Value:<span class="req_star">*</span></label>
                    <div class="col-sm-7">
                      <input type="text" placeholder="Budget amount" class="form-control" id="proj_budget" name="proj_budget" value="{{ $edit->proj_budget }}" required>
                      @if ($errors->has('proj_budget'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('proj_budget') }}</strong>
                          </span>
                      @endif
                    </div>
                </div>
                <div class="form-group row custom_form_group{{ $errors->has('proj_deadling') ? ' has-error' : '' }}">
                    <label class="col-sm-3 control-label">Project Deadline:<span class="req_star">*</span></label>
                    <div class="col-sm-7">
                      <input type="date" class="form-control" id="proj_deadling" name="proj_deadling" value="{{ $edit->proj_deadling }}" required>
                      @if ($errors->has('proj_deadling'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('proj_deadling') }}</strong>
                          </span>
                      @endif
                    </div>
                </div>
              </div>
              <div class="card-footer card_footer_button text-center">
                  <button type="submit" id="onSubmit" onclick="formValidation();" class="btn btn-primary waves-effect">UPDATE</button>
              </div>
          </div>
        </form>
    </div>
</div>
<script type="text/javascript">
/* form validation */
$(document).ready(function(){
  $("#projectform").validate({
    /* form tag off  */
    // submitHandler: function(form) { return false; },
    /* form tag off  */
    rules: {
      proj_name: {
        required : true,

      },
      starting_date: {
        required : true,
      },
      proj_deadling: {
        required : true,
      },
      address: {
        required : true,
      },
      proj_code: {
        required : true,
      },
      proj_description: {
        required : true,
      },
      proj_budget: {
        required : true,
        number: true,
        maxlength: 11,
      },
    },

    messages: {
      proj_name: {
        required : "You Must Be Input This Field!",
      },
      starting_date: {
        required : "You Must Be Select This Field!",
      },
      proj_deadling: {
        required : "You Must Be Select This Field!",
      },
      address: {
        required : "You Must Be Input This Field!",
      },
      proj_code: {
        required : "You Must Be Input This Field!",
      },
      proj_description: {
        required : "You Must Be Input This Field!",
      },
      proj_budget: {
        required : "Please Input This Field!",
        number : "You Must Be Input Number!",
        max : "You Must Be Input Maximum Length 11!",
      },
    },
  });
});
</script>
@endsection
