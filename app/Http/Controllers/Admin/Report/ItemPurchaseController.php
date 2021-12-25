<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\RequirementTools\ItemTypeController;
use App\Http\Controllers\Admin\CompanyProfileController;
use Illuminate\Http\Request;
use App\Models\ItemPurchase;
use App\Models\ItemSubCategory;
use App\Models\PurchaseRecord;

class ItemPurchaseController extends Controller{
    public function index(){
      /* ==== call itemType controller ==== */
      $itemType = new ItemTypeController();
      $allType = $itemType->getAll();
      return view('admin.report.item-purchase.index',compact('allType'));
    }

    public function process(Request $request){
      $start_date = $request->start_date;
      $end_date = $request->end_date;

      $itype_id = $request->itype_id;
      $icatg_id = $request->icatg_id;
      $iscatg_id = $request->iscatg_id;

      $companyObj = new CompanyProfileController();
      $company = $companyObj->findCompanry();


      $ItemPurchase = ItemPurchase::whereBetween('date', [$start_date, $end_date])->get();
      dd($ItemPurchase);




        $sum = ItemPurchase::whereBetween('item_purchases.date', [$start_date, $end_date])
                            ->leftjoin('purchase_records','item_purchases.item_pur_id','=','purchase_records.item_purchase_id')->sum("amount");





      // dd($all);

      return view('admin.report.item-purchase.report',compact('all','company','sum'));

    }
    /* ======================== item stock amount report ======================== */
    public function itemStock(){
      /* ==== call itemType controller ==== */
      $itemType = new ItemTypeController();
      $allType = $itemType->getAll();
      return view('admin.report.item-stock.all',compact('allType'));
    }

    public function itemStockProcess(Request $request){
      $itype_id = $request->itype_id;


      /* Company Controller Call */
      $companyObj = new CompanyProfileController();
      $company = $companyObj->findCompanry();
      $all = ItemSubCategory::where('itype_id',$itype_id)->get();

      return view('admin.report.item-stock.report',compact('all','company'));

    }



}
