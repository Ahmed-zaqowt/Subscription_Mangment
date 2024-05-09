<?php

namespace App\Http\Controllers\Admin\Profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    function index() {
         return view('admin.admins.profail.profile');
    }

    function update(Request $request) {
        $request->validate([
            'name' => 'required' ,
            'email' => 'required' ,
            'mobile' => 'required'
          ]);

          $admin = User::findOrFail(Auth::user()->id);

          $admin->update([
            'name' => $request->name ,
            'email' => $request->username ,
            'mobile' => $request->mobile
          ]);


         return redirect()->back()->with([
            'msg' =>  'تم تغيير بيانات الملف الشخصي بنجاح' ,
            'type' => 'success'
        ]);
    }

    function password() {
        return view('admin.admins.profail.password');
    }

    function update_password(Request $request) {
          $request->validate([
            'password' => 'required' ,
            'new_password' => 'required|min:8'
          ]);

          $admin = User::findOrFail(Auth::user()->id);
          if (!Hash::check($request->password, $admin->password)) {
             return redirect()->back()->with([
                'msg' => 'كلمة المرور الحالية غير صحيحة' ,
                 'type' => 'danger'
            ]);
        }

        if (Hash::check($request->new_password, $admin->password)) {
            return redirect()->back()->with([
                'msg' =>  'كلمة المرور الجديدة يجب ألا تكون مطابقة لكلمة المرور الحالية' ,
                'type' => 'danger'
            ]);
        }

        $admin->update([
            'password' => Hash::make($request->new_password) ,
        ]);

        return redirect()->back()->with([
            'msg' =>  'تم تغيير كلمة المرور بنجاح' ,
            'type' => 'success'
        ]);
    }
}
