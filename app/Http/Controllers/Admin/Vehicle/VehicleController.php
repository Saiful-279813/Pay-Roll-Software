<?php

namespace App\Http\Controllers\Admin\Vehicle;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\CompanyProfileController;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\EmployeeInfo;
use Carbon\Carbon;
use Session;
use Auth;

class VehicleController extends Controller{
  /*
  |--------------------------------------------------------------------------
  |  DATABASE OPERATION
  |--------------------------------------------------------------------------
  */
  public function getAll(){
    return $all = Vehicle::where('status',1)->orderBy('veh_id','DESC')->get();
  }
  public function findVehicle($id){
    return $edit = Vehicle::where('status',1)->where('veh_id',$id)->first();
  }

  public function delete($id){
      $delete = Vehicle::where('status',1)->where('veh_id',$id)->update([
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
      $emp_id = $request->emp_id;

      $findEmp = EmployeeInfo::where('employee_id',$emp_id)->first();

      


      $crator = Auth::user()->id;



      if($findEmp){
        // insert data in database
        $insert = Vehicle::insert([
            'veh_name' => $request->veh_name,
            'veh_price' => $request->veh_price,
            'veh_purchase_date' => $request->veh_purchase_date,
            'veh_present_metar' => $request->veh_present_metar,
            'veh_color' => $request->veh_color,
            'driver_id' => $findEmp->emp_auto_id,
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
        $insert = Vehicle::insert([
            'veh_name' => $request->veh_name,
            'veh_price' => $request->veh_price,
            'veh_purchase_date' => $request->veh_purchase_date,
            'veh_present_metar' => $request->veh_present_metar,
            'veh_color' => $request->veh_color,
            'driver_id' => 0,
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
      $emp_id = $request->emp_id;
      $id = $request->id;
      $crator = Auth::user()->id;

      $findEmp = EmployeeInfo::where('employee_id',$emp_id)->first();

      if($emp_id == ""){
        // insert data in database
        $update = Vehicle::where('veh_id',$id)->update([
            'veh_name' => $request->veh_name,
            'veh_price' => $request->veh_price,
            'veh_purchase_date' => $request->veh_purchase_date,
            'veh_present_metar' => $request->veh_present_metar,
            'veh_color' => $request->veh_color,
            'driver_id' => 0,
            'create_by_id' => $crator,
            'updated_at' => Carbon::now(),
        ]);
        /* redirect back */
        if($update){
            Session::flash('success_update','value');
            return redirect()->route('add-new.vehicle');
        }else{
            Session::flash('error','value');
            return redirect()->back();
        }
      }else{
        if($findEmp){
          // insert data in database
          $update = Vehicle::where('veh_id',$id)->update([
              'veh_name' => $request->veh_name,
              'veh_price' => $request->veh_price,
              'veh_purchase_date' => $request->veh_purchase_date,
              'veh_present_metar' => $request->veh_present_metar,
              'veh_color' => $request->veh_color,
              'driver_id' => $findEmp->emp_auto_id,
              'create_by_id' => $crator,
              'updated_at' => Carbon::now(),
          ]);
          /* redirect back */
          if($update){
              Session::flash('success_update','value');
              return redirect()->route('add-new.vehicle');
          }else{
              Session::flash('error','value');
              return redirect()->back();
          }
        }else{
          Session::flash('data_not_match','value');
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
    return view('admin.vechicle.all',compact('all'));
  }

  public function edit($id){
    $edit = $this->findVehicle($id);
    return view('admin.vechicle.edit',compact('edit'));
  }


















  /*
  |--------------------------------------------------------------------------
  |  API OPERATION
  |--------------------------------------------------------------------------
  */

  /* _____________________________ === _____________________________ */
}
