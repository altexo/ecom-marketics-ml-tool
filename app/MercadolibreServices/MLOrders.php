<?php

namespace App\MercadolibreServices;
use App\MercadolibreServices\Meli;
use App\Orders;
use App\Repository\OrdersRepository;
use App\Repository\ProductsRepository;
use App\Products;
use App\MercadolibreServices\MLMessages;

class MLOrders{
    
    private $meli; 
    private $ordersRepository;
    private $mlMessages;

    public function __construct(){
        $this->ordersRepository = new OrdersRepository(new productsRepository(new Products));
        $this->mlMessages = new MLMessages();
        $this->meli = new Meli(ENV('APP_ID'), ENV('APP_SECRET_KEY'));
    }


    public function getOrders($token, $ml_user_id, $offset = 0){
        $params = ['access_token'=> $token, 'seller'=> $ml_user_id, 'offset'=> $offset ];

        return $this->meli->get('orders/search', $params, true);
    }

    public function getAllOrders($token, $id, $offset = 0){
        return $orders = $this->getOrders($token, $id, $offset);
        if(count($orders['body']['results']) <= 0){
            return true;
        }
        foreach($orders['body']['results'] as $order){
            echo '<pre>';
            print_r($order);
            echo '</pre>';
            echo $order['id'].'<br>';
            $this->ordersRepository->saveOrder($order);
            $this->mlMessages->syncMessagesFromOrder($token, $order['id'], $id);

        }
            
        if($offset < $orders['body']['paging']['total']){
            $offset = $offset+50;
            echo'Adding 50 to offset: '.$offset.'<br>';
            
           // echo $offset.'<br>';
            $this->getAllOrders($token, $id, $offset);
        }
        return true;
    }




}