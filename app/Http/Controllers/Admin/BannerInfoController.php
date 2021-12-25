<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\CompanyProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BannerInfo;
use Carbon\Carbon;
use Session;
use Image;

class BannerInfoController extends Controller{

  /*
    ===========================
    ====DATABASE OPERATION=====
    ===========================
  */
  public function getAllInfo(){
    return $all = BannerInfo::where('status',1)->get();
  }

  public function getFindId($id){
    return $find = BannerInfo::where('status',1)->where('ban_id',$id)->first();
  }

  /*
    ===========================
    =======BLADE OPERATION=====
    ===========================
  */
  public function index(){
    $all = $this->getAllInfo();
    return view('admin.banner.index',compact('all'));
  }

  public function add(){
    $compObj = new CompanyProfileController();
    $comp = $compObj->findCompanry();
    return view('admin.banner.add',compact('comp'));
  }

  public function edit($id){
    $edit = $this->getFindId($id);
    $compObj = new CompanyProfileController();
    $comp = $compObj->findCompanry();
    return view('admin.banner.edit',compact('edit','comp'));
  }

  public function delete($id){
    $delete = BannerInfo::where('ban_id',$id)->update([
      'status' => 0,
      'updated_at' => Carbon::now(),
    ]);
    /* redirect back */
    if($delete){
      Session::flash('success_soft','value');
      return redirect()->back();
    } else{
      Session::flash('error','value');
      return redirect()->back();
    }
  }

  public function insert(Request $req){
    /* form validation */
    $this->validate($req,[
      'ban_title' => 'required',
      'ban_image' => 'required',
      'company_id' => 'required',
    ],[

    ]);

    /* making banner image */
    $banner_image = $req->file('ban_image');
    $banner_image_name = 'banner-image'.'-'.time().'-'.$banner_image->getClientOriginalExtension();
    Image::make($banner_image)->resize(1920,820)->save('uploads/banner/'.$banner_image_name);


    /* insert data in database */
    $entered_id = Auth::user()->id;
    $insert = BannerInfo::insert([
      'ban_title' => $req->ban_title,
      'ban_subtitle' => $req->ban_subtitle,
      'ban_caption' => $req->ban_caption,
      'ban_description' => $req->ban_description,
      'company_id' => $req->company_id,
      'entered_id' => $entered_id,
      'ban_image' => $banner_image_name,
      'created_at' => Carbon::now(),
    ]);
    /* redirect back */
    if($insert){
      Session::flash('success','value');
      return redirect()->back();
    } else{
      Session::flash('error','value');
      return redirect()->back();
    }
  }

  public function update(Request $req){
    /* form validation */
    $this->validate($req,[
      'ban_title' => 'required',
      'company_id' => 'required',
    ],[

    ]);

    /* insert data in database */
    $id = $req->id;
    $old_img = $req->old_img;
    $entered_id = Auth::user()->id;

    if($req->file('ban_image')){
      unlink('uploads/banner/'.$old_img);
      /* making banner image */
      $banner_image = $req->file('ban_image');
      $banner_image_name = 'banner-image'.'-'.time().'-'.$banner_image->getClientOriginalExtension();
      Image::make($banner_image)->resize(917,1000)->save('uploads/banner/'.$banner_image_name);

      $update = BannerInfo::where('status',1)->where('ban_id',$id)->update([
        'ban_title' => $req->ban_title,
        'ban_subtitle' => $req->ban_subtitle,
        'ban_caption' => $req->ban_caption,
        'ban_description' => $req->ban_description,
        'company_id' => $req->company_id,
        'entered_id' => $entered_id,
        'ban_image' => $banner_image_name,
        'updated_at' => Carbon::now(),
      ]);
      /* redirect back */
      if($update){
        Session::flash('success','value');
        return redirect()->route('banner-info');
      } else{
        Session::flash('error','value');
        return redirect()->back();
      }

    }else{

      $update = BannerInfo::where('status',1)->where('ban_id',$id)->update([
        'ban_title' => $req->ban_title,
        'ban_subtitle' => $req->ban_subtitle,
        'ban_caption' => $req->ban_caption,
        'ban_description' => $req->ban_description,
        'company_id' => $req->company_id,
        'entered_id' => $entered_id,
        'updated_at' => Carbon::now(),
      ]);
      /* redirect back */
      if($update){
        Session::flash('success','value');
        return redirect()->route('banner-info');
      } else{
        Session::flash('error','value');
        return redirect()->back();
      }

    }


  }

}
