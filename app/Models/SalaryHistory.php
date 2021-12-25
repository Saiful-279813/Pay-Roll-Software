<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryHistory extends Model{
    use HasFactory;
    protected $primaryKey = 'slh_auto_id';

    public function employee(){
      return $this->belongsTo('App\Models\EmployeeInfo','emp_auto_id','emp_auto_id');
    }



}
