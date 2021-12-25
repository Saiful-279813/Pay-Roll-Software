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
        @if(Session::has('success'))
          <div class="alert alert-success alertsuccess" role="alert">
             <strong>Successfully!</strong> Added New Office Building Information.
          </div>
        @endif
        @if(Session::has('success_update'))
          <div class="alert alert-success alertsuccess" role="alert">
             <strong>Successfully!</strong> Update Office Building Information.
          </div>
        @endif
        @if(Session::has('delete'))
          <div class="alert alert-success alertsuccess" role="alert">
             <strong>Successfully!</strong> Delete Office Building Information.
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
      <form class="form-horizontal" id="office_buildings-validation" action="{{ route('rent.new-building.insert') }}" enctype="multipart/form-data" method="post">
        @csrf
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="card-title card_top_title"><i class="fab fa-gg-circle"></i> Add  Office Building Information</h3>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="card-body card_form" style="padding-top: 0;">

              <div class="form-group custom_form_group">
                  <label class="control-label d-block" style="text-align: left;">Rent Date:<span class="req_star">*</span></label>
                  <div>
                      <input type="date" class="form-control" name="ofb_rent_date" value="{{ old('ofb_rent_date') }}">
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
                      <input type="text" class="form-control" name="ofb_owner_mobile" value="{{ old('ofb_owner_mobile') }}" placeholder="Input Owner Mobile">
                  </div>
              </div>

              <div class="form-group custom_form_group">
                  <label class="control-label d-block" style="text-align: left;"> Amount Per Month:<span class="req_star">*</span></label>
                  <div>
                      <input type="text" class="form-control" name="ofb_rent_amount" value="{{ old('ofb_rent_amount') }}" placeholder="Input Amount Per Month">
                  </div>
              </div>

              <div class="form-group custom_form_group">
                  <label class="control-label d-block" style="text-align: left;"> Advance Payment:<span class="req_star">*</span></label>
                  <div>
                      <input type="text" class="form-control" name="ofb_advance_amount" value="{{ old('ofb_advance_amount') }}" placeholder="Input Advance Payment">
                  </div>
              </div>

              <div class="form-group custom_form_group">
                  <label class="control-label d-block" style="text-align: left;"> Agrement Date:<span class="req_star">*</span></label>
                  <div>
                      <input type="date" class="form-control" name="ofb_agrement_date" value="{{ old('ofb_agrement_date') }}" placeholder="Input Agrement Date">
                  </div>
              </div>

              <div class="form-group custom_form_group">
                  <label class="control-label d-block" style="text-align: left;"> Experation Date:<span class="req_star">*</span></label>
                  <div>
                      <input type="date" class="form-control" name="ofb_experation_date" value="{{ old('ofb_experation_date') }}" placeholder="Input Experation Date">
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

                  </div>
              </div>



            </div>
            <div class="card-footer card_footer_button text-center">
                <button type="submit" class="btn btn-primary waves-effect">SAVE</button>
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
                      <h3 class="card-title card_top_title"><i class="fab fa-gg-circle"></i> Office Building List</h3>
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
                                    <th>Rent Date</th>
                                    <th>Owner Mobile</th>
                                    <th>Amount (Per Month) </th>
                                    <th>Advance Amount</th>
                                    <th>Agrement Date</th>
                                    <th>Experation Date</th>
                                    <th>Dead Pepars</th>
                                    <th>Manage</th>
                                  </tr>
                              </thead>
                              <tbody>
                                @foreach($all as $item)
                                  <tr>
                                    <td> {{ $item->ofb_rent_date }} </td>
                                    <td> {{ $item->ofb_owner_mobile }} </td>
                                    <td> {{ $item->ofb_rent_amount }} </td>
                                    <td> {{ $item->ofb_advance_amount }} </td>
                                    <td> {{ $item->ofb_agrement_date }} </td>
                                    <td> {{ $item->ofb_experation_date }} </td>
                                    <td> <img src="{{ asset($item->ofb_dead_papers) }}" width="100" alt="No Photo"> </td>

                                    <td>
                                      <a href="{{ route('rent.new-building.edit',$item->ofb_id) }}" title="edit"><i class="fa fa-pencil-square fa-lg edit_icon"></i></a>

                                      <a href="{{ route('rent.new-building.delete',$item->ofb_id) }}" title="delete" title="delete data"><i class="fa fa-trash fa-lg delete_icon"></i></a>
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
      ofb_dead_papers: {
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
      ofb_dead_papers: {
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
