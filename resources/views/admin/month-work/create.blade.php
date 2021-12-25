@extends('layouts.admin-master')
@section('title') Create Month Work History @endsection
@section('content')
<div class="row bread_part">
    <div class="col-sm-12 bread_col">
        <h4 class="pull-left page-title bread_title">Month Work History</h4>
        <ol class="breadcrumb pull-right">
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="active"> Month Work History</li>
        </ol>
    </div>
</div>
<!-- add division -->
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        @if(Session::has('success'))
          <div class="alert alert-success alertsuccess" role="alert">
             <strong>Successfully!</strong> Added New Month Work History.
          </div>
        @endif
        @if(Session::has('success_update'))
          <div class="alert alert-success alertsuccess" role="alert">
             <strong>Successfully!</strong> Update Work History.
          </div>
        @endif
        @if(Session::has('delete'))
          <div class="alert alert-success alertsuccess" role="alert">
             <strong>Successfully!</strong> Delete Work History.
          </div>
        @endif
        @if(Session::has('duplicate'))
          <div class="alert alert-warning alerterror" role="alert">
             <strong>Opps!</strong> This recode already exist.
          </div>
        @endif
        @if(Session::has('indirect_man'))
          <div class="alert alert-warning alerterror" role="alert">
             <strong>Opps!</strong> Invalid Indirect Man Power.
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
    <div class="col-md-2"></div>
    <div class="col-md-8">
      <div class="select_employee">
          <div class="card">
              <div class="card-body card_form">


                <div class="form-group row custom_form_group">
                    <label class="col-sm-3 control-label">Employee ID:</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control typeahead" placeholder="Input Employee ID" name="emp_id" id="emp_id_search" onkeyup="empSearch()" onfocus="showResult()" onblur="hideResult()">
                      <div id="showEmpId"></div>
                      <span id="error_show" class="d-none" style="color: red"></span>
                    </div>
                    <div class="col-sm-3">
                        <button type="submit" onclick="searchEmployeeDetails()" style="margin-top: 2px" class="btn btn-primary waves-effect">SEARCH</button>
                    </div>
                </div>

                {{-- Show Employee Details --}}
                <div class="col-md-12">
                  <div id="showEmployeeDetails" class="d-none">
                      <div class="row">
                          <!-- employee Deatils -->
                          <div class="col-md-6">
                              <table class="table table-bordered table-striped table-hover custom_view_table show_employee_details_table" id="showEmployeeDetailsTable">
                                <tr>
                                    <td> <span class="emp">Project:</span>  <span id="show_employee_project_name" class="emp2"></span> </td>
                                </tr>
                                <tr>
                                    <td> <span class="emp"> Name:</span>  <span id="show_employee_name" class="emp2"></span> </td>
                                </tr>

                                <tr>
                                    <td> <span class="emp">Type:</span>  <span id="show_employee_type" class="emp2"></span> </td>
                                </tr>
                              </table>
                          </div>
                          <!-- Salary Deatils -->
                          <div class="col-md-6">
                              <div class="row">
                                  <div class="col-md-12">
                                    <table class="table table-bordered table-striped table-hover custom_view_table show_employee_details_table" id="showEmployeeDetailsTable">
                                      <tr>
                                          <td> <span class="emp">Trade:</span>  <span id="show_employee_category" class="emp2"></span> </td>
                                      </tr>
                                      <tr>
                                          <td> <span class="emp">Basic Amount:</span>  <span id="show_employee_basic" class="emp2"></span> </td>
                                      </tr>
                                      <tr>
                                          <td> <span class="emp">Hourly Rate:</span>  <span id="show_employee_hourly_rent" class="emp2"></span> </td>
                                      </tr>
                                    </table>
                                  </div>
                              </div>
                          </div>
                      </div>

                      <!-- promosion form -->
                      <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                          <form style="margin-top:20px" class="form-horizontal" id="registration" action="{{ route('store.monthly-work-history') }}" method="post">
                            @csrf
                            <div class="card">
                                <div class="card-body card_form" style="padding-top: 20;">
                                  <input type="hidden" id="emp_auto_id" name="emp_id" value="">
                                  {{-- Show Input Field --}}
                                  <div class="form-group row custom_form_group">
                                    <label class="control-label col-md-3">Month:</label>
                                    <div class="col-md-7">
                                      <select class="form-control" name="month">
                                      @foreach($month as $data)
                                        <option value="{{ $data->month_id }}" {{ $data->month_id == $currentMonth ? 'selected':'' }}>{{ $data->month_name }}</option>
                                      @endforeach
                                      </select>
                                    </div>
                                </div>

                                <div id="work_hours_field" class=" ">
                                  <div  class="form-group row custom_form_group{{ $errors->has('work_hours') ? ' has-error' : '' }}">
                                      <label class="control-label col-md-3">Total Hours:<span class="req_star">*</span></label>
                                      <div class="col-md-7">

                                        <input type="text" class="form-control" placeholder="Work Hours" id="work_hours" name="work_hours" value="{{old('work_hours')}}" required max="360" min="1">
                                        @if ($errors->has('work_hours'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('work_hours') }}</strong>
                                            </span>
                                        @endif
                                      </div>
                                  </div>
                                </div>

                                {{-- <input type="text" id="work_hours_field_input" name="work_hours" value=""> --}}

                                <div class="form-group row custom_form_group{{ $errors->has('overtime') ? ' has-error' : '' }}">
                                    <label class="control-label col-md-3">Overtime Hours:<span class="req_star">*</span></label>
                                    <div class="col-md-7">
                                      <input type="text" class="form-control" placeholder="Overtime Hours" id="overtime" name="overtime" value="{{old('overtime')}} 0" required max="150">
                                      @if ($errors->has('overtime'))
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $errors->first('overtime') }}</strong>
                                          </span>
                                      @endif
                                    </div>
                                </div>

                                <div class="form-group row custom_form_group{{ $errors->has('total_work_day') ? ' has-error' : '' }}">
                                    <label class="control-label col-md-3">Total Days:<span class="req_star">*</span></label>
                                    <div class="col-md-7">
                                      <input type="text" class="form-control" placeholder="Work Days" id="total_work_day" name="total_work_day" value="{{old('total_work_day')}}" required max="30">
                                      @if ($errors->has('total_work_day'))
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $errors->first('total_work_day') }}</strong>
                                          </span>
                                      @endif
                                    </div>
                                </div>
                                  {{-- Show Input Field --}}
                                </div>
                                <div class="card-footer card_footer_button text-center">
                                    <button type="submit" class="btn btn-primary waves-effect">SUBMIT</button>
                                </div>
                            </div>
                          </form>
                        </div>
                        <div class="col-md-1"></div>
                      </div>


                      <!-- Promosion form -->
                  </div>
                </div>
                {{-- Show Employee Details --}}

              </div>
          </div>
      </div>
      <!-- Direct Man Power -->






    </div>
    <div class="col-md-2"></div>
</div>

<!-- division list -->
<div class="row">
    <div class="col-lg-12">
      <div class="card">
          <div class="card-header">
              <div class="row">
                  <div class="col-md-8">
                      <h3 class="card-title card_top_title"><i class="fab fa-gg-circle"></i> Month Work History List</h3>
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
                                      <th>Employee Id</th>
                                      <th>Employee Name</th>
                                      <th>Employee Type</th>
                                      <th>Total Hours</th>
                                      <th>Total Days</th>
                                      <th>Month</th>
                                      <th>Manage</th>
                                  </tr>
                              </thead>
                              <tbody>
                                @foreach($all as $item)
                                  <tr>
                                    <td>{{ $item->employee->employee_id }}</td>
                                    <td>{{ $item->employee->employee_name }}</td>
                                    <td>{{ $item->employee->employeeType->name }}</td>
                                    <td>{{ $item->total_hours == NULL ? '--' : $item->total_hours }}</td>
                                    <td>{{ $item->total_work_day }}</td>
                                    <td>{{ $item->month->month_name }}</td>
                                    <td>
                                      <a href="{{ route('edit.month-work',$item->month_work_id ) }}" title="edit"><i class="fa fa-pencil-square fa-lg edit_icon"></i></a>
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

<script type="text/javascript">
  $(document).ready(function(){
    $("#month_work_history").validate({
      rules: {
        indirect_emp_id: {
          required : true,
        },
      },

      messages: {
        indirect_emp_id: {
          required : "please enter designation name",
        },
      },

    });
    /* ================================================== */
  });
</script>
@endsection
