<?php

namespace App\Http\Controllers\Admin\Subscription;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SubscriptionController extends Controller
{
    function index() {
        return view('admin.admins.subscriptions.index');
    }

    function getdata() {
        $users = Subscription::query()->where('status' , Subscription::ACCEPTED )->orWhere('status' , Subscription::EXPIRED)->orderBy('created_at', 'desc');
        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('name_dis' , function ($qur) {
                return $qur->user->name;
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
              ->addColumn('payment' , function($qur){
                if($qur->payment == Subscription::NOPAID){
                   return '<div class="badge rounded-pill alert-danger"> غير مسددة</div>'  ;
                }elseif($qur->payment == Subscription::PAID){
                   return '<div class="badge rounded-pill alert-success">  مسددة</div>'  ;
                }
             })
              ->addColumn('actions', function ($qur) {
                if($qur->status == Subscription::ACCEPTED){
                    return '<form method="post" id="form_status" action="' . route('admin.order.update') . '">
                    <input type="hidden" name="id" id="id" value="' . $qur->id .  '">
                    <input type="hidden" name="_token"  value="' . csrf_token() .  '">
                    <div class="mb-2 form-group">
                    <select name="status" class="form-control-sm select_status" >
                     <option disabled selected>تعديل حالة الطلب</option>
                     <option value="1">الارجاع  الانتظار</option>
                     <option value="3">الغاء الاشتراك</option>
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                </form>';
                }else{
                    return '<button  type="submit" data-bs-toggle="modal" data-bs-target="#edit-modal" class="btn btn-outline-success btn-sm ">تجديد الاشتراك المنتهي</button>';
                }

            })
              ->rawColumns(['name', 'payment' , 'status' , 'mobile' , 'actions'])
            ->make(true);
    }

    function accepted() {
       return view('admin.admins.subscriptions.accepted');
    }

    function getdataaccepted() {
        $users = Subscription::query()->where('status' , Subscription::ACCEPTED )->orderBy('created_at', 'desc');
        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('name_dis' , function ($qur) {
                return $qur->user->name;
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
                return '<form method="post" id="form_status" action="' . route('admin.order.update') . '">
                       <input type="hidden" name="id" id="id" value="' . $qur->id .  '">
                       <input type="hidden" name="_token"  value="' . csrf_token() .  '">
                       <div class="mb-2 form-group">
                       <select name="status" class="form-control-sm select_status" >
                        <option disabled selected>تعديل حالة الطلب</option>
                        <option value="1">الرجوع الى الانتظار</option>
                        <option value="3">الغاء الاشتراك</option>
                       </select>
                       <div class="invalid-feedback"></div>
                   </div>
                   </form>';
            })
              ->rawColumns(['name' , 'status' , 'mobile', 'actions'])
            ->make(true);
    }
    function expired() {
        return view('admin.admins.subscriptions.expired');
     }

     function getdataexpired() {
         $users = Subscription::query()->where('status' , Subscription::EXPIRED )->orderBy('created_at', 'desc');
         return DataTables::of($users)
             ->addIndexColumn()
             ->addColumn('name_dis' , function ($qur) {
                 return $qur->user->name;
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
                return '<form method="post" id="form_status" action="' . route('admin.order.update') . '">
                       <input type="hidden" name="id" id="id" value="' . $qur->id .  '">
                       <input type="hidden" name="_token"  value="' . csrf_token() .  '">
                       <div class="mb-2 form-group">
                       <select name="status" class="form-control-sm select_status" >
                        <option disabled selected>تعديل حالة الطلب</option>
                        <option value="2">الغاء الاشتراك</option>
                        <option value="2">تاكيد الطلب</option>
                        <option value="3">إلغاء الطلب</option>
                       </select>
                       <div class="invalid-feedback"></div>
                   </div>
                   </form>';
            })
               ->rawColumns(['name' , 'status' , 'mobile' , 'actions'])
             ->make(true);
     }

}
