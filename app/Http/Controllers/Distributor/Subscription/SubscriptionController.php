<?php

namespace App\Http\Controllers\Distributor\subscription;

use App\Http\Controllers\Controller;
use App\Models\SMS;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Yajra\DataTables\Facades\DataTables;

class SubscriptionController extends Controller
{
    function index() {


        return view('admin.distributors.subscriptions.index');
    }

    function getdata() {
        $users = Subscription::query()
        ->where('user_id' , Auth::user()
        ->id)
        ->Where('status' , Subscription::ACCEPTED)
        ->orWhere('status' , Subscription::EXPIRED)
        ;
        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('payment' , function ($qur) {
                if($qur->payment == Subscription::NOPAID){
                    return '<div class="badge rounded-pill alert-danger">  غير مسددة</div>'  ;
                   }elseif($qur->payment == Subscription::PAID){
                    return '<div class="badge rounded-pill alert-success">مسددة </div>'  ;
                 }
              })
            ->addColumn('name' , function ($qur) {
                 return $qur->subscriber->name ;
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
              ->addColumn('actions', function ($qur) {
                if($qur->status == Subscription::ACCEPTED){
                    return '<span class="text-danger">  ليس هناك اجراءات للاشتراك</span>';
                }else{
                    return '<button  type="submit" data-bs-toggle="modal" data-bs-target="#edit-modal" data-id="'. $qur->id .'" class="btn btn-outline-success btn-sm btn-renewal">تجديد الاشتراك المنتهي</button>';
                }

            })
              ->rawColumns(['name' , 'status' , 'mobile' , 'actions' , 'payment'])
              ->make(true);
    }


    function accepted() {
       return view('admin.distributors.subscriptions.accepted');
    }

    function getdataaccepted() {
        $users = Subscription::query()->where('user_id' , Auth::user()
        ->id)->where('status' , Subscription::ACCEPTED )->orderBy('created_at', 'desc');
        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('payment' , function ($qur) {
                if($qur->payment == Subscription::NOPAID){
                    return '<div class="badge rounded-pill alert-danger">  غير مسددة</div>'  ;
                   }elseif($qur->payment == Subscription::PAID){
                    return '<div class="badge rounded-pill alert-success">مسددة </div>'  ;
                 }
              })
            ->addColumn('name' , function ($qur) {
              return $qur->subscriber->name;
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
              })->addColumn('actions', function ($qur) {
                return '<span class="text-danger">  ليس هناك اجراءات للاشتراك</span>';

            })
              ->rawColumns(['name' , 'status' , 'payment' ,  'mobile', 'actions'])
            ->make(true);
    }

    function expired() {
        return view('admin.distributors.subscriptions.expired');
     }

     function getdataexpired() {
         $users = Subscription::query()->where('user_id' , Auth::user()
         ->id)->where('status' , Subscription::EXPIRED )->orderBy('created_at', 'desc');
         return DataTables::of($users)
             ->addIndexColumn()
             ->addColumn('payment' , function ($qur) {
                if($qur->payment == Subscription::NOPAID){
                    return '<div class="badge rounded-pill alert-danger">  غير مسددة</div>'  ;
                   }elseif($qur->payment == Subscription::PAID){
                    return '<div class="badge rounded-pill alert-success">مسددة </div>'  ;
                 }
              })
             ->addColumn('name' , function ($qur) {
               return $qur->subscriber->name;
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
               ->addColumn('actions', function ($qur) {
                if($qur->status == Subscription::ACCEPTED){
                    return '<span class="text-danger">  ليس هناك اجراءات للاشتراك</span>';
                }else{
                    return '<button  type="submit" data-bs-toggle="modal" data-bs-target="#edit-modal" data-id="'. $qur->id .'" class="btn btn-outline-success btn-sm btn-renewal">تجديد الاشتراك المنتهي</button>';
                }

            })
               ->rawColumns(['name' , 'status' , 'mobile' , 'payment' , 'actions'])
             ->make(true);
     }



     function renewal(Request $request) {
        $request->validate([
            'start' => 'required' ,
            'end' => 'required' ,
        ]);

        $subscription = Subscription::query()->findOrFail($request->id);
        $subscription->update([
            'start' => $request->start ,
            'end' => $request->end ,
            'status' => Subscription::RENEWAL
        ]);

        Controller::sendSMS(env('MOBILE_NUMBER_ADMIN') , env('APP_NAME') , SMS::RENEWAL , $subscription->user->name , $subscription->subscriber->name);
        return response()->json([
            'success' => __('تم تجديد الاشتراك بنجاح')
        ], 201);
   }








}
