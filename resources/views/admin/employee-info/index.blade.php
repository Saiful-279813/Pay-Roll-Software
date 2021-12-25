@extends('layouts.admin-master')
@section('title') Employee list @endsection
@section('content')

<div class="row bread_part">
    <div class="col-sm-12 bread_col">
        <h4 class="pull-left page-title bread_title">Employee information</h4>
        <ol class="breadcrumb pull-right">
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="active">Employee Information</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="card-title card_top_title"><i class="fab fa-gg-circle"></i> Employees List </h3>
                    </div>
                    <div class="col-md-4 text-right">
                        <a href="{{ route('add-employee') }}" class="btn btn-md btn-primary waves-effect card_top_button"><i class="fa fa-plus-circle"></i> Add New Employee</a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-7">
                        @if(Session::has('success_update'))
                          <div class="alert alert-success alertsuccess" role="alert">
                             <strong>Successfully!</strong> Update Employee Information.
                          </div>
                        @endif
                        @if(Session::has('success_soft'))
                          <div class="alert alert-success alertsuccess" role="alert">
                             <strong>Successfully!</strong> delete banner information.
                          </div>
                        @endif
                        @if(Session::has('success_publish'))
                          <div class="alert alert-success alertsuccess" role="alert">
                             <strong>Successfully!</strong> publish banner information.
                          </div>
                        @endif
                        @if(Session::has('success_update_image'))
                          <div class="alert alert-success alertsuccess" role="alert">
                             <strong>Successfully!</strong> Update New Image.
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
                                            <!-- <a href="{{ url('admin/employee/view/'.$item->emp_auto_id) }}" title="view"><i class="fas fa-eye fa-lg view_icon"></i></a> -->
                                            <a href="#" title="view"><i class="fas fa-eye fa-lg view_icon"></i></a>
                                            <a href="{{ url('admin/employee/edit/'.$item->emp_auto_id) }}" title="edit"><i class="fa fa-pencil-square fa-lg edit_icon"></i></a>
                                            <!-- <a href="#" title="delete" id="softDelete" data-toggle="modal" data-target="#softDelModal" data-id="#"><i class="fa fa-trash fa-lg delete_icon"></i></a> -->
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer card_footer_expode">
                <a href="#" class="btn btn-secondary waves-effect">PRINT</a>
                <a href="#" class="btn btn-warning waves-effect">EXCEL</a>
                <a href="#" class="btn btn-success waves-effect">PDF</a>
            </div>
        </div>
    </div>
</div>
<!--Delete Modal Information-->
<div id="softDelModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none">
    <div class="modal-dialog">
        <div class="modal-content p-0 b-0">
            <form method="post" action="">
              @csrf
              <div class="card mb-0">
                <div class="card-header">
                    <h3 class="card-title float-left"><i class="fa fa-gg-circle"></i> Confirm Message</h3>
                </div>
                <div class="card-body modal_card">
                  Are you sure you want to delete?
                  <input type="hidden" id="modal_id" name="modal_id">
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-sm btn-dark waves-effect">Confirm</button>
                    <button type="button" class="btn btn-sm btn-danger waves-effect" data-dismiss="modal">Close</button>
                </div>
              </div>
            </form>
        </div>
    </div>
</div>
<!--Publish Modal Information-->
<div id="publishModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none">
    <div class="modal-dialog">
        <div class="modal-content p-0 b-0">
            <form method="post" action="">
              @csrf
              <div class="card mb-0">
                <div class="card-header">
                    <h3 class="card-title float-left"><i class="fa fa-gg-circle"></i> Confirm Message</h3>
                </div>
                <div class="card-body modal_card">
                  Are you sure you want to publish banner?
                  <input type="hidden" id="modal_id" name="modal_id">
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-sm btn-dark waves-effect">Confirm</button>
                    <button type="button" class="btn btn-sm btn-danger waves-effect" data-dismiss="modal">Close</button>
                </div>
              </div>
            </form>
        </div>
    </div>
</div>
<!--Unpublish Modal Information-->
<div id="unPubModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none">
    <div class="modal-dialog">
        <div class="modal-content p-0 b-0">
            <form method="post" action="">
              @csrf
              <div class="card mb-0">
                <div class="card-header">
                    <h3 class="card-title float-left"><i class="fa fa-gg-circle"></i> Confirm Message</h3>
                </div>
                <div class="card-body modal_card">
                  Are you sure you want to unpublish banner?
                  <input type="hidden" id="modal_id" name="modal_id">
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-sm btn-dark waves-effect">Confirm</button>
                    <button type="button" class="btn btn-sm btn-danger waves-effect" data-dismiss="modal">Close</button>
                </div>
              </div>
            </form>
        </div>
    </div>
</div>

@endsection
