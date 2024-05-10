<?php

namespace App\Http\Controllers\Admin\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Subscriber;
use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
class AdminController extends Controller
{


    function index() {
        return view('admin.admins.index');
    }


    function getdata()
    {
        $users = User::query()->where('status' , 2)->orderBy('created_at', 'desc');
        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('portfolio' , function ($qur) {
                $portfolio = number_format($qur->portfolio, 2);
                return $portfolio ;
            })
            ->addColumn(
                'actions',
                function ($qur) {

                    $data_attr = '';
                    $data_attr .= 'data-id="' . $qur->id  . '" ';
                    $data_attr .= 'data-name="' . $qur->name . '"';
                    $data_attr .= 'data-username="' . $qur->email . '"';
                    $data_attr .= 'data-mobile="' . $qur->mobile . '"';

                    $string = '';
                    $string .= '
                   <div class="d-flex align-items-center gap-3 fs-6">
                          <div class="dropdown">
      <div class="text-primary dropdown-toggle" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-eye-fill"></i>
      </div>
      <ul class="dropdown-menu" tabindex="-88888" aria-labelledby="dropdownMenuButton">

        <li><a href="'. route('admin.admin.show_sub' , $qur->id) .'"><div class="dropdown-item "  data-id="' . $qur->id . '" >' . __('رؤية المشتركين') . '</div></a></li>

      </ul>
    </div>
      <div  class="text-warning edit_btn" data-bs-toggle="modal" data-bs-target="#edit-modal" ' . $data_attr . '><i class="bi bi-pencil-fill"></i></div>
     <div class="text-danger delete_btn" data-id="' .$qur->id . '" data-url="/admin/admins/delete">
        <i class="bi bi-trash-fill"></i>
      </div>
    </div>
      </div>';
                    return $string;
                }
            )
            ->rawColumns(['actions'])
            ->make(true);
    }

    function store(Request $request)
    {
        //  dd($request);
        $request->validate([
            'name' => 'required|string:255',
            'username' => 'required|string:255|unique:users,email',
            'mobile' => 'required',
            'password' => 'required',
        ]);
        //  dd($request);
        User::create([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email' => $request->username,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            "success" => "success"
        ], 201);
    }


    function update(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:Users,email,'.$request->id,
            'mobile' => 'required|numeric|regex:/^[0-9]+$/|unique:Users,mobile,'.$request->id,
        ]);


        $User = User::query()->where('id', $request->id)->first();

        $User->update([
            'name' => $request->name,
            'email' => $request->username,
            'mobile' => $request->mobile,
        ]);

        if ($request->password != null) {
            $User->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return response()->json([
            'success' => __('تم التعديل بنجاح')
        ], 201);
    }

    function delete(Request $request)
    {
       $User = User::find($request->id);
       $User->delete();

        return response()->json(["success" => "Deleted Successful"], 201);
    }

    function show_sub($id) {
        $id = $id ;
        return view('admin.admins.show_sub' , compact('id'));
    }



    function getdatasub(Request $request) {
        $users = Subscription::query()->where('user_id' , $request->id)->orderBy('created_at', 'desc');

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('name' , function ($qur) {
              return $qur->subscriber->name;
            })
            ->addColumn('id_number' , function ($qur) {
                return $qur->subscriber->id_number;
              })
              ->addColumn('serial_number' , function ($qur) {
                return $qur->subscriber->serial_number;
              })
            ->addColumn('mobile' , function ($qur) {
                return $qur->subscriber->mobile;
              })
              ->addColumn('status' , function ($qur) {
                if($qur->status == Subscription::WAITING){
                    return '<div class="badge rounded-pill alert-info">الاشتراك معلق </div>'  ;
                   }elseif($qur->status == Subscription::ACCEPTED){
                    return '<div class="badge rounded-pill alert-success">الاشتراك جاري</div>'  ;
                 }elseif($qur->status == Subscription::CANCELED){
                    return '<div class="badge rounded-pill alert-danger">الاشتراك ملغي </div>'  ;
                  }elseif($qur->status == Subscription::EXPIRED){
                    return '<div class="badge rounded-pill alert-warning">الاشتراك منتهي </div>'  ;
                   }
              })
              ->rawColumns(['name' , 'status' , 'mobile' , 'serial_number' , 'id_number'])
            ->make(true);
    }




}
