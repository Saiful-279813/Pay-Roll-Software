<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\DivisionController;
use App\Models\Division;
use App\Models\District;
use Session;

class DistrictController extends Controller{
  /*
  ======================================
  ==========DATABASE OPERATION==========
  ======================================
  */
  public function getAllDistrict(){
     return $all = District::orderBy('district_id','DESC')->get();
  }

  public function getDivision($country_id){
    $div = Division::where('country_id',$country_id)->orderBy('division_name','ASC')->get();
    return json_encode($div);
  }

  public function getDistrict($division_id){
    $district = District::where('division_id',$division_id)->orderBy('district_name','ASC')->get();
    return json_encode($district);
  }

  public function insert(Request $req){
    /* data validation */
    $this->validate($req,[
      'country_id' => 'required',
      'division_id' => 'required',
      'district_name' => 'required',
    ],[
      'country_id.required' => 'please select country',
      'division_id.required' => 'please select division',
      'district_name.required' => 'please select district',
    ]);
    /* data insert in database */
    $insert = District::insert([
      'country_id' => $req->country_id,
      'division_id' => $req->division_id,
      'district_name' => $req->district_name,
    ]);
    /* redirect back */
    if($insert) {
      Session::flash('success_add','value');
      return Redirect()->route('add-district');
    }else{
      Session::flash('success_error','value');
      return Redirect()->route('add-district');
    }

  }

  public function update(Request $req){
    /* data validation */
    $this->validate($req,[
      'country_id' => 'required',
      'division_id' => 'required',
      'district_name' => 'required',
    ],[
      'country_id.required' => 'please select country',
      'division_id.required' => 'please select division',
      'district_name.required' => 'please select district',
    ]);
    /* data insert in database */
    $id = $req->id;
    $update = District::where('district_id',$id)->update([
      'country_id' => $req->country_id,
      'division_id' => $req->division_id,
      'district_name' => $req->district_name,
    ]);
    /* redirect back */
    if($update) {
      Session::flash('success_update','value');
      return Redirect()->route('add-district');
    }else{
      Session::flash('error_update','value');
      return Redirect()->back();
    }

  }


  /*
  ======================================
  ==========BLADE OPERATION=============
  ======================================
  */

  public function add(){
    $cntry = new CountryController();
    $div = new DivisionController();
    $allCountry = $cntry->getAllCountry();
    $allDivision = $div->getAllDivision();

    $allDistrict = $this->getAllDistrict();
    return view('admin.address.district.add',compact('allCountry','allDivision','allDistrict'));
  }

  public function edit($id){
    $cntry = new CountryController();
    $div = new DivisionController();
    $allCountry = $cntry->getAllCountry();
    $allDivision = $div->getAllDivision();

    $edit = District::where('district_id',$id)->first();
    return view('admin.address.district.edit',compact('allCountry','allDivision','edit'));
  }

}
