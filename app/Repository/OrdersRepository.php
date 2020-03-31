<?php

namespace App\Repository;
use App\Orders;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Repository\ProductsRepository;
Class OrdersRepository{
    private $orders;
    protected $productsRepository;

    public function __construct(ProductsRepository $productsRepository)
    {
        $this->productsRepository = $productsRepository;
        //$this->orders = $orders;
    }

    public function saveOrder($order): void{
        if($this->productsRepository->getMeliProductByMeliId($order['order_items'][0]['item']['id']) != null){
            $this->orders = new Orders;
            try {
                $this->orders->ml_order_id = $order['id'];
                $this->orders->status = $order['status'];
                $this->orders->ml_date_created = Carbon::parse($order['date_created'])->format('Y-m-d h:i:s');
                $this->orders->buyer_nickname = $order['buyer']['nickname'];
                $this->orders->quantity = $order['order_items'][0]['quantity'];
                $this->orders->product_ml_product_id = $order['order_items'][0]['item']['id'];
                $this->orders->save();
                Log::debug('Order with id: '.$order['id'].'Saved. ');
            } catch (\Exception $e) {
                Log::error('Error while saving order '.$e->getMessage().': ', $order);
            }
        }
        Log::error('This will not save cause this MeliID doesent exist: ', [$order]);
        

    }
}