<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
      // Check User Authentication in Login .
      $role = User::createRole(['Supper Admin']);
      return $role;
      $logInUser = request()->user();
      return view('admin.dashboard.index');
    }
}
