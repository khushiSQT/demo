<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
     static function index()
    {
        try{

            $product=Product::all();

            return view('products.index',compact('product'))->with('i');


        }catch(Exception $e){

            log::info("error".print_r($e->getMessage(),true));
        }

    }
    static function create()
    {

              try{
                return view('products.create');
              }catch(Exception $e){

                log::info("error".print_r($e->getMessage(),true));
            }



    }
}

?>
