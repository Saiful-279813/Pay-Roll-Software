<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Attendence</title>
    <link rel="stylesheet" href="{{ asset('contents/admin') }}/assets/css/salary-bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('contents/admin') }}/assets/css/salary-style.css">
    <style media="screen">
          table.salary__table{}
          table.salary__table tr{ border: 1px solid #333 }
          table.salary__table th{ border: 1px solid #333 }
          table.salary__table td{ border: 1px solid #333 }
          span.attendence-data{
            font-size: 14px;
            display: block;
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
          /* table styling */
          table.salary__table{}
          table.salary__table thead{}
          table.salary__table thead tr{}
          table.salary__table thead tr th {
            	font-size: 13px;
            	font-weight: 700;
          }
          table.salary__table tbody tr{}
          table.salary__table tbody tr td{}
          table.salary__table tbody tr td span{}
    </style>

</head>
<body>
  <section class="salary">
      <div class="container">

        <!-- salary header -->
        <div class="row align-center">
            <div class="col-md-6">
                <div class="salary__header">
                    {{-- <h3><a href="#"> </a></h3> --}}
                    <div class="project_info" style="margin-left:0">
                        <span class="project_name"> All Employee Attendence Report </span>
                    </div>
                </div>
            </div>
            <div class="col-md-6"></div>
        </div>
        <!-- salary bottom header -->
        <div class="salary__header-bottom">
            <div class="row">
                <div class="col-md-3">
                    <p class="toEndDate"> <strong> Month & Year: </strong> <span>{{ $monthName }}-{{ $year }}</span> </p>
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
                      <table class="table table-bordered salary__table">
                        <!-- table heading -->
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Name & <br> Iqama, Trade </th>
                            <!-- Date  -->
                            @for($i=1; $i<=31; $i++)
                              <th>{{ $i }}</th>
                            @endfor
                            <!-- end date -->
                            <th>Total</th>
                          </tr>
                        </thead>
                        <!-- table body -->
                        <tbody>
                          @foreach($directEmp as $emp) <!-- per employee -->
                          <tr>
                            <td> <span>{{ $emp->employee_id }}</span> </td>
                            <td> <span>{{ $emp->employee_name }} <br> {{ $emp->akama_no }}, {{ $emp->category->catg_name }}  </span> </td>
                            <!-- php block -->
                            @php
                            $allAttenDays = $emp->atten;
                            $perDayHours = $emp->perDayHours;

                            $totalWorkingDays = $emp->totalWorkingDays;
                            @endphp


                            @for($counter =1;$counter<=32;$counter++)
                            <div class="">
                                <td> <span>@if($counter <=31)
                                   {{$totalWorkingDays[$counter]}}
                                   @else
                                   {{"="}}
                                   @endif
                                 </span>
                                 <span>{{  $allAttenDays[$counter]}}</span>
                               </td>
                            </div>
                            @endfor


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
