<?php

namespace App\Http\Controllers\v1;
use App\Models\City;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;

class CityController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    |Public function / get All Cities
    |--------------------------------------------------------------------------
    */
    public function getAllCities(){

        $cities = City::all();

        if($cities->isEmpty()){
            return response()->json(['data' => null, "status" => "success", "status_code" => "200", "message" => "No results found"], 200);
        }

        return response()->json(['data' => $cities, "status" => "success", "status_code" => "200", "message" => "Cities"], 200);
    }
}
