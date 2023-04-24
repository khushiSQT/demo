<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Exception;
use Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Session;
use View;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{

            $product=Product::all();

            return view('products.index',compact('product'))->with('i');


        }catch(Exception $e){

            log::info("error".print_r($e->getMessage(),true));
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

              try{
                return view('products.create');
              }catch(Exception $e){

                log::info("error".print_r($e->getMessage(),true));
            }



    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       try{
            $rules = [
                'name'=>'required',
                'price' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ];
            $validator = Validator::make($request->all() , $rules);
            if ($validator->fails())
             {
             return redirect()->route('products.create')
             ->with('message', implode(',', $validator->messages()->all()));
             }


            $input = $request->all();
            if ($image = $request->file('image')) {
                $destinationPath = 'images/';
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $input['image'] = "$profileImage";
            }

            $a=Product::create($input);

            if($a){


            return redirect()->route('products.index')
                            ->with('success','Product created successfully.');
            }



       }catch(Exception $e){

        log::info("error".print_r($e->getMessage(),true));
    }

        }





    // public function edit(Product $product)
    // {
    //     try{
    //         return view('products.edit',compact('product'));
    //     }
    //     catch(Exception $e){
    //         log::info("error:".print_r($e->getMessage(),true));
    //     }

    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        try{
        $request->validate([
            'name'=>'required',
            'price' => 'required',

        ]);

        $input = $request->all();

        if ($request->file('image')) {
            $destinationPath = 'images/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        }

        $product->update($input);

        return redirect()->route('products.index')
                        ->with('success','Product updated successfully');
    }
    catch(Exception $e)
    {
        log::info("error:".print_r($e->getMessage(),true));
    }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try{
            $product->delete();
            return redirect()->route('products.index')->with('success','succesfiully delete');
        }
        catch(Exception $e)
    {
        log::info("error:".print_r($e->getMessage(),true));
    }

    }

    public function products_list_json()
    {

      try{


            $product=Product::all();

            return response()->json(['data' =>$product ]);

      }

      catch(Exception $e){

        log::info("error:".print_r($e->getMessage(),true));
      }

    }


    public function delete(Request $request)
    {

        try{
            $product =Product::find($request->id);

            $product->delete();


            return response()->json([

               'message' =>'Data deleted successfully!'
           ]);
        }
        catch(Exception $e){

            log::info("error:".print_r($e->getMessage(),true));

        }

    }
    public function edit(Request $request)
    {
        try{


            $product =Product::find($request->id);


            return view('products.edit',compact('product'));

        }

        catch(Exception $e)

        {
             log::info("error:".print_r($e->getMessage(),true));
        }



    }


    public function changeStatus(Request $request)
    {

        try{

            $product=Product::find($request->id);

            $product->status=$request->status ;

            $product->save();

            return response()->json(['success'=>'Status change successfully.']);

        }

        catch(Exception $e){

           log::info("error:".print_r($e->getMessage(),true));

        }

    }

    }

