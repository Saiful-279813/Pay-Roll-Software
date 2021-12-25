@extends('layouts.admin-master')
@section('title') Employee Leave Approval @endsection
@section('content')

<div class="row bread_part">
    <div class="col-sm-12 bread_col">
        <h4 class="pull-left page-title bread_title">Employee Leave Approval</h4>
        <ol class="breadcrumb pull-right">
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="active">Employee Leave Approval</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        @if(Session::has('success'))
          <div class="alert alert-success alertsuccess" role="alert">
             <strong>Successfully!</strong> Approve Employee Leave Application.
          </div>
        @endif
        @if(Session::has('success_soft'))
          <div class="alert alert-success alertsuccess" role="alert">
             <strong>Successfully!</strong> delete project information.
          </div>
        @endif

        @if(Session::has('success_update'))
          <div class="alert alert-success alertsuccess" role="alert">
             <strong>Successfully!</strong> update project information.
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
<!-- Application form -->
<div id="approver_form" class="d-none">
  <div class="row" >
      <div class="col-md-2"></div>
      <div class="col-md-8">
          <form class="form-horizontal" id="registration" method="post" action="{{ route('employee-leave.approve') }}">
            @csrf
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="card-title card_top_title"><i class="fab fa-gg-circle"></i> Employee Leave Approval</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="card-body card_form" style="padding-top: 0;">
                  <input type="hidden" id="leave_id" name="id" value="">
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
                        <input type="date" class="form-control"  id="end_date" name="end_date" value="{{old('end_date')}}" required min="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
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
                        <textarea name="description" class="form-control" disabled id="description" placeholder="Input Description" required>{{ old('description') }}</textarea>

                        @if ($errors->has('description'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                      </div>
                  </div>

                </div>
                <div class="card-footer card_footer_button text-center">
                    <button type="submit" class="btn btn-primary waves-effect">APPROVE</button>
                </div>
            </div>
          </form>
      </div>
      <div class="col-md-2"></div>
  </div>
</div>
<!-- Application List -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="card-title card_top_title"><i class="fab fa-gg-circle mr-2"></i>Employee Leave Approval</h3>
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
                                        <th>Employee Name</th>
                                        <th>Leave Days</th>
                                        <th>Leave Type</th>
                                        <th>Leave Reason</th>
                                        <th>Approve</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @forelse($all as $item)
                                    <tr>
                                        <td>{{ $item->employee->employee_id }}</td>
                                        <td>{{ $item->employee->employee_name }}</td>
                                        <td>{{ $item->required_day }}</td>
                                        <td>{{ $item->leaveType->lev_type_name }}</td>
                                        <td>{{ $item->leaveReason->lev_reas_name }}</td>
                                        <td>
                                            <a id="{{ $item->emleave_id }}" onclick="showApproverForm(this.id);" title="Show"><i class="fas fa-eye fa-lg view_icon"></i></a>
                                        </td>
                                    </tr>
                                  @empty
                                      <p class="data_not_found">Data Not Found</p>
                                  @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- date and days -->
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
