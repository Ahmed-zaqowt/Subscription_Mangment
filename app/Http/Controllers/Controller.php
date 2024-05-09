<?php

namespace App\Http\Controllers;

use App\Models\SMS;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public static function sendSMS(String $phone , String $brand_name , int $status , String $dist = null , $subscriber = null , $date = null ) {
        // dd($dist);
        $text = '';
       if($status == SMS::ADD_SUBSCRIBER){
           $text = "(". $dist . ") تم اضافة مشترك جديد من خلال الموزع" ;
        }elseif($status == SMS::RENEWAL){
           $text .= $subscriber . " للمشترك  ".$dist." تم تجديد الاشتراك من خلال الموزع" ;
       }elseif($status == SMS::ACCEPTE){
        $text .= $subscriber . " تم قبول طلب المشترك  " ;
       }elseif($status == SMS::CANCELED){
        $text .= $subscriber . " تم رفض طلب المشترك ";
       }elseif($status == SMS::EXPIRED){
        $text .= $subscriber .  " تم انتهاء اشتراك المشترك  " ;
       }elseif($status == SMS::EXPIRED_USER_MESSAGE){
        $text .= $date . " مشتركنا العزيز نود اعلامك بان الاشتراك الخاص بك سينتهي بتاريخ " ;
       }


        $basic = new \Vonage\Client\Credentials\Basic(env('VONAGE_KEY'), env('VONAGE_ID'));
        $client = new \Vonage\Client($basic);

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS($phone, $brand_name , $text , 'unicode')
        );

        $message = $response->current();
    }
}

