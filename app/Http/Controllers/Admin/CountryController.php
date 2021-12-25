<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use Session;

class CountryController extends Controller{
  public function getAllCountry(){
    return $allCountries = Country::get();
  }


  public function add()
  {
      $allCountries = $this->getAllCountry();
        return view('admin.address.country.add',compact('allCountries'));
  }

  /* Ajax Calling */
  public function checkUniqueContry(Request $request){
    $country = Country::where('country_name',$request->country_name)->first();
    if($country){
      echo "false";
    }else{
      echo "true";
    }

  }
  /* Ajax Calling */

  public function insert(Request $req){
    /* form validation */
    $this->validate($req,[
      'country_name' => 'required|unique:countries,country_name',
      // 'country_name' => 'required|unique:countries,country_name'.$id.',id',
    ],[
      'country_name.required' => 'please insert country name',
    ]);
    /* insert data in database */
    $insert = Country::insert([
      'country_name' => $req->country_name,
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


}
