@extends('layouts.admin-master')
@section('title') Sponser @endsection
@section('content')
<div class="row bread_part">
    <div class="col-sm-12 bread_col">
        <h4 class="pull-left page-title bread_title">Sponser Information</h4>
        <ol class="breadcrumb pull-right">
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="active"> Sponser Information</li>
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
    <div class="col-md-3"></div>
    <div class="col-md-6">
      <form class="form-horizontal" id="vechicleForm-validation" action="{{ route('update.sponser') }}" method="post">
        @csrf
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="card-title card_top_title"><i class="fab fa-gg-circle"></i> Edit Sponser</h3>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="card-body card_form" style="padding-top: 0;">
              <input type="hidden" name="id" value="{{ $edit->spons_id }}">
              <div class="form-group custom_form_group">
                  <label class="control-label d-block" style="text-align: left;">Sponser name:<span class="req_star">*</span></label>
                  <div>
                      <input type="text" class="form-control" name="spons_name" value="{{ $edit->spons_name }}" placeholder="Input Sponsor Name">
                  </div>
              </div>

            </div>
            <div class="card-footer card_footer_button text-center">
                <button type="submit" class="btn btn-primary waves-effect">UPDATE</button>
            </div>
        </div>
      </form>
    </div>
    <div class="col-md-3"></div>
</div>


<script type="text/javascript">
/* form validation */
$(document).ready(function(){
  $("#vechicleForm-validation").validate({
    /* form tag off  */
    // submitHandler: function(form) { return false; },
    /* form tag off  */
    rules: {
      spons_name: {
        required : true,
      },
    },

    messages: {
      spons_name: {
        required : "You Must Be Input This Field!",
      },
    },
  });
});
</script>


@endsection
