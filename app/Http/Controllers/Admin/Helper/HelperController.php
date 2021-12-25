<?php

namespace App\Http\Controllers\Admin\Helper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DateTime;

class HelperController extends Controller{
    // get month name for integer value
    public function getMonthName($monthId){
      $dateObj   = DateTime::createFromFormat('!m', $monthId);
      return $monthName = $dateObj->format('F');
    }
}
