<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model{
    use HasFactory;
    protected $primarykeys = "icatg_id";

    public function itemType(){
      return $this->belongsTo('App\Models\ItemType','itype_id','itype_id');
    }


}
