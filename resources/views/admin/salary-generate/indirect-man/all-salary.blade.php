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
    </style>
</head>
<body>
  <section class="salary">
      <div class="container">
        <!-- salary header -->
        <div class="row align-center">
            <div class="col-md-6">
                <div class="salary__header">
                    <h3><a href="#">Salary For : </a></h3>
                    <div class="project_info">
                        <span class="project_name"> {{ $project->proj_name }} </span>
                        <span class="project_name"> {{ $project->proj_code }} </span>
                    </div>
                </div>
            </div>
            <div class="col-md-6"></div>
        </div>
        <!-- salary bottom header -->
        <div class="salary__header-bottom">
            <div class="row">
                <div class="col-md-3">
                    <p class="toEndDate"> <strong>Report Generate: </strong> <span>{{ $monthName }}</span> </p>
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
                  <div class="salary__download" style="text-align:right; display:flex-; justify-content: right; align-items:center">
                    <p> <strong>Print Date</strong> {{ Carbon\Carbon::now()->format('d/m/Y') }} </p>
                    <a href="#" class="print-button" onclick="window.print()">PDF Or Pirnt</a>
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
                                  <th> <span>Srl No</span> </th>
                                  <th> <span>Empl ID</span> </th>
                                  <th> <span>Empl Name</span> </th>
                                  <th> <span>Salary Amt</span> </th>

                                  <th> <span>Mob Allo</span> </th>
                                  <th> <span>Iqama Renewal</span> </th>
                                  <th> <span>Travel Allo</span> </th>
                                  <th> <span>Food Allo</span> </th>


                                  <th> <span>Others</span> </th>
                                  <th> <span>Advance</span> </th>
                                  <th> <span>Total Salary</span> </th>
                                  <th></th>
                                  <th> <span>Signature</span> </th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                              </tr>
                              <tr class="second-head-row">
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th> <span class="iqama-head">Iqama No</span> </th>
                                  <th></th>
                                  <th> <span class="country-head">Country</span> </th>
                                  <th> <span class="district-head" >District</span> </th>
                                  <th> <span class="type-head">Type</span> </th>
                                  <th> <span class="category-head">Category</span> </th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                              </tr>
                          </thead>
                          <tbody>
                            <tr class="salary-row-parent">
                              @foreach($salaryReport as $empSalary)
                              <!-- Others -->
                              @php
                                $others = ($empSalary->house_rent + $empSalary->medical_allowance);
                              @endphp
                              <!-- Others -->
                              <!-- first tr -->
                              <tr class="first-row">
                                  <td> <span>{{ $loop->iteration }}</span> </td>
                                  <td> <span>{{ $empSalary->employee_id }}</span> </td>
                                  <td colspan="2"> <span> {{ $empSalary->employee_name }} </span> </td>
                                  <td colspan="2"> <span class="iqama-data">{{ $empSalary->akama_no }}</span> </td>
                                  <td> <span class="country-data">{{ $empSalary->country_id == NULL ? 'NO' :  Str::limit($empSalary->country_name,6) }}</span> </td>
                                  <td> <span class="district-data">{{ $empSalary->district_id == NULL ? 'NO' : Str::limit($empSalary->district_name,8) }}</span> </td>
                                  <td> <span class="type-data"> @if($empSalary->emp_type_id == 2) Indir @else Direc @endif </span> </td>
                                  <td> <span class="category-data">{{ $empSalary->catg_name }}</span> </td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td colspan="5" rowspan="2" class="signature_field"> <span class="signature"> </span> </td>
                              </tr>

                               <!-- second tr -->
                              <tr class="second-row">
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td> <span class="basic-salary-data">{{ $empSalary->basic_amount }}</span> </td>
                                  <td> <span class="mobile-data">{{ $empSalary->mobile_allowance }}</span> </td>

                                  <td> <span class="medical-data">{{ $empSalary->slh_iqama_advance }}</span> </td> <!-- iqama -->

                                  <td> <span class="travel-data">{{ $empSalary->local_travel_allowance }}</span> </td>
                                  <td> <span class="food-data">{{ $empSalary->food_allowance }}</span> </td>


                                  <td> <span class="others-data">{{ $others }}</span> </td>
                                  <td> <span class="loan-data">{{ $empSalary->slh_other_advance }}</span> </td>
                                  <td> <span class="total-salary-data">{{ $empSalary->slh_total_salary }}</span> </td>
                               </tr>
                            </tr>
                            @endforeach
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div>
  </section>
</body>
</html>
