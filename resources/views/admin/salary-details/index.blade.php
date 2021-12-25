@extends('layouts.admin-master')
@section('title') Employee Salary List @endsection
@section('content')

<div class="row bread_part">
    <div class="col-sm-12 bread_col">
        <h4 class="pull-left page-title bread_title">Employee Salary</h4>
        <ol class="breadcrumb pull-right">
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="active">Employee Salary Details</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        @if(Session::has('success_soft'))
          <div class="alert alert-success alertsuccess" role="alert">
             <strong>Successfully!</strong> delete salary details.
          </div>
        @endif

        @if(Session::has('success_update'))
          <div class="alert alert-success alertsuccess" role="alert">
             <strong>Successfully!</strong> update salary details.
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
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="card-title card_top_title"><i class="fab fa-gg-circle"></i> Employee Salary List</h3>
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
                                        <th>Emp Id</th>
                                        <th>Emp Name</th>
                                        <th>Emp Type</th>
                                        <th>Basic Salary</th>
                                        <th>Basic Hours</th>
                                        <th>Hourly Rate</th>
                                        <th>Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach($all as $item)
                                    <tr>
                                        <td>{{ $item->employee->employee_id }}</td>
                                        <td>{{ $item->employee->employee_name }}</td>

                                        @if($item->employee->hourly_employee == 1)
                                          <td>Direct(Hourly)</td>
                                        @else
                                          <td>{{ $item->employee->emp_type_id == 1 ? 'Direct' : 'Indirect' }}</td>
                                        @endif

                                        <td>{{ $item->basic_amount }}</td>
                                        <td>{{ $item->basic_hours }}</td>
                                        <td>{{ $item->hourly_rent }}</td>
                                        <td>
                                            <a href="{{ route('salary-single-details',[$item->sdetails_id]) }}" title="view"><i class="fas fa-eye fa-lg view_icon"></i></a>


                                            <a href="{{ route('salary-single-edit',[$item->sdetails_id]) }}" title="edit"><i class="fa fa-pencil-square fa-lg edit_icon"></i></a>
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
