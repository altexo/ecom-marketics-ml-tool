<?php

namespace App;
use Nicolaslopezj\Searchable\SearchableTrait;


use Illuminate\Database\Eloquent\Model;
use PDO;

class Orders extends Model
{
    use SearchableTrait;

    public function Messages(){
        return $this->hasOne('App\Messages', 'order_ml_order_id', 'ml_order_id');
    }

    // public function Products(){
    //     return $this->hasOne('App\Products', '','');
    // }

    protected $searchable = [
        'columns' => [
            'orders.ml_order_id' => 8,
            'products.title' => 10,
            'products.ml_product_id' => 8,
            'orders.buyer_nickname' => 5,
            'orders.buyer_id' => 4,
        ],
        'joins' => [
            'products' => ['products.ml_product_id','orders.product_ml_product_id'],
        ],
    ];

    
}
