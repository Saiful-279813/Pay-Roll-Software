<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ProjectInfoController;
use App\Http\Controllers\Admin\EmployeeTypeController;
use Illuminate\Http\Request;
use App\Models\Month;
use App\Models\EmployeeInfo;
use App\Models\MonthlyWorkHistory;
use App\Models\CompanyProfile;
use App\Models\SalaryDetails;
use App\Models\SalaryHistory;
use App\Models\AdvancePayHistory;
use App\Models\AdvancePay;
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

  // public function month(){
  //   $currentMonth = Carbon::now()->format('m');
  //   return $month = Month::where('month_id','>=',$currentMonth-1)->where('month_id','<=',$currentMonth)->get();
  // }

  public function month(){
    return $month = Month::get();
  }


  public function company(){
    return $compAll = CompanyProfile::where('comp_id',1)->first();
  }

  /* ===================== Single Employee Salary Generate ===================== */
  public function salaryGenerate(Request $request){
    /* Catch Two value in Request */
    $emp_id = $request->emp_id;
    $month = $request->month;
    /* current year formating */
    $year = Carbon::now()->format('Y');
    /* Calling Company */
    $company = $this->company();
    /* find employee */
    $findEmployee = EmployeeInfo::where('employee_id',$emp_id)->first();
    if($findEmployee){
      $empSalary =  EmployeeInfo::where("employee_infos.emp_auto_id",$findEmployee->emp_auto_id)
                    ->where("monthly_work_histories.month_id",$month)->where('year_id',$year)
                    ->leftjoin('advance_pays','employee_infos.emp_auto_id' , '=' ,'advance_pays.emp_id')
                    ->leftjoin('salary_details','employee_infos.emp_auto_id' , '=' , 'salary_details.emp_id')
                    ->leftjoin('monthly_work_histories','employee_infos.emp_auto_id' , '=' , 'monthly_work_histories.emp_id')->first();
       /* end query */
       if($empSalary){


         $totalOthers = ($empSalary->house_rent + $empSalary->conveyance_allowance + $empSalary->mobile_allowance + $empSalary->medical_allowance + $empSalary->local_travel_allowance + $empSalary->food_allowance + $empSalary->others1);

      // $others12 = ($empSalary->house_rent + $empSalary->conveyance_allowance + $empSalary->others1 + $empSalary->local_travel_allowance);

          $over_amount = 0;
          $total_amount = 0;
         if($empSalary->basic_hours ==  0 && $empSalary->basic_amount == 0){
              //  $over_amount = ($empSalary->overtime * $empSalary->hourly_rent);
                $total_amount = ($empSalary->total_hours * $empSalary->hourly_rent);
                $totalOthers = 0;
              //  dd($empSalary->total_amount);
          }
        elseif($empSalary->basic_hours > 0 && $empSalary->basic_amount > 0){
             $over_amount = ($empSalary->overtime * $empSalary->hourly_rent);
             $total_amount = $empSalary->basic_amount  + $over_amount;
        }
        elseif($empSalary->basic_amount > 0){


          // $totalOthers = ($empSalary->house_rent + $empSalary->conveyance_allowance + $empSalary->mobile_allowance + $empSalary->medical_allowance + $empSalary->local_travel_allowance + $empSalary->food_allowance + $empSalary->others1);

          $empSalary->allOthers = ($empSalary->house_rent + $empSalary->conveyance_allowance + $empSalary->others1);
          $total_amount = ($empSalary->basic_amount) ;
          //  dd($empSalary->allOthers);

        }

        $netSalary = ($total_amount + $totalOthers);
        $grossSalary = ($netSalary - $empSalary->installes_amount);
        $empSalary->gross_salary = $grossSalary;


    //  dd($empSalary->gross_salary);

         if($findEmployee->emp_type_id == 1){
           return view('admin.salary-generate.direct-man.salary',compact('empSalary','company','year','month','findEmployee'));
         }else{
           return view('admin.salary-generate.indirect-man.salary',compact('empSalary','company','year','month','findEmployee'));
         }

       }else{
         Session::flash('error_add3','value');
         return redirect()->back();
       }
      /* end if start else */
    }else{
      Session::flash('error_add2','value');
      return redirect()->back();
    }


  }

  /* ===================== All Employee Salary Generate ===================== */
  public function allEmpSalary(Request $request){
    // $emp_id = $request->emp_id;
    $month = $request->month;
    $project = $request->proj_id;
    $emp_type = $request->emp_type_id;

    $company = $this->company();
    $year = Carbon::now()->format('Y');


    $allEmpSalary =  EmployeeInfo::where("employee_infos.job_status",1)
                        ->where("employee_infos.emp_type_id",$emp_type)
                        ->where("employee_infos.project_id",$project)
                        ->where('monthly_work_histories.month_id',$month)

                       ->leftjoin('employee_categories','employee_infos.designation_id' , '=' , 'employee_categories.catg_id')

                       ->leftjoin('salary_details','employee_infos.emp_auto_id' , '=' , 'salary_details.emp_id')
                       ->leftjoin('advance_pays','employee_infos.emp_auto_id' , '=' ,'advance_pays.emp_id')
                       ->leftjoin('monthly_work_histories','employee_infos.emp_auto_id' , '=' , 'monthly_work_histories.emp_id')
                       // ->select('employee_categories.catg_name')
                       ->get()->all();


    $findProject = EmployeeInfo::where('project_id',$project)->first();
    if($allEmpSalary){

      foreach ($allEmpSalary as $empSalary) {



        $totalOthers = ($empSalary->house_rent + $empSalary->conveyance_allowance + $empSalary->mobile_allowance + $empSalary->medical_allowance + $empSalary->local_travel_allowance + $empSalary->food_allowance + $empSalary->others1);

     // $others12 = ($empSalary->house_rent + $empSalary->conveyance_allowance + $empSalary->others1 + $empSalary->local_travel_allowance);

         $over_amount = 0;
         $total_amount = 0;
        if($empSalary->basic_hours ==  0 && $empSalary->basic_amount == 0){
             //  $over_amount = ($empSalary->overtime * $empSalary->hourly_rent);
               $total_amount = ($empSalary->total_hours * $empSalary->hourly_rent);
               $totalOthers = 0;
             //  dd($empSalary->total_amount);
         }
       elseif($empSalary->basic_hours > 0 && $empSalary->basic_amount > 0){
            $over_amount = ($empSalary->overtime * $empSalary->hourly_rent);
            $total_amount = $empSalary->basic_amount  + $over_amount;
       }
       elseif($empSalary->basic_amount > 0){


         // $totalOthers = ($empSalary->house_rent + $empSalary->conveyance_allowance + $empSalary->mobile_allowance + $empSalary->medical_allowance + $empSalary->local_travel_allowance + $empSalary->food_allowance + $empSalary->others1);

         $empSalary->allOthers = ($empSalary->house_rent + $empSalary->conveyance_allowance + $empSalary->others1);

         // dd($empSalary->allOthers);
         $total_amount = ($empSalary->basic_amount) ;

       }

       $netSalary = ($total_amount + $totalOthers);
       // dd($netSalary);

       $grossSalary = ($netSalary - $empSalary->installes_amount);
       $empSalary->gross_salary = $grossSalary;

      }

      if($emp_type == 1){
          return view('admin.salary-generate.direct-man.all-salary',compact('allEmpSalary','company','findProject','year','month','project','emp_type'));
      }else{
          return view('admin.salary-generate.indirect-man.all-salary',compact('allEmpSalary','company','findProject','year','month','project','emp_type'));
      }
    }else{
      Session::flash('error_add','value');
      return redirect()->back();
    }

  }


  /* Month Wise Salary */
  public function monthWiseSalary(Request $request){
    $company = $this->company();
    $year = Carbon::now()->format('Y');
    $month = $request->month;
    $allEmpSalary =  EmployeeInfo::where("employee_infos.job_status",1)
                     ->where('monthly_work_histories.month_id',$month)
                     ->leftjoin('salary_details','employee_infos.emp_auto_id' , '=' , 'salary_details.emp_id')
                     ->leftjoin('advance_pays','employee_infos.emp_auto_id' , '=' ,'advance_pays.emp_id')
                     ->leftjoin('monthly_work_histories','employee_infos.emp_auto_id' , '=' , 'monthly_work_histories.emp_id')->get()->all();
      return view('admin.salary-generate.all-employee.all_salary',compact('allEmpSalary','company','year','month'));
  }


  public function employeeSalary($month){
   return  $allEmpSalary =  EmployeeInfo::where("employee_infos.job_status",1)
                        ->where('monthly_work_histories.month_id',$month)
                       ->leftjoin('salary_details','employee_infos.emp_auto_id' , '=' , 'salary_details.emp_id')
                       ->leftjoin('advance_pays','employee_infos.emp_auto_id' , '=' ,'advance_pays.emp_id')
                       ->leftjoin('monthly_work_histories','employee_infos.emp_auto_id' , '=' , 'monthly_work_histories.emp_id')->get()->all();

  }








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
      $totalOthers = ($salary->house_rent + $salary->conveyance_allowance + $salary->mobile_allowance + $salary->medical_allowance + $salary->local_travel_allowance + $salary->food_allowance + $salary->others1);

       $over_amount = 0;
       $total_amount = 0;
      if($salary->basic_hours ==  0 && $salary->basic_amount == 0){
           //  $over_amount = ($empSalary->overtime * $empSalary->hourly_rent);
             $total_amount = ($salary->total_hours * $salary->hourly_rent);
             $totalOthers = 0;
           //  dd($empSalary->total_amount);
       }
     elseif($salary->basic_hours > 0 && $salary->basic_amount > 0){
          $over_amount = ($salary->overtime * $salary->hourly_rent);
          $total_amount = $salary->basic_amount  + $over_amount;
     }
     elseif($salary->basic_amount > 0){

       $salary->allOthers = ($salary->house_rent + $salary->conveyance_allowance + $salary->others1);

       // dd($empSalary->allOthers);
       $total_amount = ($salary->basic_amount) ;

     }

     $netSalary = ($total_amount + $totalOthers);
     // dd($netSalary);

     $grossSalary = ($netSalary - $salary->installes_amount);
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
          $creator = Auth::user()->id;
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
          'food_allowance' => $salary->food_allowance,
          'others' => $salary->others1,
          /* New field in Salary History */
          'slh_total_salary' => $salary->gross_salary,
          'slh_total_hours' => $salary->total_hours,
          'slh_total_working_days' => $salary->total_work_day,
          'slh_month' => $month,
          'slh_year' => $year,
          'slh_cpf_contribution' => 0,
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
          /* New field in Salary History */
          'slh_total_salary' => $salary->gross_salary,
          'slh_total_hours' => $salary->total_hours,
          'slh_total_working_days' => $salary->total_work_day,
          'slh_month' => $month,
          'slh_year' => $year,
          'slh_cpf_contribution' => 0,
          'slh_company_contribution' => 0,
          'slh_iqama_advance' => $iqamaAdvance,
          'slh_other_advance' => $othersAdvance,
          'slh_salary_date' => Carbon::now(),
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





  /* ===================== Add Salary History ===================== */
  public function addSalaryHistory(Request $request)
  {
      /* Catch value in Request */
      $month = $request->month;
      $year = $request->year;
      $date = $request->date;
      /* Call employeeSalary Method */
      $employeeSalary = $this->employeeSalary($month);

      /* Add Data Salary History */
      foreach ($employeeSalary as $salary)
      {
        /* Calculation data */
        if($salary->emp_type_id == 1){
          /* ================ Calculation Direct Manpower ================= */
              /* Total Others */
          $totalOthers = ($salary->conveyance_allowance + $salary->mobile_allowance + $salary->medical_allowance + $salary->local_travel_allowance + $salary->food_allowance + $salary->others1);
              /* Others */
          $others = ($salary->conveyance_allowance + $salary->others1 + $salary->local_travel_allowance);
              /* Overtime */
          $over_amount = ($salary->overtime * $salary->hourly_rent);
          $total_amount = ($salary->total_hours * $salary->hourly_rent) + $over_amount;
             /* Net Amount */
          $netSalary = ($total_amount + $totalOthers);
             /* Total Amount */
          $growsSalary = ($netSalary - $salary->installes_amount);
          /* end if start else */
        }else{
          /* ================ Calculation InDirect Man Power ================= */
          $totalOthers = ($salary->house_rent + $salary->conveyance_allowance + $salary->mobile_allowance + $salary->medical_allowance + $salary->local_travel_allowance + $salary->food_allowance + $salary->others1);
          /* Total Amount */
          $growsSalary = ($salary->basic_amount + $totalOthers) - $salary->installes_amount;
        }

        /* find Employee Advance Payment */
        $findEmployeeAdvance = AdvancePay::where('emp_id',$salary->emp_auto_id)->first();
        if($findEmployeeAdvance){
          /* fine Advance History */
          $findPayHistory = AdvancePayHistory::where('aph_month',$month)->where('aph_year',$year)->first();
          if(!$findPayHistory){
            /* update advance pay */
            $installAmount = ($findEmployeeAdvance->adv_pay_amount / $findEmployeeAdvance->installes_month);
            $update = AdvancePay::where('emp_id',$salary->emp_auto_id)->update([
              'installes_amount' => $installAmount,
              'updated_at' => Carbon::now(),
            ]);
            /* insert data in advance history */
            $creator = Auth::user()->id;
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
          $insert = SalaryHistory::where('slh_auto_id',$fixDuplicateSalary->slh_auto_id)->update([
            'emp_auto_id' => $salary->emp_auto_id,

            'slh_total_hours' => $salary->total_hours,
            'slh_total_working_days' => $salary->total_work_day,

            'slh_total_salary' => $growsSalary,

            'slh_month' => $month,
            'slh_year' => $year,
            'slh_cpf_contribution' => 0,
            'slh_company_contribution' => 0,
            'slh_iqama_advance' => 0,
            'slh_other_advance' => 0,
            'slh_salary_date' => Carbon::now(),
            'updated_at' => Carbon::now(),
          ]);
        }else {
          $insert = SalaryHistory::insertGetId([
            'emp_auto_id' => $salary->emp_auto_id,
            'slh_total_salary' => $growsSalary,
            'slh_total_hours' => $salary->total_hours,
            'slh_total_working_days' => $salary->total_work_day,
            'slh_month' => $month,
            'slh_year' => $year,
            'slh_cpf_contribution' => 0,
            'slh_company_contribution' => 0,
            'slh_iqama_advance' => 0,
            'slh_other_advance' => 0,
            'slh_salary_date' => Carbon::now(),
            'created_at' => Carbon::now(),
          ]);
        }


     }


      if($insert){
        Session::flash('success','value');
        return redirect()->route('salary-generat');
      }else{
        Session::flash('error','value');
        return redirect()->route('salary-generat');
      }



  }

  /* ===================== Add Salary History single employee ===================== */
  public function singleEmployeeSalary($month,$empId){
    return $employee = EmployeeInfo::where("employee_infos.emp_auto_id",$empId)
                ->where('monthly_work_histories.month_id',$month)
                ->leftjoin('salary_details','employee_infos.emp_auto_id' , '=' , 'salary_details.emp_id')
                ->leftjoin('advance_pays','employee_infos.emp_auto_id' , '=' ,'advance_pays.emp_id')
                ->leftjoin('monthly_work_histories','employee_infos.emp_auto_id' , '=' , 'monthly_work_histories.emp_id')->first();
  }


  public function addSignleEmployeeSalaryHistory(Request $request){
    /* catch value in request */
    $month = $request->month;
    $project = $request->project;
    $emp_type = $request->emp_type;
    $year = $request->year;
    $date = $request->date;
    $empId = $request->emp_id;
    /* query in salary history */
    $salary = $this->singleEmployeeSalary($month,$empId);
    /* Calculation data */
    if($salary->emp_type_id == 1){
      /* ================ Calculation Direct Manpower ================= */
          /* Total Others */
      $totalOthers = ($salary->conveyance_allowance + $salary->mobile_allowance + $salary->medical_allowance + $salary->local_travel_allowance + $salary->food_allowance + $salary->others1);
          /* Others */
      $others = ($salary->conveyance_allowance + $salary->others1 + $salary->local_travel_allowance);
          /* Overtime */
      $over_amount = ($salary->overtime * $salary->hourly_rent);
      $total_amount = ($salary->total_hours * $salary->hourly_rent) + $over_amount;
         /* Net Amount */
      $netSalary = ($total_amount + $totalOthers);
         /* Total Amount */
      $growsSalary = ($netSalary - $salary->installes_amount);
      /* end if start else */
    }else{
      /* ================ Calculation InDirect Man Power ================= */
      $totalOthers = ($salary->house_rent + $salary->conveyance_allowance + $salary->mobile_allowance + $salary->medical_allowance + $salary->local_travel_allowance + $salary->food_allowance + $salary->others1);
      /* Total Amount */
      $growsSalary = ($salary->basic_amount + $totalOthers) - $salary->installes_amount;
    }

    /* find Employee Advance Payment */
    $findEmployeeAdvance = AdvancePay::where('emp_id',$empId)->first();
    if($findEmployeeAdvance){
      /* fine Advance History */
      $findPayHistory = AdvancePayHistory::where('aph_month',$month)->where('aph_year',$year)->first();
      if(!$findPayHistory){
        /* update advance pay */
        $installAmount = ($findEmployeeAdvance->adv_pay_amount / $findEmployeeAdvance->installes_month);
        $update = AdvancePay::where('emp_id',$empId)->update([
          'installes_amount' => $installAmount,
          'updated_at' => Carbon::now(),
        ]);
        /* insert data in advance history */
        $creator = Auth::user()->id;
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


    /* Check Salary History Table For Skip Duplicate data */
    $fixDuplicateSalary = SalaryHistory::where('emp_auto_id',$empId)->first();
    /* Implement Condition */
    if($fixDuplicateSalary){
      $insert = SalaryHistory::where('slh_auto_id',$fixDuplicateSalary->slh_auto_id)->update([
        'emp_auto_id' => $salary->emp_auto_id,
        'slh_total_salary' => $growsSalary,
        'slh_total_hours' => $salary->total_hours,
        'slh_total_working_days' => $salary->total_work_day,
        'slh_month' => $month,
        'slh_year' => $year,




        'slh_cpf_contribution' => 0,
        'slh_company_contribution' => 0,
        'slh_iqama_advance' => 0,
        'slh_other_advance' => 0,
        'slh_salary_date' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ]);
      /* end if start else */
    }else{
      $insert = SalaryHistory::insertGetId([
        'emp_auto_id' => $salary->emp_auto_id,
        'slh_total_salary' => $growsSalary,
        'slh_total_hours' => $salary->total_hours,
        'slh_total_working_days' => $salary->total_work_day,
        'slh_month' => $month,
        'slh_year' => $year,
        'slh_cpf_contribution' => 0,
        'slh_company_contribution' => 0,
        'slh_iqama_advance' => 0,
        'slh_other_advance' => 0,
        'slh_salary_date' => Carbon::now(),
        'created_at' => Carbon::now(),
      ]);
      /* end else */
    }
    /* redirect Salary Generat Page */
    if($insert){
      Session::flash('success','value');
      return redirect()->route('salary-generat');
    }else{
      Session::flash('error','value');
      return redirect()->route('salary-generat');
    }




  }








  /* ===================== Download Pdf ===================== */
  public function downloadPdf($project,$month,$emp_type){
    $employeeSalary = $this->employeeSalary($project,$month,$emp_type);

    // dd($employeeSalary);

    $pdf = PDF::loadView('admin.salary-generate.PDF.all-direct');
    return $pdf->download('salary-report.pdf');


  }



  /*
  |--------------------------------------------------------------------------
  |  BLADE OPERATION
  |--------------------------------------------------------------------------
  */
  public function index(){
    $project = new ProjectInfoController();
    $projects = $project->getAllInfo();
    $month = $this->month();
    $emp_type_obj = new EmployeeTypeController();
    $emp_types = $emp_type_obj->getEmployeeTypeAll();

    return view('admin.salary-generate.all',compact('month','projects','emp_types'));
  }

  public function create(){
    $currentMonth = Carbon::now()->format('m');
    $month = $this->month();
    return view('admin.salary-generate.salary-proccessing',compact('month','currentMonth'));
  }





  /*
  |--------------------------------------------------------------------------
  |  API OPERATION
  |--------------------------------------------------------------------------
  */
}
