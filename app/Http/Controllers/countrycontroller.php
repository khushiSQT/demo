<?php

namespace App\Http\Controllers;

use App\Models\country;
use App\Models\state;
use App\Models\city;
use Illuminate\Http\Request;
use Exception;
use Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Session;
use View;

class countrycontroller extends Controller
{
    public function country()
    {
        $data=country::all();

        return view('dropdown.country',compact('data'));

    }


    public function state(Request $request)
    {

        $data=state::where("country_id",$request->country_id)->get(["states_name", "id"]);
        return response()->json($data);

    }

    public function city(Request $request)
    {
        $data=city::where("state_id",$request->state_id)->get("city_name","id");
        return response()->json($data);
    }

}
