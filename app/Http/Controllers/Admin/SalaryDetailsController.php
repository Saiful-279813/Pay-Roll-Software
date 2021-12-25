<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalaryDetails;
use App\Models\EmployeeInfo;
use App\Controllers\Admin\EmployeeInfoController;
use Carbon\Carbon;
use Session;

class SalaryDetailsController extends Controller{
    /*
    =============================
    =====DATABSE OPEREATION======
    =============================
    */
    public function getSalaryList(){
      return $all = SalaryDetails::orderBy('sdetails_id','DESC')->get();
    }

    public function getSingleSalary($id){
      return $find_id =  SalaryDetails::where('sdetails_id',$id)->leftjoin('employee_infos','salary_details.emp_id','=','employee_infos.emp_auto_id')->select('employee_infos.emp_type_id','salary_details.*')->first();

    }

    public function delete($id){
      $delete = SalaryDetails::where('sdetails_id',$id)->delete();
      if($delete){
        Session::flash('success_soft','value');
        return Redirect()->back();
      }else{
        Session::flash('error','value');
        return Redirect()->back();
      }
    }

    /* Direct Man power status update */
    public function directManStatusUpdate($empId){
      $findEmployee = EmployeeInfo::where('job_status',1)->where('emp_auto_id',$empId)->first();
      if($findEmployee->emp_type_id == 1 && $findEmployee->hourly_employee == 1){
        EmployeeInfo::where('emp_auto_id',$empId)->update([
          'hourly_employee' => NULL,
        ]);
      }else{
        EmployeeInfo::where('emp_auto_id',$empId)->update([
          'hourly_employee' => 1,
        ]);
      }
      return Redirect()->back();
    }
    /* Direct Man power status update */

    /* salary data insert */
    public function insert(Request $req){

        $id = $req->empId;
        $salaryDetails = SalaryDetails::where('emp_id',$id)->pluck('emp_id');

        $update = SalaryDetails::where('emp_id',$salaryDetails)->update([
          'emp_id' => $id,
          'basic_amount' => $req->basic_amount,
          'basic_hours' => $req->basic_hours,
          'hourly_rent' => $req->hourly_rate,
          'house_rent' => $req->house_rent,
          'mobile_allowance' => $req->mobile_allowance,
          'medical_allowance' => $req->medical_allowance,
          'local_travel_allowance' => $req->local_travel_allowance,
          'conveyance_allowance' => $req->conveyance_allowance,

          'food_allowance' => $req->food_allowance,
          'others1' => $req->others1,
          'created_at' => Carbon::now(),
        ]);
        if($update){
          Session::flash('success','value');
          return Redirect()->route('add-employee');
        }else{
          Session::flash('error','value');
          return Redirect()->back();
        }
    }

    /* ================= Salary Details Update ================= */
    public function update(Request $req){
        /* data insert in database */
        $id = $req->id;

        // dd($request->all);
        // dd($req->hourly_rate);

        $update = SalaryDetails::where('sdetails_id',$id)->update([

          'basic_amount' => $req->basic_amount,
          'basic_hours' => $req->basic_hours,
          'hourly_rent' => $req->hourly_rate,
          'house_rent' => $req->house_rent,
          'mobile_allowance' => $req->mobile_allowance,
          'medical_allowance' => $req->medical_allowance,
          'local_travel_allowance' => $req->local_travel_allowance,
          'conveyance_allowance' => $req->conveyance_allowance,

          'food_allowance' => $req->food_allowance,
          'others1' => $req->others1,
          'created_at' => Carbon::now(),
        ]);
        if($update){
          Session::flash('success_update','value');
          return Redirect()->route('salary-details');
        }else{
          Session::flash('error','value');
          return Redirect()->back();
        }

    }

    /* Employee Information For CPF Contribution */
    public function empInfoForContribution(Request $request){
      $empId = $request->employeeID;
      $findEmpl = EmployeeInfo::where('job_status',1)->where('employee_id',$empId)->first();
      if($findEmpl){
        $data = SalaryDetails::with('employee')->where('emp_id',$findEmpl->emp_auto_id)->first();
        return response()->json([ 'data' => $data ]);
      }else{
        return response()->json([ 'invalidEmpId' => 'Employee Id Dosen,t Match!' ]);
      }
    }

    public function updateContributionAmount(Request $request){
      $empId = $request->empId;


      $update = SalaryDetails::where('emp_id',$empId)->update([
        'cpf_contribution' => $request->amount,
        'saudi_tax' => $request->tax,
        'updated_at' => Carbon::now(),
      ]);
      if($update){
        Session::flash('success','value');
        return Redirect()->back();
      }

    }


    /*
    =============================
    =======BLADE OPEREATION======
    =============================
    */

    public function index(){
      $all = $this->getSalaryList();
      return view('admin.salary-details.index',compact('all'));
    }

    public function edit($id){
        $data = $this->getSingleSalary($id);
        return view('admin.salary-details.edit',compact('data'));
    }

    public function view($id){
        $view = $this->getSingleSalary($id);
        return view('admin.salary-details.view',compact('view'));
    }

    public function setContributionAmount(){
      return view('admin.salary-details.contribution');
    }


    /* ======================================================================= */
}
