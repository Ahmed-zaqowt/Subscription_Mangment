<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    function index() {
      $setting = Setting::orderBy('created_at' , 'desc')->first();

     return view('admin.admins.settings.settings' , compact('setting'));
    }

    function storOrupdate(Request $request) {

        $request->validate([
            'price' =>'required'
        ]);

        $cond = [] ;
        $data = ['price' => $request->price] ;
         Setting::updateOrCreate($cond , $data);

        return redirect()->back()->with([
            'msg' => "تم اضافة السعر الشهري" ,
            'type' => 'success'
        ]);

    }
}
