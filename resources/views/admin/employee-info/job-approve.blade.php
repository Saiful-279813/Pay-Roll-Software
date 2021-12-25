@extends('layouts.admin-master')
@section('title') Unapproval Employee list @endsection
@section('internal-css')
  <style media="screen">
  .approve_button {
      background: #2B4049;
      color: #fff;
      font-size: 12px;
      padding: 3px 6px;
      border-radius: 5px;
  }
  .approve_button:hover {
      color: #fff;
  }
  </style>
@endsection
@section('content')

<div class="row bread_part">
    <div class="col-sm-12 bread_col">
        <h4 class="pull-left page-title bread_title">Unapproval Employee List</h4>
        <ol class="breadcrumb pull-right">
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="active">Unapproval Employee</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-7">
        @if(Session::has('approve'))
          <div class="alert alert-success alertsuccess" role="alert">
             <strong>Successfully!</strong> Approve in Employee Job.
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
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="alltableinfo" class="table table-bordered custom_table mb-0">
                                <thead>
                                    <tr>
                                        <th>Emp Id</th>
                                        <th>Name</th>
                                        <th>Country</th>
                                        <th>Employee Type</th>
                                        <th>Profile Photo</th>
                                        <th>Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach($all as $item)
                                    <tr>
                                        <td>{{ $item->employee_id }}</td>
                                        <td>{{Str::words($item->employee_name,3)}}</td>
                                        @if($item->country_id == NULL)
                                          <td>Not Assigned</td>
                                        @else
                                        <td>{{ $item->country->country_name }}</td> <!--country-->
                                       @endif
                                        <td>{{ $item->emp_type_id == NULL ? 'Not Assigned' : $item->employeeType->name }}</td> <!--employeeType-->
                                        <td>
                                            <img src="{{ asset($item->profile_photo) }}" alt="Not Assigned" width="80">
                                        </td>
                                        <td>
                                            <a href="{{ route('employee-job-approve.success',$item->emp_auto_id) }}" title="Approve" class="approve_button">Approve</a>
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
