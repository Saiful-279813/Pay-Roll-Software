<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\SubCompanyInfo;
use App\Http\Controllers\Admin\CompanyProfileController;
use Carbon\Carbon;
use Session;

class SubCompanyInfoController extends Controller{
  /*
  =============================
  =====DATABSE OPEREATION======
  =============================
  */
  public function getAll(){
    return $all = SubCompanyInfo::where('status',1)->get();
  }
  public function getfindId($id){
    return $find = SubCompanyInfo::where('status',1)->where('sb_comp_id',$id)->firstOrFail();
  }
  /*
  =============================
  =======BLADE OPEREATION======
  =============================
  */
  public function create(){
    $all = $this->getAll();
    $companyObj = new CompanyProfileController();
    $comp = $companyObj->getAll();
    return view('admin.sub-company.add',compact('all','comp'));
  }

  public function edit($id){
      $edit = $this->getfindId($id);
      $companyObj = new CompanyProfileController();
      $comp = $companyObj->getAll();
      return view('admin.sub-company.edit',compact('edit','comp'));
  }

  public function view($id){
      $view = $this->getfindId($id);
      return view('admin.sub-company.view',compact('view'));
  }

  public function delete($id){
      $delete = SubCompanyInfo::where('sb_comp_id',$id)->update([
        'status' => 0,
        'updated_at' => Carbon::now(),
      ]);
      /* Redirect back */
      if($delete) {
        Session::flash('delete','value');
        return Redirect()->back();
      }else{
        Session::flash('error','value');
        return Redirect()->back();
      }
  }

  public function insert(Request $req){
    // form validation
    $this->validate($req,[
      'sb_comp_name' => 'required',
      'company_id' => 'required',
      'sb_comp_address' => 'required',
      'sb_comp_mobile1' => 'required',
      'sb_comp_mobile2' => 'required',
      'sb_comp_email1' => 'required',
      'sb_comp_email2' => 'required',
      'sb_comp_phone1' => 'required',
      'sb_comp_phone2' => 'required',
      'details' => 'required',
    ],[

    ]);
    /* data access in database */
    $entered_id = Auth::user()->id;
    $insert = SubCompanyInfo::insert([
      'sb_comp_name' => $req->sb_comp_name,
      'company_id' => $req->company_id,
      'sb_comp_address' => $req->sb_comp_address,
      'sb_comp_mobile1' => $req->sb_comp_mobile1,
      'sb_comp_mobile2' => $req->sb_comp_mobile2,
      'sb_comp_email1' => $req->sb_comp_email1,
      'sb_comp_email2' => $req->sb_comp_email2,
      'sb_comp_phone1' => $req->sb_comp_phone1,
      'sb_comp_phone2' => $req->sb_comp_phone2,
      'sb_comp_contact_parson_details' => $req->details,
      'entered_id' => $entered_id,
      'created_at' => Carbon::now(),
    ]);
    /* Redirect back */
    if($insert) {
      Session::flash('success','value');
      return Redirect()->back();
    }else{
      Session::flash('error','value');
      return Redirect()->back();
    }
  }

  public function update(Request $req){
    // form validation
    $this->validate($req,[
      'sb_comp_name' => 'required',
      'company_id' => 'required',
      'sb_comp_address' => 'required',
      'sb_comp_mobile1' => 'required',
      'sb_comp_mobile2' => 'required',
      'sb_comp_email1' => 'required',
      'sb_comp_email2' => 'required',
      'sb_comp_phone1' => 'required',
      'sb_comp_phone2' => 'required',
      'details' => 'required',
    ],[

    ]);
    /* data access in database */
    $id = $req->id;
    $entered_id = Auth::user()->id;
    $update = SubCompanyInfo::where('sb_comp_id',$id)->update([
      'sb_comp_name' => $req->sb_comp_name,
      'company_id' => $req->company_id,
      'sb_comp_address' => $req->sb_comp_address,
      'sb_comp_mobile1' => $req->sb_comp_mobile1,
      'sb_comp_mobile2' => $req->sb_comp_mobile2,
      'sb_comp_email1' => $req->sb_comp_email1,
      'sb_comp_email2' => $req->sb_comp_email2,
      'sb_comp_phone1' => $req->sb_comp_phone1,
      'sb_comp_phone2' => $req->sb_comp_phone2,
      'sb_comp_contact_parson_details' => $req->details,
      'entered_id' => $entered_id,
      'updated_at' => Carbon::now(),
    ]);
    /* Redirect back */
    if($update) {
      Session::flash('success_update','value');
      return Redirect()->route('sub-comp-info');
    }else{
      Session::flash('error','value');
      return Redirect()->back();
    }
  }

}
