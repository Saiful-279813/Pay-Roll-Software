@extends('layouts.admin-master')
@section('title') Create Concern Company Information @endsection
@section('content')
<div class="row bread_part">
    <div class="col-sm-12 bread_col">
        <h4 class="pull-left page-title bread_title">Concern Company Information</h4>
        <ol class="breadcrumb pull-right">
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="active"> Concern Company</li>
        </ol>
    </div>
</div>
<!-- add division -->
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        @if(Session::has('success'))
          <div class="alert alert-success alertsuccess" role="alert">
             <strong>Successfully!</strong> Added Information.
          </div>
        @endif
        @if(Session::has('success_update'))
          <div class="alert alert-success alertsuccess" role="alert">
             <strong>Successfully!</strong> Update Information.
          </div>
        @endif
        @if(Session::has('delete'))
          <div class="alert alert-success alertsuccess" role="alert">
             <strong>Successfully!</strong> Delete This Information.
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
    <div class="col-md-3"></div>
    <div class="col-md-6">
      <form class="form-horizontal" id="registration" action="{{ route('insert-sub-company') }}" method="post">
        @csrf
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="card-title card_top_title"><i class="fab fa-gg-circle"></i> New Concern Company Details</h3>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="card-body card_form" style="padding-top: 0;">
              <div class="form-group custom_form_group{{ $errors->has('company_id') ? ' has-error' : '' }}">
                  <label class="control-label d-block" style="text-align: left;">Mother Company Name:<span class="req_star">*</span></label>
                  <div>
                    <select class="form-control" name="company_id" required>
                        <option value="">Select Here</option>
                        @foreach($comp as $com)
                        <option value="{{ $com->comp_id }}">{{ $com->comp_name_en }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('company_id'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('company_id') }}</strong>
                        </span>
                    @endif
                  </div>
              </div>
              <div class="form-group custom_form_group{{ $errors->has('sb_comp_name') ? ' has-error' : '' }}">
                  <label class="control-label d-block" style="text-align: left;">Company Name:<span class="req_star">*</span></label>
                  <div>
                    <input type="text" class="form-control" placeholder="Company Name" id="sb_comp_name" name="sb_comp_name" value="{{old('sb_comp_name')}}" required>
                    @if ($errors->has('sb_comp_name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('sb_comp_name') }}</strong>
                        </span>
                    @endif
                  </div>
              </div>
              <div class="form-group custom_form_group{{ $errors->has('sb_comp_mobile1') ? ' has-error' : '' }}">
                  <label class="control-label d-block" style="text-align: left;">Mobile Number 1:<span class="req_star">*</span></label>
                  <div>
                    <input type="text" class="form-control" placeholder="Mobile Number" id="sb_comp_mobile1" name="sb_comp_mobile1" value="{{old('sb_comp_mobile1')}}" required>
                    @if ($errors->has('sb_comp_mobile1'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('sb_comp_mobile1') }}</strong>
                        </span>
                    @endif
                  </div>
              </div>
              <div class="form-group custom_form_group{{ $errors->has('sb_comp_mobile2') ? ' has-error' : '' }}">
                  <label class="control-label d-block" style="text-align: left;">Mobile Number:<span class="req_star">*</span></label>
                  <div>
                    <input type="text" class="form-control" placeholder="Mobile Number" id="sb_comp_mobile2" name="sb_comp_mobile2" value="{{old('sb_comp_mobile2')}}" required>
                    @if ($errors->has('sb_comp_mobile2'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('sb_comp_mobile2') }}</strong>
                        </span>
                    @endif
                  </div>
              </div>
              <div class="form-group custom_form_group{{ $errors->has('sb_comp_email1') ? ' has-error' : '' }}">
                  <label class="control-label d-block" style="text-align: left;">Email Address 1:<span class="req_star">*</span></label>
                  <div>
                    <input type="email" class="form-control" placeholder="Email Address" id="sb_comp_email1" name="sb_comp_email1" value="{{old('sb_comp_email1')}}" required>
                    @if ($errors->has('sb_comp_email1'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('sb_comp_email1') }}</strong>
                        </span>
                    @endif
                  </div>
              </div>
              <div class="form-group custom_form_group{{ $errors->has('sb_comp_email2') ? ' has-error' : '' }}">
                  <label class="control-label d-block" style="text-align: left;">Email Address 2:<span class="req_star">*</span></label>
                  <div>
                    <input type="email" class="form-control" placeholder="Email Address" id="sb_comp_email2" name="sb_comp_email2" value="{{old('sb_comp_email2')}}" required>
                    @if ($errors->has('sb_comp_email2'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('sb_comp_email2') }}</strong>
                        </span>
                    @endif
                  </div>
              </div>
              <div class="form-group custom_form_group{{ $errors->has('sb_comp_phone1') ? ' has-error' : '' }}">
                  <label class="control-label d-block" style="text-align: left;">Phone Number:<span class="req_star">*</span></label>
                  <div>
                    <input type="text" class="form-control" placeholder="Phone Number" id="sb_comp_phone1" name="sb_comp_phone1" value="{{old('sb_comp_phone1')}}" required>
                    @if ($errors->has('sb_comp_phone1'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('sb_comp_phone1') }}</strong>
                        </span>
                    @endif
                  </div>
              </div>
              <div class="form-group custom_form_group{{ $errors->has('sb_comp_phone2') ? ' has-error' : '' }}">
                  <label class="control-label d-block" style="text-align: left;">Phone Number 2:<span class="req_star">*</span></label>
                  <div>
                    <input type="text" class="form-control" placeholder="Phone Number" id="sb_comp_phone2" name="sb_comp_phone2" value="{{old('sb_comp_phone2')}}" required>
                    @if ($errors->has('sb_comp_phone2'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('sb_comp_phone2') }}</strong>
                        </span>
                    @endif
                  </div>
              </div>
              <div class="form-group custom_form_group{{ $errors->has('sb_comp_address') ? ' has-error' : '' }}">
                  <label class="control-label d-block" style="text-align: left;">Address:<span class="req_star">*</span></label>
                  <div>
                    <textarea name="sb_comp_address" class="form-control" required>{{old('sb_comp_address')}}</textarea>
                    @if ($errors->has('sb_comp_address'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('sb_comp_address') }}</strong>
                        </span>
                    @endif
                  </div>
              </div>
              <div class="form-group custom_form_group{{ $errors->has('details') ? ' has-error' : '' }}">
                  <label class="control-label d-block" style="text-align: left;">Contact Person Details:<span class="req_star">*</span></label>
                  <div>
                    <textarea name="details" class="form-control" required>{{old('details')}}</textarea>
                    @if ($errors->has('details'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('details') }}</strong>
                        </span>
                    @endif
                  </div>
              </div>
            </div>
            <div class="card-footer card_footer_button text-center">
                <button type="submit" class="btn btn-primary waves-effect">CREATE</button>
            </div>
        </div>
      </form>
    </div>
    <div class="col-md-3"></div>
</div>

<!-- division list -->
<div class="row">
    <div class="col-lg-12">
      <div class="card">
          <div class="card-header">
              <div class="row">
                  <div class="col-md-8">
                      <h3 class="card-title card_top_title"><i class="fab fa-gg-circle"></i> Concern Company List</h3>
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
                                      <th>Company Name</th>
                                      <th>Mobile No</th>
                                      <th>Email Address</th>
                                      <th>Phone No</th>
                                      <th>Manage</th>
                                  </tr>
                              </thead>
                              <tbody>
                                @foreach($all as $item)
                                  <tr>
                                    <td>{{ $item->sb_comp_name }}</td>
                                    <td>{{ $item->sb_comp_mobile1 }}</td>
                                    <td>{{ $item->sb_comp_email1 }}</td>
                                    <td>{{ $item->sb_comp_phone1 }}</td>
                                    <td>
                                      <a href="{{ route('view-info',$item->sb_comp_id) }}" title="view"><i class="fa fa-plus-square fa-lg view_icon"></i></a>
                                      <a href="{{ route('edit-info',$item->sb_comp_id) }}" title="edit"><i class="fa fa-pencil-square fa-lg edit_icon"></i></a>
                                      <a href="{{ route('delete-info',$item->sb_comp_id) }}" title="delete"  id="delete" title="delete data"><i class="fa fa-trash fa-lg delete_icon"></i></a>
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
