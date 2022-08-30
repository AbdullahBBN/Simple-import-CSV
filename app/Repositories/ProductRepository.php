<?php
namespace App\Repositories;

use App\Models\Product;

class ProductRepository {

    public function findOneByName($value){
        return Product::where("product_name", $value)->first();
    }

    public function findAll(){
        return Product::all();
    }

    public function removeAll(){
        return Product::truncate();
    }
}
