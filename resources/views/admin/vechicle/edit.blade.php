@extends('layouts.admin-master')
@section('title') Vechicle @endsection
@section('content')
<div class="row bread_part">
    <div class="col-sm-12 bread_col">
        <h4 class="pull-left page-title bread_title">Vechicle Information</h4>
        <ol class="breadcrumb pull-right">
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="active"> Vechicle Information</li>
        </ol>
    </div>
</div>
<!-- add division -->
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        @if(Session::has('error'))
          <div class="alert alert-warning alerterror" role="alert">
             <strong>Opps!</strong> please try again.
          </div>
        @endif
        @if(Session::has('data_not_match'))
          <div class="alert alert-warning alerterror" role="alert">
             <strong>Opps!</strong> Driver Id Does,n Match!.
          </div>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
      <form class="form-horizontal" id="vechicleForm-validation" action="{{ route('update-vechicle') }}" method="post">
        @csrf
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="card-title card_top_title"><i class="fab fa-gg-circle"></i> Update Vechicle Information</h3>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="card-body card_form" style="padding-top: 0;">
              <input type="hidden" name="id" value="{{ $edit->veh_id }}">
              <div class="form-group custom_form_group">
                  <label class="control-label d-block" style="text-align: left;">Name:<span class="req_star">*</span></label>
                  <div>
                      <input type="text" class="form-control" name="veh_name" value="{{ $edit->veh_name }}" placeholder="Input Vechicle Name">
                  </div>
              </div>

              <div class="form-group custom_form_group">
                  <label class="control-label d-block" style="text-align: left;"> Price:<span class="req_star">*</span></label>
                  <div>
                      <input type="text" class="form-control" name="veh_price" value="{{ $edit->veh_price }}" placeholder="Input Vechicle Price">
                  </div>
              </div>

              <div class="form-group custom_form_group">
                  <label class="control-label d-block" style="text-align: left;"> Present Metar:<span class="req_star">*</span></label>
                  <div>
                      <input type="text" class="form-control" name="veh_present_metar" value="{{ $edit->veh_present_metar }}" placeholder="Input Vechicle Present Metar">
                  </div>
              </div>

              <div class="form-group custom_form_group">
                  <label class="control-label d-block" style="text-align: left;">Color:<span class="req_star">*</span></label>
                  <div>
                      <input type="text" class="form-control" name="veh_color" value="{{ $edit->veh_color }}" placeholder="Input Vechicle Color">
                  </div>
              </div>

              <div class="form-group custom_form_group">
                  <label class="control-label d-block" style="text-align: left;">Purchase Date:<span class="req_star">*</span></label>
                  <div>
                      <input type="date" class="form-control" name="veh_purchase_date" value="{{ $edit->veh_purchase_date }}" placeholder="Input Purchase Date">
                  </div>
              </div>

              <div class="form-group custom_form_group">
                  <label class="control-label d-block" style="text-align: left;">Driver Assigned:</label>
                  <div>
                    <input type="text" class="form-control typeahead" placeholder="Type Employee ID" name="emp_id" id="dir_emp_id_search" onkeyup="dirEmpSearch()" onfocus="showResult()" onblur="hideResult()" value="{{ $edit->driver_id == NULL ? '' : $edit->employee->employee_id }} ">
                  </div>
                  <!-- <div id="showEmpId"></div> -->
                  <div id="showEmpId2"></div>
              </div>

            </div>
            <div class="card-footer card_footer_button text-center">
                <button type="submit" class="btn btn-primary waves-effect">UPDATE</button>
            </div>
        </div>
      </form>
    </div>
    <div class="col-md-3"></div>
</div>
<!-- script area -->
<script type="text/javascript">
/* form validation */
$(document).ready(function(){
  $("#vechicleForm-validation").validate({
    /* form tag off  */
    // submitHandler: function(form) { return false; },
    /* form tag off  */
    rules: {
      veh_name: {
        required : true,
      },
      veh_purchase_date: {
        required : true,
      },
      veh_present_metar: {
        required : true,
        number: true,
        maxlength: 9,
      },
      veh_color: {
        required : true,
      },
      veh_price: {
        required : true,
        number: true,
        maxlength: 15,
      },
    },

    messages: {
      veh_name: {
        required : "You Must Be Input This Field!",
      },
      veh_color: {
        required : "You Must Be Input This Field!",
      },
      veh_purchase_date: {
        required : "You Must Be Select This Field!",
      },
      veh_price: {
        required : "Please Input This Field!",
        number : "You Must Be Input Number!",
        max : "You Must Be Input Maximum Length 15!",
      },
      veh_present_metar: {
        required : "Please Input This Field!",
        number : "You Must Be Input Number!",
        max : "You Must Be Input Maximum Length 9!",
      },
    },
  });
});
</script>


@endsection
