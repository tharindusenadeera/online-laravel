<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuCategory;
use Validator;
use Response;

class MenuCategoryController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $categories = MenuCategory::orderBy('id', 'desc')->get();
    return view('category.index', compact('categories'));
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

    if ($validator->fails()) {
      return Response::json(['errors' => $validator->getMessageBag()->toArray()], 200);
    }

    $category = MenuCategory::create([
      'name'       => $request->name,
      'status'     => 1,
      'created_by' => auth()->user()->id,
      'category_type' => $request->category_type
    ]);

    if ($category) {
      return Response::json(['success' => "19199212", "message" => "Menu Category created successfully!"], 200);
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
    $category = MenuCategory::find($id);
    return Response::json(['success' => "19199212", "data" => $category], 200);
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
      return Response::json(['errors' => $validator->getMessageBag()->toArray()], 200);
    }

    $category = MenuCategory::find($id);

    $input = $request->all();

    $category->fill($input)->save();

    if ($category) {
      return Response::json(['success' => "19199212", "message" => "Menu Category updated successfully!"], 200);
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
  private function validateInputs($inputs, $id=-1)
  {
    $rules = [
      "name"  => "required|unique:menu_categories,name,".$id,
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
    if ($status == 0 || $status == 1) {

      $category = MenuCategory::find($id);

      if ($category) {
        $category->status = $status;
      }

      if ($category->save()) {
        return Response::json(['success' => "19199212", "message" => "Category updated successfully"], 200);
      }
    }
  }
}
