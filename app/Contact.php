<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    //
    protected $fillable = [
        'name',
        'email',
        'phone',
        'option_1',
        'option_2',
        'option_3',
        'option_4',
        'option_5',
        'user_id'
    ];


    public function user(){
        return $this->belongsTo('App\User');
    }
}
