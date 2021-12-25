<?php

namespace App\Http\Controllers\Admin\EmpLeave;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveReason;

class LeaveReasonController extends Controller{
    public function getAll(){
      return $all = LeaveReason::get();
    }
}
