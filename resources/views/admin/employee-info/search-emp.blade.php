@extends('layouts.admin-master')
@section('title') Employee Information Search @endsection
@section('content')

@section('internal-css')
  <style media="screen">
  a.checkButton {
    background: teal;
    color: #fff!important;
    font-size: 13px;
    padding: 5px 10px;
    cursor: pointer;
  }
  </style>
@endsection

<div class="row bread_part">
    <div class="col-sm-12 bread_col">
        <h4 class="pull-left page-title bread_title">Employee Information Search</h4>
        <ol class="breadcrumb pull-right">
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="active">Employee Information Search</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
          <div class="card">
              <div class="card-header"></div>
              <div class="card-body card_form">
                  <div class="row">
                    <div class="col-md-9">
                      {{-- checkbox for iqama no wise search employee --}}
                      <div class="row">
                        <div class="col-md-5"></div>
                        <div class="col-md-3">
                          <div class="form-check" style="margin-bottom:15px;">
                            <a id="iqamaWiseSearch" class=" d-block checkButton" onclick="iqamaWiseSearch()">Iqama Wise Search?</a>
                            <a id="idWiseSearch" class=" d-none checkButton" onclick="idWiseSearch()">ID Wise Search?</a>
                          </div>
                        </div>
                      </div>
                      {{-- Search Employee Id --}}
                      <div id="searchEmployeeId"  class=" d-block">
                        <div class="form-group row custom_form_group ">
                            <label class="col-sm-5 control-label">Employee ID:</label>
                            <div class="col-sm-4">
                              <input type="text" class="form-control typeahead" placeholder="Input Employee ID" name="emp_id" id="emp_id_search" onkeyup="empSearch()" onfocus="showResult()" onblur="hideResult()">
                              <div id="showEmpId"></div>
                              <span id="error_show" class="d-none" style="color: red"></span>
                            </div>
                            <div class="col-sm-2">
                                <button type="submit" onclick="searchEmployeeDetails()" style="margin-top: 2px" class="btn btn-primary waves-effect">SEARCH</button>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                      </div>
                      {{-- Search Employee IQama No --}}
                      <div id="searchIqamaNo" class=" d-none">
                        <div class="form-group row custom_form_group ">
                            <label class="col-sm-5 control-label">IQama No:</label>
                            <div class="col-sm-4">
                              <input type="text" id="iqamaNoSearch" class="form-control typeahead" placeholder="Input IQama No" name="iqamaNo">
                              <span id="error_show" class="d-none" style="color: red"></span>
                            </div>
                            <div class="col-sm-2">
                                <button type="submit" onclick="searchEmployeeDetails()" style="margin-top: 2px" class="btn btn-primary waves-effect">SEARCH</button>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                      </div>


                    </div>
                    {{-- show image --}}
                    <div class="col-md-3">
                      <div class="employee_photo_show" id="employee_photo_show">
                            <img src="{{ asset('contents/admin') }}/assets/images/avatar-1.jpg" alt="" class="image-resize">
                      </div>
                    </div>
                  </div>



                <!-- show employee information -->
                <div class="col-md-12">
                  <div id="showEmployeeDetails" class="d-none">
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
                      <!-- job experience list -->
                      <div class="row" style="margin-top: 50px">
                          <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h3 class="card-title card_top_title"><i class="fab fa-gg-circle"></i> Job Experience </h3>
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
                                                            <th>Company Name</th>
                                                            <th>Title</th>
                                                            <th>Total Days</th>
                                                            <th>Designation</th>
                                                            <th>Responsibilty</th>
                                                            <!-- <th>Manage</th> -->
                                                        </tr>
                                                    </thead>
                                                    <tbody id="show_employee_job_experience_list">



                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          </div>
                      </div>
                      <!-- Employee Contact person -->
                      <div class="row" style="margin-top: 50px">
                          <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h3 class="card-title card_top_title"><i class="fab fa-gg-circle"></i> Contact Person Information </h3>
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
                                                            <th>Person Name</th>
                                                            <th>Mobile No</th>
                                                            <th>Relationship</th>

                                                            <!-- <th>Manage</th> -->
                                                        </tr>
                                                    </thead>
                                                    <tbody id="show_employee_contact_person_list"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          </div>
                      </div>

                  </div>
                </div>
              </div>
              <div class="card-footer card_footer_button text-center">
                .
              </div>
          </div>
    </div>
</div>
{{-- iqama no wise Search --}}
<script type="text/javascript">
  // iqama Wise
  function iqamaWiseSearch(){
    $('#iqamaWiseSearch').removeClass('d-block').addClass('d-none');
    $('#idWiseSearch').removeClass('d-none').addClass('d-block');
    // input field
    $('#searchEmployeeId').removeClass('d-block').addClass('d-none');
    $('#searchIqamaNo').removeClass('d-none').addClass('d-block');

  }
  // id Wise
  function idWiseSearch(){
    $('#idWiseSearch').removeClass('d-block').addClass('d-none');
    $('#iqamaWiseSearch').addClass('d-block').removeClass('d-none');
    // input field
    $('#searchIqamaNo').removeClass('d-block').addClass('d-none');
    $('#searchEmployeeId').removeClass('d-none').addClass('d-block');
  }

</script>
@endsection
