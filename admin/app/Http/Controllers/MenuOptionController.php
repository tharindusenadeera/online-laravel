<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuOption;
use App\Models\Category;

use Validator;
use Response;

class MenuOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menuOptions = MenuOption::orderBy('id', 'desc')->get();
        return view('menu-option.index',compact('menuOptions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

        if($validator->fails()){
          return Response::json(['errors' => $validator->getMessageBag()->toArray()], 200);
        }

        $menuoption = MenuOption::create([
            'name'         => $request->name,
            'status'       => 1,
            'created_by'   => auth()->user()->id,
        ]);

        if ($menuoption) {
          return Response::json(['success' => "19199212", "message" => "Menu option added successfully!"], 200);
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
        $menuoption = MenuOption::find($id);
        return Response::json(['success' => "19199212", "data" => $menuoption], 200);
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
        $validator = $this->validateInputs($request->all());

        if($validator->fails()){
          return Response::json(['errors' => $validator->getMessageBag()->toArray()], 200);
        }

        $menuoption = MenuOption::find($id);

        $input = $request->all();

        $menuoption->fill($input)->save();

        if ($menuoption) {
            return Response::json(['success' => "19199212", "message" => "User updated successfully"], 200);
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
    private function validateInputs($inputs)
    {
      $rules =[
        "name"     => "required|unique:menu_option",
      ];

      return Validator::make($inputs, $rules);
    }

    /*
    |--------------------------------------------------------------------------
    |Public function / toggle status
    |--------------------------------------------------------------------------
    */
    public function toggleStatus($id, $status, Request $request)
    {
        if( $status == 0 || $status == 1){

          $menuoption = MenuOption::find($id);

          if ($menuoption) {
            $menuoption->status = $status;
          }

          if ($menuoption->save()) {
              return Response::json(['success' => "19199212", "message" => "Menu option updated successfully"], 200);
          }
        }
    }
}
