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

                  </div>
              </div>
              <div class="col-md-6"></div>
          </div>
          <!-- salary bottom header -->
          <div class="salary__header-bottom">
              <div class="row">
                  <div class="col-md-3">
                    <div class="project_info" style="margin-left:0">
                        <span class="project_name">  <strong>Salary Month :</strong> Nobemver,2021 </span>
                    </div>
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
                                  <th> <span>S.N</span> </th>
                                  <th> <span>Empl ID</span> </th>
                                  <th> <span>Employee Name</span> </th>
                                  <th> <span>Iqama No</span> </th>

                                  <th> <span>Company</span> </th>

                                  <th> <span>Nation</span> </th>
                                  <th> <span>Trade</span> </th>

                                  <th> <span></span> </th>
                                  <th> <span></span> </th>

                                  <th> <span></span> </th>
                                  <th> <span></span> </th>

                                  <th> <span></span> </th>
                                  <th></th>
                                  <th> <span>Signature</span> </th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                              </tr>
                              <tr class="second-head-row">
                                  <th></th>
                                  <th></th>
                                  <th> <span class="currency"> Sponser </span> </th> </th>
                                  <th> <span class="currency"> BS/(Rate) </span> </th>
                                  <th> <span class="currency"> Ovh(Amt) </span> </th>
                                  <th> <span class="currency">Hr/WrD</span> </th>
                                  <th> <span class="currency"> Total(FA + Allow) </span> </th>
                                  <th> <span class="currency"> (Adv1 + Adv2) </span> </th>
                                  <th> <span class="currency"> (Visa Amt) </span> </th>
                                  <th> <span class="currency"> (Contr)/(Insur) </span> </th>
                                  <th> <span class="currency"> (Iqama Renewal) </span> </th>
                                  <th> <span class="currency"> Grow Salary </span> </th>
                                  <!-- <th> <span class="iqama-head">Rate/Hours</span> </th>
                                  <th> <span class="iqama-head">OT.Hr/Amt </span> </th>
                                  <th> <span class="iqama-head">Iqama No</span> </th>
                                  <th> <span class="country-head">Country</span> </th>
                                  <th> <span class="district-head" >District</span> </th>
                                  <th> <span class="type-head">Type</span> </th>
                                  <th> <span class="category-head">Category</span> </th> -->
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                              </tr>
                          </thead>
                          <tbody>
                            <tr class="salary-row-parent">
                              <!-- first tr -->
                              <tr class="first-row">
                                  <td> <span>#</span> </td>
                                  <td> <span>#</span> </td>
                                  <td colspan="1"> <span> # </span> </td>
                                  <td colspan="1"> <span>#</span> </td>
                                  <td colspan="1"> <span>#</span> </td>
                                  <td colspan="1"> <span>#</span> </td>
                                  <td> <span>#</span> </td>
                                  <td> <span></span> </td>
                                  <td> <span></span> </td>
                                  <td> <span></span> </td>
                                  <td></td>
                                  <td></td>
                                  <td colspan="5" rowspan="2" class="signature_field"> <span class="signature">  </span> </td>
                              </tr>
                               <!-- second tr -->
                              <tr class="second-row">
                                  <td></td>
                                  <td></td>
                                  <td> <span class="currency_data">#</span> </td>
                                  <td> <span class="currency_data">#</span> </td> {{-- Basic salary & Rate --}}
                                  {{--  --}}
                                  <td> <span class="currency_data">#</span> </td>



                                  <td> <span class="currency_data">#</span> </td>
                                  <td> <span class="currency_data">#</span> </td>
                                  <td> <span class="currency_data">#</span> </td>

                                  <td> <span class="currency_data">#</span> </td> <!-- iqama -->
                                  <td> <span class="currency_data">#</span> </td>
                                  <td> <span class="currency_data"> # </span> </td>
                                  <td> <span class="currency_data"> # </span> </td>
                               </tr>
                            </tr>

                            <tr>
                              <td colspan="3"></td>
                              <td colspan="3">
                                <p style="margin-bottom:0"> <strong>Total Work Hours:</strong> # </p>
                              </td>
                              <td colspan="3">
                                <p style="margin-bottom:0"> <strong>Iqama Renewal:</strong> # </p>
                              </td>
                              <td colspan="2"> <p style="text-align:right;margin-bottom:0"> <strong>Total Salary Amount:</strong> </p> </td>
                              <td> <p style="margin-bottom:0"> # </p> </td>
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
                                <td rowspan="4"></td>
                                <td><span>Hekkljk</span></td>
                                <td><span>Hekkljk</span></td>
                                <td><span>Hekkljk</span></td>
                              </tr>
                              <tr>
                                <td><span>Hekkljk</span></td>
                                <td><span>Hekkljk</span></td>
                                <td><span>Hekkljk</span></td>
                              </tr>
                              <tr>
                                <td><span>Hekkljk</span></td>
                                <td><span>Hekkljk</span></td>
                                <td><span>Hekkljk</span></td>
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
