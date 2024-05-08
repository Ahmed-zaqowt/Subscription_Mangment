<?php

namespace App\Http\Controllers\Admin\distributor;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Subscriber;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class DistributorController extends Controller
{
    function index() {

        return view('admin.distributors.index');
    }


    function getdata()
    {
        $users = Subscriber::query()->orderBy('created_at', 'desc');

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('actions',
                function ($qur) {
                    $user = Subscription::query()->where('subscriber_id' , $qur->id)->orderBy('created_at', 'desc')->first();
                    $data_attr = '';
                    $data_attr .= 'data-id="' . $qur->id  . '" ';
                    $data_attr .= 'data-name="' . $qur->name . '"';
                    $data_attr .= 'data-id_number="' . $qur->id_number . '"';
                    $data_attr .= 'data-mobile="' . $qur->mobile . '"';
                    $data_attr .= 'data-serial_number="' . $qur->serial_number . '"';

                    $string = '';
                    $string .= '
                   <div class="d-flex align-items-center gap-3 fs-6">
                          <div class="dropdown">
      <div class="text-primary dropdown-toggle" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-eye-fill"></i>
      </div>
      <ul class="dropdown-menu" tabindex="-88888" aria-labelledby="dropdownMenuButton">

        <li> <a href="'. route('dist.user.subsciptions' , $qur->id) .'"><div class="dropdown-item followers_btn" data-id="' . $qur->id . '" data-type="followers">' . __('رؤية سجل الاشتراكات') . '</a></div></li>
      </ul>
    </div>

      <div  class="text-warning edit_btn" data-bs-toggle="modal" data-bs-target="#edit-modal" ' . $data_attr . '><i class="bi bi-pencil-fill"></i></div>



     <div class="text-danger delete_btn" data-id="' .$qur->id . '" data-url="/User/Users/delete">
        <i class="bi bi-trash-fill"></i>
      </div>
    </div>
      </div>';
                    return $string;
                }
            )
            ->rawColumns(['actions' , 'start_sub' , 'end_sub'])
            ->make(true);
    }

    function store(Request $request)
    {

        $request->validate([
            'name' => 'required' ,
            'mobile' => 'required|string:255|unique:subscribers,mobile' ,
            'id_number' => 'required|string:255|unique:subscribers,id_number' ,
            'serial_number' => 'required|string:255|unique:subscribers,serial_number' ,
            'start' => 'required' ,
            'end' => 'required' ,
        ]);

        $subscriber = Subscriber::create([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'id_number' => $request->id_number,
            'serial_number' => $request->serial_number,
            'user_id' => Auth::user()->id
        ]);

        $sub = Subscription::create([
            'user_id' => Auth::user()->id ,
            'subscriber_id' => $subscriber->id ,
            'status' => Subscription::WAITING ,
            'start' => $request->start ,
            'end' => $request->end ,
        ]);

        $startDate = Carbon::createFromFormat('Y-m-d', $sub->start);
        $endDate = Carbon::createFromFormat('Y-m-d', $sub->end);

        $diffInDays = $endDate->diffInDays($startDate);
        $setting = Setting::orderBy('created_at' , 'desc')->first();
        $subscription_price = ($diffInDays * $setting->price)/30 ; // حصيلة الاشتراك كم بالفلوس
        $portfolio = $subscriber->portfolio ;
         $admin = User::find(Auth::user()->id);
        $admin->update([
            'portfolio' => $portfolio + $subscription_price
        ]);

        return response()->json([
            "success" => "success"
        ], 201);
    }


    function update(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'serial_number' => 'required|string|max:255|unique:subscribers,serial_number,'.$request->id,
            'id_number' => 'required|string|max:255|unique:subscribers,id_number,'.$request->id,
            'mobile' => 'required|numeric|regex:/^[0-9]+$/|unique:subscribers,mobile,'.$request->id,
        ]);


        $subscriper = Subscriber::query()->where('id', $request->id)->first();

        $subscriper->update([
            'name' => $request->name,
            'id_number' => $request->id_number,
            'serial_number' => $request->serial_number,
            'mobile' => $request->mobile,
        ]);

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

    function subsciptions($id) {
         $sub = Subscriber::where('id' , $id)->first();
         return view('admin.distributors.subscription' , compact('sub'));
    }

    function getdatasub(Request $request) {

        $users = Subscription::query()->where('subscriber_id' , $request->id)->orderBy('created_at', 'desc');

        return DataTables::of($users)
            ->addIndexColumn()
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
            ->rawColumns(['status'])
            ->make(true);
    }

    function add_sub(Request $request) {


        Subscription::create([
            'user_id' => Auth::user()->id ,
            'subscriber_id' => $request->subscriber_id ,
            'status' => Subscription::WAITING ,
            'start' => $request->start ,
            'end' => $request->end ,
        ]);

        return redirect()->back()->with(['msg' => 'تمت الاضافة بنجاح']);
    }
}
