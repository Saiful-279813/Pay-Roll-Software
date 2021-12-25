<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemSubCategory extends Model
{
    use HasFactory;
    public function itemType(){
      return $this->belongsTo('App\Models\ItemType','itype_id','itype_id');
    }

    public function itemCatg(){
      return $this->belongsTo('App\Models\ItemCategory','icatg_id','icatg_id');
    }
}
