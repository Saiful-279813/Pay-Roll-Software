<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OfficeBuilding;
use Carbon\Carbon;
use Session;
use Auth;
use Image;


class OfficeBuildingController extends Controller{
  /*
  |--------------------------------------------------------------------------
  |  DATABASE OPERATION
  |--------------------------------------------------------------------------
  */
  public function getAll(){
    return $all = OfficeBuilding::where('status',1)->orderBy('ofb_id','DESC')->get();
  }
  public function findOffice($id){
    return $edit = OfficeBuilding::where('status',1)->where('ofb_id',$id)->first();
  }

  public function delete($id){
      $delete = OfficeBuilding::where('status',1)->where('ofb_id',$id)->update([
        'status' => 0,
        'updated_at' => Carbon::now(),
      ]);
      /* redirect back */
      if($delete){
          Session::flash('delete','value');
          return redirect()->back();
      }else{
          Session::flash('error','value');
          return redirect()->back();
      }
  }



  public function insert(Request $request){
      $crator = Auth::user()->id;


      if($request->file('ofb_dead_papers') != "" ){
        /* making image */
        $deadPhoto = $request->file('ofb_dead_papers');
        $name_gen = 'office_dead-'.time().'.'.$deadPhoto->getClientOriginalExtension();
        Image::make($deadPhoto)->resize(300,300)->save('uploads/office-building/'.$name_gen);
        $uplodPath = 'uploads/office-building/'.$name_gen;

        // insert data in database
        $insert = OfficeBuilding::insert([
            'ofb_rent_date' => $request->ofb_rent_date,
            'ofb_rent_form' => $request->ofb_rent_form,
            'ofb_owner_mobile' => $request->ofb_owner_mobile,
            'ofb_rent_amount' => $request->ofb_rent_amount,
            'ofb_advance_amount' => $request->ofb_advance_amount,
            'ofb_agrement_date' => $request->ofb_agrement_date,
            'ofb_experation_date' => $request->ofb_experation_date,
            'ofb_dead_papers' => $uplodPath,
            'create_by_id' => $crator,
            'created_at' => Carbon::now(),
        ]);
        /* redirect back */
        if($insert){
            Session::flash('success','value');
            return redirect()->back();
        }else{
            Session::flash('error','value');
            return redirect()->back();
        }

      }else{
        // insert data in database
        $insert = OfficeBuilding::insert([
            'ofb_rent_date' => $request->ofb_rent_date,
            'ofb_rent_form' => $request->ofb_rent_form,
            'ofb_owner_mobile' => $request->ofb_owner_mobile,
            'ofb_rent_amount' => $request->ofb_rent_amount,
            'ofb_advance_amount' => $request->ofb_advance_amount,
            'ofb_agrement_date' => $request->ofb_agrement_date,
            'ofb_experation_date' => $request->ofb_experation_date,
            'create_by_id' => $crator,
            'created_at' => Carbon::now(),
        ]);
        /* redirect back */
        if($insert){
            Session::flash('success','value');
            return redirect()->back();
        }else{
            Session::flash('error','value');
            return redirect()->back();
        }


      }

  }


  public function update(Request $request){
      $crator = Auth::user()->id;
      $old_image = $request->old_image;
      $id = $request->id;

      if($request->file('ofb_dead_papers') != "" ){
        if($old_image != ""){
          unlink($old_image);
        }
        /* making image */
        $deadPhoto = $request->file('ofb_dead_papers');
        $name_gen = 'office_dead-'.time().'.'.$deadPhoto->getClientOriginalExtension();
        Image::make($deadPhoto)->resize(300,300)->save('uploads/office-building/'.$name_gen);
        $uplodPath = 'uploads/office-building/'.$name_gen;

        // insert data in database
        $update = OfficeBuilding::where('ofb_id',$id)->update([
            'ofb_rent_date' => $request->ofb_rent_date,
            'ofb_rent_form' => $request->ofb_rent_form,
            'ofb_owner_mobile' => $request->ofb_owner_mobile,
            'ofb_rent_amount' => $request->ofb_rent_amount,
            'ofb_advance_amount' => $request->ofb_advance_amount,
            'ofb_agrement_date' => $request->ofb_agrement_date,
            'ofb_experation_date' => $request->ofb_experation_date,
            'ofb_dead_papers' => $uplodPath,
            'create_by_id' => $crator,
            'created_at' => Carbon::now(),
        ]);
        /* redirect back */
        if($update){
            Session::flash('success_update','value');
            return redirect()->route('rent.new-building');
        }else{
            Session::flash('error','value');
            return redirect()->back();
        }

      }else{
        // insert data in database
        $update = OfficeBuilding::where('ofb_id',$id)->update([
            'ofb_rent_date' => $request->ofb_rent_date,
            'ofb_rent_form' => $request->ofb_rent_form,
            'ofb_owner_mobile' => $request->ofb_owner_mobile,
            'ofb_rent_amount' => $request->ofb_rent_amount,
            'ofb_advance_amount' => $request->ofb_advance_amount,
            'ofb_agrement_date' => $request->ofb_agrement_date,
            'ofb_experation_date' => $request->ofb_experation_date,
            'create_by_id' => $crator,
            'created_at' => Carbon::now(),
        ]);
        /* redirect back */
        if($update){
            Session::flash('success_update','value');
            return redirect()->route('rent.new-building');
        }else{
            Session::flash('error','value');
            return redirect()->back();
        }


      }

  }









  /*
  |--------------------------------------------------------------------------
  |  BLADE OPERATION
  |--------------------------------------------------------------------------
  */

  public function index(){
    $all = $this->getAll();
    return view('admin.office-building.all',compact('all'));
  }

  public function edit($id){
    $edit = $this->findOffice($id);
    return view('admin.office-building.edit',compact('edit'));
  }










  /*
  |--------------------------------------------------------------------------
  |  API OPERATION
  |--------------------------------------------------------------------------
  */






  /* _____________________________ === _____________________________ */
}
