<?php

namespace App\Http\Controllers;

use App\Models\item;
use App\Models\Product;
use Illuminate\Http\Request;
use Exception;
use Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Session;
use View;

class ItemController extends Controller
{
    public function index()
    {

        return view('item.index');

    }
       public function create(Request $request)
       {
        $abc=Product::all();

        return view('item.create',compact('abc'));
       }
       public function store(Request $request)
       {


        $items=$request->group;
        // dd($items);

        foreach($items as $item)
        {

            $abc=new item();
            $abc->fname=$item['fname'];
            $abc->lname=$item['lname'];
            $abc->detail=$item['detail'];
            $abc->product_id=$item['p_name'];
            $xyz=$abc->save();


        }
        return redirect()->route('item.index',)
        ->with('success','Product create successfully');

       }
       public function indexjson(Request $request)
       {
        $page_index = (int)$request->input('start') > 0 ? ($request->input('start')
         / $request->input('length')) + 1 : 1;
        $limit = (int)$request->input('length') > 0 ? $request->input('length') : DEFAULT_RECORDS_LIMIT;
        $columnIndex = $request->input('order')[0]['column']; // Column index
        $columnName = $request->input('columns')[$columnIndex]['data']; // Column name
        $columnSortOrder = $request->input('order')[0]['dir']; // asc or desc value

        $main_query = item::from('items as cat')
        ->select('cat.id','cat.fname','cat.lname','cat.detail','cat.price','cat.created_at','cat.updated_at','cat.product_id')->with('product_data')->orderBy($columnName,
         $columnSortOrder);

         if(isset($request->fname)){
            $main_query = $main_query->where('cat.fname','LIKE',"%{$request->fname}%");
         }

        $xyz=$request->product_id;

        if(isset($xyz))
        {

            $main_query = $main_query->where('cat.product_id',$xyz);
        }
         if(isset($request->created_at) && isset($request->updated_at)  ){
            $a=date("Y/m/d H:i:s",strtotime($request->created_at));
            $b=date("Y/m/d H:i:s",strtotime($request->updated_at));
            // $a=$request->created_at;
            // $b=$request->updated_at;
            dd($a,$b);
            $main_query =  $main_query->whereBetween('cat.created_at',[$a,$b]);
         }

        $data_list_for_count = $main_query->get();  // group by and direct count not working

        $recordsTotal = count($data_list_for_count);

        $recordsFiltered = $recordsTotal;

        if(empty($request->input('search.value'))){

            $appointments = $main_query->paginate($limit, ['*'], 'page', $page_index);

        }else {

            $search = $request->input('search.value');

            $search_query = $main_query->where('cat.fname','LIKE',"%{$search}%")
                                        ->orWhere('cat.created_at','LIKE',"%{$search}%")
                                         ->orWhere('cat.updated_at','LIKE',"%{$search}%");

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
        //   $items=item::with(['product_data'])->get();

        //   return response()->json(['data'=>$items], 200);

       }
       public function delete(Request $request)
       {
          $item=item::find($request->id);
          $item->delete();

          return response()->json([

            'message' =>'Data deleted successfully!'
        ]);
       }
       public function edit(Request $request)

       {
            $item=item::find($request->id);

            return view('item.edit',compact('item'));

       }
       public function update(Request $request,$id)
       {
        //dd($request->all());

              $item=item::find($id);


              $item->fname=$request->fname;

              $item->lname=$request->lname;
              $item->detail=$request->detail;
              $item->price=$request->price;

              $abc= $item->update();

              return redirect()->route('item.index');

       }

       public function multiepledit(Request $request)
       {
            $item=item::all();
            //dd($item);
            return view('item.multie',compact('item'));
       }

       public function multiepleupdate(Request $request)
       {
              $item=$request->abc;
              if(isset( $item ) && count($item)>0)
              {
              foreach ($item as $data) {

                if (isset($data['key'])) {
                    $item = item::where('id', $data['key'])->first();

                    $item->update($data);

                }
            }
        }
            $items=$request->group;

            if(isset( $items ) && count($items)>0)
            {
            foreach($items as $item)
            {
            if(isset( $item['fname']  ) && ( $item['lname']  )  && ( $item['detail']  ) ){
            $total=new item();

            $total->fname=$item['fname'];
            $total->lname=$item['lname'];
            $total->detail=$item['detail'];
            $xyz=$total->save();
            }
         }
        }
         return redirect()->route('item.index');

       }
       public function multiDelete(Request $request)
       {

       // Log::info("message". print_r($request->all(),true));
        $ids = $request->id;

           if (!empty($ids) && count($ids) > 0) {

                $abc=item::whereIn('id', $ids)->delete();

           }

           return response()->json(['success' => "Selected items have been deleted."]);
       }

    //    public function groupby()
    //    {

    //     $abc=Product::with('item')->get();
    //     dd($abc);
    //     //$abc=item::whereColumn('fname', 'lname')->get();
    //    }

       public function groupby()
       {
        $items=item::with('product_data')->get();

         return view('item.groupby',compact('items'));
       }
       public function a()
       {
        return view('item.a');
       }
       public function lib()
       {
        return view('item.2');
       }


}
