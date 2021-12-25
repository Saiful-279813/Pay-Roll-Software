<?php

namespace App\Http\Controllers\Admin\InOut;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\MonthController;
use App\Http\Controllers\Admin\CompanyProfileController;
use App\Http\Controllers\Admin\ProjectInfoController;
use App\Http\Controllers\Admin\Helper\HelperController;
use Illuminate\Http\Request;
use App\Models\EmployeeInOut;
use App\Models\EmployeeInfo;
use App\Models\MonthlyWorkHistory;
use App\Models\SalaryDetails;
use Carbon\Carbon;
use Auth;


class EmployeeInOutController extends Controller{
    /*
    |--------------------------------------------------------------------------
    |  DATABASE OPERATION
    |--------------------------------------------------------------------------
    */

    /* Ajax method */
    /* =============== Entry Time Insert =============== */
    public function timeInsert(Request $request){
      /* insert data in database */
      $emp_id = $request->emp_id;
      $creator = Auth::user()->id;
      $emp_io_shift = $request->emp_io_shift;

      $catchDate = $request->date;
      $date = Carbon::createFromFormat('Y-m-d', $catchDate)->format('d');
      $month = Carbon::createFromFormat('Y-m-d', $catchDate)->format('m');
      $year = Carbon::createFromFormat('Y-m-d', $catchDate)->format('Y');

      $findEmployee = EmployeeInfo::where('employee_id',$emp_id)->first();


      if($findEmployee){

        $findTodayEntry = EmployeeInOut::where('emp_io_date',$date)->where('emp_io_month',$month)->where('emp_io_year',$year)->where('emp_id',$findEmployee->emp_auto_id)->first();

          if($findTodayEntry){
            return response()->json(['error' => 'This Data Already Exists']);
          }else{
            $insert = EmployeeInOut::insert([
              'emp_id' => $findEmployee->emp_auto_id,
              'emp_io_date' => $date,
              'emp_io_month' => $month,
              'emp_io_year' => $year,
              'emp_io_shift' => $emp_io_shift,

              'emp_io_entry_time' => $request->entry_time,
              'emp_io_out_time' => 0,

              'create_by_id' => $creator,
              'emp_io_entry_date' => Carbon::now(),
              'created_at' => Carbon::now(),
            ]);

            return response()->json(['success' => 'Successfully Added Employee Entry Time']);
          }
      }else{
          return response()->json(['error' => 'Employee Not Found!']);
      }
    }
    /* =============== Out Time Insert =============== */
    public function outTimeInsert(Request $request){
      // Catch Request Value
      $empInOutId = $request->id;
      $out_time = $request->out_time;
      $empId = $request->empId;
      $month = $request->month;
      $year = $request->year;
      $hours = 0;



      $attend = EmployeeInOut::where('emp_io_id',$empInOutId)->first();


      if($attend->emp_io_shift == 1){  // night sheeft
        $hours  = ($out_time - $attend->emp_io_entry_time)+24;
      }else{
        $hours = ($out_time - $attend->emp_io_entry_time);
      }


      $outTimeInsert = EmployeeInOut::where('emp_io_id',$empInOutId)->update([
        'emp_io_out_time' => $out_time,
        'daily_work_hours' => $hours,
        'updated_at' => Carbon::now(),
      ]);

      // fine total work time
      $totalTime = EmployeeInOut::where('emp_io_id',$empInOutId)->first();

      /* update month work history */
      $findEmployeeInMonthWork = MonthlyWorkHistory::where('emp_id',$empId)->where('month_id',$month)->where('year_id',$year)->first();
      /* =============== Overtime Calculation =============== */
      $overtime;

      if($totalTime->employee->hourly_employee == true ){
        $overtime = 0;
      }else{

        if( ($totalTime->daily_work_hours - 10) > 0){
          $overtime = $totalTime->daily_work_hours - 10;
        }else{
          $overtime = 0;
        }

      }




      if($findEmployeeInMonthWork){
        /* old hours ,day overtime */
        $oldOvertime = $findEmployeeInMonthWork->overtime;
        $oldTotalHours = $findEmployeeInMonthWork->total_hours;
        $oldDays = $findEmployeeInMonthWork->total_work_day;

        //
        $update = MonthlyWorkHistory::where('emp_id',$empId)->where('month_id',$month)->where('year_id',$year)->update([
          'total_hours' => $oldTotalHours + $totalTime->daily_work_hours,
          'overtime' => $oldOvertime + $overtime,
          'total_work_day' => $oldDays + 1,
          'updated_at' => Carbon::now()
        ]);


      }else{
        $insert = MonthlyWorkHistory::insert([
          'emp_id' => $empId,
          'month_id' => $month,
          'year_id' => $year,
          'total_hours' => $totalTime->daily_work_hours,
          'overtime' =>  $overtime,
          'total_work_day' =>  1,
          'entered_id' =>  Auth::user()->id,
          'created_at' => Carbon::now(),
        ]);

      }

      /* update month work history */

      // return response()->json(['data' => $totalTime->daily_work_hours]);

      if($outTimeInsert){
        return response()->json(['success' => 'Successfully Added Employee Out Time']);
      }else{
        return response()->json(['error' => 'Opps! Please Try Again']);
      }



    }

    // public function getEmployeeEntryTime(){
    //   $getAll = EmployeeInOut::with('employee')->orderBy('emp_io_id','DESC')->get();
    //   return json_encode($getAll);
    // }
    /* Ajax method */

    public function processEntryList(Request $request){
      $proj_id = $request->proj_name;

      $catchDate = $request->date;
      $date = Carbon::createFromFormat('Y-m-d', $catchDate)->format('d');
      $month = Carbon::createFromFormat('Y-m-d', $catchDate)->format('m');
      $year = Carbon::createFromFormat('Y-m-d', $catchDate)->format('Y');



      $getAll = EmployeeInOut::where('employee_infos.project_id',$proj_id)
                              ->where('employee_in_outs.emp_io_date',$date)
                              ->where('employee_in_outs.emp_io_month',$month)
                              ->where('employee_in_outs.emp_io_year',$year)
                              ->where('employee_in_outs.emp_io_out_time',0)
                              ->leftjoin('employee_infos','employee_in_outs.emp_id','=','employee_infos.emp_auto_id')->get();

      if($getAll == true){
          return response()->json([ "entryList" => $getAll ]);
      }else{
          return response()->json([ 'error' => "Data Not Found!" ]);
      }



    }

    public function reportProcess(Request $request){
      $month = $request->month_id;
      $year = Carbon::now()->format('Y');

      $helperOBJ = new HelperController();
      $monthName = $helperOBJ->getMonthName($month);

      $compObj = new CompanyProfileController();
      $company = $compObj->findCompanry();
      // $workTimereport = EmployeeInOut::whereBetween('emp_io_entry_date', [$start_date, $end_date])->get();
      // $directEmp = EmployeeInfo::where('emp_type_id',1)->get();
      $directEmp = EmployeeInfo::where('job_status',1)->get(); // active employee

      $count = 0;
      foreach($directEmp as $emp){

        $Attendence = EmployeeInOut::where('emp_id',$emp->emp_auto_id)->where('emp_io_year',$year)->where('emp_io_month',$month)->orderBy('emp_io_date','ASC')->get();

        $findBasicHours = SalaryDetails::where('emp_id',$emp->emp_auto_id)->first();
        $basicHours = $findBasicHours->basic_hours;
        $hoursPerDay = 10;//$basicHours > 0 ? round(($basicHours / 26)): 0;
        $emp->perDayHours = $hoursPerDay;

        $allAttend = array_fill(0,33,' ');
        $totalWorkingDays = array_fill(0,33,' ');



        $totalHours = 0;
        foreach ($Attendence as $attend) {
        //  dd($emp->daily_work_hours);

          $attendday = (int) $attend->emp_io_date;
          //$hours = ($attend->emp_id_total_hours - $attend->emp_id_total_hours);
          // $totalHours +=  $hours;


          $allAttend[$attendday] = 0;
          if($attend->daily_work_hours >= 10){
            $allAttend[$attendday] = ($attend->daily_work_hours-$hoursPerDay);
          }




          $totalHours +=   $allAttend[$attendday] ;

          $totalWorkingDays[$attendday] = $hoursPerDay;

        }
         $allAttend[32] = $totalHours;
         $emp->atten = $allAttend;
         $emp->totalWorkingDays = $totalWorkingDays;
 
 
      }

    //  dd($directEmp);
       return view('admin.employee-in-out.report-generate',compact('company','directEmp','monthName','year'));
    }
    /*
    |--------------------------------------------------------------------------
    |  BLADE OPERATION
    |--------------------------------------------------------------------------
    */

    public function index(){
      /* month controller */
      $monthObj = new MonthController();
      $month = $monthObj->getAll();
      return view('admin.employee-in-out.index',compact('month'));
    }

    public function entryList(){
      /* project object */
      $projObj = new ProjectInfoController();
      $project = $projObj->getAllInfo();

      return view('admin.employee-in-out.all',compact('project'));
    }

    public function report(){
      /* month controller */
      $monthObj = new MonthController();
      $month = $monthObj->getAll();
      return view('admin.employee-in-out.report',compact('month'));
    }















    /*
    |--------------------------------------------------------------------------
    |  API OPERATION
    |--------------------------------------------------------------------------
    */
}
