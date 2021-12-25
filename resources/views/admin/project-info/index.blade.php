@extends('layouts.admin-master')
@section('title') Project Information @endsection
@section('content')

<div class="row bread_part">
    <div class="col-sm-12 bread_col">
        <h4 class="pull-left page-title bread_title">Project Information</h4>
        <ol class="breadcrumb pull-right">
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="active">Project Information</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        @if(Session::has('success'))
          <div class="alert alert-success alertsuccess" role="alert">
             <strong>Successfully!</strong> Added New project information.
          </div>
        @endif
        @if(Session::has('success_soft'))
          <div class="alert alert-success alertsuccess" role="alert">
             <strong>Successfully!</strong> delete project information.
          </div>
        @endif

        @if(Session::has('success_incharge'))
          <div class="alert alert-success alertsuccess" role="alert">
             <strong>Successfully!</strong> Added Project Incharge.
          </div>
        @endif

        @if(Session::has('success_update'))
          <div class="alert alert-success alertsuccess" role="alert">
             <strong>Successfully!</strong> update project information.
          </div>
        @endif

        @if(Session::has('data_not_found'))
          <div class="alert alert-warning alerterror" role="alert">
             <strong>Opps!</strong> invalid Employee Id.
          </div>
        @endif
        @if(Session::has('error'))
          <div class="alert alert-warning alerterror" role="alert">
             <strong>Opps!</strong> please try again.
          </div>
        @endif
    </div>
    <div class="col-md-2"></div>
</div>


<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <form class="form-horizontal project-details-form" id="projectform" method="post" action="{{ route('insert-project-info') }}" enctype="multipart/form-data">
          @csrf
          <div class="card">
              <div class="card-header">
                  <div class="row">
                      <div class="col-md-8">
                          <h3 class="card-title card_top_title"><i class="fab fa-gg-circle"></i> New Project Information</h3>
                      </div>
                      <div class="clearfix"></div>
                  </div>
              </div>
              <div class="card-body card_form">

                <div class="form-group row custom_form_group{{ $errors->has('proj_name') ? ' has-error' : '' }}">
                    <label class="col-sm-3 control-label">Project Name:<span class="req_star">*</span></label>
                    <div class="col-sm-7">
                      <input type="text" placeholder="project name" class="form-control" id="proj_name" name="proj_name" value="{{old('proj_name')}}">
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
                      <input type="date" placeholder="starting date" class="form-control" id="starting_date" name="starting_date" value="{{old('starting_date')}}">
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
                      <textarea id="address" name="address" class="form-control">{{ old('address') }}</textarea>
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
                      <input type="text" placeholder="project code" class="form-control" id="proj_code" name="proj_code" value="{{old('proj_code')}}">
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
                      <input type="text" placeholder="Budget amount" class="form-control" id="proj_budget" name="proj_budget" value="{{old('proj_budget')}}">
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
                      <input type="date" class="form-control" id="proj_deadling" name="proj_deadling" value="{{old('proj_deadling')}}">
                      @if ($errors->has('proj_deadling'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('proj_deadling') }}</strong>
                          </span>
                      @endif
                    </div>
                </div>
                <div class="form-group row custom_form_group">
                    <label class="col-sm-3 control-label">Description:<span class="req_star">*</span></label>
                    <div class="col-sm-7">
                      <textarea name="proj_description" class="form-control" placeholder="Project Description"></textarea>
                    </div>
                </div>

                <div class="form-group row custom_form_group{{ $errors->has('proj_main_thumb') ? ' has-error' : '' }}">
                    <label class="col-sm-3 control-label">Project Main Thumbnail:<span class="req_star">*</span></label>
                    <div class="col-sm-4">
                      <div class="input-group">
                          <span class="input-group-btn">
                              <span class="btn btn-default btn-file btnu_browse">
                                  Browse… <input type="file" name="proj_main_thumb" id="imgInp8">
                              </span>
                          </span>
                          <input type="text" class="form-control" readonly>
                      </div>
                      @if ($errors->has('proj_main_thumb'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('proj_main_thumb') }}</strong>
                          </span>
                      @endif
                    </div>
                    <div class="col-sm-3">
                        <img id='img-upload8' class="upload_image"/>
                    </div>
                </div>



              </div>
              <div class="card-footer card_footer_button text-center">
                  <button type="submit" onclick="inchargeValidation()" class="btn btn-primary waves-effect">SAVE</button>
              </div>
          </div>
        </form>
    </div>
    <div class="col-md-1"></div>
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="card-title card_top_title"><i class="fab fa-gg-circle mr-2"></i>Project List</h3>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="alltableinfo" class="table table-bordered custom_table mb-0">
                                <thead>
                                    <tr>
                                        <th>Starting Date</th>
                                        <th>Deadline</th>
                                        <th>Project Name</th>
                                        <th>Project Incharge</th>
                                        <th>Project Value</th>

                                        <th>Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @forelse($all as $item)
                                    <tr>
                                        <td>{{ Carbon\Carbon::parse($item->starting_date)->format('d-m-Y') }}</td>
                                        <td>{{ Carbon\Carbon::parse($item->proj_deadling)->format('d-m-Y') }}</td>
                                        <td>{{ $item->proj_name }}</td>
                                        <td>{{ $item->proj_Incharge_id == NULL ? 'Not Assigned' : $item->employee->employee_name }}</td>
                                        <td>{{ $item->proj_budget }}</td>

                                        <td>
                                            <a href="{{ route('project-info-view',[$item->proj_id]) }}" title="view"><i class="fas fa-eye fa-lg view_icon"></i></a>

                                            <a href="{{ route('project-info-edit',[$item->proj_id]) }}" title="edit"><i class="fa fa-pencil-square fa-lg edit_icon"></i></a>

                                            <!-- <a href="{{ route('project-info-delete',[$item->proj_id]) }}" title="delete" id="delete"><i class="fa fa-trash fa-lg delete_icon"></i></a> -->
                                        </td>
                                    </tr>
                                  @empty
                                      <p class="data_not_found">Data Not Found</p>
                                  @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- script area -->
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
