<?php

namespace App\Http\Controllers\Distributor\order;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    function index()
    {
        return view('admin.distributors.orders.orders');
    }

    function getdata()
    {
        $users = Subscription::query()->where('user_id' , Auth::user()->id)->where('status', Subscription::WAITING)->orderBy('created_at', 'desc');

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('name_dist', function ($qur) {
                return $qur->user->name;
            })
            ->addColumn('name', function ($qur) {
                return $qur->subscriber->name;
            })
            ->addColumn('mobile', function ($qur) {
                return $qur->subscriber->mobile;
            })
            ->addColumn('id_number', function ($qur) {
                return $qur->subscriber->id_number;
            })
            ->addColumn('serial_number', function ($qur) {
                return $qur->subscriber->serial_number;
            })
            ->addColumn('status', function ($qur) {
                if ($qur->status == Subscription::WAITING) {
                    return '<div class="badge rounded-pill alert-info">الطلب معلق </div>'  ;
                }
            })
            ->addColumn('actions', function ($qur) {
                return '<div class="text-danger delete_btn" data-id="' .$qur->id . '" data-url="/distributor/orders/delete">
                <i class="bi bi-trash-fill"></i>
                </div>';
            })
            ->rawColumns(['name', 'status', 'mobile', 'actions'])
            ->make(true);
    }



    function canceled() {
        return view('admin.distributors.orders.canceled');
    }

    function getdata_canceled() {
        $users = Subscription::query()->where('user_id' , Auth::user()->id)->where('status', Subscription::CANCELED)->orderBy('created_at', 'desc');

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('name', function ($qur) {
                return $qur->subscriber->name;
            })
            ->addColumn('mobile', function ($qur) {
                return $qur->subscriber->mobile;
            })
            ->addColumn('id_number', function ($qur) {
                return $qur->subscriber->id_number;
            })
            ->addColumn('serial_number', function ($qur) {
                return $qur->subscriber->serial_number;
            })
            ->addColumn('status', function ($qur) {
                if ($qur->status == Subscription::CANCELED) {
                    return '<div class="badge rounded-pill alert-danger">الطلب ملغي </div>'  ;
                }
            })
            ->addColumn('actions', function ($qur) {
                return '<div class="text-danger delete_btn" data-id="' .$qur->id . '" data-url="/distributor/orders/delete">
                <i class="bi bi-trash-fill"></i>
                </div>';
            })
            ->rawColumns(['name', 'status', 'mobile', 'actions'])
            ->make(true);
    }


    function delete(Request $request)
    {
       $sub = Subscription::find($request->id);
       $sub->delete();

        return response()->json(["success" => "تم الحذف بنجاح"], 201);
    }

    function renewal()
    {
        return view('admin.distributors.orders.renewal');
    }

    function getdatarenewal()
    {
        $users = Subscription::query()->where('user_id' , Auth::user()->id)->where('status', Subscription::RENEWAL)->orderBy('created_at', 'desc');

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('name_dist', function ($qur) {
                return $qur->user->name;
            })
            ->addColumn('name', function ($qur) {
                return $qur->subscriber->name;
            })
            ->addColumn('mobile', function ($qur) {
                return $qur->subscriber->mobile;
            })
            ->addColumn('id_number', function ($qur) {
                return $qur->subscriber->id_number;
            })
            ->addColumn('serial_number', function ($qur) {
                return $qur->subscriber->serial_number;
            })
            ->addColumn('status', function ($qur) {
                if ($qur->status == Subscription::RENEWAL) {
                    return '<div class="badge rounded-pill alert-info">الطلب مرسل للتجديد </div>'  ;
                }
            })
            ->addColumn('actions', function ($qur) {
                return '<div class="text-danger delete_btn" data-id="' .$qur->id . '" data-url="/distributor/orders/delete">
                <i class="bi bi-trash-fill"></i>
                </div>';
            })
            ->rawColumns(['name', 'status', 'mobile', 'actions'])
            ->make(true);
    }
}
