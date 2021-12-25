<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdvancePay;
use App\Models\AdvancePurpose;
use App\Models\EmployeeInfo;
use Carbon\Carbon;
use Session;
use Auth;

class AdvancePayController extends Controller{
    /*
      =================================
      ========== DATABASE OPERATION ===
      =================================
    */
    public function getAllPurpose(){
      return $all = AdvancePurpose::get();
    }

    public function getAll(){
      return $all = AdvancePay::where('status',1)->orderBy('adv_pay_id','DESC')->get();
    }

    public function findId($id){
      return $all = AdvancePay::where('status',1)->where('adv_pay_id',$id)->first();
    }

    public function insert(Request $request){
      // form validation
      $this->validate($request,[
        'emp_id' => 'required',
        'adv_pay_purpose' => 'required',
        'adv_pay_amount' => 'required',
        'installes_month' => 'required',
      ],[

      ]);
      /* calculation */
      $installes_amount = ($request->adv_pay_amount / $request->installes_month);

      $creator = Auth::user()->id;
      $employee_id = EmployeeInfo::where('employee_id',$request->emp_id)->first();
      $emp_id = $employee_id->emp_auto_id;

      $loan = AdvancePay::where('emp_id',$emp_id)->first();
      /* insert data in database */
      if($loan){
          Session::flash('error_duplicate','value');
          return redirect()->back();
      }else{

      $insert = new AdvancePay();
      $insert->emp_id = $emp_id;
      $insert->adv_pay_purpose = $request->adv_pay_purpose;
      $insert->adv_pay_amount = $request->adv_pay_amount;
      $insert->installes_month = $request->installes_month;
      $insert->installes_amount = $installes_amount;
      $insert->entry_date = Carbon::now();
      $insert->entered_id = $creator;
      $insert->created_at = Carbon::now();
      $insert->save();

      /* redirect back */
      if( $insert->save() ){
        Session::flash('success','value');
        return redirect()->back();
      } else{
        Session::flash('error','value');
        return redirect()->back();
      }

    }


    }

    public function update(Request $request){
      // form validation
      $this->validate($request,[
        'emp_id' => 'required',
        'adv_pay_purpose' => 'required',
        'adv_pay_amount' => 'required',
        'installes_month' => 'required',
      ],[

      ]);
      /* calculation */
      $installes_amount = ($request->adv_pay_amount / $request->installes_month);

      $creator = Auth::user()->id;
      $employee_id = EmployeeInfo::where('employee_id',$request->emp_id)->first();
      $emp_id = $employee_id->emp_auto_id;
      $id = $request->id;
      /* insert data in database */
      $update = AdvancePay::where('status',1)->where('adv_pay_id',$id)->update([
        'emp_id' => $emp_id,
        'adv_pay_purpose' => $request->adv_pay_purpose,
        'adv_pay_amount' => $request->adv_pay_amount,
        'installes_month' => $request->installes_month,
        'installes_amount' => $installes_amount,
        'entry_date' => Carbon::now(),
        'entered_id' => $creator,
        'updated_at' => Carbon::now(),
      ]);
      /* redirect back */
      if($update){
        Session::flash('success_update','value');
        return redirect()->route('addvance.payment');
      } else{
        Session::flash('error','value');
        return redirect()->back();
      }
    }

    /* GET FIND Employee */
    public function findEmployee(Request $request){
      $emp_id = $request->emp_id;
      $findEmployee = EmployeeInfo::where('employee_id',$emp_id)->first();
      if($findEmployee){
        $findAdvancePayment = AdvancePay::where('emp_id',$findEmployee->emp_auto_id)->first();
        if($findAdvancePayment){
          return response()->json([
            'findAdvancePay' => $findAdvancePayment,
          ]);
        }else{
          return response()->json([
            'status_no' => 'noAdvance',
          ]);
        }

      }else{
        return response()->json([ 'status' => 'error' ]);
      }

    }

    /* update install advance amount */
    public function updateAdvanceInstallAmount(Request $request){
      $nextAmount = $request->nextPay;
      if($nextAmount == ""){
        $update = AdvancePay::where('adv_pay_id',$request->id)->update([
          'installes_amount' => 0,
          'updated_at' => Carbon::now(),
        ]);
      }else{
        $update = AdvancePay::where('adv_pay_id',$request->id)->update([
          'installes_amount' => $nextAmount,
          'updated_at' => Carbon::now(),
        ]);
      }

      /* redirect back */
      if($update){
        Session::flash('success','value');
        return redirect()->back();
      } else{
        Session::flash('error','value');
        return redirect()->back();
      }

    }


    /*
      =================================
      ====== BLADE OPERATION ==========
      =================================
    */
    public function index(){
        $all = $this->getAll();
        $purpose = $this->getAllPurpose();
        return view('admin.emp-loan.all',compact('all','purpose'));
    }

    public function edit($id){
        $edit = $this->findId($id);
        $purpose = $this->getAllPurpose();
        return view('admin.emp-loan.edit',compact('edit','purpose'));
    }

    public function employeeMonthlyPaymentSetting(){
      return view('admin.emp-loan.advance-adjust');
    }
}
