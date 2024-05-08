<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catgeory extends Model
{
    use HasFactory;
    protected $guarded = [] ;


    function  parent() {
     return $this->hasOne(Catgeory::class , 'parent_id')->withDefault(['name' => '-']);
    }
}
