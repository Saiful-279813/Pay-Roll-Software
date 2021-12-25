<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpLeave extends Model
{
    use HasFactory;
    protected $primaryKey = 'emleave_id';

    public function user(){
      return $this->belongsTo('App\Models\User','approve_by_id','id');
    }

    public function employee(){
      return $this->belongsTo('App\Models\EmployeeInfo','emp_id','emp_auto_id');
    }

    public function leaveType(){
      return $this->belongsTo('App\Models\LeaveType','leave_type_id','lev_type_id');
    }

    public function leaveReason(){
      return $this->belongsTo('App\Models\LeaveReason','leave_reason_id','lev_reas_id');
    }



}
