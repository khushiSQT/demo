<?php

namespace App\Http\Controllers;


use App\Models\book;
use Illuminate\Http\Request;
use Exception;
use Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Session;
use View;

class BookController extends Controller
{
    public function index()
    {

        return view('book.index');
    }

    public function store(Request $request)
    {
        $book=new book();
        $book->name=$request->name;
        $book->price=$request->price;
        $abc=$book->save();


         return redirect()->route('book.index');
    }
}
