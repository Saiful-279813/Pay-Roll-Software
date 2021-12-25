@extends('layouts.admin-master')
@section('title') Employee Leave Form @endsection
@section('content')
<div class="row bread_part">
    <div class="col-sm-12 bread_col">
        <h4 class="pull-left page-title bread_title">Employee Leave Form</h4>
        <ol class="breadcrumb pull-right">
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="active"> Employee Leave Form</li>
        </ol>
    </div>
</div>
<!-- add division -->
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        @if(Session::has('success'))
          <div class="alert alert-success alertsuccess" role="alert">
             <strong>Successfully!</strong> Apply Your Application.
          </div>
        @endif
        @if(Session::has('success_update'))
          <div class="alert alert-success alertsuccess" role="alert">
             <strong>Successfully!</strong> Update Your Application.
          </div>
        @endif
        @if(Session::has('delete'))
          <div class="alert alert-success alertsuccess" role="alert">
             <strong>Successfully!</strong> Delete Your Application.
          </div>
        @endif
        @if(Session::has('error'))
          <div class="alert alert-warning alerterror" role="alert">
             <strong>Opps!</strong> please try again.
          </div>
        @endif
        @if(Session::has('error_exist'))
          <div class="alert alert-warning alerterror" role="alert">
             <strong>Opps!</strong> You Already Apply For Leave.
          </div>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
      <form class="form-horizontal" id="registration" action="{{ route('employee-leave-application') }}" method="post">
        @csrf
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="card-title card_top_title"><i class="fab fa-gg-circle"></i> Employee Leave Form</h3>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="card-body card_form" style="padding-top: 0;">

              <div class="form-group custom_form_group{{ $errors->has('leave_type_id') ? ' has-error' : '' }}">
                  <label class="control-label d-block" style="text-align: left;">Leave Type:<span class="req_star">*</span></label>
                  <div>
                    <select class="form-control" name="leave_type_id" required>
                      <option value="">Select Leave Type</option>
                      @foreach($allType as $type)
                      <option value="{{ $type->lev_type_id }}">{{ $type->lev_type_name }}</option>
                      @endforeach
                    </select>
                    @if ($errors->has('leave_type_id'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('leave_type_id') }}</strong>
                        </span>
                    @endif
                  </div>
              </div>

              <div class="form-group custom_form_group{{ $errors->has('leave_reason_id') ? ' has-error' : '' }}">
                  <label class="control-label d-block" style="text-align: left;">Leave Reason:<span class="req_star">*</span></label>
                  <div>
                    <select class="form-control" name="leave_reason_id" required>
                      <option value="">Select Leave Reason</option>
                      @foreach($allReason as $reason)
                      <option value="{{ $reason->lev_reas_id }}">{{ $reason->lev_reas_name }}</option>
                      @endforeach
                    </select>
                    @if ($errors->has('leave_reason_id'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('leave_reason_id') }}</strong>
                        </span>
                    @endif
                  </div>
              </div>

              <div class="form-group custom_form_group{{ $errors->has('start_date') ? ' has-error' : '' }}">
                  <label class="control-label d-block" style="text-align: left;">Start Date:<span class="req_star">*</span></label>
                  <div>
                    <input type="date" class="form-control"  id="start_date" name="start_date" value="{{old('start_date')}}" required min="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                    @if ($errors->has('start_date'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('start_date') }}</strong>
                        </span>
                    @endif
                  </div>
              </div>

              <div class="form-group custom_form_group{{ $errors->has('end_date') ? ' has-error' : '' }}">
                  <label class="control-label d-block" style="text-align: left;">End Date:<span class="req_star">*</span></label>
                  <div>
                    <input type="date" class="form-control"  id="end_date" name="end_date" value="{{old('end_date')}}" required min="{{ Carbon\Carbon::now()->addDays(1)->format('Y-m-d') }}">
                    <span id="error_invalid_date" class="error"></span>
                    @if ($errors->has('end_date'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('end_date') }}</strong>
                        </span>
                    @endif
                  </div>
              </div>

              <div class="form-group custom_form_group">
                  <label class="control-label d-block" style="text-align: left;">Total Day:</label>
                  <div>
                    <input type="text" required class="form-control" onclick="EmpLeaveDays()" name="required_day" placeholder="Input Total Days" id="show_days" value="">
                  </div>
              </div>

              <div class="form-group custom_form_group{{ $errors->has('description') ? ' has-error' : '' }}">
                  <label class="control-label d-block" style="text-align: left;">Description:<span class="req_star">*</span></label>
                  <div>
                    <textarea name="description" class="form-control" placeholder="Input Description" required>{{ old('description') }}</textarea>

                    @if ($errors->has('description'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                    @endif
                  </div>
              </div>



            </div>
            <div class="card-footer card_footer_button text-center">
                <button type="submit" class="btn btn-primary waves-effect">Apply</button>
            </div>
        </div>
      </form>
    </div>
    <div class="col-md-2"></div>
</div>

<script type="text/javascript">
    function EmpLeaveDays(){
      var start_date = $("#start_date").val();
      var end_date = $("#end_date").val();

      var st_date = new Date(start_date);
      var en_date = new Date(end_date);
      var total = (en_date - st_date);
      var days = total/1000/60/60/24;

      if(en_date < st_date){
        $("span[id='error_invalid_date']").html('Invalid Date!');
      }else{
        $("#show_days").val(days).prop('disabled', true);
        $("#start_date").click(function(){
          $("#show_days").val(days).prop('disabled', false);
        });
      }
    }
</script>


@endsection
