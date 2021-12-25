@extends('layouts.admin-master')
@section('title') Employee Advance @endsection
@section('content')
<div class="row bread_part">
    <div class="col-sm-12 bread_col">
        <h4 class="pull-left page-title bread_title">Employee Advance</h4>
        <ol class="breadcrumb pull-right">
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="active">Employee Advance</li>
        </ol>
    </div>
</div>
<!-- add division -->
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        @if(Session::has('success'))
          <div class="alert alert-success alertsuccess" role="alert">
             <strong>Successfully!</strong> Added New Advance Payment.
          </div>
        @endif
        @if(Session::has('success_update'))
          <div class="alert alert-success alertsuccess" role="alert">
             <strong>Successfully!</strong> Update Advance Payment Information.
          </div>
        @endif
        @if(Session::has('error_duplicate'))
          <div class="alert alert-warning alerterror" role="alert">
             <strong>Opps!</strong> You already have a loan.
          </div>
        @endif
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
      <form class="form-horizontal" id="registration" action="{{ route('insert-advance.pay') }}" method="post">
        @csrf
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="card-title card_top_title"><i class="fab fa-gg-circle"></i> Employee Advance</h3>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="card-body card_form" style="padding-top: 0;">

              <div class="form-group custom_form_group{{ $errors->has('emp_id') ? ' has-error' : '' }}">
                  <label class="control-label d-block" style="text-align: left;">Employee ID:</label>
                  <div>
                    <input type="text" class="form-control typeahead" placeholder="Input Employee ID" name="emp_id" id="emp_id_search" onkeyup="empSearch()" onfocus="showResult()" onblur="hideResult()" value="{{ old('emp_id') }}">
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
                          <option value="{{ $pur->id }}">{{ $pur->purpose }}</option>
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
                    <input type="text" class="form-control" placeholder="Input Amount" name="adv_pay_amount" value="{{old('adv_pay_amount')}}" required>
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
                    <input type="text" class="form-control" placeholder="Input month" name="installes_month" value="{{old('installes_month')}}" required>
                    @if ($errors->has('installes_month'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('installes_month') }}</strong>
                        </span>
                    @endif
                  </div>
              </div>

            </div>
            <div class="card-footer card_footer_button text-center">
                <button type="submit" class="btn btn-primary waves-effect">SAVE</button>
            </div>
        </div>
      </form>
    </div>
    <div class="col-md-2"></div>
</div>

<!-- division list -->
<div class="row">
    <div class="col-lg-12">
      <div class="card">
          <div class="card-header">
              <div class="row">
                  <div class="col-md-8">
                      <h3 class="card-title card_top_title"><i class="fab fa-gg-circle"></i> Employee Advance List</h3>
                  </div>
                  <div class="clearfix"></div>
              </div>
          </div>
          <div class="card-body">
              <div class="row">
                  <div class="col-12">
                      <div class="table-responsive">
                          <table id="alltableinfo" class="table table-bordered custom_table mb-0">
                              <thead>
                                  <tr>
                                      <th>Employee Id</th>
                                      <th>Reason</th>
                                      <th>Advance Amount</th>
                                      <th>Installment Month</th>
                                      <th>Amount Per Month</th>
                                      <th>Manage</th>
                                  </tr>
                              </thead>
                              <tbody>
                                @foreach($all as $item)
                                  <tr>
                                    <td>{{ $item->employee->employee_id }}</td>
                                    <td>{{ $item->advPurpose->purpose }}</td>
                                    <td>{{ $item->adv_pay_amount }}</td>
                                    <td>{{ $item->installes_month}}</td>
                                    <td>{{ $item->installes_amount}}</td>
                                    <td>
                                      <a href="{{ route('edit-advance.pay',$item->adv_pay_id) }}" title="edit"><i class="fa fa-pencil-square fa-lg edit_icon"></i></a>
                                    </td>
                                  </tr>
                                 @endforeach
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </div>
</div>
@endsection
