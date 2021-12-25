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
                    <h3><a href="#">Cost In For : </a></h3>
                    <div class="project_info">
                        <span class="project_name"> Salary  </span>
                    </div>
                </div>
            </div>
            <div class="col-md-6"></div>
        </div>
        <!-- salary bottom header -->
        <div class="salary__header-bottom">
            <div class="row">
                <div class="col-md-3">
                    <p class="toEndDate"> <strong>Report Generate: </strong> <span>{{ $monthName }}-{{ $year }}</span> </p>
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
                                  <th> <span>Employee ID</span> </th>
                                  <th> <span>Employee Name</span> </th>
                                  <th> <span>IQama No</span> </th>
                                  <th> <span>Type</span> </th>
                                  <th> <span>Salary Amt</span> </th>
                              </tr>
                          </thead>
                          <tbody>
                            @forelse($salary as $item)
                            <tr class="salary-row-parent">
                              <td> <span>{{ $loop->iteration }}</span> </td>
                              <td> <span>{{ $item->employee->employee_id }}</span> </td>
                              <td> <span>{{ $item->employee->employee_name }}</span> </td>
                              <td> <span>{{ $item->employee->akama_no }}</span> </td>
                              @if($item->employee->hourly_employee == 1)
                                  <td> <span>Dir(Hourly)</span> </td>
                              @else
                                  <td> <span>{{ $item->employee->emp_type_id == 1 ? 'Direct':'Indir' }}</span> </td>
                              @endif

                              <td> <span>{{ $item->slh_total_salary }}</span> </td>
                            </tr>
                            @empty
                              <p>Data Not Found!</p>
                            @endforelse
                            <tr>
                              <td colspan="5">  <span style="display:block; text-align:right; font-size:16px">Total Salary Amout : </span> </td>
                              <td>{{ $totalSalary }}</td>
                            </tr>
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div>
  </section>
</body>
</html>
