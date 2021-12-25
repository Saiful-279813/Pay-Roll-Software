<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Tools & Metarials</title>
    <link rel="stylesheet" href="{{ asset('contents/admin') }}/assets/css/salary-bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('contents/admin') }}/assets/css/salary-style.css">
    <style media="screen">
        tr.first-row:last-child{
          display: none;
        }
    </style>
</head>
<body>
  <section class="salary">
      <div class="container">
        <!-- salary header -->
        <div class="row align-center">
            <div class="col-md-6">
                <!-- <div class="salary__header">
                    <h3><a href="#">Salary For : </a></h3>
                    <div class="project_info">
                        <span class="project_name"> # </span>
                    </div>
                </div> -->
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
                  <div class="salary__download" style="text-align:right">
                      <a target="_blank" href="#">Download PDF</a>
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
                              <tr class="first-head-row">
                                <th>Type</th>
                                <th>Category</th>
                                <th>Sub Category</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Net Amount</th>
                              </tr>
                          </thead>
                          <tbody>

                            <tr class="salary-row-parent">
                              @foreach($all as $item)
                              <tr class="first-row" style="border: 1px solid #3F3F3F!important">
                                <td>{{ $item->itemType->itype_name }}</td>
                                <td>{{ $item->icatg_name }}</td>
                                <td>{{ $item->iscatg_name }}</td>
                                <td>{{ $item->rate }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->amount }}</td>
                              </tr>
                              @endforeach
                              <tr class="second-row">
                                <td colspan="5"> <span style="display:block; text-align:right; font-size: 16px">Total Amount</span> </td>
                                <td colspan="5">{{ $sum }}</td>
                              </tr>
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
