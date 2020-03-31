<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ml_account extends Model
{
    protected $table = "ml_account";

    protected $fillable = [
        'ml_user_id', 'ml_email','ml_token', 'ml_refresh_token', 'user_id'
    ];

    protected $hidden = [
        'ml_token', 'ml_refresh_token'
    ];

    public function products()
    {
        return $this->hasMany('App\Products', 'ml_account_ml_user_id', 'ml_user_id');
    }

    // public function user(){
    //     return $this->belongsTo('App\User', 'ml_user_id', '')
    // }
}
