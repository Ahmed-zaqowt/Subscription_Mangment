<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\SMS;
use App\Models\Subscriber;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    function index()
    {
        return view('admin.admins.orders.orders');
    }

    function getdata()
    {
        $users = Subscription::query()
            ->where('status', Subscription::WAITING)
            ->orderBy('created_at', 'desc');

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('name_dist', function ($qur) {
                return $qur->user->email;
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
                    return '<div class="badge rounded-pill alert-info">الطلب معلق </div>';
                }
            })
            ->addColumn('actions', function ($qur) {
                return '<form method="post" id="form_status" action="' . route('admin.order.update') . '">
                       <input type="hidden" name="id" id="id" value="' . $qur->id .  '">
                       <input type="hidden" name="_token"  value="' . csrf_token() .  '">
                       <div class="mb-2 form-group">
                       <select name="status" class="form-control-sm select_status" >
                        <option disabled selected>تعديل حالة الطلب</option>
                        <option value="2">تاكيد الطلب</option>
                        <option value="3">إلغاء الطلب</option>
                       </select>
                       <div class="invalid-feedback"></div>
                   </div>
                   </form>';
            })
            ->rawColumns(['name', 'status', 'mobile', 'actions'])
            ->make(true);
    }

    function update(Request $request)
    {

        $order = Subscription::query()->findOrFail($request->id);

        if ($order->status == Subscription::ACCEPTED && $request->status == Subscription::WAITING || $request->status == Subscription::CANCELED ) {
            $startDate = Carbon::createFromFormat('Y-m-d', $order->start);
            $endDate = Carbon::createFromFormat('Y-m-d', $order->end);

            $diffInDays = $endDate->diffInDays($startDate);
            $setting = Setting::orderBy('created_at', 'desc')->first();
            $subscription_price = ($diffInDays * $setting->price) / 30; // حصيلة الاشتراك كم بالفلوس
            $portfolio = $order->user->portfolio;
            $admin = User::find($order->user->id);

            $admin->update([
                'portfolio' => $portfolio - $subscription_price
            ]);

            $order->update([
                'payment' => '8' ,
            ]);

        }

        if ($request->status == Subscription::ACCEPTED) {
            $order->update([
                'status' => Subscription::ACCEPTED
            ]);
            $startDate = Carbon::createFromFormat('Y-m-d', $order->start);
            $endDate = Carbon::createFromFormat('Y-m-d', $order->end);

            $diffInDays = $endDate->diffInDays($startDate);
            $setting = Setting::orderBy('created_at', 'desc')->first();
            $subscription_price = ($diffInDays * $setting->price) / 30; // حصيلة الاشتراك كم بالفلوس
            $portfolio = $order->user->portfolio;
            $admin = User::find($order->user->id);

            // $admin = User::find(Auth::user()->id);
            $admin->update([
                'portfolio' => $portfolio + $subscription_price
            ]);

            Controller::sendSMS($order->user->mobile , env('APP_NAME') , SMS::ACCEPTE , $order->subscriber->name);

        } elseif ($request->status == Subscription::CANCELED) {
            $order->update([
                'status' => Subscription::CANCELED
            ]);
        } elseif ($request->status == Subscription::WAITING) {
            $order->update([
                'status' => Subscription::WAITING
            ]);

            Controller::sendSMS($order->user->mobile , env('APP_NAME') , SMS::CANCELED , $order->subscriber->name);
        } else {
            return  response()->json([
                'danger' => 'الادخال خاطئ'
            ], 201);
        }



        return  response()->json([
            'success' => 'تم تعديل الحالة بنجاح'
        ], 201);
    }

    function canceled()
    {
        return view('admin.admins.orders.canceled');
    }

    function getdatacanceled()
    {
        $users = Subscription::query()->where('status', Subscription::CANCELED)->orderBy('created_at', 'desc');

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
                if ($qur->status == Subscription::CANCELED) {
                    return '<div class="badge rounded-pill alert-danger">الطلب ملغي </div>';
                }
            })
            ->addColumn('actions', function ($qur) {
                return '<form method="post" id="form_status" action="' . route('admin.order.update') . '">
                       <input type="hidden" name="id" id="id" value="' . $qur->id .  '">
                       <input type="hidden" name="_token"  value="' . csrf_token() .  '">
                       <div class="mb-2 form-group">
                       <select name="status" class="form-control-sm select_status" >
                        <option disabled selected>تعديل حالة الطلب</option>
                        <option value="1">ارجاع للانتظار</option>
                        <option value="2">تاكيد الطلب</option>
                       </select>
                       <div class="invalid-feedback"></div>
                   </div>
                   </form>';
            })
            ->rawColumns(['name', 'status', 'mobile', 'actions'])
            ->make(true);
    }

    function renewal()
    {
        return view('admin.admins.orders.renewal');
    }

    function getdatarenewal()
    {
        $users = Subscription::query()
            ->where('status', Subscription::RENEWAL)
            ->orderBy('created_at', 'desc');

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('name_dist', function ($qur) {
                return $qur->user->email;
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
                    return '<div class="badge rounded-pill alert-info">الطلب مرسل للتجديد </div>';
                }
            })
            ->addColumn('actions', function ($qur) {
                return '<form method="post" id="form_status" action="' . route('admin.order.update') . '">
                       <input type="hidden" name="id" id="id" value="' . $qur->id .  '">
                       <input type="hidden" name="_token"  value="' . csrf_token() .  '">
                       <div class="mb-2 form-group">
                       <select name="status" class="form-control-sm select_status" >
                        <option disabled selected>تعديل حالة الطلب</option>
                        <option value="2">تاكيد الطلب</option>
                        <option value="3">إلغاء الطلب</option>
                       </select>
                       <div class="invalid-feedback"></div>
                   </div>
                   </form>';
            })
            ->rawColumns(['name', 'status', 'mobile', 'actions'])
            ->make(true);
    }
}
