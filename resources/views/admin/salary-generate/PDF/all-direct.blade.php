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
                    <h3><a href="#">Salary For : </a></h3>
                    <div class="project_info">
                        <span class="project_name"> # </span>
                        <span class="project_code"> # </span>
                    </div>
                </div>
            </div>
            <div class="col-md-6"></div>
        </div>
        <!-- salary bottom header -->
        <div class="salary__header-bottom">
            <div class="row">
                <div class="col-md-3">
                    <p class="date">#</p>
                </div>
                <div class="col-md-6">
                  <div class="company_information" style="text-align:center">
                    <h4>#  <small># </small> </h4>
                    <address class="address">
                         #
                    </address>
                    <p> <span> # </span>  <span> # </span> </p>


                  </div>
                </div>
                <div class="col-md-3">
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
                                <th> <span>Rate/Hours</span> </th>
                                <th> <span>Total.Hr/Ds</span> </th>
                                <th> <span>OT.Hr/Amt </span> </th>
                                <th> <span>Total Amount </span> </th>



                                <th> <span>Mob Allo</span> </th>
                                <th> <span>Iqama Renewal</span> </th>

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
                                    <td colspan="2"> <span> # </span> </td>
                                    <td colspan="2"> <span class="iqama-data">#</span> </td>
                                    <td> <span class="country-data">#</span> </td>
                                    <td> <span class="district-data">#</span> </td>
                                    <td> <span class="type-data">#</span> </td>
                                    <td> <span class="category-data">#</span> </td>
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
                                    <td> <span class="basic-salary-data">#</span> </td>
                                    <td> <span class="hourly_rate">#</span> </td>
                                    <td> <span class="overtime-data">#</span> </td>
                                    <td> <span class="total-amount">#</span> </td>
                                    <td> <span class="mobile-data">#</span> </td>
                                    <td> <span class="medical-data">#</span> </td>
                                    <td> <span class="food-data">#</span> </td>
                                    <td> <span class="others-data">#</span> </td>
                                    <td> <span class="loan-data">#</span> </td>
                                    <td> <span class="total-salary-data">#</span> </td>
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
