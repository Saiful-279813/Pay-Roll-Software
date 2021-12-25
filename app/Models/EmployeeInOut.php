<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeInOut extends Model{
    use HasFactory;
    protected $primaryKey = 'emp_io_id';
    protected $guarded = [];

    public function employee(){
      return $this->belongsTo('App\Models\EmployeeInfo','emp_id','emp_auto_id');
    }
    public function user(){
      return $this->belongsTo('App\Models\User','create_by_id','id');
    }
    public function month(){
      return $this->belongsTo('App\Models\Month','emp_io_month','month_id');
    }


}
