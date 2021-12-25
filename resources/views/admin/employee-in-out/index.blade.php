@extends('layouts.admin-master')
@section('title') Employee Entry & Out @endsection
@section('content')

<div class="row bread_part">
    <div class="col-sm-12 bread_col">
        <h4 class="pull-left page-title bread_title">Employee Attendence (In Time)</h4>
        <ol class="breadcrumb pull-right">
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="active">Employee Attendence</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        @if(Session::has('success'))
          <div class="alert alert-success alertsuccess" role="alert">
             <strong>Successfully!</strong> Added New project information.
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

        @if(Session::has('data_not_found'))
          <div class="alert alert-warning alerterror" role="alert">
             <strong>Opps!</strong> invalid Employee Id.
          </div>
        @endif
    </div>
    <div class="col-md-2"></div>
</div>


<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <form class="form-horizontal project-details-form" id="employeeEntryTime">

          <div class="card">
              <div class="card-body card_form">

                <div class="form-group row custom_form_group">
                    <label class="control-label col-md-3">Employee ID:</label>
                    <div class="col-md-7">
                      <input type="text" class="form-control typeahead" placeholder="Input Employee ID" name="emp_id" value="{{ old('emp_id') }}">
                      <span class="error d-none" id="error_massage"></span>
                    </div>
                </div>

                <div class="form-group row custom_form_group">
                    <label class="col-sm-3 control-label">Select Date:</label>
                    <div class="col-sm-7">
                      <input type="date" class="form-control" name="date" value="{{ Carbon\Carbon::now()->format('m/d/Y') }}" required>
                    </div>
                </div>

                <div class="form-group row custom_form_group">
                    <label class="col-sm-3 control-label">Entry Time:</label>
                    <div class="col-sm-7">
                        <input type="number" name="entry_time" value="{{ old('entry_time') }}" class="form-control" placeholder="Input Time (1 to 24 Hours)" required max="24" min="0">
                    </div>
                </div>

                <div class="form-group row custom_form_group">
                    <label class="col-sm-3 control-label"> Night Shift:</label>
                    <div class="col-sm-7">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="emp_io_shift" id="emp_io_shift" value="1">
                        <label class="form-check-label">If Night Shift Then Check This Box</label>
                      </div>
                    </div>
                </div>



              </div>
              <div class="card-footer card_footer_button text-center">
                  <button type="submit" onclick="employeeEntryTime()" class="btn btn-primary waves-effect">SAVE</button>

              </div>
          </div>
        </form>
    </div>
    <div class="col-md-1"></div>
</div>
<!-- script area -->
<script type="text/javascript">
/* form validation */
$(document).ready(function(){

  $("#employeeEntryTime").validate({
    /* form tag off  */
    submitHandler: function(form) {
         return false;
     },
    /* form tag off  */
    rules: {
      emp_id: {
        required : true,
      },
      date: {
        required : true,
      },
      entry_time: {
        required : true,
        number: true,
        max: 24,
        min: 0,
      },
    },

    messages: {
      emp_id: {
        required : "You Must Be Input This Field!",
      },
      date: {
        required : "You Must Be Select This Field!",
      },
      entry_time: {
        required : "Please Input This Field!",
        number : "You Must Be Input Number!",
        max : "You Must Be Input Maximum 24!",
      },
    },


  });
});

/* insert data in ajax */
function employeeEntryTime(){
  var emp_id = $('input[name="emp_id"]').val();
  var date = $('input[name="date"]').val();
  var entry_time = $('input[name="entry_time"]').val();

    if($('input[name="emp_io_shift"]').is(':checked')){
        var emp_io_shift = 1;
    } else {
        var emp_io_shift = 0;
    }


  if(emp_io_shift == 1){
    $("input[name='emp_io_shift']").attr({ "min" : 12 , "max" : 24});

    /* ajax request */
    if(emp_id != "" && entry_time != "" && date !=""){

      $.ajax({
        type:'POST',
        dataType: 'json',
        data:{ emp_id:emp_id, date:date, entry_time:entry_time, emp_io_shift:emp_io_shift },
        url:"{{ route('employee-entry-time-insert') }}",
        success:function(data){

          // error_massage
          if(data.error){
            $("span[id='error_massage']").text("Employee Not Found!");
            $("span[id='error_massage']").removeClass('d-none').addClass('d-block');
          }else{
            var emp_id = $('input[name="emp_id"]').val("");
            var date = $('input[name="date"]').val("");
            var entry_time = $('input[name="entry_time"]').val("");
            var emp_io_shift = $('input[name="emp_io_shift"]').prop('checked', false);
            $("span[id='error_massage']").addClass('d-none').removeClass('d-block');
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
        }
      });
    }

  }else{
    $("input[name='emp_io_shift']").attr({ "max" : 12 , "min" : 0 });
    /* ajax request */
    if(emp_id != "" && entry_time != "" && date !=""){

      $.ajax({
        type:'POST',
        dataType: 'json',
        data:{ emp_id:emp_id, date:date, entry_time:entry_time, emp_io_shift:emp_io_shift },
        url:"{{ route('employee-entry-time-insert') }}",
        success:function(data){

          // error_massage
          if(data.error){
            $("span[id='error_massage']").text("Employee Not Found!");
            $("span[id='error_massage']").removeClass('d-none').addClass('d-block');
          }else{
            var emp_id = $('input[name="emp_id"]').val("");
            var date = $('input[name="date"]').val("");
            var entry_time = $('input[name="entry_time"]').val("");
            var emp_io_shift = $('input[name="emp_io_shift"]').prop('checked', false);
            $("span[id='error_massage']").addClass('d-none').removeClass('d-block');
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
        }
      });
    }


  }




}
</script>

@endsection
