<?php

namespace App\MercadolibreServices;
use App\MercadolibreServices\Meli;
//use App\User;
use App\Ml_account;

class MeliToken 
{
    public function refreshToken($ml_account){
        $meli = new Meli(ENV('APP_ID'), ENV('APP_SECRET_KEY'), $ml_account->ml_token, $ml_account->ml_refresh_token) ;
        $new_token = $meli->refreshAccessToken();
        if ($new_token['httpCode'] == 200) {

            $ml_account = Ml_account::where('ml_user_id', $ml_account->ml_user_id)->first();
            $ml_account->ml_token = $new_token['body']->access_token;
            $ml_account->ml_refresh_token = $new_token['body']->refresh_token;
            $ml_account->save();

            return ['success'=> true, 'new_token'=> $ml_account->ml_token];
        }else{
            ['success'=> false, 'new_token'=> ''];
        }
    }


}
