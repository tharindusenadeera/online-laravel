<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\MenuOptionCategory;
use App\Models\MenuOption;
use App\Models\MenuOptionCategoryMenuOption;
use Illuminate\Support\Facades\DB;

use Validator;
use Response;

class MenuOptionCategotyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menuoptions          = MenuOption::all();
        $menuoptioncategories = MenuOptionCategory::with('menuOptionCategoryMenuOption')->orderBy('id', 'desc')->get();
        return view('menu-option-category.index',compact('menuoptioncategories','menuoptions'));
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

            try {

                DB::beginTransaction();

                $menuoptioncategory = MenuOptionCategory::create([
                    'name'      => $request->name,
                    'status'    => 1,
                    'created_by'=> auth()->user()->id,
                ]);


                foreach($request->menu_options as $menu_option){
                    $this->createMenuOptionCategoryMenuOption($menuoptioncategory->id, $menu_option);
                }

                DB::commit();

                if ($menuoptioncategory) {
                    return Response::json(['success' => "19199212", "message" => "Menu option category created successfully!"], 200);
                }

            } catch (\Illuminate\Database\QueryException $e) {
                DB::rollback();

                return Response::json(['success' => "19199212", "message" => "Menu option category not created!"], 500);

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
        $menuoptioncategory = MenuOptionCategory::with('menuOptionCategoryMenuOption')->where('id',$id)->first();
        return Response::json(['success' => "19199212", "data" => $menuoptioncategory], 200);
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

            try {

                DB::beginTransaction();

                $menuoptioncategory = MenuOptionCategory::find($id);

                $input = $request->all();
                $menuoptioncategory->fill($input)->save();

                $res=MenuOptionCategoryMenuOption::where('menu_option_category_id',$id)->delete();

                foreach($request->menu_options as $menu_option){
                    $this->createMenuOptionCategoryMenuOption($menuoptioncategory->id, $menu_option);
                }

                DB::commit();

                if ($menuoptioncategory) {
                    return Response::json(['success' => "19199212", "message" => "Menu option category updated successfully!"], 200);
                }

            } catch (\Illuminate\Database\QueryException $e) {
                DB::rollback();
                return Response::json(['success' => "19199212", "message" => "Menu option category not updated"], 500);
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
        "name"         => "required",
        "menu_options" => "required|array|min:1",
      ];

      return Validator::make($inputs, $rules);
    }


    /*
    |--------------------------------------------------------------------------
    |Private function / create MenuOption Category Menu Option
    |--------------------------------------------------------------------------
    */
    private function createMenuOptionCategoryMenuOption($menu_option_category_id,$menu_option_id){
        $Menuoptioncategory = MenuOptionCategoryMenuOption::create([
            'menu_option_category_id'   => $menu_option_category_id,
            'menu_option_id'            => $menu_option_id,
            'status'                    => 1,
        ]);

        return;
    }

    /*
    |--------------------------------------------------------------------------
    |Public function / toggle status
    |--------------------------------------------------------------------------
    */
    public function toggleStatus($id, $status, Request $request)
    {
        if( $status == 0 || $status == 1){

            $menuoptioncategory = MenuOptionCategory::find($id);

          if ($menuoptioncategory) {
            $menuoptioncategory->status = $status;
          }

          if ($menuoptioncategory->save()) {
              return Response::json(['success' => "19199212", "message" => "Menu option category updated successfully"], 200);
          }
        }
    }
}
