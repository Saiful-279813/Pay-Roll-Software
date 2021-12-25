<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Deduction;
/* ======== externel controller ========*/
use App\Http\Controllers\Admin\EmployeeInfoController;
use App\Http\Controllers\Admin\EmpCategoryController;

class DeductionController extends Controller{
  /*
      ================================
      =======DATABASE OPERATION=======
      ================================
  */
  public function getAllDeduction(){
    $all = Deduction::get();
  }

  /*
      ================================
      =======VIEW OPERATION===========
      ================================
  */
  public function index(){
    return 'This Page Comming Soon......';
    return Redirect()->back();
  }

  public function add(){
    /* employee info */
    $empObj = new EmployeeInfoController();
    $empInfo = $empObj->getAllEmployees();
    /* employee category */
    $empCatgObj = new EmpCategoryController();
    $allCatg = $empCatgObj->getAllCategory();


    return view('admin.employee-deduction.add',compact('empInfo','allCatg'));
  }


}
