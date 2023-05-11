<?php

namespace App\Http\Controllers;
use App\Repositories\ProductRepository;
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

        return ProductRepository::index();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

             return ProductRepository::create();

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


            ];
            $validator = Validator::make($request->all() , $rules);
            if ($validator->fails())
             {
             return redirect()->route('products.create')
             ->with('message', implode(',', $validator->messages()->all()));
             }

             $files = [];
             if($request->hasfile('image'))
              {
                 foreach($request->file('image') as $file)
                 {
                     $name = time().rand(1,50).'.'.$file->extension();
                     $file->move(public_path('images'), $name);
                     $files[] = $name;


                 }
              }

              $file= new Product();

              $file->image = implode(',',$files);

              $file->name = $request->name;

              $file->price =  $request->price;

              $file->save();

              return redirect()->route('products.index',$file)
              ->with('success','Product create successfully');




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

    public function products_list_json(Request $request)
    {

      try{

        $page_index = (int)$request->input('start') > 0 ? ($request->input('start')
         / $request->input('length')) + 1 : 1;
        $limit = (int)$request->input('length') > 0 ? $request->input('length') : DEFAULT_RECORDS_LIMIT;
        $columnIndex = $request->input('order')[0]['column']; // Column index
        $columnName = $request->input('columns')[$columnIndex]['data']; // Column name
        $columnSortOrder = $request->input('order')[0]['dir']; // asc or desc value

        $main_query = Product::from('products as cat')
        ->select('cat.id','cat.name','cat.price','cat.image','cat.status')->orderBy($columnName,
         $columnSortOrder);

        $data_list_for_count = $main_query->get();  // group by and direct count not working
        $recordsTotal = count($data_list_for_count);

        $recordsFiltered = $recordsTotal;

        if(empty($request->input('search.value'))){

            $appointments = $main_query->paginate($limit, ['*'], 'page', $page_index);

        }else {

            $search = $request->input('search.value');

            $search_query = $main_query->where('cat.id','LIKE',"%{$search}%")
                                        ->orWhere('cat.name','LIKE',"%{$search}%")
                                        ->orWhere('cat.price','LIKE',"%{$search}%")
                                        ->orWhere('cat.image','LIKE',"%{$search}%")
                                        ->orWhere('cat.status','LIKE',"%{$search}%");

            $appointments = $search_query->paginate($limit, ['*'], 'page', $page_index);

            $search_list_for_count = $search_query->get();  // group by and direct count not working

            $recordsFiltered = count($search_list_for_count);



        }

        log::info("error:".print_r($recordsFiltered,true));
        $response = array(
            "draw" => (int)$request->input('draw'),
            "recordsTotal" => (int)$recordsTotal,
            "recordsFiltered" => (int)$recordsFiltered,
            "data" => $appointments->getCollection()
        );

        return response()->json($response, 200);
        // $draw = $request->get('draw');
        // $start = $request->get("start");
        // $rowperpage = $request->get("length"); // Rows display per page

        // $columnIndex_arr = $request->get('order');
        // $columnName_arr = $request->get('columns');
        // $order_arr = $request->get('order');
        // $search_arr = $request->get('search');

        // $columnIndex = $columnIndex_arr[0]['column']; // Column index
        // $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        // $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        // $searchValue = $search_arr['value']; // Search value

        // // Total records
        // $totalRecords = Product::select('count(*) as allcount')->count();
        // $totalRecordswithFilter = Product::select('count(*) as allcount')
        // ->where('name', 'like', '%' .$searchValue . '%')
        // ->orWhere('price', 'like', '%' .$searchValue . '%')
        // ->orWhere('status', 'like', '%' .$searchValue . '%')
        // ->orWhere('image', 'like', '%' .$searchValue . '%')
        // ->count();
        // // Fetch records
        // $records = Product::orderBy($columnName,$columnSortOrder)
        //        ->where('products.name', 'like', '%' .$searchValue . '%')
        //        ->orWhere('products.price', 'like', '%' .$searchValue . '%')
        //        ->orWhere('products.status', 'like', '%' .$searchValue . '%')
        //        ->orWhere('products.image', 'like', '%' .$searchValue . '%')
        //       ->select('products.*')
        //       ->skip($start)
        //       ->take($rowperpage)
        //       ->get();

        // $data_arr = array();

        // foreach($records as $record){
        //    $id = $record->id;

        //    $name = $record->name;
        //     $price=$record->price;
        //     $status=$record->status;
        //     $image=$record->status;
        //    $data_arr[] = array(
        //        "id" => $id,
        //        "price"=>$price,
        //        "name" => $name,
        //        "status" => $status,
        //        "image" => $image,
        //    );
        // }

        // $response = array(
        //    "draw" => intval($draw),
        //    "iTotalRecords" => $totalRecords,
        //    "iTotalDisplayRecords" => $totalRecordswithFilter,
        //    "aaData" => $data_arr
        // );

        // return response()->json($response);
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

            $images = explode(',', $product->image);




            return view('products.edit',compact('product','images'));

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

