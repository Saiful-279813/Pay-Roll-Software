<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeeType;

class EmployeeTypeController extends Controller
{
    public function getEmployeeTypeAll(){
      return $all = EmployeeType::get();
    }
}
