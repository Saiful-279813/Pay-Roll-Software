<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\EmployeeTypeController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\ProjectInfoController;
use App\Http\Controllers\Admin\SponsorController;
use App\Http\Controllers\Admin\CompanyProfileController;
use App\Http\Controllers\Admin\EmpCategoryController;
use Illuminate\Http\Request;
use App\Models\ProjectInfo;
use App\Models\EmployeeInfo;
use App\Models\Division;
use App\Models\Religion;
use App\Models\EmployeeCategory;
use App\Models\EmpProjectHistory;
use App\Models\SalaryDetails;
use Carbon\Carbon;
use Session;
use Image;
use Auth;

class EmployeeInfoController extends Controller{
  /*
  |--------------------------------------------------------------------------
  |  DATABASE OPERATION
  |--------------------------------------------------------------------------
  */

  public function getAllEmployees(){
    return $all = EmployeeInfo::where('job_status',1)->orderBy('emp_auto_id','DESC')->get();
  }

  public function getAllUnapprove(){
    return $all = EmployeeInfo::where('job_status',0)->orderBy('emp_auto_id','DESC')->get();
  }

  public function getEmployeeById($emp_auto_id){
    return $edit = EmployeeInfo::where('job_status',1)->where('emp_auto_id',$emp_auto_id)->first();
  }
  /* id generator */
  public function generetEmployeeId(){
    $all = EmployeeInfo::count();
    return $empId ="10".$all;
    // EMP-
  }

  public function getEmpCategory($emp_type_id){
      $getEmpCatg = EmployeeCategory::where('emp_type_id',$emp_type_id)->where('catg_status',1)->get();
      return json_encode($getEmpCatg);
  }

  // ajax Call
  public function checkEmpId($empId){
    $employee = EmployeeInfo::where('employee_id',$empId)->first();
    if($employee){
      return response()->json(['result' => 1]);
    }else{
      return response()->json(['result' => 0]);
    }
  }

  /* ============== insert Employee Information in DATABASE ============== */
  public function insert(Request $request){
    $this->validate($request,[
      'emp_id' => 'required|max:7|unique:employee_infos,employee_id',
      'emp_name' => 'required|string|max:30',
      'akama_no' => 'required|string|max:40|unique:employee_infos,akama_no',
      'passfort_no' => 'required|string|max:40|unique:employee_infos,passfort_no',
      'mobile_no' => 'required|max:20|unique:employee_infos,mobile_no',
      'akama_expire' => 'required',
      'passfort_expire_date' => 'required',
      'sponsor_id' => 'required',
    ],[
      'emp_name.required' => 'please enter employee name!',
    ]);

    $hourlyEmpValue = $request->hourly_employee;
    $creator = Auth::user()->id;
    /* data insert */
    $insert = EmployeeInfo::insertGetId([
      'employee_id' => $request->emp_id,
      'employee_name' => $request->emp_name,
      'akama_no' => $request->akama_no,
      'akama_expire_date' => $request->akama_expire,
      'passfort_no' => $request->passfort_no,
      'passfort_expire_date' => $request->passfort_expire_date,
      'sponsor_id' => $request->sponsor_id,
      'mobile_no' => $request->mobile_no,

      'country_id' => $request->country_id,
      'division_id' => $request->division_id,
      'district_id' => $request->district_id,
      'post_code' => $request->post_code,
      'details' => $request->details,
      'present_address' => $request->present_address,
      'emp_type_id' => $request->emp_type_id,
      'designation_id' => $request->designation_id,
      'hourly_employee' => $hourlyEmpValue,

      'project_id' => $request->project_id,
      'department_id' => $request->department_id,
      'date_of_birth' => $request->date_of_birth,
      'phone_no' => $request->phone_no,
      'email' => $request->email,
      'maritus_status' => $request->maritus_status,
      'gender' => $request->gender,
      'religion' => $request->religion,
      'joining_date' => $request->joining_date,
      'confirmation_date' => $request->confirmation_date,
      'appointment_date' => $request->appointment_date,
      'entry_date' => Carbon::now(),
      'entered_id' => $creator,
      'created_at' => Carbon::now(),
    ]);

    if($insert){
      /* passfort photo */
      if($request->file('pasfort_photo') ){

        /* making passfort image */
        $pasfort_photo = $request->file('pasfort_photo');
        $passfort_photo_gen = 'Emp-passfort-image-'.time().'.'.$pasfort_photo->getClientOriginalExtension();
        Image::make($pasfort_photo)->resize(300,300)->save('uploads/employee/'.$passfort_photo_gen);
        $passportUplodPath = 'uploads/employee/'.$passfort_photo_gen;


        EmployeeInfo::where('emp_auto_id',$insert)->update([
          'pasfort_photo' => $passportUplodPath,
        ]);
      }
      /* profile photo */
      if($request->file('profile_photo') ){
        /* making image */
        $profile_photo = $request->file('profile_photo');
        $profile_photo_gen = 'Emp-profile-image-'.time().'.'.$profile_photo->getClientOriginalExtension();
        Image::make($profile_photo)->resize(300,300)->save('uploads/employee/'.$profile_photo_gen);
        $uplodPath = 'uploads/employee/'.$profile_photo_gen;

        EmployeeInfo::where('emp_auto_id',$insert)->update([
          'profile_photo' => $uplodPath,
        ]);
      }
      /* akama photo */
      if($request->file('akama_photo')){
        /* making image */
        $akama_photo = $request->file('akama_photo');
        $akama_photo_gen = 'Emp-akama-image-'.time().'.'.$akama_photo->getClientOriginalExtension();
        Image::make($akama_photo)->resize(300,300)->save('uploads/employee/'.$akama_photo_gen);
        $uplodPath = 'uploads/employee/'.$akama_photo_gen;

        EmployeeInfo::where('emp_auto_id',$insert)->update([
          'akama_photo' => $uplodPath,
        ]);
      }
      /* medical photo */
      if($request->file('medical_report')){
        /* making image */
        $medical_report = $request->file('medical_report');
        $medical_report_gen = 'Emp-medical-image-'.time().'.'.$medical_report->getClientOriginalExtension();
        Image::make($medical_report)->resize(300,300)->save('uploads/employee/'.$medical_report_gen);
        $uplodPath = 'uploads/employee/'.$medical_report_gen;

        EmployeeInfo::where('emp_auto_id',$insert)->update([
          'medical_report' => $uplodPath,
        ]);
      }
      /* appoint photo */
      if($request->file('appoint_latter')){
        /* making image */
        $appoint_latter = $request->file('appoint_latter');
        $appoint_name = 'Emp-appoint_latter-image-'.time().'.'.$appoint_latter->getClientOriginalExtension();
        Image::make($appoint_latter)->resize(300,300)->save('uploads/employee/'.$appoint_name);
        $uplodPath = 'uploads/employee/'.$appoint_name;

        EmployeeInfo::where('emp_auto_id',$insert)->update([
          'employee_appoint_latter' => $uplodPath,
        ]);
      }
    }
    if($insert){
        /* insert employee id in salary details table */
        SalaryDetails::insert([
          'emp_id' => $insert,
          'created_at' => Carbon::now(),
        ]);

        /*insert project history */
        EmpProjectHistory::insert([
          'emp_id' => $insert,
          'project_id' => 0,
          'asigned_date' => Carbon::now(),
          'create_by_id' => $creator,
          'created_at' => Carbon::now(),
        ]);
        // find last employee
        $lastEmployee = EmployeeInfo::where('emp_auto_id',$insert)->pluck('emp_auto_id','employee_name','emp_type_id','profile_photo');
        /* redirect salary page */
        return Redirect()->route('add-salary-info',[$insert]);
    }else{
      Session::flash('error','value');
      return redirect()->back();
    }


  }

  /* ======== update data ======== */
  public function updateData(Request $request){

    $id = $request->id;


    $this->validate($request,[
      'emp_id' => 'required|max:7|unique:employee_infos,employee_id,'.$id.',emp_auto_id',
      'emp_name' => 'required|string|max:30',
      'akama_no' => 'required|string|max:40|unique:employee_infos,akama_no,'.$id.',emp_auto_id',
      'passfort_no' => 'required|string|max:40|unique:employee_infos,passfort_no,'.$id.',emp_auto_id',
      'mobile_no' => 'required|max:20|unique:employee_infos,mobile_no,'.$id.',emp_auto_id',
      'akama_expire' => 'required',
      'passfort_expire_date' => 'required',
      'sponsor_id' => 'required',
    ],[
      'emp_name.required' => 'please enter employee name!',
    ]);

    $update = EmployeeInfo::where('emp_auto_id',$id)->update([
      'employee_id' => $request->emp_id,
      'employee_name' => $request->emp_name,
      'akama_no' => $request->akama_no,
      'akama_expire_date' => $request->akama_expire,
      'passfort_no' => $request->passfort_no,
      'passfort_expire_date' => $request->passfort_expire_date,
      'sponsor_id' => $request->sponsor_id,
      'mobile_no' => $request->mobile_no,


      'country_id' => $request->country_id,
      'division_id' => $request->division_id,
      'district_id' => $request->district_id,
      'post_code' => $request->post_code,
      'details' => $request->details,
      'present_address' => $request->present_address,
      'emp_type_id' => $request->emp_type_id,
      'designation_id' => $request->designation_id,
      'project_id' => $request->project_id,
      'department_id' => $request->department_id,
      'date_of_birth' => $request->date_of_birth,
      'phone_no' => $request->phone_no,
      'email' => $request->email,
      'maritus_status' => $request->maritus_status,
      'gender' => $request->gender,
      'religion' => $request->religion,
      'joining_date' => $request->joining_date,
      'confirmation_date' => $request->confirmation_date,
      'appointment_date' => $request->appointment_date,
      'entry_date' => Carbon::now(),
      'entered_id' => Auth::user()->id,
      'updated_at' => Carbon::now(),
    ]);
    /* redirect add page */
    if($update){
      Session::flash('success_update','value');
      return Redirect()->route('employee-list');
    } else{
      Session::flash('error','value');
      return redirect()->back();
    }


  }

  /* ======== update image ======== */
  public function updateImage(Request $request){
     $id = $request->id;
     $findImage = EmployeeInfo::where('emp_auto_id',$id)->first();

     $profileOld = $request->old_profile_photo;
     $passfortOld = $request->old_pasfort_photo;
     $akamaOld = $request->old_akama_photo;
     $medicalOld = $request->old_medical_report;
     $appointOld = $request->old_employee_appoint_latter;


     /* appoint latter photo */
     if($request->file('appoint_latter') ){
       if($findImage->employee_appoint_latter != ""){
          unlink($appointOld);
       }
       /* making image */
       $appoint_latter = $request->file('appoint_latter');
       $appoint_name = 'Emp-appoint_latter-image-'.time().'.'.$appoint_latter->getClientOriginalExtension();
       Image::make($appoint_latter)->resize(300,300)->save('uploads/employee/'.$appoint_name);
       $uplodPath = 'uploads/employee/'.$appoint_name;

       $update = EmployeeInfo::where('emp_auto_id',$id)->update([
         'employee_appoint_latter' => $uplodPath,
         'updated_at' => Carbon::now(),
       ]);
     }

     /* medical report photo */
     if($request->file('medical_report') ){
       if($findImage->medical_report != ""){
          unlink($medicalOld);
       }
       /* making image */
       $medical_photo = $request->file('medical_report');
       $medical_photo_gen = 'Emp-medical-image-'.time().'.'.$medical_photo->getClientOriginalExtension();
       Image::make($medical_photo)->resize(300,300)->save('uploads/employee/'.$medical_photo_gen);
       $uplodPath = 'uploads/employee/'.$medical_photo_gen;

       $update = EmployeeInfo::where('emp_auto_id',$id)->update([
         'medical_report' => $uplodPath,
         'updated_at' => Carbon::now(),
       ]);
     }

     /* profile photo */
     if($request->file('profile_photo') ){
       if($findImage->profile_photo != ""){
          unlink($profileOld);
       }
       /* making image */
       $profile_photo = $request->file('profile_photo');
       $profile_photo_gen = 'Emp-profile-image-'.time().'.'.$profile_photo->getClientOriginalExtension();
       Image::make($profile_photo)->resize(300,300)->save('uploads/employee/'.$profile_photo_gen);
       $uplodPath = 'uploads/employee/'.$profile_photo_gen;

       $update = EmployeeInfo::where('emp_auto_id',$id)->update([
         'profile_photo' => $uplodPath,
         'updated_at' => Carbon::now(),
       ]);
     }

     /* Passfort Photo */
     if($request->file('pasfort_photo') ){
       if($findImage->pasfort_photo != ""){
          unlink($passfortOld);
       }
       /* making image */
       $passport_photo = $request->file('pasfort_photo');
       $passport_photo_name = 'Emp-passport-image-'.time().'.'.$passport_photo->getClientOriginalExtension();
       Image::make($passport_photo)->resize(300,300)->save('uploads/employee/'.$passport_photo_name);
       $uplodPath = 'uploads/employee/'.$passport_photo_name;

       $update = EmployeeInfo::where('emp_auto_id',$id)->update([
         'pasfort_photo' => $uplodPath,
         'updated_at' => Carbon::now(),
       ]);
     }

     /* Akama Photo */
     if($request->file('akama_photo') ){
       if($findImage->akama_photo != ""){
          unlink($akamaOld);
       }
       /* making image */
       $iqama_photo = $request->file('akama_photo');
       $iqama_photo_name = 'Emp-iqama-image-'.time().'.'.$iqama_photo->getClientOriginalExtension();
       Image::make($iqama_photo)->resize(300,300)->save('uploads/employee/'.$iqama_photo_name);
       $uplodPath = 'uploads/employee/'.$iqama_photo_name;

       $update = EmployeeInfo::where('emp_auto_id',$id)->update([
         'akama_photo' => $uplodPath,
         'updated_at' => Carbon::now(),
       ]);

     }

     /* redirect add page */
     if($update){
       Session::flash('success_update_image','value');
       return Redirect()->route('employee-list');
     } else{
       Session::flash('error','value');
       return redirect()->back();
     }

  }

  public function jobApproveSuccess($id){
      $approve = EmployeeInfo::where('job_status',0)->where('emp_auto_id',$id)->update([
        'job_status' => 1,
        'updated_at' => Carbon::now(),
      ]);
      if($approve){
        Session::flash('approve','value');
        return redirect()->back();
      }else{
        Session::flash('error','value');
        return redirect()->back();
      }
  }

  public function iqamaWiseEmployeeSummary(Request $request){
    /* ========== Company Profile ========== */
    $companyOBJ = new CompanyProfileController();
    $company = $companyOBJ->findCompanry();
    return view('admin.report.employee_summary.view',compact('company'));
  }

  public function idWiseEmployeeSummary(Request $request){
    /* ========== Company Profile ========== */
    $companyOBJ = new CompanyProfileController();
    $company = $companyOBJ->findCompanry();
    return view('admin.report.employee_summary.view',compact('company'));
  }

  public function projectWiseEmployeeListProcess(Request $request){
    /* ========== Company Profile ========== */
    $companyOBJ = new CompanyProfileController();
    $company = $companyOBJ->findCompanry();
    $project = ProjectInfo::where('proj_id',$request->proj_id)->pluck('proj_name');
    $employee = EmployeeInfo::where('project_id',$request->proj_id)->orderBy('employee_id','ASC')->get();

    if($employee !=""){
      return view('admin.employee-info.project_wise.report',compact('employee','company','project'));
    }else{
      Session::flash('error','value');
      return redirect()->back();
    }
  }

  public function tradeWiseEmployeeListProcess(Request $request){
    /* ========== Company Profile ========== */
    $companyOBJ = new CompanyProfileController();
    $company = $companyOBJ->findCompanry();
    $trade = EmployeeCategory::where('catg_id',$request->catg_id)->pluck('catg_name');
    $employee = EmployeeInfo::where('designation_id',$request->catg_id)->orderBy('employee_id','ASC')->get();

    if($employee != NULL){
      return view('admin.employee-info.trade_wise.report',compact('employee','company','trade'));
    }else{
      Session::flash('error','value');
      return redirect()->back();
    }

  }




  /*
  |--------------------------------------------------------------------------
  |  BLADE OPERATION
  |--------------------------------------------------------------------------
  */
  public function index(){
      $all = $this->getAllEmployees();
      return view('admin.employee-info.index',compact('all'));
  }

  public function jobApprove(){
    $all = $this->getAllUnapprove();
    return view('admin.employee-info.job-approve',compact('all'));
  }

  public function searchEmp(){
    return view('admin.employee-info.search-emp');
  }

  public function getReligion(){
    return $all = Religion::get();
  }



  public function add(){
    $countryObj = new CountryController();
    $countryList = $countryObj->getAllCountry();
    /* employee type */
    $empTypeObj = new EmployeeTypeController();
    $empTypes = $empTypeObj->getEmployeeTypeAll();
    /* call Department */
    $depart = new DepartmentController();
    $allDepart = $depart->getAllDepartment();
    /* employee */
    $empIdGeneret = $this->generetEmployeeId();
    $relig = $this->getReligion();
    /* project name */
    $project = new ProjectInfoController();
    $proj = $project->getAllInfo();
    /* sponsor name */
    $sponsorOBJ = new SponsorController();
    $sponsor = $sponsorOBJ->getAll();

    return view('admin.employee-info.add',compact('sponsor','proj','relig','countryList','empTypes','allDepart','empIdGeneret'));
  }

  public function addSalaryDetails($insert){
      $employee = EmployeeInfo::where('emp_auto_id',$insert)->first();
      return view('admin.employee-info.add-salary-info',compact('insert','employee'));
  }

  public function edit($emp_auto_id){
    $countryObj = new CountryController();
    $countryList = $countryObj->getAllCountry();
    /* employee type */
    $empTypeObj = new EmployeeTypeController();
    $empTypes = $empTypeObj->getEmployeeTypeAll();

    /* call Department */
    $depart = new DepartmentController();
    $allDepart = $depart->getAllDepartment();
    /* main query */
    $edit = $this->getEmployeeById($emp_auto_id);
    /* Religion */
    $relig = $this->getReligion();
    /* project name */
    $project = new ProjectInfoController();
    $proj = $project->getAllInfo();

    /* sponsor name */
    $sponsorOBJ = new SponsorController();
    $sponsor = $sponsorOBJ->getAll();

    return view('admin.employee-info.edit',compact('sponsor','edit','proj','relig','countryList','empTypes','allDepart'));
  }

  public function view($emp_auto_id){
    $view = EmployeeInfo::where('emp_auto_id',$emp_auto_id)->first();
    return view('admin.employee-info.view',compact('view'));
  }

  /* ==================== Employee Salary Summary ==================== */
  public function EmployeeSummary(){
    return view('admin.employee-info.salary-summary');
  }
  /* ==================== Project Wise Employee List ==================== */
  public function projectWiseEmployeeList(){
    /* project name */
    $projectOBJ = new ProjectInfoController();
    $projects = $projectOBJ->getAllInfo();
    return view('admin.employee-info.project_wise.all',compact('projects'));
  }
  /* ==================== Project Wise Employee List ==================== */
  public function tradeWiseEmployeeList(){
    /* project name */
    $categoryOBJ = new EmpCategoryController();
    $category = $categoryOBJ->getAllCategory();
    return view('admin.employee-info.trade_wise.all',compact('category'));
  }










  /*
  |--------------------------------------------------------------------------
  |  API OPERATION
  |--------------------------------------------------------------------------
  */







  /* ======== end class bracket ======== */
}
