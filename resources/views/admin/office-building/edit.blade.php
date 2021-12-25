@extends('layouts.admin-master')
@section('title') Office Building @endsection
@section('content')
<div class="row bread_part">
    <div class="col-sm-12 bread_col">
        <h4 class="pull-left page-title bread_title">Office Building Information</h4>
        <ol class="breadcrumb pull-right">
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="active"> Office Building Information</li>
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
      <form class="form-horizontal" id="office_buildings-validation" action="{{ route('rent.new-building.update') }}" enctype="multipart/form-data" method="post">
        @csrf
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="card-title card_top_title"><i class="fab fa-gg-circle"></i> Update  Office Building Information</h3>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="card-body card_form" style="padding-top: 0;">
              <input type="hidden" name="id" value="{{ $edit->ofb_id }}">
              <div class="form-group custom_form_group">
                  <label class="control-label d-block" style="text-align: left;">Rent Date:<span class="req_star">*</span></label>
                  <div>
                      <input type="date" class="form-control" name="ofb_rent_date" value="{{ $edit->ofb_rent_date }}">
                  </div>
              </div>

              <div class="form-group custom_form_group">
                  <!-- <label class="control-label d-block" style="text-align: left;">Rent Form:<span class="req_star">*</span></label> -->
                  <div>
                      <input type="hidden" class="form-control" name="ofb_rent_form" value="{{ old('ofb_rent_form') }}" placeholder="Input Rent Form">
                  </div>
              </div>

              <div class="form-group custom_form_group">
                  <label class="control-label d-block" style="text-align: left;"> Owner Mobile:<span class="req_star">*</span></label>
                  <div>
                      <input type="text" class="form-control" name="ofb_owner_mobile" value="{{ $edit->ofb_owner_mobile }}" placeholder="Input Owner Mobile">
                  </div>
              </div>

              <div class="form-group custom_form_group">
                  <label class="control-label d-block" style="text-align: left;"> Amount Per Month:<span class="req_star">*</span></label>
                  <div>
                      <input type="text" class="form-control" name="ofb_rent_amount" value="{{ $edit->ofb_rent_amount }}" placeholder="Input Amount Per Month">
                  </div>
              </div>

              <div class="form-group custom_form_group">
                  <label class="control-label d-block" style="text-align: left;"> Advance Payment:<span class="req_star">*</span></label>
                  <div>
                      <input type="text" class="form-control" name="ofb_advance_amount" value="{{ $edit->ofb_advance_amount }}" placeholder="Input Advance Payment">
                  </div>
              </div>

              <div class="form-group custom_form_group">
                  <label class="control-label d-block" style="text-align: left;"> Agrement Date:<span class="req_star">*</span></label>
                  <div>
                      <input type="date" class="form-control" name="ofb_agrement_date" value="{{ $edit->ofb_agrement_date }}" placeholder="Input Agrement Date">
                  </div>
              </div>

              <div class="form-group custom_form_group">
                  <label class="control-label d-block" style="text-align: left;"> Experation Date:<span class="req_star">*</span></label>
                  <div>
                      <input type="date" class="form-control" name="ofb_experation_date" value="{{ $edit->ofb_experation_date }}" placeholder="Input Experation Date">
                  </div>
              </div>

              <div class="form-group custom_form_group">
                  <label class="control-label d-block" style="text-align: left;">Deed Photo:</label>
                  <div class="row">

                    <div class="col-sm-8">
                      <div class="input-group passfortFiles">
                          <span class="input-group-btn">
                              <span class="btn btn-default btn-file btnu_browse">
                                  Browse… <input type="file" name="ofb_dead_papers" id="imgInp4">
                              </span>
                          </span>
                          <input type="text" class="form-control" readonly>
                      </div>
                      <div class="col-sm-4" style="margin-top: 10px">
                          <img id='img-upload4' class="upload_image"/>
                      </div>
                    </div>
                    <input type="hidden" name="old_image" value="{{ $edit->ofb_dead_papers }}">
                    <div class="col-sm-4">
                        <img src="{{ asset($edit->ofb_dead_papers) }}" alt="" style="width:100px">
                    </div>

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
<!-- script area -->
<script type="text/javascript">
/* form validation */
$(document).ready(function(){
  $("#office_buildings-validation").validate({
    /* form tag off  */
    // submitHandler: function(form) { return false; },
    /* form tag off  */
    rules: {
      ofb_rent_date: {
        required : true,
      },
      ofb_agrement_date: {
        required : true,
      },
      ofb_experation_date: {
        required : true,
      },


      ofb_owner_mobile: {
        required : true,
        number: true,
        maxlength: 15,
      },

      ofb_rent_amount: {
        required : true,
        number: true,
        maxlength: 15,
      },
      ofb_advance_amount: {
        required : true,
        number: true,
        maxlength: 15,
      },

    },

    messages: {
      ofb_rent_date: {
        required : "You Must Be Select This Field!",
      },
      ofb_agrement_date: {
        required : "You Must Be Select This Field!",
      },
      ofb_experation_date: {
        required : "You Must Be Select This Field!",
      },
      ofb_owner_mobile: {
        required : "Please Input This Field!",
        number : "You Must Be Input Number!",
        max : "You Must Be Input Maximum Length 15!",
      },
      ofb_rent_amount: {
        required : "Please Input This Field!",
        number : "You Must Be Input Number!",
        max : "You Must Be Input Maximum Length 15!",
      },
      ofb_advance_amount: {
        required : "Please Input This Field!",
        number : "You Must Be Input Number!",
        max : "You Must Be Input Maximum Length 15!",
      },
    },

    errorPlacement: function(error, element)
    {
      if (element.is(":radio"))
      {
          error.appendTo(element.parents('.gender'));
      }
      else if(element.is(":file")){
          error.appendTo(element.parents('.passfortFiles'));
      }
      else
      {
          error.insertAfter( element );
      }

     }




  });
});
</script>


@endsection
