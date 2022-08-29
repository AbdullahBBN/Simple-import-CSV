<?php

namespace App\Http\Controllers;

use App\Imports\ProductsImport;
use App\Models\Product;
use http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    /**
     * @desc Importing CSV file using Execl package and return to home page
     */

    /**
     * Runs the process.
     *
     * The callback receives the type of output (out or err) and
     * some bytes from the output in real-time. It allows to have feedback
     * from the independent process during execution.
     *
     * The STDOUT and STDERR are also available after the process is finished
     * via the getOutput() and getErrorOutput() methods.
     * @return \Illuminate\Http\Response redirect
     */
    public function importCSVFile(Request $request){
        $importFile = $request->file("csv");

        Excel::import(new ProductsImport, $importFile);

        return redirect()->route("home");
    }

    public function removeAll(Request $request){
        Product::truncate();
        if(Cache::has("products")){
            Cache::forget("products");
        }
    }

    public function getSingleProduct(Request $request){
        $name = $request->get("name");
        $product = Product::where("product_name",$name)->firstOrFail();
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

        $products = Product::paginate(10);

        Cache::put("products",$products,3600);

        return $products;
    }

}
