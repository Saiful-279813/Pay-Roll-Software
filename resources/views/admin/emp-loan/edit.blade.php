@extends('layouts.admin-master')
@section('title') Employee Advance @endsection
@section('content')
<div class="row bread_part">
    <div class="col-sm-12 bread_col">
        <h4 class="pull-left page-title bread_title">Employee Advance </h4>
        <ol class="breadcrumb pull-right">
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="active"> Update Imformation </li>
        </ol>
    </div>
</div>
<!-- add division -->
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        @if(Session::has('error'))
          <div class="alert alert-warning alerterror" role="alert">
             <strong>Opps!</strong> please try again.
          </div>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
      <form class="form-horizontal" id="registration" action="{{ route('update-advance.pay') }}" method="post">
        @csrf
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="card-title card_top_title"><i class="fab fa-gg-circle"></i> Update Employee Advance</h3>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="card-body card_form" style="padding-top: 0;">
              <input type="hidden" name="id" value="{{ $edit->adv_pay_id }}">
              <div class="form-group custom_form_group{{ $errors->has('emp_id') ? ' has-error' : '' }}">
                  <label class="control-label d-block" style="text-align: left;">Employee ID:</label>
                  <div>
                    <input type="text" class="form-control typeahead" placeholder="Type Employee ID" name="emp_id" id="emp_id_search" onkeyup="empSearch()" onfocus="showResult()" onblur="hideResult()" value=" {{ $edit->employee->employee_id }}">
                    @if ($errors->has('emp_id'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('emp_id') }}</strong>
                        </span>
                    @endif
                  </div>
                  <div id="showEmpId"></div>
              </div>


            <div class="form-group custom_form_group{{ $errors->has('adv_pay_purpose') ? ' has-error' : '' }}">
                  <label class="control-label d-block" style="text-align: left;">Select Advance Purpose:</label>
                  <div>
                      <select class="form-control" name="adv_pay_purpose" required>
                          <option value="">Select Here</option>
                          @foreach($purpose as $pur)
                          <option value="{{ $pur->id }}" {{ $pur->id == $edit->adv_pay_purpose ? 'selected':'' }}>{{ $pur->purpose }}</option>
                          @endforeach
                      </select>
                  </div>
                    @if ($errors->has('adv_pay_purpose'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('adv_pay_purpose') }}</strong>
                        </span>
                    @endif
              </div>

              <div class="form-group custom_form_group{{ $errors->has('adv_pay_amount') ? ' has-error' : '' }}">
                  <label class="control-label d-block" style="text-align: left;">Advance Amount:<span class="req_star">*</span></label>
                  <div>
                    <input type="text" class="form-control" placeholder="Input Amount" name="adv_pay_amount" value="{{ $edit->adv_pay_amount }}" required>
                    @if ($errors->has('adv_pay_amount'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('adv_pay_amount') }}</strong>
                        </span>
                    @endif
                  </div>
              </div>

              <div class="form-group custom_form_group{{ $errors->has('installes_month') ? ' has-error' : '' }}">
                  <label class="control-label d-block" style="text-align: left;"> Install Month:<span class="req_star">*</span></label>
                  <div>
                    <input type="text" class="form-control" placeholder="Input Month" name="installes_month" value="{{ $edit->installes_month }}" required>
                    @if ($errors->has('installes_month'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('installes_month') }}</strong>
                        </span>
                    @endif
                  </div>
              </div>

            </div>
            <div class="card-footer card_footer_button text-center">
                <button type="submit" class="btn btn-primary waves-effect">UPDATE</button>
            </div>
        </div>
      </form>
    </div>
    <div class="col-md-2"></div>
</div>
@endsection
