<?php

namespace App\Http\Controllers\Distributor\order;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\User;
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
        $users = Subscription::query()->where('user_id', Auth::user()->id)->where('status', Subscription::WAITING)->orderBy('created_at', 'desc');

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
                if ($qur->status == Subscription::WAITING) {
                    return '<div class="badge rounded-pill alert-info">الطلب معلق </div>';
                }
            })
            ->addColumn('actions', function ($qur) {
                $data_attr = '';
                $data_attr .= 'data-id="' . $qur->id  . '" ';
                $data_attr .= 'data-name="' . $qur->subscriber->name . '"';
                $data_attr .= 'data-id_number="' . $qur->subscriber->id_number . '"';
                $data_attr .= 'data-serial_number="' . $qur->subscriber->serial_number . '"';
                $data_attr .= 'data-start="' . $qur->start . '"';
                $data_attr .= 'data-end="' . $qur->end . '"';
                $data_attr .= 'data-mobile="' . $qur->subscriber->mobile . '"';
                $data_attr .= 'data-status_mobile="' . $qur->status_mobile . '"';

                $string = '';
                $string .= '
                   <div class="d-flex align-items-center gap-3 fs-6">

      <div  class="text-warning edit_btn" data-bs-toggle="modal" data-bs-target="#edit-modal" ' . $data_attr . '><i class="bi bi-pencil-fill"></i></div>
      <div class="text-danger delete_btn" data-id="' . $qur->id . '" data-url="/distributor/orders/delete">
      <i class="bi bi-trash-fill"></i>
      </div>
    </div>
      </div>';


                return $string;

                return '
                <div  class="text-warning edit_btn" data-bs-toggle="modal" data-bs-target="#edit-modal" ' . $data_attr . '><i class="bi bi-pencil-fill"></i></div>
                ';
            })
            ->rawColumns(['name', 'status', 'mobile', 'actions'])
            ->make(true);
    }

    /*function update(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|numeric|regex:/^[0-9]+$/|unique:Users,mobile,'.$request->user_id,
            'id_number' => 'required|numeric|regex:/^[0-9]+$/|unique:subscribers,id_number,'.$request->user_id,
            'serial_number' => 'required|numeric|regex:/^[0-9]+$/|unique:subscribers,serial_number,'.$request->user_id,
            'start' => 'required' ,
            'end' => 'required' ,
            'status_mobile' => 'required' ,
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
*/

    function delete(Request $request)
    {
        $sub = Subscription::find($request->id);
        $sub->delete();

        return response()->json(["success" => "تم الحذف بنجاح"], 201);
    }

    function canceled()
    {
        return view('admin.distributors.orders.canceled');
    }

    function getdata_canceled()
    {
        $users = Subscription::query()->where('user_id', Auth::user()->id)->where('status', Subscription::CANCELED)->orderBy('created_at', 'desc');

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
                    return '<div class="badge rounded-pill alert-danger">الطلب ملغي </div>';
                }
            })
            ->addColumn('actions', function ($qur) {
                return '<div class="text-danger delete_btn" data-id="' . $qur->id . '" data-url="/distributor/orders/delete">
                <i class="bi bi-trash-fill"></i>
                </div>';
            })
            ->rawColumns(['name', 'status', 'mobile', 'actions'])
            ->make(true);
    }




    function renewal()
    {
        return view('admin.distributors.orders.renewal');
    }

    function getdatarenewal()
    {
        $users = Subscription::query()->where('user_id', Auth::user()->id)->where('status', Subscription::RENEWAL)->orderBy('created_at', 'desc');

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
                    return '<div class="badge rounded-pill alert-info">الطلب مرسل للتجديد </div>';
                }
            })
            ->addColumn('actions', function ($qur) {
                return '<div class="text-danger delete_btn" data-id="' . $qur->id . '" data-url="/distributor/orders/delete">
                <i class="bi bi-trash-fill"></i>
                </div>';
            })
            ->rawColumns(['name', 'status', 'mobile', 'actions'])
            ->make(true);
    }
}
