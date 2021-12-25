<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Currency\CurrencyController;
use Illuminate\Http\Request;
use App\Models\CompanyProfile;
use Carbon\Carbon;
use Session;

class CompanyProfileController extends Controller{


  public function getAll(){
    return $all = CompanyProfile::all();
  }

  public function findCompanry(){
    return $profile = CompanyProfile::where('comp_id',1)->firstOrFail();
  }

  public function profile(){

    $currency = new CurrencyController();
    $cur = $currency->getAllCurrency();
    $profile =  CompanyProfile::where('comp_id',1)->first();

    if($profile != null)
        return view('admin.company-profile.profile',compact('profile','cur'));
    else {
        $profile = new CompanyProfile();
        return view('admin.company-profile.profile',compact('profile','cur'));
    }
  }

  public function updateProfile(Request $req){
    // form validation
    $this->validate($req,[
      'comp_name_en' => 'required',
      'comp_name_arb' => 'required',
      'curc_id' => 'required',
      'comp_email1' => 'required',
      'comp_email2' => 'required',
      'comp_phone1' => 'required',
      'comp_phone2' => 'required',
      'comp_mobile1' => 'required',
      'comp_mobile2' => 'required',
      'comp_address' => 'required',
      'comp_mission' => 'required',
      'comp_vission' => 'required',
      'comp_contact_address' => 'required',
      'comp_support_number' => 'required',
      'comp_hotline_number' => 'required',
      'comp_description' => 'required',
    ],[

    ]);
    /* data access in database */



    $update = CompanyProfile::where('comp_id',1)->update([
      'comp_name_en' => $req->comp_name_en,
      'comp_name_arb' => $req->comp_name_arb,
      'curc_id' => $req->curc_id,
      'comp_address' => $req->comp_address,
      'comp_email1' => $req->comp_email1,
      'comp_email2' => $req->comp_email2,
      'comp_phone1' => $req->comp_phone1,
      'comp_phone2' => $req->comp_phone2,
      'comp_mobile1' => $req->comp_mobile1,
      'comp_mobile2' => $req->comp_mobile2,
      'comp_support_number' => $req->comp_support_number,
      'comp_hotline_number' => $req->comp_hotline_number,
      'comp_description' => $req->comp_description,
      'comp_mission' => $req->comp_mission,
      'comp_vission' => $req->comp_vission,
      'comp_contact_address' => $req->comp_contact_address,
      'updated_at' => Carbon::now(),
    ]);
    /* Redirect back */
    if($update) {
      Session::flash('success','value');
      return Redirect()->back();
    }else{
      Session::flash('error','value');
      return Redirect()->back();
    }
  }
}
