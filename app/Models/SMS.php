<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Type\Integer;

class SMS extends Model
{
    const ADD_SUBSCRIBER = 1 ;
    const RENEWAL = 2 ;
    const ACCEPTE =  3 ;
    const CANCELED =  4 ;
    const EXPIRED = 5 ;
    const EXPIRED_USER_MESSAGE = 6 ;
    public function sendSMS(String $phone , String $brand_name , Integer $status , $dist = null , $subscriber = null , $date = null ) {

        $text = '';
       if($status == self::ADD_SUBSCRIBER){
           $text = `($subscriber) اسم المشترك($dist) تم اضافة مشترك جديد من خلال الموزع` ;
       }elseif($status == self::RENEWAL){
           $text = `($subscriber)  للمشترك ($dist)تم تجديد الاشتراك من خلال الموزع` ;
       }elseif($status == self::ACCEPTE){
        $text = `($subscriber) تم قبول طلب المشترك  ` ;

       }elseif($status == self::CANCELED){
        $text = `($subscriber) تم رفض طلب المشترك  ` ;

       }elseif($status == self::EXPIRED){
        $text = `($subscriber) تم انتهاء اشتراك المشترك  ` ;
       }elseif($status == self::EXPIRED_USER_MESSAGE){
        $text = `($date) مشتركنا العزيز نود اعلامك بان الاشتراك الخاص بك سينتهي بتاريخ ` ;
       }


        $basic = new \Vonage\Client\Credentials\Basic(env('VONAGE_KEY'), env('VONAGE_ID'));
        $client = new \Vonage\Client($basic);

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS($phone, $brand_name , $text , 'unicode')
        );

        $message = $response->current();
    }
}
