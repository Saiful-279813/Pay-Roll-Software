<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All EmpLeave Salary Generate</title>
    <link rel="stylesheet" href="{{ asset('contents/admin') }}/assets/css/salary-bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('contents/admin') }}/assets/css/salary-style.css">
</head>
<body>
  <section class="salary">
      <div class="container">
        <!-- salary header -->
        <div class="row align-center">
            <div class="col-md-6">
                <div class="salary__header">
                    <h3><a href="#">Expenditure Report For : </a></h3>
                    <div class="project_info">
                        <span class="project_name"> {{ $start_date }} to {{ $end_date }} </span>
                        <span class="project_code">  </span>
                    </div>
                </div>
            </div>
            <div class="col-md-6"></div>
        </div>
        <!-- salary bottom header -->

          <div class="salary__table-wrap">
              <div class="row">
                  <div class="col-md-12">
                      <table class="table table-responsive salary__table">
                        <thead>
                            <!-- first-head-row -->
                            <tr class="first-head-row">
                                <th> <span>Srl.NO</span> </th>
                                <th> <span>Cost Type</span> </th>
                                <th> <span>Project</span> </th>
                                <th> <span>Cost By</span> </th>
                                <th> <span>Date</span> </th>
                                <th> <span> Amount </span> </th>
                            </tr>
                        </thead>

                          <tbody>
                            @foreach($expend_report as $report)
                            <tr class="salary-row-parent">
                                <td> <span class="basic-salary-data">{{ $loop->iteration }}</span> </td>
                                <td> <span class="hourly_rate">{{ $report->costType->cost_type_name }}</span> </td>
                                <td> <span class="overtime-data">{{ $report->project->proj_name }}</span> </td>
                                <td> <span class="employee_name">{{ $report->employee->employee_name }}</span> </td>
                                <td> <span class="mobile-data">{{ $report->expire_date }}</span> </td>
                                <td> <span class="medical-data">{{ $report->amount }}</span> </td>
                            </tr>
                            @endforeach
                            <tr>
                                  <td colspan="5"></td>
                                  <td> <span class="total-amount">12009</span> </td>
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
