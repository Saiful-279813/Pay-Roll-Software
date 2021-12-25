@extends('layouts.admin-master')
@section('title') Trade Wise Employees  @endsection
@section('content')
<div class="row bread_part">
    <div class="col-sm-12 bread_col">
        <h4 class="pull-left page-title bread_title">Trade Wise Employees </h4>
        <ol class="breadcrumb pull-right">
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="active"> Trade Wise Employees </li>
        </ol>
    </div>
</div>
<!-- add division -->
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        @if(Session::has('error'))
          <div class="alert alert-warning alerterror" role="alert">
             <strong>Opps!</strong> This Trade Employee Not Assigned!.
          </div>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
      <form class="form-horizontal" target="_blank" action="{{ route('trade-wise.employee.process') }}" method="post">
        @csrf
        <div class="card">
            <div class="card-header"></div>
            <div class="card-body card_form" style="padding-top: 0;">

              <div class="form-group custom_form_group">
                  <label class="control-label d-block" style="text-align: left;">Select Trade:</label>
                  <div>
                    <select class="form-control" name="catg_id">
                        @foreach($category as $cate)
                        <option value="{{ $cate->catg_id }}" >{{ $cate->catg_name }}</option>
                        @endforeach
                    </select>
                  </div>
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

@endsection
