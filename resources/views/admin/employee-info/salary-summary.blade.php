@extends('layouts.admin-master')
@section('title') Employee Information Search @endsection
@section('content')

@section('internal-css')
  <style media="screen">
  a.checkButton {
    background: teal;
    color: #fff!important;
    font-size: 13px;
    padding: 5px 10px;
    cursor: pointer;
  }
  </style>
@endsection

<div class="row bread_part">
    <div class="col-sm-12 bread_col">
        <h4 class="pull-left page-title bread_title">Employee Information Search</h4>
        <ol class="breadcrumb pull-right">
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="active">Employee Information Search</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
          <div class="card">
              <div class="card-header"></div>
              <div class="card-body card_form">
                  <div class="row">
                    <div class="col-md-9">
                      {{-- checkbox for iqama no wise search employee --}}
                      <div class="row">
                        <div class="col-md-5"></div>
                        <div class="col-md-3">
                          <div class="form-check" style="margin-bottom:15px;">
                            <a id="iqamaWiseSearch" class=" d-block checkButton" onclick="iqamaWiseSearch()">Iqama Wise Search?</a>
                            <a id="idWiseSearch" class=" d-none checkButton" onclick="idWiseSearch()">ID Wise Search?</a>
                          </div>
                        </div>
                      </div>
                      {{-- Search Employee Id --}}
                      <div id="searchEmployeeId"  class=" d-block">
                        <form action="{{ route('empid.wise-employee-salary.summary') }}" target="_blank" method="post">
                          @csrf
                          <div class="form-group row custom_form_group ">
                              <label class="col-sm-5 control-label">Employee ID:</label>
                              <div class="col-sm-4">
                                <input type="text" class="form-control typeahead" placeholder="Input Employee ID" name="emp_id" id="emp_id_search" onkeyup="empSearch()" onfocus="showResult()" onblur="hideResult()">
                                <div id="showEmpId"></div>
                                <span id="error_show" class="d-none" style="color: red"></span>
                              </div>
                              <div class="col-sm-2">
                                  <button type="submit" style="margin-top: 2px" class="btn btn-primary waves-effect">SEARCH</button>
                              </div>
                              <div class="col-md-1"></div>
                          </div>
                        </form>
                      </div>
                      {{-- Search Employee IQama No --}}
                      <div id="searchIqamaNo" class=" d-none">
                        <form action="{{ route('iqamawise-employee-salary.summary') }}" target="_blank" method="post">
                          @csrf
                          <div class="form-group row custom_form_group ">
                              <label class="col-sm-5 control-label">IQama No:</label>
                              <div class="col-sm-4">
                                <input type="text" id="iqamaNoSearch" class="form-control typeahead" placeholder="Input IQama No" name="iqamaNo">
                                <span id="error_show" class="d-none" style="color: red"></span>
                              </div>
                              <div class="col-sm-2">
                                  <button type="submit" style="margin-top: 2px" class="btn btn-primary waves-effect">SEARCH</button>
                              </div>
                              <div class="col-md-1"></div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
              </div>
          </div>
    </div>
</div>
{{-- iqama no wise Search --}}
<script type="text/javascript">
  // iqama Wise
  function iqamaWiseSearch(){
    $('#iqamaWiseSearch').removeClass('d-block').addClass('d-none');
    $('#idWiseSearch').removeClass('d-none').addClass('d-block');
    // input field
    $('#searchEmployeeId').removeClass('d-block').addClass('d-none');
    $('#searchIqamaNo').removeClass('d-none').addClass('d-block');

  }
  // id Wise
  function idWiseSearch(){
    $('#idWiseSearch').removeClass('d-block').addClass('d-none');
    $('#iqamaWiseSearch').addClass('d-block').removeClass('d-none');
    // input field
    $('#searchIqamaNo').removeClass('d-block').addClass('d-none');
    $('#searchEmployeeId').removeClass('d-none').addClass('d-block');
  }

</script>
@endsection
