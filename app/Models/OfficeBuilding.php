<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficeBuilding extends Model{
    use HasFactory;
    protected $primaryKey = 'ofb_id';
    protected $guarded = [];

    public function user(){
      return $this->belongsTo('App\Models\User','create_by_id','id');
    }
}
