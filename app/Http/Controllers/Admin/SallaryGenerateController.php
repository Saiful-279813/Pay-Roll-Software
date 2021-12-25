<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ProjectInfoController;
use App\Http\Controllers\Admin\EmployeeTypeController;
use App\Http\Controllers\Admin\MonthController;
use App\Http\Controllers\Admin\CompanyProfileController;
use App\Http\Controllers\Admin\Helper\HelperController;
use Illuminate\Http\Request;
use App\Models\Month;
use App\Models\EmployeeInfo;
use App\Models\MonthlyWorkHistory;
use App\Models\SalaryDetails;
use App\Models\SalaryHistory;
use App\Models\AdvancePayHistory;
use App\Models\ProjectInfo;
use App\Models\AdvancePay;
use App\Models\EmpContributeHistory;
use Carbon\Carbon;
use PDF;
use Session;
use Auth;

class SallaryGenerateController extends Controller{
  /*
  |--------------------------------------------------------------------------
  |  DATABASE OPERATION
  |--------------------------------------------------------------------------
  */

  /* ===================== All Employee Store Salary Record ===================== */
  public function monthlySalaryRecord($month,$year){
   return  $allEmpSalary =  EmployeeInfo::where("employee_infos.job_status",1)
                        ->where('monthly_work_histories.month_id',$month)
                        ->where('monthly_work_histories.year_id',$year)
                       ->leftjoin('salary_details','employee_infos.emp_auto_id' , '=' , 'salary_details.emp_id')
                       ->leftjoin('advance_pays','employee_infos.emp_auto_id' , '=' ,'advance_pays.emp_id')
                       ->leftjoin('monthly_work_histories','employee_infos.emp_auto_id' , '=' , 'monthly_work_histories.emp_id')->get()->all();

  }



  /* Salary Store In Salary History */
  public function salaryStore(Request $request){
    $year = Carbon::now()->format('Y');
    $month = $request->month;
    $creator = Auth::user()->id;
    /* Call monthlySalaryRecord Method */
    $monthWiseSalary = $this->monthlySalaryRecord($month,$year);

    if($monthWiseSalary == NULL){
      Session::flash('not_record','value');
      return redirect()->back();
    }


    /* ============== Salary Processing ============== */
    foreach ($monthWiseSalary as $salary){

      /* Advance Purpose */
      $iqamaAdvance = 0;
      $othersAdvance = 0;

      /* ================ Calculation ================ */
      $totalOthers = ($salary->house_rent + $salary->conveyance_allowance + $salary->mobile_allowance + $salary->medical_allowance + $salary->local_travel_allowance + $salary->others1);

       $over_amount = 0;
       $total_amount = 0;
       $food_allowance = 0;

    if($salary->hourly_employee == true){
           //  $over_amount = ($empSalary->overtime * $empSalary->hourly_rent);
             $total_amount = ($salary->total_hours * $salary->hourly_rent);
             $totalOthers = ($salary->others1);
             $over_amount = 0;
           //  dd($empSalary->total_amount);
    }
     elseif($salary->basic_hours > 0 && $salary->basic_amount > 0){
          $over_amount = ($salary->overtime * ($salary->hourly_rent + 1.5));
          $total_amount = ( ($salary->basic_amount / 30 ) * $salary->total_work_day )  + $over_amount;
     }
     elseif($salary->basic_amount > 0){

       $salary->allOthers = ($salary->house_rent + $salary->conveyance_allowance + $salary->others1);
       $over_amount = ($salary->overtime * $salary->hourly_rent);
       $total_amount = ( ($salary->basic_amount / 30) ) * ($salary->total_work_day) + $over_amount ;

     }

     // Food Allowance Calculation
     if($salary->food_allowance > 0){
       if($salary->total_work_day>=26){
           $food_allowance = $salary->food_allowance;
       }else { 
           $food_allowance = (($salary->food_allowance / 30) * $salary->total_work_day);
       }
     }

     $netSalary = ($total_amount + $totalOthers + $food_allowance);
     // $netSalary = ($total_amount + $totalOthers );

     // dd($netSalary);


     $salary->saudi_tax = 300;
     $grossSalary = ($netSalary - ($salary->installes_amount + $salary->cpf_contribution + $salary->saudi_tax ));
     $salary->gross_salary = $grossSalary;


      /* find Employee Advance Payment */
      $findEmployeeAdvance = AdvancePay::where('emp_id',$salary->emp_auto_id)->first();
      if($findEmployeeAdvance)
      {

        if($salary->adv_pay_purpose == 1){
          $iqamaAdvance = $salary->installes_amount;
        } else{
          $othersAdvance= $salary->installes_amount;
        }



        /* fine Advance History */
        $findPayHistory = AdvancePayHistory::where('aph_month',$month)->where('aph_year',$year)->first();
        if(!$findPayHistory){
          /* update advance pay */
          $installAmount = ($findEmployeeAdvance->adv_pay_amount / $findEmployeeAdvance->installes_month);
          // reset next month advance pay amount
          $update = AdvancePay::where('emp_id',$salary->emp_auto_id)->update([
            'installes_amount' => $installAmount,
            'updated_at' => Carbon::now(),
          ]);
          /* insert data in advance history */

          $insert = AdvancePayHistory::insert([
            'adv_pay_id' => $findEmployeeAdvance->adv_pay_id,
            'aph_date' => Carbon::now(),
            'aph_month' => $month,
            'aph_year' => $year,
            'amount' => $salary->installes_amount,
            'create_by_id' => $creator,
            'created_at' => Carbon::now(),
          ]);
        }
      }

      /* ================ End Calculation ================= */
      $fixDuplicateSalary = SalaryHistory::where('emp_auto_id',$salary->emp_auto_id)->first();
      if($fixDuplicateSalary){

  //dd($salary);

        $insert = SalaryHistory::where('slh_auto_id',$fixDuplicateSalary->slh_auto_id)->update([
          'emp_auto_id' => $salary->emp_auto_id,
          /* New field in Salary History */

          'basic_amount' => $salary->basic_amount,
          'basic_hours' => $salary->basic_hours,
          'house_rent' => $salary->house_rent,
          'hourly_rent' => $salary->hourly_rent,
          'mobile_allowance' => $salary->mobile_allowance,
          'medical_allowance' => $salary->medical_allowance,
          'local_travel_allowance' => $salary->local_travel_allowance,
          'conveyance_allowance' => $salary->conveyance_allowance,
          'food_allowance' => $food_allowance,
          'others' => $salary->others1,

          'slh_total_overtime' => $salary->overtime,
          'slh_overtime_amount' => $over_amount,
          /* New field in Salary History */
          'slh_total_salary' => $salary->gross_salary,
          'slh_total_hours' => $salary->total_hours,
          'slh_total_working_days' => $salary->total_work_day,
          'slh_month' => $month,
          'slh_year' => $year,
          'slh_cpf_contribution' => $salary->cpf_contribution,
          'slh_saudi_tax' => $salary->saudi_tax,
          'slh_company_contribution' => 0,
          'slh_iqama_advance' => $iqamaAdvance,
          'slh_other_advance' => $othersAdvance,
          'slh_salary_date' => Carbon::now(),
          'created_at' => Carbon::now(),

        ]);
      }else {
        $insert = SalaryHistory::insertGetId([
          'emp_auto_id' => $salary->emp_auto_id,
          /* New field in Salary History */
          'basic_amount' => $salary->basic_amount,
          'basic_hours' => $salary->basic_hours,
          'house_rent' => $salary->house_rent,
          'hourly_rent' => $salary->hourly_rent,
          'mobile_allowance' => $salary->mobile_allowance,
          'medical_allowance' => $salary->medical_allowance,
          'local_travel_allowance' => $salary->local_travel_allowance,
          'conveyance_allowance' => $salary->conveyance_allowance,
          'food_allowance' => $salary->food_allowance,
          'others' => $salary->others1,

          'slh_total_overtime' => $salary->overtime,
          'slh_overtime_amount' => $over_amount,
          /* New field in Salary History */
          'slh_total_salary' => $salary->gross_salary,
          'slh_total_hours' => $salary->total_hours,
          'slh_total_working_days' => $salary->total_work_day,
          'slh_month' => $month,
          'slh_year' => $year,
          'slh_cpf_contribution' => $salary->cpf_contribution,
          'slh_saudi_tax' => $salary->saudi_tax,
          'slh_company_contribution' => 0,
          'slh_iqama_advance' => $iqamaAdvance,
          'slh_other_advance' => $othersAdvance,
          'slh_salary_date' => Carbon::now(),
          'created_at' => Carbon::now(),
        ]);
      }
      /* ================ Employee Contribution ================= */
      $contribution = EmpContributeHistory::where('emp_auto_id',$salary->emp_auto_id)->where('Month',$month)->where('Year',$year)->first();

      if($contribution){
        EmpContributeHistory::where('emp_auto_id',$salary->emp_auto_id)->where('Month',$month)->where('Year',$year)->update([
          'emp_auto_id' => $salary->emp_auto_id,
          'Amount' => $salary->cpf_contribution,
          'Month' => $month,
          'Year' => $year,
          'CreateById' => $creator,
          'updated_at' => Carbon::now(),
        ]);
      }else{
        EmpContributeHistory::insert([
          'emp_auto_id' => $salary->emp_auto_id,
          'Amount' => $salary->cpf_contribution,
          'Month' => $month,
          'Year' => $year,
          'CreateById' => $creator,
          'created_at' => Carbon::now(),
        ]);
      }




   }


    if($insert){
      Session::flash('success','value');
      return redirect()->back();
    }else{
      Session::flash('error','value');
      return redirect()->back();
    }

  }

  /* ===================== All Employee Store Salary Record ===================== */

  /* ==================== Single Employee Month Wise Salary Report ==================== */
  public function singleEmployeeMonthWiseSalaryReport(Request $request){
    // Catch request Data
    $empId = $request->emp_id;
    $month = $request->month;
    $year = Carbon::now()->format('Y');

    $HelperOBJ = new HelperController();
    $monthName = $HelperOBJ->getMonthName($month);

    /* ========== Company Profile ========== */
    $companyOBJ = new CompanyProfileController();
    $company = $companyOBJ->findCompanry();

    $findEmployee = EmployeeInfo::where('employee_id',$empId)->first();
    if($findEmployee){

        $salary = SalaryHistory::with('employee')->where('emp_auto_id',$findEmployee->emp_auto_id)->where('slh_month',$month)->where('slh_year',$year)->first();
        $allSalaryAmount = SalaryHistory::where('slh_month',$month)->where('emp_auto_id',$findEmployee->emp_auto_id)->where('slh_year',$year)->sum('slh_total_salary');
        $iqamaAmount = SalaryHistory::where('slh_month',$month)->where('emp_auto_id',$findEmployee->emp_auto_id)->where('slh_year',$year)->sum('slh_iqama_advance');
        $totalHours = SalaryHistory::where('slh_month',$month)->where('emp_auto_id',$findEmployee->emp_auto_id)->where('slh_year',$year)->sum('slh_total_hours');

        // find Salary Record This Month
        if($salary){
          // Condition Wise Check
          if($salary->hourly_employee == true){
            $others = $salary->others;
          }else{
            $others = ($salary->house_rent + $salary->conveyance_allowance + $salary->medical_allowance + $salary->others);
          }
          // Condition Wise Check
          $salary->otherAmount = $others;
        }

        return view('admin.salary-generate.single_employee.salary',compact('salary','monthName','company','allSalaryAmount','iqamaAmount','totalHours'));

    }else{
      Session::flash('invalidEmployeeId','value');
      return redirect()->back();
    }
  }

  /* ==================== Single Employee Month Wise Salary Report ==================== */
  public function projectEmployeeMonthWiseSalaryReport(Request $request){
    return "Work Pending Please Go Back";
    $projectId = $request->proj_id;
    $month = $request->month;
    $year = Carbon::now()->format('Y');
    $empType = $request->emp_type_id;

    $HelperOBJ = new HelperController();
    $monthName = $HelperOBJ->getMonthName($month);

    /* ========== Company Profile ========== */
    $companyOBJ = new CompanyProfileController();
    $company = $companyOBJ->findCompanry();

    /* ========== Project Info ========== */
    $projectOBJ = new ProjectInfoController();
    $project = $projectOBJ->getFindId($projectId);



    $salaryReport = SalaryHistory::with('employee')->where('slh_month',$month)->where('slh_year',$year)->get();
    $allSalaryAmount = SalaryHistory::where('slh_month',$month)->where('slh_year',$year)->sum('slh_total_salary');
    $iqamaAmount = SalaryHistory::where('slh_month',$month)->where('slh_year',$year)->sum('slh_iqama_advance');
    $totalHours = SalaryHistory::where('slh_month',$month)->where('slh_year',$year)->sum('slh_total_hours');

     if($salaryReport){

       if($empType == 1){
           return view('admin.salary-generate.direct-man.all-salary',compact('salaryReport','monthName','company','project'));
       }else{
           return view('admin.salary-generate.indirect-man.all-salary',compact('salaryReport','monthName','company','project'));
       }



     }else{
       Session::flash('salaryRecordNotFound','value');
       return redirect()->back();
     }

  }


  /* =================== Month Wise Salary =================== */
  public function monthWiseSalary(Request $request){

    $month = $request->month;
    $year = Carbon::now()->format('Y');

    $HelperOBJ = new HelperController();
    $monthName = $HelperOBJ->getMonthName($month);

    /* ========== Company Profile ========== */
    $companyOBJ = new CompanyProfileController();
    $company = $companyOBJ->findCompanry();


    $salaryReport = SalaryHistory::with('employee')->where('slh_month',$month)->where('slh_year',$year)->get();
    $allSalaryAmount = SalaryHistory::where('slh_month',$month)->where('slh_year',$year)->sum('slh_total_salary');
    $iqamaAmount = SalaryHistory::where('slh_month',$month)->where('slh_year',$year)->sum('slh_iqama_advance');
    $totalHours = SalaryHistory::where('slh_month',$month)->where('slh_year',$year)->sum('slh_total_hours');
    // find Salary Record This Month
    if($salaryReport){
      // Condition Wise Check
      foreach ($salaryReport as $salary){
        if($salary->hourly_employee == true){
          $others = $salary->others;
        }else{
          $others = ($salary->house_rent + $salary->conveyance_allowance + $salary->medical_allowance + $salary->others);
        }
        // Condition Wise Check
        $salary->otherAmount = $others;
      }



      return view('admin.salary-generate.all-employee.all_salary',compact('salaryReport','monthName','company','allSalaryAmount','iqamaAmount','totalHours'));

    }else{
      Session::flash('salaryRecordNotFound','value');
      return redirect()->back();
    }
  }






  /*
  |--------------------------------------------------------------------------
  |  BLADE OPERATION
  |--------------------------------------------------------------------------
  */
  public function index(){
    return null;
  }

  public function create(){
    $currentMonth = Carbon::now()->format('m');
    // Call Project Info Controller
    $project = new ProjectInfoController();
    $projects = $project->getAllInfo();
    // Call Month Controller
    $monthOBJ = new MonthController();
    $month = $monthOBJ->getAll();
    // Call Employee Info Controller
    $emp_type_obj = new EmployeeTypeController();
    $emp_types = $emp_type_obj->getEmployeeTypeAll();

    return view('admin.salary-generate.salary-proccessing',compact('month','currentMonth','projects','emp_types'));
  }





  /*
  |--------------------------------------------------------------------------
  |  API OPERATION
  |--------------------------------------------------------------------------
  */
}
