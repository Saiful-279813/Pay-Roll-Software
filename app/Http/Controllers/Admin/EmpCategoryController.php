<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\EmployeeTypeController;
use Illuminate\Http\Request;
use App\Models\EmployeeCategory;
use Carbon\Carbon;
use Session;

class EmpCategoryController extends Controller{
    /*
    |--------------------------------------------------------------------------
    |  DATABASE OPERATION
    |--------------------------------------------------------------------------
    */
    public function getAllCategory(){
        return $all = EmployeeCategory::where('catg_status',1)->orderBy('catg_id','DESC')->get();
    }

    public function findCategory($id){
       return $edit = EmployeeCategory::where('catg_status',1)->where('catg_id',$id)->first();
    }


    /*
    |--------------------------------------------------------------------------
    |  BLADE OPERATION
    |--------------------------------------------------------------------------
    */

    public function index(){
      $all = $this->getAllCategory();
      $getEmpType = new EmployeeTypeController();
      $getType = $getEmpType->getEmployeeTypeAll();
      return view('admin.employee-category.add',compact('all','getType'));
    }

    public function edit($id){
      $edit = $this->findCategory($id);
      $getEmpType = new EmployeeTypeController();
      $getType = $getEmpType->getEmployeeTypeAll();
      return view('admin.employee-category.edit',compact('edit','getType'));
    }

    public function insert(Request $req){
      /* form validation */
      $this->validate($req,[
        'catg_name' => 'required',
        'emp_type_id' => 'required'
      ],[
        'catg_name.required' => 'please enter category name'
      ]);
      /* data insert */
      $insert = EmployeeCategory::insert([
        'catg_name' => $req->catg_name,
        'emp_type_id' => $req->emp_type_id,
        'created_at' => Carbon::now(),
      ]);
      /* Redirect back */
      if($insert) {
        Session::flash('success_add','value');
        return Redirect()->back();
      }else{
        Session::flash('success_error','value');
        return Redirect()->back();
      }

    }

    public function update(Request $req){
      /* form validation */
      $this->validate($req,[
        'catg_name' => 'required',
        'emp_type_id' => 'required',
      ],[
        'catg_name.required' => 'please enter category name'
      ]);
      /* data update */
      $id = $req->id;
      $update = EmployeeCategory::where('catg_id',$id)->update([
        'catg_name' => $req->catg_name,
        'emp_type_id' => $req->emp_type_id,
        'updated_at' => Carbon::now(),
      ]);
      /* Redirect back */
      if($update) {
        Session::flash('success_update','value');
        return Redirect()->route('emp-category');
      }else{
        Session::flash('error_update','value');
        return Redirect()->back();
      }

    }

    public function delete($id){
      $delete = EmployeeCategory::where('catg_id',$id)->delete();
      /* Redirect back */
      if($delete) {
        Session::flash('success_delete','value');
        return Redirect()->back();
      }else{
        Session::flash('success_error','value');
        return Redirect()->back();
      }
    }

}
