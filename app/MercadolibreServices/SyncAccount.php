<?php
namespace App\MercadolibreServices;
use App\MercadolibreServices\MLProducts;
use App\MercadolibreServices\MLMessages;
use App\MercadolibreServices\MLOrders;
use Async;

class SyncAccount{
    public $meli;
    private $mlProducts;
    private $mlMessages;
    private $mlOrders;

    public function __construct(MLProducts $mlProducts, MLMessages $mlMessages, MLOrders $mlOrders)
    {
        $this->mlProducts = $mlProducts;
        $this->mlMessages = $mlMessages;
        $this->mlOrders = $mlOrders;
        $this->meli = new Meli(ENV('APP_ID'), ENV('APP_SECRET_KEY'));
    }

    public function index($ml_id, $token){
        
        // run with anonymous function:
        // Async::run(function() {
        //     // Do a thing
        // });
    }
    public function syncProducts($ml_product_id, $ml_user_id,$token){
        
        $item = $this->mlProducts->getProductById($ml_product_id, $token);
        // if($item['httpCode']==200){
        //     $this->
        // }
        // $orders = $this->mlOrders->getOrders($token, $ml_user_id);
        // $messages = $this->mlMessages->getMessagesByOrder($token, '1932734148', $ml_user_id);
        //Get orders of products
        //Get Msjs of product

        //Save them
    }

    private function saveProduct($product){

    }

    private function saveOrder($order){

    }
    private function saveMessage($message){
        
    }


}