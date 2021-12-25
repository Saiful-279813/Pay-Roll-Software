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
        @if(Session::has('success'))
          <div class="alert alert-success alertsuccess" role="alert">
             <strong>Successfully!</strong> Added New Vechicle Information.
          </div>
        @endif
        @if(Session::has('success_update'))
          <div class="alert alert-success alertsuccess" role="alert">
             <strong>Successfully!</strong> Update Vechicle Information.
          </div>
        @endif
        @if(Session::has('delete'))
          <div class="alert alert-success alertsuccess" role="alert">
             <strong>Successfully!</strong> Delete Vechicle Information.
          </div>
        @endif
        @if(Session::has('error'))
          <div class="alert alert-warning alerterror" role="alert">
             <strong>Opps!</strong> please try again.
          </div>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
      <form class="form-horizontal" id="vechicleForm-validation" action="{{ route('insert-new.vechicle') }}" method="post">
        @csrf
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="card-title card_top_title"><i class="fab fa-gg-circle"></i> Add New Vechicle Information</h3>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="card-body card_form" style="padding-top: 0;">

              <div class="form-group custom_form_group">
                  <label class="control-label d-block" style="text-align: left;">Name:<span class="req_star">*</span></label>
                  <div>
                      <input type="text" class="form-control" name="veh_name" value="{{ old('veh_name') }}" placeholder="Input Vechicle Name">
                  </div>
              </div>

              <div class="form-group custom_form_group">
                  <label class="control-label d-block" style="text-align: left;"> Price:<span class="req_star">*</span></label>
                  <div>
                      <input type="text" class="form-control" name="veh_price" value="{{ old('veh_price') }}" placeholder="Input Vechicle Price">
                  </div>
              </div>

              <div class="form-group custom_form_group">
                  <label class="control-label d-block" style="text-align: left;"> Present Metar:<span class="req_star">*</span></label>
                  <div>
                      <input type="text" class="form-control" name="veh_present_metar" value="{{ old('veh_present_metar') }}" placeholder="Input Vechicle Present Metar">
                  </div>
              </div>

              <div class="form-group custom_form_group">
                  <label class="control-label d-block" style="text-align: left;">Color:<span class="req_star">*</span></label>
                  <div>
                      <input type="text" class="form-control" name="veh_color" value="{{ old('veh_color') }}" placeholder="Input Vechicle Color">
                  </div>
              </div>

              <div class="form-group custom_form_group">
                  <label class="control-label d-block" style="text-align: left;">Purchase Date:<span class="req_star">*</span></label>
                  <div>
                      <input type="date" class="form-control" name="veh_purchase_date" value="{{ old('veh_purchase_date') }}" placeholder="Input Purchase Date">
                  </div>
              </div>

              <div class="form-group custom_form_group">
                  <label class="control-label d-block" style="text-align: left;">Vehicle Driver:</label>
                  <div>
                    <input type="text" class="form-control typeahead" placeholder="Type Employee ID" name="emp_id" id="dir_emp_id_search" onkeyup="dirEmpSearch()" onfocus="showResult()" onblur="hideResult()" value="{{ old('emp_id') }}">
                  </div>
                  <!-- <div id="showEmpId"></div> -->
                  <div id="showEmpId2"></div>
              </div>

            </div>
            <div class="card-footer card_footer_button text-center">
                <button type="submit" class="btn btn-primary waves-effect">SAVE</button>
            </div>
        </div>
      </form>
    </div>
    <div class="col-md-3"></div>
</div>

<!-- division list -->
<div class="row">
    <div class="col-lg-12">
      <div class="card">
          <div class="card-header">
              <div class="row">
                  <div class="col-md-8">
                      <h3 class="card-title card_top_title"><i class="fab fa-gg-circle"></i> Vechicle List</h3>
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
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Color</th>
                                    <th>Metars</th>
                                    <th>Purchase Date</th>
                                    <th>Driver</th>
                                    <th>Manage</th>
                                  </tr>
                              </thead>
                              <tbody>
                                @foreach($all as $item)
                                  <tr>
                                    <td> {{ $item->veh_name }} </td>
                                    <td> {{ $item->veh_price }} </td>
                                    <td> {{ $item->veh_color }} </td>
                                    <td> {{ $item->veh_present_metar }} </td>
                                    <td> {{ $item->veh_purchase_date }} </td>
                                    <td>
                                      @if($item->driver_id == NULL)
                                        No Driver Assigned
                                      @else
                                        {{  $item->employee->employee_id }} , {{ $item->employee->employee_name }}
                                      @endif
                                    </td>
                                    <td>
                                      <a href="{{ route('edit-vechicle',$item->veh_id) }}" title="edit"><i class="fa fa-pencil-square fa-lg edit_icon"></i></a>

                                      <a href="{{ route('delete-vechicle',$item->veh_id) }}" title="delete" title="delete data"><i class="fa fa-trash fa-lg delete_icon"></i></a>
                                    </td>
                                  </tr>
                                @endforeach
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
