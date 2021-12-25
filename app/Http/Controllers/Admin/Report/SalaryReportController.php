<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\MonthController;
use App\Http\Controllers\Admin\CompanyProfileController;
use App\Http\Controllers\Admin\Helper\HelperController;
use Illuminate\Http\Request;
use App\Models\SalaryHistory;
use App\Models\EmployeeInfo;
use Carbon\Carbon;
use Session;

class SalaryReportController extends Controller{
    public function year(){
      $yearArray = array();
      $year = Carbon::now()->format('Y');
      $c = 0;
      for ($i=$year; $i >= $year-10; $i--) {
        $yearArray[$c++]= $i;
      }
      // dd($yearArray);
      return $yearArray;
    }


    public function index(){
      $monthOBJ = new MonthController();
      $month = $monthOBJ->getAll();
      $year = $this->year();
      return view('admin.report.salary.index',compact('year','month'));
    }

    public function process(Request $request){
      /* Catch Request Value */
      $month = $request->month;
      $year = $request->year;
      $salary = SalaryHistory::where('slh_month',$month)->where('slh_year',$year)->get();
      $totalSalary = SalaryHistory::where('slh_month',$month)->where('slh_year',$year)->sum('slh_total_salary');
      /* Company Controller Call */
      $companyObj = new CompanyProfileController();
      $company = $companyObj->findCompanry();
      /* Helper Controller Call */
      $helperOBJ = new HelperController();
      $monthName = $helperOBJ->getMonthName($month);
      return view('admin.report.salary.report',compact('salary','company','totalSalary','monthName','year'));
    }




    /* ************ Single Employee Salary History Report  ************ */
    public function singleEmployeeSalary(){
      return view('admin.report.salary.single-employee.index');
    }

    public function SalaryHistoryProcess(Request $request){
      $empId = $request->emp_id;
      /* Find Employee */
      $findEmployee = EmployeeInfo::where('employee_id',$empId)->first();
      /* Check Condition */
      if($findEmployee){
        $SalaryHistory = SalaryHistory::where('emp_auto_id',$findEmployee->emp_auto_id)->orderBy('slh_month','ASC')->get();

        $growSalary = SalaryHistory::where('emp_auto_id',$findEmployee->emp_auto_id)->sum('slh_total_salary');
        
        // foreach($SalaryHistory as $data){
        //   $month = $data->slh_month;
        //   $data->$monthName = $helperOBJ->getMonthName($month);
        // }

        /* Company Controller Call */
        $companyObj = new CompanyProfileController();
        $company = $companyObj->findCompanry();
        return view('admin.report.salary.single-employee.report',compact('company','findEmployee','SalaryHistory','growSalary'));
      }else{
        Session::flash('error','value');
        return redirect()->back();
      }


    }



}
