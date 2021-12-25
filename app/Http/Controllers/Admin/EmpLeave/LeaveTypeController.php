<?php

namespace App\Http\Controllers\Admin\EmpLeave;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveType;

class LeaveTypeController extends Controller{
    public function getAll(){
      return $all = LeaveType::get();
    }
}
