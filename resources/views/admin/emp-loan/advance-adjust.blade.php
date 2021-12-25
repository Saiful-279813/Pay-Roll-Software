@extends('layouts.admin-master')
@section('title') Employee Monthly Advance Setting @endsection
@section('content')

<div class="row bread_part">
    <div class="col-sm-12 bread_col">
        <h4 class="pull-left page-title bread_title">Employee Monthly Advance Setting</h4>
        <ol class="breadcrumb pull-right">
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="active">Employee Monthly Advance Setting</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        @if(Session::has('success'))
          <div class="alert alert-success alertsuccess" role="alert" style="margin-left: -20px">
             <strong>Successfully!</strong> Updated.
          </div>
        @endif
        @if(Session::has('error'))
          <div class="alert alert-warning alerterror" role="alert">
             <strong>Opps!</strong> please try again.
          </div>
        @endif
    </div>
    <div class="col-md-2"></div>
</div>


<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <!-- <form class="form-horizontal project-details-form" id="registration" method="post" action="{{ route('insert-project-info') }}" enctype="multipart/form-data">
          @csrf -->
          <div class="card">
              <div class="card-header">
                  <div class="row">
                      <div class="col-md-8">
                          <h3 class="card-title card_top_title"><i class="fab fa-gg-circle"></i> Employee Monthly Advance Setting </h3>
                      </div>
                      <div class="clearfix"></div>
                  </div>
              </div>
              <div class="card-body card_form">
                <!-- SEARCH Employee -->
                <div class="form-group row custom_form_group" style="margin-top:10px">
                    <div class="col-md-2"></div>
                    <label class="col-sm-3 control-label">Employee Id:<span class="req_star">*</span></label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" name="employee_id" id="employee_id" required placeholder="Employee ID Type Here ">

                      <span id="error_through" style="color:red"></span>
                    </div>
                    <div class="col-sm-1" >
                      <button onclick="findEmployeeForAdvanceSetting()" class="btn btn-primary btn-sm emp-sarch">SEARCH</button>
                    </div>
                </div>
                <!-- form -->
                <div id="finalySubmited" class="d-none card_footer_button text-center">
                  <div class="row">
                      <div class="col-md-2"></div>
                      <div class="col-md-8">
                        <div class="form-wrap">
                          <h4>Employee Advance Information</h4>
                          <!-- form -->
                          <form id="projectInchargeForm" action="{{ route('update.advance-installAmount') }}" method="post">
                            @csrf
                            <!-- Select Project Option-->
                            <input type="hidden" name="id" id="adv_pay_id" value="">
                            <div class="form-group row custom_form_group">
                                <label class="col-sm-3 control-label">Total Advance:</label>
                                <div class="col-sm-7">
                                  <input type="text" id="totalAdvance" class="form-control" value="" disabled>
                                </div>
                            </div>
                            <div class="form-group row custom_form_group">
                                <label class="col-sm-3 control-label">Total Paid:</label>
                                <div class="col-sm-7">
                                  <input type="text" id="totalPay" class="form-control" value="" disabled>
                                </div>
                            </div>
                            <div class="form-group row custom_form_group">
                                <label class="col-sm-3 control-label">Next Pay:</label>
                                <div class="col-sm-7">
                                  <input type="text" id="nextPay" name="nextPay" class="form-control" value="100">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary waves-effect">SAVE</button>
                          </form>
                      </div>

                      </div>
                      <div class="col-md-2"></div>
                  </div>
                </div>

              </div>
          </div>
        <!-- </form> -->
    </div>
    <div class="col-md-1"></div>
</div>

<script type="text/javascript">
    function findEmployeeForAdvanceSetting(){
      var emp_id = $("#employee_id").val();
      $.ajax({
        type:'POST',
        dataType: 'json',
        data:{ emp_id:emp_id },
        url:"{{ route('findEmployeeForLoan') }}",
        success:function(response){
            if(response.status == 'error'){
              if(emp_id != ''){
                $("#error_through").text("dosn,t match");
                $("#finalySubmited").addClass('d-none').removeClass('d-block');
              }

            }else{

              if(response.status_no == 'noAdvance'){
                $("#error_through").text("Employee Didn,t get Advance..");
                $("#finalySubmited").addClass('d-none').removeClass('d-block');
              }else{
                var installAmount = Math.round(response.findAdvancePay.installes_amount);
                $("#employee_id").val("");
                $('input[id="adv_pay_id"]').val(response.findAdvancePay.adv_pay_id);
                $('input[id="totalAdvance"]').val(response.findAdvancePay.adv_pay_amount);
                $('input[id="totalPay"]').val(response.findAdvancePay.total_paid);
                $('input[id="nextPay"]').val(installAmount);
                $("#error_through").text('');
                $("#finalySubmited").removeClass('d-none').addClass('d-block');

              }


            }

        }
      });
    }

    function inchargeValidation(){
      var emp_id = $("#employee_id").val();
      $.ajax({
        type:'POST',
        dataType: 'json',
        data:{ emp_id:emp_id },
        url:"{{ route('check.valid-emp-id') }}",
        success:function(response){
          if(response.status == 'error'){
            // $("form[id='registration']").submit(false);
          }
        }
      });

    }
</script>
<!-- validation -->
<script type="text/javascript">
/* form validation */
$(document).ready(function(){
  $("#projectInchargeForm").validate({
    rules: {
    messages: {
      proj_name: {
        required : "You Must Be Select This Field!",
      },
    },
  });
});
</script>
@endsection
