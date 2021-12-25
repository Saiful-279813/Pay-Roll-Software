<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeePromotion extends Model{
    use HasFactory;
    protected $primaryKey = 'emp_prom_id';
    protected $guarded = [];
}
