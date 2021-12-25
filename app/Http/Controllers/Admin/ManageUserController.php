<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\EmployeeInfo;
use App\Models\User;
use App\Models\Role;
use Carbon\Carbon;
use Session;

class ManageUserController extends Controller{
    /*
      =============================
      ======DATABASE OPERATION=====
      =============================
    */
    public function getAllUser()
    {
        return $all = User::get();
    }

    public function getFindId($id){
      return $find = User::where('id',$id)->first();
    }

    public function getEmployee(){
      return $all = EmployeeInfo::get();
    }

    public function getRole(){
      return $all = Role::get();
    }


    public function activeInactive(Request $request){
      $id = $request->user_id;
      $status = User::where('id',$id)->first();


      if($status->status == 0){
        $userStatus = User::where('id',$id)->where('status',0)->update([
          'status' => 1,
          'updated_at' => Carbon::now(),
        ]);
        return response()->json([ 'success' => 'Sucessfully Completed', 'value' => 1 ]);
      }else{
        $userStatus = User::where('id',$id)->where('status',1)->update([
          'status' => 0,
          'updated_at' => Carbon::now(),
        ]);
        return response()->json(['success' => 'Sucessfully Completed', 'value' => 1 ]);
      }



    }

    // Edit User Role
    public function editRole(Request $request){
      $all = Role::where('role_auto_id',$request->Id)->orderBy('role_auto_id','ASC')->get();
      return json_encode($all);
    }


    /*
      =============================
      ========BLADE OPERATION======
      =============================
    */
    public function index(){
        $user_id = Auth::user()->id;
        $all = User::where('id','!=',$user_id)->where('id','!=',1)->get();
        $role = $this->getRole();
        return view('admin.manage-user.index',compact('role','all'));
    }





    public function edit($id){
        $edit = $this->getFindId($id);
        $role = $this->getRole();
        return view('admin.manage-user.edit',compact('edit','role'));
    }

    public function insert(Request $request){
      // form validation
        $this->validate($request,[
          'password' => 'required|min:8|confirmed'
        ],[

        ]);
        /* making */
        $fineEmp = User::where('emp_id',$request->emp_id)->where('phone_number',$request->phone_number)->first();

        if($fineEmp){
          Session::flash('duplicate','value');
          return Redirect()->back();
        }else{
          $pass = Hash::make($request->password);
          $insert = User::insert([
            'name' => $request->employee_name,
            'emp_id' => $request->emp_id,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => $pass,
            'role_id' => $request->role_id,
            'created_at' => Carbon::now(),
          ]);
          if($insert) {
            Session::flash('success','value');
            return Redirect()->back();
          }else{
            Session::flash('error','value');
            return Redirect()->back();
          }
      }



    }


    public function updatePassword(Request $request){
      // form validation
      $request->validate([
        'oldPassword' => 'required',
        'password' => 'required|min:8',
        'password_confirmation' => 'required|min:8',
      ]);

    $oldDbPass = User::where('id',$request->id)->first();
    $db_pass = $oldDbPass->password;
    $current_password = $request->oldPassword;
    $newpass = $request->password;
    $confirmpass = $request->password_confirmation;

   if (Hash::check($current_password,$db_pass)) {
      if ($newpass === $confirmpass) {
          User::where('id',$request->id)->update([
            'password' => Hash::make($newpass)
          ]);
          Session::flash('success','value');
          return Redirect()->back();
      }else {
        Session::flash('passwordNotMatch','value');
        return Redirect()->back();
      }
   }else {
     Session::flash('oldPasswordNotMatch','value');
     return Redirect()->back();
   }






    }




    public function update(Request $request){
      /* insert data in database */
      $update = User::where('id',$request->id)->update([
        'role_id' => $request->role_id,
        'updated_at' => Carbon::now(),
      ]);
      if($update) {
        Session::flash('success_update','value');
        return Redirect()->back();
      }else{
        Session::flash('error','value');
        return Redirect()->back();
      }
    }


    public function delete($id){
        $delete = User::where('status',1)->where('id',$id)->delete();
        if($delete) {
          Session::flash('delete','value');
          return Redirect()->back();
        }else{
          Session::flash('error','value');
          return Redirect()->back();
        }
    }


}
