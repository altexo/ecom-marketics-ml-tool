<?php

namespace App\MercadolibreServices;
use App\MercadolibreServices\Meli;

class MLTest{

    public $meli;
    public function __construct()
    {
        $this->meli = new Meli(ENV('APP_ID'), ENV('APP_SECRET_KEY'));
    }

    public function createTestUser($token, $site_id){
        $params = ['access_token'=> $token]; 
        $body = ['site_id'=> $site_id];
        return $this->meli->post('users/test_user', $body,$params);
    }
    /*
    {
        "body": {
            "id": 535863128,
            "nickname": "TESTZ6GDKOP3",
            "password": "qatest6728",
            "site_status": "active",
            "email": "test_user_53965870@testuser.com"
        },
        "httpCode": 201
    }
    

    {
        "body": {
            "id": 535863184,
            "nickname": "TETE8540712",
            "password": "qatest3499",
            "site_status": "active",
            "email": "test_user_24412870@testuser.com"
        },
        "httpCode": 201
    }
    */
}