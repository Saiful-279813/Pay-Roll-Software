<?php

namespace App\Http\Controllers\Admin\Expire;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\EmployeeTypeController;
use App\Http\Controllers\Admin\EmployeeInfoController;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PassportExpireController extends Controller{
    public function index(){
      $empOBJ = new EmployeeTypeController();
      $emp_type_id = $empOBJ->getEmployeeTypeAll();
      /* employee info */
      $empob = new EmployeeInfoController();
      $emp = $empob->getAllEmployees();

      return view('admin.expired.passport-expired.index',compact('emp_type_id','emp'));
    }
}
