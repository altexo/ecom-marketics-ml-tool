<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Products extends Model implements Searchable
{
    
    public function Orders(){
        return $this->hasMany('App\Orders', 'product_ml_product_id', 'ml_product_id');
    }

  
}
