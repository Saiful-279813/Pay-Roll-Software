<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\CountryController;
use App\Models\Division;
use Carbon\Carbon;
use Session;


class DivisionController extends Controller{
  /*
  ======================================
  ==========DATABASE OPERATION==========
  ======================================
  */
  public function getAllDivision(){
    return $all = Division::get();
  }

  public function editDivision($division_id){
    return $edit = Division::where('division_id',$division_id)->first();
  }

  public function validDivision(Request $request){
    $divName = $request->division_name;
    $findDivision = Division::where('country_id',$req->country_id)
                    ->where('division_name',$divName)
                    ->first();
    if($findDivision){
      return response()->json([ 'status' => 'success' ]);
    }else{
      return response()->json([ 'status' => 'error' ]);
    }
  }


  /*
  ======================================
  ============BLADE OPERATION===========
  ======================================
  */


  public function add(){
    $countryObj = new CountryController();
    $countries = $countryObj->getAllCountry();
    $getallDiv = $this->getAllDivision();
    return view('admin.address.add',compact('countries','getallDiv'));
  }

  public function edit($division_id){
      $countryObj = new CountryController();
      $edit = $this->editDivision($division_id);
      $countries = $countryObj->getAllCountry();
      return view('admin.address.edit',compact('edit','countries'));
  }

  public function insert(Request $req){
    /* form validation */
    $this->validate($req,[
      'country_id' => 'required',
      'division_name' => 'required',
    ],[
      'country_id.required' => 'please select country',
      'division_name.required' => 'please insert division name',
    ]);
    /* insert data in database */
    $insert = Division::insert([
      'country_id' => $req->country_id,
      'division_name' => $req->division_name,
    ]);
    /* redirect back */
    if($insert) {
      Session::flash('success_add','value');
      return redirect()->back();
    }else{
      Session::flash('error_add','value');
      return redirect()->back();
    }

  }

  public function update(Request $req){
    /* form validation */
    $this->validate($req,[
      'country_id' => 'required',
      'division_name' => 'required',
    ],[
      'country_id.required' => 'please select country',
      'division_name.required' => 'please insert division name',
    ]);
    /* insert data in database */
    $id = $req->id;
    $update = Division::where('division_id',$id)->update([
      'country_id' => $req->country_id,
      'division_name' => $req->division_name,
      'updated_at' => Carbon::now(),
    ]);
    /* redirect back */
    if($update) {
      Session::flash('success_update','value');
      return Redirect()->route('add-division');
    }else{
      Session::flash('error_update','value');
      return Redirect()->route('add-division');
    }

  }

}
