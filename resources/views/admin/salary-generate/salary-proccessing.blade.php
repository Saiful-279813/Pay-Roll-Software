@extends('layouts.admin-master')
@section('title') Salary Processing @endsection
@section('content')

<div class="row bread_part">
    <div class="col-sm-12 bread_col">
        <h4 class="pull-left page-title bread_title"> Salary Processing </h4>
        <ol class="breadcrumb pull-right">
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="active"> Salary Processing</li>
        </ol>
    </div>
</div>
<!-- response Message -->
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        @if(Session::has('success'))
          <div class="alert alert-success alertsuccess" role="alert">
             <strong>Successfully!</strong> Salary Processing Done.
          </div>
        @endif
        @if(Session::has('not_record'))
          <div class="alert alert-warning alerterror" role="alert">
             <strong>Opps!</strong> Monthly Salary Record Not Found!.
          </div>
        @endif
        @if(Session::has('error'))
          <div class="alert alert-warning alerterror" role="alert">
             <strong>Opps!</strong> please try again!.
          </div>
        @endif
    </div>
    <div class="col-md-2"></div>
</div>
<!-- Form -->
<div class="row">
    <div class="col-lg-12">
        <form class="form-horizontal" id="registration" method="post" action="{{ route('salary-record.store') }}" >
          @csrf
          <div class="card">
              <div class="card-header"></div>
              <div class="card-body card_form">
                <div class="form-group row custom_form_group">
                    <label class="col-sm-3 control-label">Month:<span class="req_star">*</span></label>
                    <div class="col-sm-7">
                      <select class="form-control" name="month">
                        @foreach($month as $data)
                          <option value="{{ $data->month_id }}" {{ $data->month_id == $currentMonth ? 'selected' : "" }}>{{ $data->month_name }}</option>
                        @endforeach
                      </select>
                    </div>
                </div>
              </div>
              <div class="card-footer card_footer_button text-center">
                  <button type="submit" class="btn btn-primary waves-effect">Processing</button>
              </div>
          </div>
        </form>
    </div>
</div>
{{-- Diffrent Diffrent Category Wise Salary Generate --}}

<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
      <form class="form-horizontal" id="registration" target="_blank" action="{{ route('single-employee-salary-generat') }}" method="post">
        @csrf
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="card-title card_top_title salary-generat-heading"> Processing Salary for a Employee</h3>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="card-body card_form" style="padding-top: 0;">

              <div class="form-group custom_form_group{{ $errors->has('emp_id') ? ' has-error' : '' }}">
                  <label class="control-label d-block" style="text-align: left;">Employee ID:</label>
                  <div>
                    <input type="text" class="form-control typeahead" placeholder="Type Employee ID" name="emp_id" id="emp_id_search" onkeyup="empSearch()" onfocus="showResult()" onblur="hideResult()" value="{{ old('emp_id') }}">
                    @if ($errors->has('emp_id'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('emp_id') }}</strong>
                        </span>
                    @endif
                  </div>
                  <div id="showEmpId"></div>
              </div>

              <div class="form-group custom_form_group{{ $errors->has('month') ? ' has-error' : '' }}">
                  <label class="control-label d-block" style="text-align: left;">Select Month:</label>
                  <div>
                    <select class="form-control" name="month">
                        @foreach($month as $item)
                        <option value="{{ $item->month_id }}" {{ $item->month_id == Carbon\Carbon::now()->format('m') ? 'selected' :'' }}>{{ $item->month_name }}</option>
                        @endforeach
                    </select>

                    @if ($errors->has('month'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('month') }}</strong>
                        </span>
                    @endif
                  </div>
              </div>


            </div>
            <div class="card-footer card_footer_button text-center">
                <button type="submit" class="btn btn-primary waves-effect">Salary Process</button>
            </div>
        </div>
      </form>
    </div>
    <div class="col-md-2"></div>
</div>
<!-- All Employee Salary Generat -->
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
      <form class="form-horizontal" id="registration" target="_blank" action="{{ route('project-month-empType.wise-salary') }}" method="post">
        @csrf
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="card-title card_top_title salary-generat-heading"> Processing Salary for All Employees</h3>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="card-body card_form" style="padding-top: 0;">

              <div class="form-group custom_form_group">
                  <label class="control-label d-block" style="text-align: left;">Select Month:</label>
                  <div>
                    <select class="form-control" name="month" required>
                        @foreach($month as $item)
                        <option value="{{ $item->month_id }}" {{ $item->month_id == Carbon\Carbon::now()->format('m') ? 'selected' :'' }}>{{ $item->month_name }}</option>
                        @endforeach
                    </select>
                  </div>
              </div>

              <div class="form-group custom_form_group">
                  <label class="control-label d-block" style="text-align: left;">Select Project:</label>
                  <div>
                    <select class="form-control" name="proj_id" required>
                        @foreach($projects as $proj)
                        <option value="{{ $proj->proj_id }}" >{{ $proj->proj_name }}</option>
                        @endforeach
                    </select>
                  </div>
              </div>

              <div class="form-group custom_form_group">
                  <label class="control-label d-block" style="text-align: left;">Select Employee Type:</label>
                  <div>
                    <select class="form-control" name="emp_type_id" required>
                        @foreach($emp_types as $types)
                        <option value="{{ $types->id }}" >{{ $types->name }}</option>
                        @endforeach
                    </select>
                  </div>
              </div>


            </div>
            <div class="card-footer card_footer_button text-center">
                <button type="submit" class="btn btn-primary waves-effect">Salary Process</button>
            </div>
        </div>
      </form>
    </div>
    <div class="col-md-2"></div>
</div>
<!-- All Employee Salary Generat With out Project -->
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
      <form class="form-horizontal" id="registration" target="_blank" action="{{ route('all-emp.salary-without-project-emp-type') }}" method="post">
        @csrf
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="card-title card_top_title salary-generat-heading" >Processing Salary for All Employees With Out Project</h3>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="card-body card_form" style="padding-top: 0;">

              <div class="form-group custom_form_group">
                  <label class="control-label d-block" style="text-align: left;">Select Month:</label>
                  <div>
                    <select class="form-control" name="month" required>
                        @foreach($month as $item)
                        <option value="{{ $item->month_id }}" {{ $item->month_id == Carbon\Carbon::now()->format('m') ? 'selected' :'' }}>{{ $item->month_name }}</option>
                        @endforeach
                    </select>
                  </div>
              </div>


            </div>
            <div class="card-footer card_footer_button text-center">
                <button type="submit" class="btn btn-primary waves-effect">Salary Process</button>
            </div>
        </div>
      </form>
    </div>
    <div class="col-md-2"></div>
</div>



{{-- end section --}}
@endsection
