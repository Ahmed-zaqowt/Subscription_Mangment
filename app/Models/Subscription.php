<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    protected $guarded = [] ;

    const WAITING = 1 ;
    const ACCEPTED = 2 ;
    const CANCELED = 3 ;
    const EXPIRED = 4  ;
    const RENEWAL = 5 ;

    const OLD = 6 ;
    const NEW = 7 ;


    const NOPAID = 8 ;
    const PAID = 9 ;
    
    function subscriber() {
         return $this->belongsTo(Subscriber::class);
    }

    function user() {
        return $this->belongsTo(User::class);
       }
}
