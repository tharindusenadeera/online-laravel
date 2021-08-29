<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;

use Validator;
use Response;

class CityController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $cities = City::orderBy('id', 'desc')->get();
    return view('city.index', compact('cities'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {


    $validator = $this->validateInputs($request->all());

    if ($validator->fails()) {

      return response()->json(['errors' => $validator->getMessageBag()->toArray()], 200);
    }

    $city = City::create([
      'name' => $request->name,
      'delivery_charge' => $request->delivery_charge,
      'status' => 1,
    ]);

    if ($city) {

      return response()->json(['success' => "19199212", 'message' => "City created successfully"], 200);
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $city = City::find($id);
    return response()->json(['success' => "19199212", "data" => $city], 200);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $validator = $this->validateInputs($request->all(), $id);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->getMessageBag()->toArray()], 200);
    }

    $city = City::find($id);

    $input = $request->all();

    $city->fill($input)->save();

    if ($city) {

      return response()->json(['success' => "19199212", 'message' => 'City updated successfully'], 200);
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }

  /*
    |--------------------------------------------------------------------------
    |Private function / Input validation
    |--------------------------------------------------------------------------
    */
  private function validateInputs($inputs, $id = -1)
  {
    $rules = [
      "name"     => "required|unique:cities,name," . $id,
      "delivery_charge" => "required|numeric|min:0|regex:/^(\d{1,})(\.\d{1,2})?$/",
    ];

    $messages = [
      'delivery_charge.regex' => 'Delivery charge input format is invalid. Ex: 10.50',

    ];
    return Validator::make($inputs, $rules, $messages);
  }

  /*
    |--------------------------------------------------------------------------
    |Public function / toggle status
    |--------------------------------------------------------------------------
    */
  public function toggleStatus($id, $status, Request $request)
  {

    if ($status == 0 || $status == 1) {

      $city = City::find($id);

      if ($city) {
        $city->status = $status;
      }

      if ($city->save()) {
        return response()->json(['success' => "19199212", "message" => "City status updated successfully"], 200);
      }
    }
  }
}
