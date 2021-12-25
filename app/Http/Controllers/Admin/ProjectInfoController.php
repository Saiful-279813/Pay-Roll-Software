<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\CompanyProfileController;
use App\Http\Controllers\Admin\Helper\HelperController;
use Illuminate\Http\Request;
use App\Models\ProjectInfo;
use App\Models\EmployeeInfo;
use App\Models\ProjectImgUpload;
use Carbon\Carbon;
use DateTime;
use Session;
use Image;

class ProjectInfoController extends Controller{
    /*
    |--------------------------------------------------------------------------
    |  DATABASE OPERATION
    |--------------------------------------------------------------------------
    */
    /* GET ALL Project */
    public function getAllInfo(){
      return $all = ProjectInfo::where('status',1)->orderBy('proj_id','DESC')->get();
    }
    /* GET FIND Project */
    public function getFindId($id){
      return $find = ProjectInfo::where('status',1)->where('proj_id',$id)->first();
    }
    /* GET Project MULTIPLE IMAGE */
    public function getMultipleImage($proj_id){
      return $find = ProjectImgUpload::where('project_id',$proj_id)->get();
    }
    /* GET FIND Employee */
    public function findEmployee(Request $request){
      $emp_id = $request->emp_id;
      $findEmployee = EmployeeInfo::with('department','category')->where('employee_id',$emp_id)->first();
      if($findEmployee){
        return response()->json([ 'findEmployee' => $findEmployee]);
      }else{
        return response()->json([ 'status' => 'error' ]);
      }

    }
    /* FIND VALID Employee */
    public function validEmployee(Request $request){
      $emp_id = $request->emp_id;
      $findEmployee = EmployeeInfo::where('employee_id',$emp_id)->first();
      if($findEmployee){
        return response()->json([ 'status' => 'success' ]);
      }else{
        return response()->json([ 'status' => 'error' ]);
      }

    }
    /* DELETE Project */
    public function delete($id){
      $delete = ProjectInfo::where('proj_id',$id)->update([
        'status' => 0,
        'updated_at' => Carbon::now(),
      ]);
      /* redirect back */
      if($delete){
        Session::flash('success_soft','value');
        return redirect()->back();
      } else{
        Session::flash('error','value');
        return redirect()->back();
      }
    }
    /* INSERT Project */
    public function insert(Request $req){
      /* form validation */
      $this->validate($req,[
        'proj_name' => 'required',
        'starting_date' => 'required',
        'address' => 'required',
        'proj_code' => 'required',
        'proj_budget' => 'required|integer',
        'proj_deadling' => 'required',
      ],[
        'proj_budget.integer' => 'please enter project budget amount'
      ]);
      /* insert data in database */
        if($req->file('proj_main_thumb') !="" ){

          $proj_main_thumb = $req->file('proj_main_thumb');
          $proj_main_thumb_name = 'Emp-profile-image-'.time().'.'.$proj_main_thumb->getClientOriginalExtension();
          Image::make($proj_main_thumb)->resize(491,359)->save('uploads/project/'.$proj_main_thumb_name);
          $uplodPath = 'uploads/project/'.$proj_main_thumb_name;


          $insert = ProjectInfo::insert([
            'proj_name' => $req->proj_name,
            'starting_date' => $req->starting_date,
            'address' => $req->address,
            'proj_code' => $req->proj_code,
            'proj_budget' => $req->proj_budget,
            'proj_deadling' => $req->proj_deadling,
            'proj_description' => $req->proj_description,
            'proj_main_thumb' => $uplodPath,
            'created_at' => Carbon::now(),
          ]);

        }else {

          $insert = ProjectInfo::insert([
            'proj_name' => $req->proj_name,
            'starting_date' => $req->starting_date,
            'address' => $req->address,
            'proj_code' => $req->proj_code,
            'proj_budget' => $req->proj_budget,
            'proj_deadling' => $req->proj_deadling,
            'proj_description' => $req->proj_description,
            'created_at' => Carbon::now(),
          ]);

        }

        /* redirect back */
        if($insert){
          Session::flash('success','value');
          return redirect()->back();
        } else{
          Session::flash('error','value');
          return redirect()->back();
        }

    }
    /* UPDATE Project */
    public function update(Request $req){
      /* form validation */
      $this->validate($req,[
        'proj_name' => 'required',
        'starting_date' => 'required',
        'address' => 'required',
        'proj_code' => 'required',
        'proj_budget' => 'required|integer',
        'proj_deadling' => 'required',
      ],[
        'proj_budget.integer' => 'please enter project budget amount'
      ]);
      /* insert data in database */
      $id = $req->id;
      $update = ProjectInfo::where('proj_id',$id)->update([
        'proj_name' => $req->proj_name,
        'starting_date' => $req->starting_date,
        'address' => $req->address,
        'proj_code' => $req->proj_code,
        'proj_budget' => $req->proj_budget,
        'proj_deadling' => $req->proj_deadling,
        'updated_at' => Carbon::now(),
      ]);
      /* redirect back */
      if($update){
        Session::flash('success_update','value');
        return redirect()->route('project-info');
      } else{
        Session::flash('error','value');
        return redirect()->back();
      }
    }

    /* Insert Project In-charge */
    public function InsertProjectInchage(Request $request){
      $project = $request->proj_name;
      $emp_id = $request->emp_id;
      /* insert Project incharge */
      $update = ProjectInfo::where('proj_id',$project)->update([
        'proj_Incharge_id' => $emp_id,
        'updated_at' => Carbon::now()
      ]);

      /* redirect back */
      if($update){

        Session::flash('success_incharge','value');
        return redirect()->route('project-info');
      } else{
        Session::flash('error','value');
        return redirect()->back();
      }
    }

    /* Project Wise Total Hours */
    public function projectWiseTotalWorkHoursGenerat(Request $request){
      $proj_id = $request->proj_id;
      // $start_date = $request->start_date->format('d');

      $start_date = date('d', strtotime($request->start_date));
      $start_month = date('m', strtotime($request->start_date));
      $start_year = date('Y', strtotime($request->start_date));

      $end_date = date('d', strtotime($request->end_date));
      $end_month = date('m', strtotime($request->end_date));
      $end_year = date('Y', strtotime($request->end_date));

      $helperOBJ = new HelperController();
      $toMonth = $helperOBJ->getMonthName($start_month);
      $endMonth = $helperOBJ->getMonthName($end_month);



      // year_id/
      /* Query in Project */
      $project = ProjectInfo::where('proj_id',$proj_id)->first();
      if($project){
        /* Query in Employee and monthly Work History */
        $companyObj = new CompanyProfileController();
        $company = $companyObj->findCompanry();
        $projectWiseTotalWork = EmployeeInfo::where('employee_infos.project_id',$project->proj_id)
                                ->whereBetween("monthly_work_histories.month_id", [$start_month,$end_month])
                                ->whereBetween("monthly_work_histories.year_id", [$start_year,$end_year])
                                ->leftjoin('monthly_work_histories','employee_infos.emp_auto_id' , '=' ,'monthly_work_histories.emp_id')
                                ->leftjoin('employee_categories','employee_infos.designation_id' , '=' ,'employee_categories.catg_id')
                                ->get();

        $totalHours = EmployeeInfo::where('employee_infos.project_id',$project->proj_id)
                                ->whereBetween("monthly_work_histories.month_id", [$start_month,$end_month])
                                ->whereBetween("monthly_work_histories.year_id", [$start_year,$end_year])
                                ->leftjoin('monthly_work_histories','employee_infos.emp_auto_id' , '=' ,'monthly_work_histories.emp_id')
                                ->sum('total_hours');

        $overtime = EmployeeInfo::where('employee_infos.project_id',$project->proj_id)
                                ->whereBetween("monthly_work_histories.month_id", [$start_month,$end_month])
                                ->whereBetween("monthly_work_histories.year_id", [$start_year,$end_year])
                                ->leftjoin('monthly_work_histories','employee_infos.emp_auto_id' , '=' ,'monthly_work_histories.emp_id')
                                ->sum('overtime');


        $totalWorkHours = ((int)$totalHours + (int)$overtime);


        return view('admin.project-info.projectWiseTotalWorkHoursReport',compact('endMonth','toMonth','projectWiseTotalWork','company','totalWorkHours','project'));
      }



    }


    /* Project Wise Total Salary */
    public function projectWiseTotalSalaryGenerate(Request $request){
      $proj_id = $request->proj_id;
      // Date Formating
      $start_date = date('d', strtotime($request->start_date));
      $start_month = date('m', strtotime($request->start_date));
      $start_year = date('Y', strtotime($request->start_date));

      $end_date = date('d', strtotime($request->end_date));
      $end_month = date('m', strtotime($request->end_date));
      $end_year = date('Y', strtotime($request->end_date));



      // year_id/
      /* Query in Project */
      $project = ProjectInfo::where('proj_id',$proj_id)->first();
      if($project){
        /* Query in Employee and monthly Work History */
        $companyObj = new CompanyProfileController();
        $company = $companyObj->findCompanry();
        $projectWiseTotalSalary = EmployeeInfo::where('employee_infos.project_id',$project->proj_id)
                                ->whereBetween("salary_histories.slh_month", [$start_month,$end_month])
                                ->whereBetween("salary_histories.slh_year", [$start_year,$end_year])

                                ->leftjoin('salary_histories','employee_infos.emp_auto_id' , '=' ,'salary_histories.emp_auto_id')
                                ->leftjoin('employee_categories','employee_infos.designation_id' , '=' ,'employee_categories.catg_id')
                                ->get();



        $totalSalay = EmployeeInfo::where('employee_infos.project_id',$project->proj_id)
                      ->whereBetween("salary_histories.slh_month", [$start_month,$end_month])
                      ->whereBetween("salary_histories.slh_year", [$start_year,$end_year])
                      ->leftjoin('salary_histories','employee_infos.emp_auto_id' , '=' ,'salary_histories.emp_auto_id')
                      ->sum('slh_total_salary');



        return view('admin.project-info.projectWiseSalaryReport',compact('projectWiseTotalSalary','company','totalSalay','project'));
      }


    }
    /*
    |--------------------------------------------------------------------------
    |  BLADE OPERATION
    |--------------------------------------------------------------------------
    */

    public function index(){
      $all = $this->getAllInfo();
      return view('admin.project-info.index',compact('all'));
    }

    // Project Wise Total Hours view method
    public function projectWiseTotalWorkHours(){
      $project = $this->getAllInfo();
      return view('admin.project-info.projectWiseTotalWorkHours',compact('project'));
    }

    // Project Wise Total Salary view method
    public function projectWiseTotalSalary(){
      $project = $this->getAllInfo();
      return view('admin.project-info.projectWiseSalary',compact('project'));
    }


    public function add(){
      return view('admin.project-info.add');
    }

    public function edit($id){
      $edit = $this->getFindId($id);
      return view('admin.project-info.edit',compact('edit'));
    }

    public function view($id){
      $view = $this->getFindId($id);
      return view('admin.project-info.view',compact('view'));
    }

    public function addProjectInchage(){
      $allProject = $this->getAllInfo();
      return view('admin.project-info.project-incharge',compact('allProject'));
    }











    /*
    |--------------------------------------------------------------------------
    |  API OPERATION
    |--------------------------------------------------------------------------
    */





    /* _____________________________ === _____________________________ */
}
