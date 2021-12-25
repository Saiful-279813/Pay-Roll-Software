@extends('layouts.admin-master')
@section('title') Management User @endsection
@section('content')
<div class="row bread_part">
    <div class="col-sm-12 bread_col">
        <h4 class="pull-left page-title bread_title"> Manage User</h4>
        <ol class="breadcrumb pull-right">
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="active"> Management User</li>
        </ol>
    </div>
</div>
<!-- add division -->
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        @if(Session::has('success'))
          <div class="alert alert-success alertsuccess" role="alert">
             <strong>Successfully!</strong> Created New User.
          </div>
        @endif
        @if(Session::has('success_update'))
          <div class="alert alert-success alertsuccess" role="alert">
             <strong>Successfully!</strong> Update User Information.
          </div>
        @endif
        @if(Session::has('delete'))
          <div class="alert alert-success alertsuccess" role="alert">
             <strong>Successfully!</strong> Delete User Information.
          </div>
        @endif
        @if(Session::has('error'))
          <div class="alert alert-warning alerterror" role="alert">
             <strong>Opps!</strong> please try again.
          </div>
        @endif
        @if(Session::has('duplicate'))
          <div class="alert alert-warning alerterror" role="alert">
             <strong>Opps!</strong> This User All-Ready Exist.
          </div>
        @endif
    </div>
    <div class="col-md-1"></div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="card-title card_top_title"><i class="fab fa-gg-circle"></i> New User</h3>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

              <div class="card-body card_form">
                <div class="form-group row custom_form_group">
                    <label class="col-sm-3 control-label">Employee ID:</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control typeahead" placeholder="Type Employee ID" name="emp_id" id="emp_id_search" onkeyup="empSearch()" onfocus="showResult()" onblur="hideResult()">
                      <div id="showEmpId"></div>
                    </div>
                    <div class="col-sm-3">
                        <button type="submit" onclick="searchEmployeeDetails()" style="margin-top: 2px" class="btn btn-primary waves-effect">SEARCH</button>
                    </div>
                </div>
                <!-- show employee information -->
                <div class="col-md-12">
                  <div id="showEmployeeDetails" class="d-none" style="margin-top:0">
                      <!-- promosion form -->
                      <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                          <form style="margin-top:20px" class="form-horizontal" id="registration" action="{{ route('manage-user.insert') }}" method="post">
                            @csrf
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h3 class="card-title card_top_title"><i class="fab fa-gg-circle"></i>  User Details</h3>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="card-body card_form" style="padding-top: 0;">

                                  <!-- hidden input -->
                                  <input type="hidden" id="input_emp_id_in_desig" name="emp_id" value="">
                                  <input type="hidden" id="hidden_input_emp_name_in_user" name="employee_name" value="">
                                  <input type="hidden" id="hidden_input_emp_mobile_in_user" name="phone_number" value="">
                                  <input type="hidden" id="hidden_input_emp_email_in_user" name="email" value="">
                                  <!-- show input -->
                                  <div class="form-group row custom_form_group">
                                      <label class="control-label col-md-3">Name:</label>
                                      <div class="col-md-8">
                                          <input type="text" class="form-control" id="show_input_emp_name_in_user" disabled>
                                      </div>
                                  </div>
                                  <div class="form-group row custom_form_group">
                                      <label class="control-label col-md-3">Employee Category:</label>
                                      <div class="col-md-8">
                                          <input type="text" class="form-control" id="show_input_emp_category_in_user" disabled>
                                      </div>
                                  </div>
                                  <div class="form-group row custom_form_group">
                                      <label class="control-label col-md-3">User Name:</label>
                                      <div class="col-md-8">
                                          <input type="text" class="form-control" id="show_input_emp_mobile_in_user" disabled>
                                      </div>
                                  </div>
                                  <div class="form-group custom_form_group row{{ $errors->has('role_id') ? ' has-error' : '' }}">
                                      <label class="control-label col-md-3">User Role:</label>
                                      <div class="col-md-8">
                                        <select class="form-control" id="role_id" name="role_id" required>
                                          <option value="">Select Role</option>
                                          @foreach($role as $item)
                                          <option value="{{ $item->role_auto_id }}">{{ $item->role_name }}</option>
                                          @endforeach
                                        </select>

                                        @if ($errors->has('role_id'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('role_id') }}</strong>
                                            </span>
                                        @endif
                                      </div>
                                  </div>

                                  <div class="form-group custom_form_group row{{ $errors->has('password') ? ' has-error' : '' }}">
                                      <label class="control-label col-md-3">Password:<span class="req_star">*</span></label>
                                      <div class="col-md-8">
                                        <input type="password" class="form-control" placeholder="********" id="password" name="password" autocomplete="new-password" required>
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                      </div>
                                  </div>

                                  <div class="form-group custom_form_group row{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                      <label class="control-label col-md-3"> Confirmed Password:<span class="req_star">*</span></label>
                                      <div class="col-md-8">
                                        <input type="password" class="form-control" placeholder="********" id="password_confirmation" name="password_confirmation" required>
                                        @if ($errors->has('password_confirmation'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                                            </span>
                                        @endif
                                      </div>
                                  </div>

                                </div>
                                <div class="card-footer card_footer_button text-center">
                                    <button type="submit" class="btn btn-primary waves-effect">Create User</button>
                                </div>
                            </div>
                          </form>
                        </div>
                        <div class="col-md-1"></div>
                      </div>
                  </div>
                </div>
              </div>

            <div class="card-footer card_footer_button text-center">
                .
            </div>
        </div>
    </div>
    <div class="col-md-1"></div>
</div>

<!-- User list -->
<div class="row">
    <div class="col-lg-12">
      <div class="card">
          <div class="card-header">
              <div class="row">
                  <div class="col-md-8">
                      <h3 class="card-title card_top_title"><i class="fab fa-gg-circle"></i> User List</h3>
                  </div>
                  <div class="clearfix"></div>
              </div>
          </div>
          <div class="card-body">
              <div class="row">
                  <div class="col-12">
                      <div class="table-responsive">
                          <table id="alltableinfo" class="responsive table table-bordered custom_table mb-0">
                              <thead>
                                  <tr>
                                      <th>Name</th>
                                      <th>Mobile</th>
                                      <th>Role</th>
                                      <th>Photo</th>
                                      <th>Manage</th>
                                  </tr>
                              </thead>
                              <tbody>
                                @foreach($all as $item)
                                  <tr>
                                    <td>{{ $item->employee->employee_name }}</td>
                                    <td>{{ $item->phone_number }}</td>
                                    <td>{{ $item->role->role_name }}</td>
                                    <td>
                                      <img src="{{ asset('uploads/employee/'.$item->employee->profile_photo) }}" alt="{{ $item->employee->employee_name }}" width="50">
                                    </td>
                                    <td>
                                      <div style="display:flex;">
                                        <a onclick="userActiveInactive(this.id)" id="{{ $item->id }}" title="edit">
                                          <div class="form-check form-switch d-inline-block" style="margin-left: 20px;">
                                            <input style="cursor:pointer" class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" {{ $item->status == 0 ? 'checked' :'' }}  {{ $item->status == 0 ? ' value="0" ' : ' value="1" ' }}>
                                          </div>
                                        </a>
                                        <a href="{{ route('edit-manage.user',[$item->id]) }}" title="edit"><i class="fa fa-pencil-square fa-lg edit_icon mr-2"></i></a>
                                        <a href="{{ route('delete-manage.user',[$item->id]) }}" title="delete" id="delete"><i class="fa fa-trash fa-lg delete_icon"></i></a>
                                      </div>
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
<!-- script section -->
@section('manageUser')
<script type="text/javascript">
  function userActiveInactive(id){
    // var attr = $("#flexSwitchCheckChecked").val();
    // alert(attr);

    var user_id = id;

    $.ajax({
      type:'POST',
      url: "{{ route('user-active.inactive') }}",
      data:{ user_id:user_id },
      dataType:'json',
      success:function(data){
        if(data.value == 0){
          $("input[id='flexSwitchCheckChecked']").attr('checked');
        }else{
          $("input[id='flexSwitchCheckChecked']").attr('');
        }


        //  start message
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        })
        if($.isEmptyObject(data.error)){
            Toast.fire({
              type: 'success',
              title: data.success
            })
        }else{
          Toast.fire({
            type: 'error',
            title: data.error
          })
        }
        //  end message




        /* ====================================================================*/
      }

    });
  }



</script>
@endsection
