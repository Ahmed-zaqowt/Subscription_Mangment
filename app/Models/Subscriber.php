<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;
    protected $guarded = [] ;

    function sub()  {
      return $this->belongsTo(Subscriber::class , 'subscriber_id');
    }



}
