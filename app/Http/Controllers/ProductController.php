<?php

namespace App\Http\Controllers;

use App\Imports\ProductsImport;
use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Services\ProductService;
use http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    private $productRepo;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepo = $productRepository;
    }

    /**
     * @desc Importing CSV file using Execl package and return to home page
     */
    public function importCSVFile(Request $request){
        $importFile = $request->file("csv");

        Excel::import(new ProductsImport(), $importFile);

        return redirect()->route("home")->with("message", "Successfully started the import process");
    }

    public function removeAll(Request $request){
        $this->productRepo->removeAll();
        if(Cache::has("products")){
            Cache::forget("products");
        }
    }

    public function getSingleProduct(Request $request){
        $name = $request->get("name");
        $product = $this->productRepo->findOneByName($name);
        return $product;
    }

    /**
     * Return all product with pagination (10) and save it in cache
     * Using Cache To return the products after the first
    */
    public function getAllProduct(Request $request){

        if(Cache::has("products")){
            return Cache::get("products");
        }

        $products = $this->productRepo->findAll();

        Cache::put("products",$products,3600);

        return $products;
    }

}
