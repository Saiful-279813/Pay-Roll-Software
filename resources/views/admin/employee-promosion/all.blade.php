@extends('layouts.admin-master')
@section('title') Employee Promosion @endsection
@section('content')

<div class="row bread_part">
    <div class="col-sm-12 bread_col">
        <h4 class="pull-left page-title bread_title">Employee Details Information for Promotion</h4>
        <ol class="breadcrumb pull-right">
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
          <div class="card">


              <div class="card-body card_form">
                    <div class="form-group row custom_form_group">
                        <label class="col-sm-3 control-label">Employee ID:</label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control typeahead" placeholder="Input Employee ID" name="emp_id" id="emp_id_search" onkeyup="empSearch()" onfocus="showResult()" onblur="hideResult()">
                          <div id="showEmpId"></div>
                          <span id="error_show" class="d-none" style="color: red"></span>
                        </div>
                        <div class="col-sm-3">
                            <button type="submit" onclick="searchEmployeeDetails()" style="margin-top: 2px" class="btn btn-primary waves-effect">SEARCH</button>
                        </div>
                    </div>

                <!-- show employee information -->
                <div class="col-md-12">
                  <div id="showEmployeeDetails" class="d-none">
                      <div class="row">
                          <div class="col-md-9"></div>
                          <div class="col-md-3">
                            <div class="employee_photo_show">

                            </div>
                          </div>
                      </div>
                      <div class="row">
                          <!-- employee Deatils -->
                          <div class="col-md-6">
                              <div class="header_row">
                                  <span class="emp_info">Employee Information Details</span>
                              </div>
                              <table class="table table-bordered table-striped table-hover custom_view_table show_employee_details_table" id="showEmployeeDetailsTable">
                                <tr>
                                    <td> <span class="emp">Project Name:</span>  <span id="show_employee_project_name" class="emp2"></span> </td>
                                </tr>
                                <tr>
                                    <td> <span class="emp">Employee Id:</span>  <span id="show_employee_id" class="emp2"></span> </td>
                                </tr>
                                <tr>
                                    <td> <span class="emp">Employee Name:</span>  <span id="show_employee_name" class="emp2"></span> </td>
                                </tr>

                                <tr>
                                    <td> <span class="emp">Iqama No:</span>  <span id="show_employee_akama_no" class="emp2"></span> </td>
                                </tr>
                                <tr>
                                    <td> <span class="emp">Iqama Expire Date:</span>  <span id="show_employee_akama_expire_date" class="emp2"></span> </td>
                                </tr>

                                <tr>
                                    <td> <span class="emp">Passport No:</span>  <span id="show_employee_passport_no" class="emp2"></span> </td>
                                </tr>
                                <tr>
                                    <td> <span class="emp">Passport Expire Date:</span>  <span id="show_employee_passport_expire_date" class="emp2"></span> </td>
                                </tr>

                                <tr>
                                    <td> <span class="emp">Employee Type:</span>  <span id="show_employee_type" class="emp2"></span> </td>
                                </tr>
                                <tr>
                                    <td> <span class="emp">Employee Designation:</span>  <span id="show_employee_category" class="emp2"></span> </td>
                                </tr>
                                <tr>
                                    <td> <span class="emp">Department:</span>  <span id="show_employee_department" class="emp2"></span> </td>
                                </tr>
                                <tr>
                                    <td> <span class="emp">Present Address:</span>  <span id="show_employee_present_address" class="emp2"></span> </td>
                                </tr>
                                <tr>
                                    <td> <span class="emp">Parmanent Address:</span> <span id="show_employee_address_Ds"></span>, <span id="show_employee_address_D"></span> , <span id="show_employee_address_C" class="emp2"></span>   </td>
                                </tr>
                                <tr>
                                    <td> <span class="emp">Parmanent Address Details:</span>  <span id="show_employee_address_details" class="emp2"></span> </td>
                                </tr>

                                <tr>
                                    <td> <span class="emp">Date Of Birth:</span>  <span id="show_employee_date_of_birth" class="emp2"></span> </td>
                                </tr>
                                <tr>
                                    <td> <span class="emp">Mobile Number:</span>  <span id="show_employee_mobile_no" class="emp2"></span> </td>
                                </tr>
                                <tr>
                                    <td> <span class="emp">Email Address:</span>  <span id="show_employee_email" class="emp2"></span> </td>
                                </tr>
                                <tr>
                                    <td> <span class="emp">Metarial Status:</span>  <span id="show_employee_metarials" class="emp2"></span> </td>
                                </tr>
                                <tr>
                                    <td> <span class="emp">Joining Date:</span>  <span id="show_employee_joining_date" class="emp2"></span> </td>
                                </tr>
                                <tr>
                                    <td> <span class="emp">Confirmation Date:</span>  <span id="show_employee_confirmation_date" class="emp2"></span> </td>
                                </tr>
                                <tr>
                                    <td> <span class="emp">Appointment Date:</span>  <span id="show_employee_appointment_date" class="emp2"></span> </td>
                                </tr>
                              </table>
                          </div>
                          <!-- Salary Deatils -->
                          <div class="col-md-6">
                              <div class="row">
                                  <div class="col-md-12">
                                    <div class="header_row">
                                        <span class="emp_info">Employee Salary Details</span>
                                    </div>
                                    <table class="table table-bordered table-striped table-hover custom_view_table show_employee_details_table" id="showEmployeeDetailsTable">
                                      <tr>
                                          <td> <span class="emp">Basic Amount:</span>  <span id="show_employee_basic" class="emp2"></span> </td>
                                      </tr>
                                      <tr>
                                          <td> <span class="emp">House Rate:</span>  <span id="show_employee_house_rent" class="emp2"></span> </td>
                                      </tr>
                                      <tr>
                                          <td> <span class="emp">Hourly Rate:</span>  <span id="show_employee_hourly_rent" class="emp2"></span> </td>
                                      </tr>
                                      <tr>
                                          <td> <span class="emp">Mobile Allowance:</span>  <span id="show_employee_mobile_allow" class="emp2"></span> </td>
                                      </tr>
                                      <tr>
                                          <td> <span class="emp">Medical Allowance:</span>  <span id="show_employee_medical_allow" class="emp2"></span> </td>
                                      </tr>
                                      <tr>
                                          <td> <span class="emp">Local Travels Allowance:</span>  <span id="show_employee_local_travel_allow" class="emp2"></span> </td>
                                      </tr>
                                      <tr>
                                          <td> <span class="emp">Conveyance Allowance:</span>  <span id="show_employee_conveyance_allow" class="emp2"></span> </td>
                                      </tr>
                                      <tr>
                                          <td> <span class="emp">Increment No:</span>  <span id="show_employee_increment_no" class="emp2"></span> </td>
                                      </tr>
                                      <tr>
                                          <td> <span class="emp">Increment Amount:</span>  <span id="show_employee_increment_amount" class="emp2"></span> </td>
                                      </tr>
                                      <tr>
                                          <td> <span class="emp">Others:</span>  <span id="show_employee_others" class="emp2"></span> </td>
                                      </tr>
                                    </table>
                                  </div>
                              </div>
                          </div>
                      </div>

                      <!-- promosion form -->
                      <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                          <form style="margin-top:20px" class="form-horizontal" id="registration" action="{{ route('employee-promosion.submit') }}" method="post">
                            @csrf
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h3 class="card-title card_top_title"><i class="fab fa-gg-circle"></i> Salary Details</h3>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="card-body card_form" style="padding-top: 0;">


                                  <input type="hidden" id="input_emp_id_in_desig" name="emp_id" value="">
                                  <input type="hidden" id="input_emp_desig_id_in_desig" name="designation_id" value="">
                                  <input type="hidden" id="input_total_amount" name="total" value="">



                                  <div class="form-group custom_form_group">
                                      <label class="control-label d-block" style="text-align: left;">Designation:</label>
                                      <div>
                                        <select class="form-control" name="designation_id" id="designation_id">

                                        </select>


                                      </div>
                                  </div>

                                  <div class="form-group custom_form_group{{ $errors->has('basic_amount') ? ' has-error' : '' }}">
                                      <label class="control-label d-block" style="text-align: left;">Basic Salary:<span class="req_star">*</span></label>
                                      <div>
                                        <input type="text" class="form-control" id="input_basic_amount" name="basic_amount" value="" required>
                                        @if ($errors->has('basic_amount'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('basic_amount') }}</strong>
                                            </span>
                                        @endif
                                      </div>
                                  </div>

                                  <div class="form-group custom_form_group{{ $errors->has('hourly_rent') ? ' has-error' : '' }}">
                                      <label class="control-label d-block" style="text-align: left;">Hourly Rate:<span class="req_star">*</span></label>
                                      <div>
                                        <input type="text" class="form-control" id="input_hourly_rate" name="hourly_rent" value="" >
                                        @if ($errors->has('hourly_rent'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('hourly_rent') }}</strong>
                                            </span>
                                        @endif
                                      </div>
                                  </div>

                                  <div class="form-group custom_form_group{{ $errors->has('house_rent') ? ' has-error' : '' }}">
                                      <label class="control-label d-block" style="text-align: left;">House Rent:<span class="req_star">*</span></label>
                                      <div>
                                        <input type="text" class="form-control" id="input_house_rate" name="house_rent" value="" >
                                        @if ($errors->has('house_rent'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('house_rent') }}</strong>
                                            </span>
                                        @endif
                                      </div>
                                  </div>

                                  <div class="form-group custom_form_group{{ $errors->has('mobile_allowance') ? ' has-error' : '' }}">
                                      <label class="control-label d-block" style="text-align: left;">Mobile Allowance:<span class="req_star">*</span></label>
                                      <div>
                                        <input type="text" class="form-control" id="input_mobile_allowance" name="mobile_allowance" value="" >
                                        @if ($errors->has('mobile_allowance'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('mobile_allowance') }}</strong>
                                            </span>
                                        @endif
                                      </div>
                                  </div>

                                  <div class="form-group custom_form_group{{ $errors->has('medical_allowance') ? ' has-error' : '' }}">
                                      <label class="control-label d-block" style="text-align: left;">Medical Allowance:<span class="req_star">*</span></label>
                                      <div>
                                        <input type="text" class="form-control" id="input_medical_allowance" name="medical_allowance" value="" >
                                        @if ($errors->has('medical_allowance'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('medical_allowance') }}</strong>
                                            </span>
                                        @endif
                                      </div>
                                  </div>

                                  <div class="form-group custom_form_group{{ $errors->has('local_travel_allowance') ? ' has-error' : '' }}">
                                      <label class="control-label d-block" style="text-align: left;">Local Travel Allowance:<span class="req_star">*</span></label>
                                      <div>
                                        <input type="text" class="form-control" id="input_local_travel_allowance" name="local_travel_allowance" value="" >
                                        @if ($errors->has('local_travel_allowance'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('local_travel_allowance') }}</strong>
                                            </span>
                                        @endif
                                      </div>
                                  </div>

                                  <div class="form-group custom_form_group{{ $errors->has('conveyance_allowance') ? ' has-error' : '' }}">
                                      <label class="control-label d-block" style="text-align: left;">Conveyance Allowance:<span class="req_star">*</span></label>
                                      <div>
                                        <input type="text" class="form-control" id="input_conveyance_allowance" name="conveyance_allowance" value="" >
                                        @if ($errors->has('conveyance_allowance'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('conveyance_allowance') }}</strong>
                                            </span>
                                        @endif
                                      </div>
                                  </div>

                                  <div class="form-group custom_form_group{{ $errors->has('others1') ? ' has-error' : '' }}">
                                      <label class="control-label d-block" style="text-align: left;">Others:<span class="req_star">*</span></label>
                                      <div>
                                        <input type="text" class="form-control" id="input_others1" name="others1" value="">
                                        @if ($errors->has('others1'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('others1') }}</strong>
                                            </span>
                                        @endif
                                      </div>
                                  </div>

                                </div>
                                <div class="card-footer card_footer_button text-center">
                                    <button type="submit" class="btn btn-primary waves-effect">SUBMIT</button>
                                </div>
                            </div>
                          </form>
                        </div>
                        <div class="col-md-2"></div>
                      </div>


                      <!-- Promosion form -->
                  </div>
                </div>
              </div>
              <div class="card-footer card_footer_button text-center">
                .
              </div>
          </div>
    </div>
</div>
@endsection
