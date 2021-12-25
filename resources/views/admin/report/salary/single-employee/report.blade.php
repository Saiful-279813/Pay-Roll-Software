<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Generate</title>
    <link rel="stylesheet" href="{{ asset('contents/admin') }}/assets/css/salary-bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('contents/admin') }}/assets/css/salary-style.css">
    <style media="screen">
      td span.salary-date{
        background: greenyellow;
        padding: 5px 5px;
      }
      .print-btn {
      	text-decoration: none;
      	background: teal;
      	color: #fff;
      	padding: 5px 10px;
      }
      .print-btn:hover {
      	background: teal;
      	color: #fff;
      }
      span.grow-salary-title{
        font-size: 16px;
        display: block;
        text-align: right;
        padding-right: 10px;
      }
      span.grow-salary-data{
        font-size: 16px;
      }

      a.print-button{
        text-decoration: none;
        background: teal;
        color: #fff;
        padding: 5px 10px;
      }
      p.toEndDate{}
      p.toEndDate strong{ font-size: 14px }
      p.toEndDate span {
        font-size: 14px;
        font-weight: 600;
        margin-left: 2px;
      }
      div.officer-signature{
        display: flex;
        justify-content: space-between;
      }
      /* Employee Summary Table */
      table.employee-summary{
        border: 1px solid #ddd;
      }
      table.employee-summary thead{
        border: 1px solid #2B4049;
        background: #2B4049;
      }
      table.employee-summary thead th{
        color: #fff;
        padding-left: 20px;
      }
      table.employee-summary thead th:first-child{
        width: 56px;
        text-align: right;
      }
      table.employee-summary tbody td{
        padding-left: 20px;
      }
      span{
        font-size: 14px !important;
        font-weight: 400 !important;
      }
      span.total{
        display: block;
        text-align: right;
      }
      .p-title{
        text-align: right !important;
        font-weight: 600;
      }
      .p-amount{
        text-align: left !important;
      }

    </style>
</head>
<body>
  <section class="salary">
      <div class="container">
        <!-- salary header -->
        <div class="row align-center">
            <div class="col-md-6">
                <div class="salary__header">
                    <h3><a href="#">Report For : </a></h3>
                    <div class="project_info">
                        <span class="project_name"> Salary History </span>
                    </div>
                </div>
            </div>
            <div class="col-md-6"></div>
        </div>
        <!-- salary bottom header -->
        <div class="salary__header-bottom">
            <div class="row">
                <div class="col-md-3">
                    <p class="date">{{ Carbon\Carbon::now()->format('d/F/Y') }}</p>
                </div>
                <div class="col-md-6">
                  <div class="company_information" style="text-align:center">
                    <h4>{{$company->comp_name_en}}  <small>{{$company->comp_name_arb}} </small> </h4>
                    <address class="address">
                         {{$company->comp_address}}
                    </address>
                    <p> <span> {{$company->comp_phone1}} </span>  <span> {{$company->comp_phone2}} </span> </p>


                  </div>
                </div>
                <div class="col-md-3">
                  <div class="salary__download" style="text-align:right; display:flex; justify-content: right; align-items:center">

                    <a href="#" class="print-btn" onclick="window.print()">Download Pdf</a>
                  </div>
                </div>
            </div>
        </div>
        <!-- salary table -->


          <div class="salary__table-wrap">
              <div class="row">
                  <div class="col-md-12">
                      <table class="table table-responsive salary__table">
                          <thead>
                              <!-- first-head-row -->
                              <tr class="first-head-row">
                                  <th> <span>Date</span> </th>

                                  <th> <span>Salary Amt</span> </th>

                                  <th> <span>Rate/Hours/Days</span> </th>
                                  <th> <span>OT.Hr/Amt</span> </th>



                                  <th> <span>Mob Allo</span> </th>
                                  <th> <span>Iqama Renewal</span> </th>
                                  <th> <span>Travel Allo</span> </th>
                                  <th> <span>Food Allo</span> </th>


                                  <th> <span>Others</span> </th>
                                  <th> <span>Others Adv</span> </th>
                                  <th> <span>Total Salary</span> </th>
                                  <th></th>


                              </tr>
                              <tr class="second-head-row">
                                  <th> <span>SL</span> </th>
                                  <th> <span>Empl ID</span> </th>
                                  <th> <span>Employee Name</span> </th>

                                  <th> <span class="iqama-head"></span> </th>
                                  <th> <span class="iqama-head"> </span> </th>
                                  <th> <span class="iqama-head">Iqama No</span> </th>
                                  <th> <span class="country-head">Country</span> </th>
                                  <th> <span class="district-head" >District</span> </th>
                                  <th> <span class="type-head">Type</span> </th>
                                  <th> <span class="category-head">Desig</span> </th>
                                  <th></th>
                                  <th></th>


                              </tr>
                          </thead>
                          <tbody>
                            <tr class="salary-row-parent">
                              <!-- first tr -->
                              <tr class="first-row">
                                  <td> <span>{{ $findEmployee->emp_auto_id }}</span> </td>
                                  <td> <span>{{ $findEmployee->employee_id }}</span> </td>
                                  <td colspan="3"> <span> {{ $findEmployee->employee_name }}  </span> </td>



                                  <td colspan="1"> <span class="iqama-data">{{ $findEmployee->akama_no }}</span> </td>
                                  <td> <span class="country-data"> {{ Str::limit($findEmployee->country->country_name,4) }} </span> </td>

                                  <td> <span class="district-data">{{ Str::limit($findEmployee->district->district_name,6) }}</span> </td>
                                  <td> <span class="type-data">{{ Str::limit($findEmployee->employeeType->name,6) }}</span> </td>
                                  <td> <span class="category-data">{{ Str::limit($findEmployee->category->name,6) }}</span> </td>
                                  <td></td>


                              </tr>

                               <!-- second tr -->
                              @foreach($SalaryHistory as $data)
                              <tr class="second-row">
                                  <td> <span class="salary-date"> {{ date("F", mktime(0, 0, 0, $data->slh_month, 10)); }} / {{ $data->slh_year }}</span> </td>
                                  <td> <span class="">{{ $data->basic_amount }}</span> </td>
                                  <td> <span class="">{{ $data->hourly_rent }} / {{ $data->slh_total_hours }} / {{ $data->slh_total_working_days }}</span> </td>


                                  <td> <span class="basic-salary-data">{{ $data->slh_total_overtime }} / {{ $data->slh_overtime_amount }}</span> </td>
                                  <td> <span class="mobile-data">{{ $data->mobile_allowance }}</span> </td>

                                  <td> <span class="medical-data">{{ $data->slh_iqama_advance }}</span> </td> <!-- iqama -->

                                  <td> <span class="travel-data">{{ $data->local_travel_allowance }}</span> </td>
                                  <td> <span class="food-data">{{ $data->food_allowance }}</span> </td>
                                  <td> <span class="others-data">{{ $data->others }}</span> </td>
                                  <td> <span class="loan-data">{{ $data->slh_other_advance }}</span> </td>
                                  <td> <span class="total-salary-data">{{ $data->slh_total_salary }}</span> </td>
                               </tr>
                              @endforeach
                              <!-- grow salary -->
                                <tr>
                                  <td colspan="10"> <span class="grow-salary-title">Total :</span> </td>
                                  <td> <span class="grow-salary-data">{{ $growSalary }}</span> </td>
                                </tr>
                            </tr>

                          </tbody>
                      </table>
                      {{-- Employee Summary Details --}}
                      <div class="row">
                        <div class="col-md-8">
                          <table class="table employee-summary">
                            <thead>
                              <tr>
                                <th scope="col">30920</th>
                                <th scope="col">Description</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Remarks</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td rowspan="6"></td>
                                <td><span>1-Jawazat Fee</span></td>
                                <td><span>1000</span></td>
                                <td><span></span></td>
                              </tr>
                              <tr>
                                <td><span>2-Maktab Al Amal Fee</span></td>
                                <td><span>00</span></td>
                                <td><span></span></td>
                              </tr>
                              <tr>
                                <td><span>3-Medical Inssurance</span></td>
                                <td><span>00</span></td>
                                <td><span>New</span></td>
                              </tr>
                              <tr>
                                <td><span>4-Medical Inssurance</span></td>
                                <td><span>00</span></td>
                                <td><span>OLD</span></td>
                              </tr>
                              <tr>
                                <td><span>5-REMAINING IQAMA AMOUNT</span></td>
                                <td><span>00</span></td>
                                <td><span>Mr.Rashed 21-04-21</span></td>
                              </tr>
                              <tr>
                                <td colspan="2"> <span class="total">SUB TOTAL DEDUCTION :</span> </td>
                                <td> <span> 102023 </span> </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="col-md-4">
                          <div class="row">
                            <div class="col-md-7">
                              <p class="p-title">SUB TOTAL IQAMA RENEWAL</p>
                            </div>
                            <div class="col-md-1">
                              <p>:</p>
                            </div>
                            <div class="col-md-4">
                              <p class="p-amount">1209</p>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-7">
                              <p class="p-title">TO BE DEDUCTED AMOUNT</p>
                            </div>
                            <div class="col-md-1">
                              <p>:</p>
                            </div>
                            <div class="col-md-4">
                              <p class="p-amount">1209</p>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-7">
                              <p class="p-title">REMAINING AMOUNT </p>
                            </div>
                            <div class="col-md-1">
                              <p>:</p>
                            </div>
                            <div class="col-md-4">
                              <p class="p-amount">1209</p>
                            </div>
                          </div>
                        </div>
                      </div>
                      {{-- Officer Signature --}}
                      <div class="row">
                        <div class="officer-signature">
                          <p>Operation Manager</p>
                          <p>Accountant</p>
                          <p>General Manager</p>
                        </div>
                      </div>
                      {{-- Officer Signature --}}
                  </div>
              </div>
          </div>
      </div>
  </section>
</body>
</html>
