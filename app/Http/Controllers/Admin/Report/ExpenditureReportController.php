<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DailyCost;

class ExpenditureReportController extends Controller{
    public function index(){
      return view('admin.report.expenditure.index');
    }

    public function process(Request $request){
      $start_date = $request->start_date;
      $end_date = $request->end_date;

      $expend_report = DailyCost::where('status','approve')->whereBetween('expire_date', [$start_date, $end_date])->get();

      if($expend_report){

        return view('admin.report.expenditure.report-sheet',compact('expend_report','start_date','end_date'));
      }else{
        echo "nai";
      }

    }

}
