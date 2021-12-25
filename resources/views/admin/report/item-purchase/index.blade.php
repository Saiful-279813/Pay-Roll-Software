@extends('layouts.admin-master')
@section('title') Report Metarials & Tools Purchase @endsection
@section('content')
<div class="row bread_part">
    <div class="col-sm-12 bread_col">
        <h4 class="pull-left page-title bread_title">Report Metarials & Tools Purchase</h4>
        <ol class="breadcrumb pull-right">
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="active"> Report Metarials & Tools Purchase</li>
        </ol>
    </div>
</div>
<!-- add division -->
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
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
      <form class="form-horizontal" id="registration" target="_blank" action="{{ route('tools-metarials-process') }}" method="post">
        @csrf
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="card-title card_top_title"><i class="fab fa-gg-circle"></i> Metarials & Tools Purchase</h3>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="card-body card_form" style="padding-top: 0;">

              <div class="form-group row custom_form_group{{ $errors->has('itype_id') ? ' has-error' : '' }}">
                  <label class="control-label col-sm-3 custom-control-label">Item Type:<span class="req_star">*</span></label>
                  <div class="col-sm-7">
                    <select class="form-control custom-form-control" name="itype_id" id="itype_id">
                        <option value="">Select Item Type</option>
                        @foreach($allType as $type)
                        <option value="{{ $type->itype_id }}">{{ $type->itype_name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('itype_id'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('itype_id') }}</strong>
                        </span>
                    @endif
                  </div>
              </div>

              <div class="form-group row custom_form_group{{ $errors->has('icatg_id') ? ' has-error' : '' }}">
                  <label class="control-label col-md-3 custom-control-label">Category Name:<span class="req_star">*</span></label>
                  <div class="col-md-7">
                    <select class="form-control custom-form-control" name="icatg_id" id="icatg_id">
                        <option value="">Select Category Name</option>
                    </select>
                    @if ($errors->has('icatg_id'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('icatg_id') }}</strong>
                        </span>
                    @endif
                  </div>
              </div>

              <div class="form-group row custom_form_group{{ $errors->has('iscatg_id') ? ' has-error' : '' }}">
                  <label class="control-label col-md-3 custom-control-label">Sub Category Name:<span class="req_star">*</span></label>
                  <div class="col-md-7">
                    <select class="form-control custom-form-control" name="iscatg_id" id="iscatg_id">
                        <option value="">Select Sub Category</option>
                    </select>
                    @if ($errors->has('iscatg_id'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('iscatg_id') }}</strong>
                        </span>
                    @endif
                  </div>
              </div>


              <div class="row">
                  <div class="col-md-2"></div>
                  <div class="col-md-4">
                    <div class="form-group custom_form_group">
                        <label class="control-label d-block" style="text-align: left;">Start Date:</label>
                        <div>
                            <input type="date" class="form-control" name="start_date" value="{{ old('start_date') }}" required>
                        </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group custom_form_group">
                        <label class="control-label d-block" style="text-align: left;">End Date:</label>
                        <div>
                            <input type="date" class="form-control" name="end_date" value="{{ old('end_date') }}" required>
                        </div>
                    </div>
                  </div>
                  <div class="col-md-2"></div>
              </div>
            </div>
            <div class="card-footer card_footer_button text-center">
                <button type="submit" class="btn btn-primary waves-effect">PROCESS</button>
            </div>
        </div>
      </form>
    </div>
  <div class="col-md-2"></div>
</div>
<!-- script area -->
<script type="text/javascript">
$(document).ready(function() {
  $('select[name="itype_id"]').on('change', function(){
      var itype_id = $(this).val();
      if(itype_id) {
          $.ajax({
              url: "{{  url('/admin/item/category/ajax') }}/"+itype_id,
              type:"GET",
              dataType:"json",
              success:function(data) {
                 var d =$('select[name="icatg_id"]').empty();
                    $.each(data, function(key, value){

                        $('select[name="icatg_id"]').append('<option value="'+ value.icatg_id +'">' + value.icatg_name + '</option>');

                    });

              },

          });
      } else{

      }

  });
  /* call sub category */
  /* call district */
  $('select[name="icatg_id"]').on('change', function(){
      var icatg_id = $(this).val();
      if(icatg_id) {
          $.ajax({
              url: "{{  url('/admin/item/sub-category/ajax') }}/"+icatg_id,
              type:"GET",
              dataType:"json",
              success:function(data) {
                   $('select[name="iscatg_id"]').empty();
                    $.each(data, function(key, value){
                        $('select[name="iscatg_id"]').append('<option value="'+ value.iscatg_id +'">' + value.iscatg_name + '</option>');
                    });

              },

          });
      } else {
          alert('danger');
      }
  });

});
</script>

@endsection
