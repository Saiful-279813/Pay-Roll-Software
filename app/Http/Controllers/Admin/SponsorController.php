<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\CompanyProfileController;
use Illuminate\Http\Request;
use App\Models\Sponsor;
use App\Models\EmployeeInfo;
use Carbon\Carbon;
use Session;
use Auth;

class SponsorController extends Controller{
    /*
    |--------------------------------------------------------------------------
    |  DATABASE OPERATION
    |--------------------------------------------------------------------------
    */
    public function getAll(){
      return $all = Sponsor::where('status',1)->orderBy('spons_id','DESC')->get();
    }

    public function findSponser($id){
      return $edit = Sponsor::where('status',1)->where('spons_id',$id)->first();
    }

    /* Dhaka Insert */
    public function insert(Request $request){
      $creator = Auth::user()->id;
      /* form validation */
      $this->validate($request,[
        'spons_name' => 'required',
      ],[
        'spons_name.required' => 'You Must Be Input This Field!',
      ]);
      /* insert data in database */
      $insert = Sponsor::insert([
        'spons_name' => $request->spons_name,
        'create_by_id' => $creator,
        'created_at' => Carbon::now(),
      ]);
      /* redirect back */
      if($insert) {
        Session::flash('success','value');
        return redirect()->back();
      }else{
        Session::flash('error','value');
        return redirect()->back();
      }
    }

    public function update(Request $request){
      $creator = Auth::user()->id;
      $id = $request->id;
      /* form validation */
      $this->validate($request,[
        'spons_name' => 'required',
      ],[
        'spons_name.required' => 'You Must Be Input This Field!',
      ]);
      /* insert data in database */
      $update = Sponsor::where('spons_id',$id)->update([
        'spons_name' => $request->spons_name,
        'create_by_id' => $creator,
        'updated_at' => Carbon::now(),
      ]);
      /* redirect back */
      if($update) {
        Session::flash('success_update','value');
        return redirect()->route('add-sponser');
      }else{
        Session::flash('error','value');
        return redirect()->back();
      }
    }

    public function delete($id){
      $updateStatus = Sponsor::where('spons_id',$id)->update([
        'status' => 0,
        'updated_at' => Carbon::now(),
      ]);
      /* redirect back */
      if($updateStatus) {
        Session::flash('delete','value');
        return redirect()->back();
      }else{
        Session::flash('error','value');
        return redirect()->back();
      }
    }
    /* ==================== Report Process ==================== */
    public function reportProcess(Request $request){
      $sponserId = $request->spons_id;
      /* company profile call */
      $companyOBJ = new CompanyProfileController();
      $company = $companyOBJ->findCompanry();
      /* sponer wise employee find */
      $sponserWiseEmployee = EmployeeInfo::where('sponsor_id',$sponserId)->get();
      return view('admin.sponser.report_process',compact('company','sponserWiseEmployee'));
    }


    /*
    |--------------------------------------------------------------------------
    |  BLADE OPERATION
    |--------------------------------------------------------------------------
    */
    public function index(){
      $all = $this->getAll();
      return view('admin.sponser.all',compact('all'));
    }

    public function edit($id){
      $edit = $this->findSponser($id);
      return view('admin.sponser.edit',compact('edit'));
    }

    public function report(){
      $sponser = $this->getAll();
      return view('admin.sponser.report',compact('sponser'));
    }








    /*
    |--------------------------------------------------------------------------
    |  API OPERATION
    |--------------------------------------------------------------------------
    */



    /* _____________________________ === _____________________________ */
}
