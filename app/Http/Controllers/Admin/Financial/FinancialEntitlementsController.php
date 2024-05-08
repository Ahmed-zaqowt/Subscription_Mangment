<?php

namespace App\Http\Controllers\Admin\Financial;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FinancialEntitlementsController extends Controller
{
     function index(){
        return view('admin.admins.financial.index');
     }

     function getdata()
     {
         $users = User::query()->where('status' , 2)->orderBy('created_at', 'desc');
         return DataTables::of($users)
             ->addIndexColumn()
             ->addColumn('portfolio' , function ($qur) {
                 $portfolio = number_format($qur->portfolio, 2);
                 if($portfolio == 0){
                   return '<div class="badge rounded-pill alert-danger">'. $portfolio .'</div>'  ;
                 }else{
                    return '<div class="badge rounded-pill alert-success">'. $portfolio .'</div>'  ;
                }
             })
             ->addColumn(
                 'actions',
                 function ($qur) {

                     $string = '';
                     if($qur->portfolio != 0){
                        $string .= '<form id="form_add" action="'.route('admin.financial.zeroing') .'" method="post" >
                        <input type="hidden" name="id" value="'.$qur->id .'">
                      <input type="hidden" name="_token" value="'.csrf_token() .'">
                        <button type="submit" class="btn btn-primary btn-sm ">تصفير المحفظة</button></form>';
                     }else{
                        $string .= '
                        <button type="submit" class="btn btn-secondary btn-sm">المحفظة فارغة</button>
                        ';
                     }

                     return $string;
                 }
             )
             ->rawColumns(['actions' , 'portfolio'])
             ->make(true);
     }

     function zeroing(Request $request) {
         $dist = User::find($request->id);
         $dist->update([
           'portfolio' => 0
         ]);

         return redirect()->back()->with([
            'msg' => 'تم تصفير المحفظة ' ,
            'type' => 'success'
         ]);

     }
}
