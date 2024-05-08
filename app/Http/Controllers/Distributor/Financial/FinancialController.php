<?php

namespace App\Http\Controllers\Distributor\Financial;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinancialController extends Controller
{
    function index(){
        $id = Auth::user()->id ;
        $user = User::Where('id' , $id)->first();
        $portfolio = $user->portfolio ;
        return view('admin.distributors.financial.index' , compact('portfolio'));
     }

}
