@extends('layouts.admin-master')
@section('title') Update System User Information @endsection
@section('internal-css')
  <style media="screen">
    .user-profile-image{
    	border-radius: 50%;
    	width: 150px;
    	height: 150px;
    	text-align: center;
    	margin: 0 auto 10px;
    }
  </style>
@endsection
@section('content')
<div class="row bread_part">
    <div class="col-sm-12 bread_col">
        <h4 class="pull-left page-title bread_title">Manage User Information</h4>
        <ol class="breadcrumb pull-right">
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="active"> Update User Information</li>
        </ol>
    </div>
</div>
<!-- add division -->
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        @if(Session::has('success'))
          <div class="alert alert-success alertsuccess" role="alert">
             <strong>Successfully!</strong> Change Password.
          </div>
        @endif
        @if(Session::has('success_update'))
          <div class="alert alert-success alertsuccess" role="alert">
             <strong>Successfully!</strong> Change User Role.
          </div>
        @endif
        @if(Session::has('passwordNotMatch'))
          <div class="alert alert-warning alerterror" role="alert">
             <strong>Opps!</strong> New Password & Confirmed Password Not Match!.
          </div>
        @endif
        @if(Session::has('oldPasswordNotMatch'))
          <div class="alert alert-warning alerterror" role="alert">
             <strong>Opps!</strong> Invalid Old Password.
          </div>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-md-4">
      @include('admin.manage-user.include.sidebar')
    </div>
    <div class="col-md-8">
      <form class="form-horizontal" id="registration" action="{{ route('updateRole') }}" method="post">
        @csrf
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="card-title card_top_title"><i class="fab fa-gg-circle"></i> Update User Information</h3>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="card-body card_form" style="padding-top: 0;">
              <input type="hidden" name="id" value="{{ $edit->id }}">

              <div class="form-group custom_form_group row">
                  <label class="control-label col-md-3">Employee ID:</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control" value="{{ $edit->employee->employee_id }}" disabled>
                  </div>
              </div>

              <div class="form-group custom_form_group row">
                  <label class="control-label col-md-3">Phone Number:</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control" value="{{ $edit->phone_number }}" disabled>
                  </div>
              </div>

              <div class="form-group custom_form_group row">
                  <label class="control-label col-md-3">User Role:<span class="req_star">*</span></label>
                  <div class="col-md-9">
                    <select class="form-control" id="role_id" name="role_id">
                      @foreach($role as $item)
                      <option value="{{ $item->role_auto_id }}" {{ $item->role_auto_id == $edit->role_id ? 'selected':'' }}>{{ $item->role_name }}</option>
                      @endforeach
                    </select>
                  </div>
              </div>


            </div>
            <div class="card-footer card_footer_button text-center">
                <button type="submit" class="btn btn-primary waves-effect">UPDATE</button>
            </div>
        </div>
      </form>
      {{-- password change --}}
      <form class="form-horizontal" id="registration" action="{{ route('password-change') }}" method="post">
        @csrf
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="card-title card_top_title"><i class="fab fa-gg-circle"></i> Change Password</h3>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="card-body card_form" style="padding-top: 0;">
              <input type="hidden" name="id" value="{{ $edit->id }}">

              <div class="form-group custom_form_group row{{ $errors->has('oldPassword') ? ' has-error' : '' }}">
                  <label class="control-label col-md-3"> Old Password:<span class="req_star">*</span></label>
                  <div class="col-md-8">
                    <div class="input-group" id="show_hide_password">
                      <input class="form-control" type="password" placeholder="********" id="oldPassword" name="oldPassword" required>
                      <div class="input-group-addon">
                        <a href="" style="color:#333"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                      </div>
                    </div>
                    @if ($errors->has('oldPassword'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('oldPassword') }}</strong>
                        </span>
                    @endif
                  </div>
              </div>

              <div class="form-group custom_form_group row{{ $errors->has('password') ? ' has-error' : '' }}">
                  <label class="control-label col-md-3">New Password:<span class="req_star">*</span></label>
                  <div class="col-md-8">
                    <div class="input-group" id="show_hide_password2">
                      <input class="form-control" type="password" placeholder="********" id="oldPassword" name="password" autocomplete="new-password" required>
                      <div class="input-group-addon">
                        <a href="" style="color:#333"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                      </div>
                    </div>
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
                    <div class="input-group" id="show_hide_password3">
                      <input class="form-control" type="password" placeholder="********" iid="password_confirmation" name="password_confirmation" required>
                      <div class="input-group-addon">
                        <a href="" style="color:#333"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                      </div>
                    </div>
                    @if ($errors->has('password_confirmation'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
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
