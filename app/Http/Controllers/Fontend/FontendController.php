<?php

namespace App\Http\Controllers\Fontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BannerInfoController;
use App\Http\Controllers\Admin\ProjectInfoController;

class FontendController extends Controller{
  public function index(){
    /* banner controller import */
    $banner = new BannerInfoController();
    $getBanner = $banner->getAllInfo();
    /* Project controller import */
    $projObj = new ProjectInfoController();
    $proj = $projObj->getAllInfo();

    return view('website.index',compact('getBanner','proj'));
  }

  public function projectDetails($proj_id){
    /* Project controller import */
    $projObj = new ProjectInfoController();
    $proj = $projObj->getFindId($proj_id);
    /* project muliple image */
    $muliple = $projObj->getMultipleImage($proj_id);

    return view('website.project-details',compact('proj','muliple'));
  }

}
