<?php

namespace App\Repository;
use App\Products;
use Illuminate\Support\Facades\Log;

class ProductsRepository{

    private $prod;
    public function __construct(){

    }

    public function getMeliProductByMeliId($meli_id){
        return Products::where('ml_product_id', $meli_id)->first();
    }

    public function saveProduct($product, $ml_user_id): void{
        $this->prod = new Products;
        try{
            $this->prod->title = $product->title;
            $this->prod->image = $product->pictures[0]->url;
            $this->prod->price = $product->price;
            $this->prod->ml_product_id = $product->id;
            $this->prod->ml_account_ml_user_id = $ml_user_id;
            $this->prod->save();
            Log::debug('Product with: '.$product->id.' Saved.');
        }catch(\Exception $e){
            Log::error('Error while saving product: '. $e->getMessage().': ',[$product]);
        }

    }
}