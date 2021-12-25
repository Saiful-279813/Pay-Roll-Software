<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\EmployeeInfoController;
use App\Http\Controllers\Admin\MonthController;
use App\Http\Controllers\Admin\EmployeeTypeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\MonthlyWorkHistory;
use App\Models\EmployeeInfo;
use Carbon\Carbon;
use Session;

class DailyWorkHistoryController extends Controller{
  /*
  |--------------------------------------------------------------------------
  |  DATABASE OPERATION
  |--------------------------------------------------------------------------
  */
  public function getAll(){
    return $all = MonthlyWorkHistory::where('status',1)->get();
  }
  public function getfindId($id){
    return $find = MonthlyWorkHistory::where('status',1)->where('month_work_id',$id)->firstOrFail();
  }



  public function store(Request $request){
    // dd($request->all());
    /* insert data in database */
    $recode = MonthlyWorkHistory::where('emp_id',$request->emp_id)->where('month_id',$request->month)->first();
    if($recode){
      $insert = MonthlyWorkHistory::where('month_work_id',$recode->month_work_id)->where('emp_id',$request->emp_id)->where('month_id',$request->month)->update([
        'emp_id' => $request->emp_id,
        'month_id' => $request->month,
        'year_id' => Carbon::now()->format('Y'),
        'total_hours' => $request->work_hours,
        'overtime' => $request->overtime,
        'total_work_day' => $request->total_work_day,
        'entered_id' => Auth::user()->id,
        'updated_at' => Carbon::now(),
      ]);
    }else{
      $insert = MonthlyWorkHistory::insert([
        'emp_id' => $request->emp_id,
        'month_id' => $request->month,
        'year_id' => Carbon::now()->format('Y'),
        'total_hours' => $request->work_hours,
        'overtime' => $request->overtime,
        'total_work_day' => $request->total_work_day,
        'entered_id' => Auth::user()->id,
        'created_at' => Carbon::now(),
      ]);
    }
    if($insert){
        Session::flash('success','value');
        return Redirect()->back();
    }else{
        Session::flash('error','value');
        return Redirect()->back();
    }


  }

  public function insertIndirect(Request $request){
    /* form validation */
    $this->validate($request,[
      'indirect_emp_id' => 'required',
      'total_work_day' => 'required|integer',
    ],[

    ]);
    /* insert data in database */
    $year = Carbon::now()->format('Y');
    $month = $request->month;
    $entered_id = Auth::user()->id;
    /*find employee id */
    $findId = EmployeeInfo::where('employee_id',$request->indirect_emp_id)->where('job_status',1)->first();
    $employee_id = $findId->emp_auto_id;

    $recode = MonthlyWorkHistory::where('emp_id',$employee_id)->where('month_id',$month)->first();

    if($recode){
        Session::flash('duplicate','value');
        return Redirect()->back();
    }else{
          $insert = MonthlyWorkHistory::insert([
            'emp_id' => $employee_id,
            'month_id' => $month,
            'year_id' => $year,
            'total_hours' => 0,
            'overtime' => $request->overtime,
            'total_work_day' => $request->total_work_day,
            'entered_id' => $entered_id,
            'created_at' => Carbon::now(),
          ]);

          if($insert){
              Session::flash('success','value');
              return Redirect()->back();
          }else{
              Session::flash('error','value');
              return Redirect()->back();
          }
    }


  }







  public function update(Request $request){
    /* form validation */
    $this->validate($request,[
      'emp_id' => 'required',
      'total_work_day' => 'required|integer',
    ],[

    ]);
    /* insert data in database */
    $year = Carbon::now()->format('Y');
    $month = Carbon::now()->format('m');
    $entered_id = Auth::user()->id;
    /*find employee id */
    $findId = EmployeeInfo::where('employee_id',$request->emp_id)->where('job_status',1)->first();
    $employee_id = $findId->emp_auto_id;

    $recode = MonthlyWorkHistory::where('emp_id',$employee_id)->where('month_id',$month)->first();

    $id = $request->id;
    $update = MonthlyWorkHistory::where('status',1)->where('month_work_id',$id)->update([
      'emp_id' => $employee_id,
      'month_id' => $month,
      'year_id' => $year,
      'total_hours' => $request->work_hours,
      'overtime' => $request->overtime,
      'total_work_day' => $request->total_work_day,
      'entered_id' => $entered_id,
      'updated_at' => Carbon::now(),
    ]);

    if($update){
        Session::flash('success_update','value');
        return Redirect()->route('add-daily-work');
    }else{
        Session::flash('error','value');
        return Redirect()->back();
    }


  }





  /*
  |--------------------------------------------------------------------------
  |  AJAX OPERATION
  |--------------------------------------------------------------------------
  */

  public function autocomplete(Request $request){
    $data = EmployeeInfo::where("employee_id","LIKE","%{$request->empId}%")->where('job_status',1)->get();
        return view('admin.month-work.search',compact('data'));
  }

  public function conditionAutocomplete(Request $request){
    $data = EmployeeInfo::where("employee_id","LIKE","%{$request->empId}%")->where('job_status',1)->where('emp_type_id',2)->get();
        return view('admin.month-work.search',compact('data'));
  }

  public function findDirectEmployee(Request $request){
    $data = EmployeeInfo::where("employee_id","LIKE","%{$request->empId}%")->where('job_status',1)->where('emp_type_id',1)->get();
        return view('admin.month-work.search2',compact('data'));
  }

  public function findEmployeeTypeId(Request $request){
      $findType = EmployeeInfo::where('emp_type_id',$request->emp_type_id)->where('job_status',1)->first();
      return json_encode($findType);

  }




  /*
  |--------------------------------------------------------------------------
  |  API OPERATION
  |--------------------------------------------------------------------------
  */







  /*
  |--------------------------------------------------------------------------
  |  BLADE OPERATION
  |--------------------------------------------------------------------------
  */
  public function index(){
    /* employee type controller call */
    $employee_type = new EmployeeTypeController();
    $emp_type_id =  $employee_type->getEmployeeTypeAll();
    $all = $this->getAll();
    $monthOBJ = new MonthController();
    $month = $monthOBJ->getAll();
    $currentMonth =  Carbon::now()->format('m');
    return view('admin.month-work.create',compact('all','emp_type_id','month','currentMonth'));
  }

  public function edit($id){
      $edit = $this->getfindId($id);
      return view('admin.month-work.edit',compact('edit'));
  }




}
