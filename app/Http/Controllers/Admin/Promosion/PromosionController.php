<?php

namespace App\Http\Controllers\Admin\Promosion;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\EmpCategoryController;
use Illuminate\Http\Request;
use App\Models\EmployeeInfo;
use App\Models\EmployeePromotion;
use App\Models\EmpJobExperience;
use App\Models\EmpContactPerson;
use App\Models\EmployeeCategory;
use App\Models\SalaryDetails;
use Carbon\Carbon;
use Session;
use Auth;


class PromosionController extends Controller{
  /*
  |--------------------------------------------------------------------------
  |  DATABASE OPERATION
  |--------------------------------------------------------------------------
  */
  public function findEmployee(Request $request){
      $employee_id = $request->emp_id;
      $emp_auto_id = EmployeeInfo::where('employee_id',$employee_id)->first();

      $findEmployee =  EmployeeInfo::with('country','division','district','employeeType')->where("employee_infos.emp_auto_id",$emp_auto_id->emp_auto_id)
                  ->leftjoin('salary_details','employee_infos.emp_auto_id' , '=' , 'salary_details.emp_id')
                  ->leftjoin('employee_types','employee_types.id' , '=' , 'employee_infos.emp_type_id')
                  ->leftjoin('departments','departments.dep_id' , '=' , 'employee_infos.department_id')
                  ->leftjoin('employee_categories','employee_categories.catg_id' , '=' ,'employee_infos.catg_type_id')
                  ->first();



      $find_job_experience = EmpJobExperience::where('emp_id',$emp_auto_id->emp_auto_id)->get();
      $find_emp_contact_person = EmpContactPerson::where('emp_id',$emp_auto_id->emp_auto_id)->get();

      // return json_encode($findEmployee);
      return json_encode([
        'find_job_experience' => $find_job_experience,
        'find_emp_contact_person' => $find_emp_contact_person,
        'findEmployee' => $findEmployee,
       ]);
  }




  // Find An Employee Details
  public function findEmployeeDetails(Request $request){
      $employee_id = $request->emp_id;
      $iqamaNo = $request->iqamaNo;

      if($employee_id !=""){
        $employee = EmployeeInfo::where('employee_id',$employee_id)->first();
      }else{
        $employee = EmployeeInfo::where('akama_no',$iqamaNo)->first();
      }

     // dd($employee_id);
      if($employee){

        /* find employee in request employee id wise */
        $findEmployee =  EmployeeInfo::with('country','division','district','employeeType','project','category','department')
        ->where('emp_auto_id',$employee->emp_auto_id)->first();
        /* find salary in request employee id wise */
        $salary = SalaryDetails::where('emp_id',$employee->emp_auto_id)->first();


        /* ====== Employee Designation Query ====== */
        $designationOBJ = new EmpCategoryController();
        $designation = $designationOBJ->getAllCategory();
        /* ====== Employee Job Experience Query ====== */
        $find_job_experience = EmpJobExperience::where('emp_id',$employee->emp_auto_id)->get();
        /* ====== Employee Contact Person Query ====== */
        $find_emp_contact_person = EmpContactPerson::where('emp_id',$employee->emp_auto_id)->get();
        /* ====== return json ====== */
        return json_encode([
          'find_job_experience' => $find_job_experience,
          'find_emp_contact_person' => $find_emp_contact_person,
          'findEmployee' =>  $findEmployee,
          'salary' => $salary,
          'designation' => $designation,
         ]);
      }else{
        return json_encode([
          'status' => "error",
         ]);
      }














  }

  public function insertPromosion(Request $request){
    /* ======== Form Validation ======== */
    $this->validate($request,[

    ],[

    ]);
    /* ======== Insert data In Database ======== */
    $emp_id = $request->emp_id;
    $entered_id = Auth::user()->id;

    $insertPromosion = EmployeePromotion::insert([
        'emp_id' => $emp_id,
        'designation_id' => $request->designation_id,
        'new_designation_id' => $request->new_designation_id,
        'entered_id' => $entered_id,
        'created_at' => Carbon::now(),
    ]);

    if($insertPromosion){
      $increment_no = EmployeePromotion::where('emp_id',$emp_id)->count();
      $increment_amount = ($request->basic_amount + $request->house_rent + $request->mobile_allowance + $request->medical_allowance + $request->local_travel_allowance + $request->conveyance_allowance + $request->others1) - $request->total;
      $insertSalaryDetails = SalaryDetails::where('emp_id',$emp_id)->update([
        'emp_id' => $emp_id,
        'basic_amount' => $request->basic_amount,
        'house_rent' => $request->house_rent,
        'hourly_rent' => $request->hourly_rent,
        'mobile_allowance' => $request->mobile_allowance,
        'medical_allowance' => $request->medical_allowance,
        'local_travel_allowance' => $request->local_travel_allowance,
        'conveyance_allowance' => $request->conveyance_allowance,
        'increment_no' => $increment_no,
        'increment_amount' => $increment_amount,
        'others1' => $request->others1,
        'updated_at' => Carbon::now(),
      ]);
    }

    if($insertSalaryDetails){
      $insertEmployee = EmployeeInfo::where('emp_auto_id',$emp_id)->update([
        'designation_id' => $request->designation_id,
        'updated_at' => Carbon::now(),
      ]);
      /* redirect back */
      if($insertEmployee){
        Session::flash('success','value');
        return Redirect()->back();
      }else{
        Session::flash('error','value');
        return Redirect()->back();
      }

    }

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
    /* call Designation controller */

    return view('admin.employee-promosion.all');
  }




  /* ======================================================================= */
}
