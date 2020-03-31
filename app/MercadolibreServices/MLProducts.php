<?php

namespace App\MercadolibreServices;
use App\MercadolibreServices\Meli;

class MLProducts{

    private $meli; 

    public function __construct(){
        $this->meli = new Meli(ENV('APP_ID'), ENV('APP_SECRET_KEY'));
    }

    public function getProducts($id,$token, $offset = 0){
        $params = ['access_token'=>$token, 'offset'=> $offset];
        return $this->meli->get('users/'.$id.'/items/search', $params, true);
    }

    public function getProductById($ml_id, $token){
        //curl -X GET https://api.mercadolibre.com/items?ids=$ITEM_ID1,$ITEM_ID2&attributes=$ATTRIBUTE1,$ATTRIBUTE2,$ATTRIBUTE3&access_token=$ACCESS_TOKEN

       //$params = ['access_token'=>$token, 'id'=> $ml_id, 'attributes'=> ['price', 'title']];
       //$params = ['access_token'=>$token, 'id'=> $ml_id];
        return $this->meli->get('items?access_token='.$token.'&id='.$ml_id.'&attributes=title,price,id,pictures');
    }

    public function getScanId($token, $id){
        $params = ['access_token'=> $token, 'search_type' => 'scan'];
        return $this->meli->get('users/'.$id.'/items/search', $params, true);

    }
    public function getProductsScrollId($id, $token, $scroll_id){
        $params = ['access_token'=> $token, 'search_type' => 'scan', 'scroll_id'=> $scroll_id];
        return $this->meli->get('users/'.$id.'/items/search', $params, true);
    }

}