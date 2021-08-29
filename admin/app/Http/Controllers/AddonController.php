<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Addon;
use Validator;
use Response;

class AddonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $addons = Addon::orderBy('id', 'desc')->get();
        return view('addon.index',compact('addons'));
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

        $addon = Addon::create([
            'name'         => $request->name,
            'status'       => 1,
            'created_by'   => auth()->user()->id,
        ]);

        if ($addon) {
          return Response::json(['success' => "19199212", "message" => "Add-on added successfully!"], 200);
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
        $addon = Addon::find($id);
        return Response::json(['success' => "19199212", "data" => $addon], 200);
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

        $addon = Addon::find($id);

        $input = $request->all();

        $addon->fill($input)->save();

        if ($addon) {
            return Response::json(['success' => "19199212", "message" => "Add-on updated successfully"], 200);
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
        "name"     => "required|unique:addon",
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

            $addon = Addon::find($id);

          if ($addon) {
            $addon->status = $status;
          }

          if ($addon->save()) {
              return Response::json(['success' => "19199212", "message" => "Add-on updated successfully"], 200);
          }
        }
    }
}
