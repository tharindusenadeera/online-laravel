<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\MenuItem;
use App\Models\MenuOptionCategory;
use App\Models\MenuOption;
use App\Models\MenuOptionCategoryMenuOption;
use App\Models\MenuIitemMenuOptionCategoryMenuOption;
use App\Models\MenuCategory;
use App\Models\Addon;
use App\Models\MenuItemAddon;
use App\Models\OrderMenuItemAddon;
use App\Helper\ImageUpload as ImageUploadHelper;
use Validator;
use Response;

class MenuItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $menuitems            = MenuItem::orderBy('id', 'desc')->get();
        return view('menu.index',compact('menuitems'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menuoptioncategories = MenuOptionCategory::with('categoryMenuoption', 'categoryMenuoption.menuOption')->get();
        $menuitems            = MenuItem::orderBy('id', 'desc')->get();
        $menuCategory         = MenuCategory::where('status', 1)->orderBy('name', 'asc')->get();
        $addons               = Addon::where('status', 1)->orderBy('name', 'asc')->get();
        return view('menu.add-menu', compact('menuitems', 'menuoptioncategories', 'menuCategory', 'addons'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = $this->validateInputs($request->all(),true);

        if($validator->fails()){
          return Response::json(['errors' => $validator->getMessageBag()->toArray()], 200);
        }

          try {

            DB::beginTransaction();

            $image = ImageUploadHelper::uploadBase64($request->main_image);


            $menuitem =MenuItem::create([
                'name'         => $request->name,
                'main_image'   => $image,
                'price'        => $request->price,
                'qty'          => $request->qty,
                'status'       => '1',
                'created_by'   => auth()->user()->id,
                'menu_category'=> $request->menu_category,
            ]);

            if (isset($request->options) && $request->options != null) {
                foreach ($request->options as $menu_option) {
                    MenuIitemMenuOptionCategoryMenuOption::create([
                        'menu_item_id'                        => $menuitem->id,
                        'menu_option_category_menu_option_id' => $menu_option,
                    ]);
                }
            }

            if (isset($request->addons) && $request->addons != null) {
                    foreach ($request->addons as $key => $addon) {

                        MenuItemAddon::create([
                            'menu_item_id'   => $menuitem->id,
                            'addon_id'       => $addon,
                            'amount'         => $request->amount[$key],
                            'status'         => '1',
                        ]);
                    }
            }


            DB::commit();

            if ($menuitem) {
              return Response::json(['success' => "19199212", "message" => "Menu item created successfully!"], 200);
            }

        } catch (\Illuminate\Database\QueryException $e) {
          DB::rollback();

          return Response::json(['success' => "19199212", "message" => "Menu item not created!"], 500);
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
        $menuitem = MenuItem::with('menuIitemMenuOptionCategoryMenuOption','menuIitemMenuOptionCategoryMenuOption.MenuOptionCategoryMenuOption',
                                    'menuIitemMenuOptionCategoryMenuOption.MenuOptionCategoryMenuOption.menuOption','menuIitemMenuOptionCategoryMenuOption.MenuOptionCategoryMenuOption.menuOptionCategory','activeMenuItemAddons')->where('id',$id)->first();

        return Response::json(['success' => "19199212", "data" => $menuitem], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menuoptioncategories = MenuOptionCategory::with('categoryMenuoption', 'categoryMenuoption.menuOption')->get();
        $menuitems            = MenuItem::orderBy('id', 'desc')->get();
        $menuCategory         = MenuCategory::where('status', 1)->orderBy('name', 'asc')->get();
        $addons               = Addon::where('status', 1)->orderBy('name', 'asc')->get();
        return view('menu.add-menu', compact('menuitems', 'menuoptioncategories', 'menuCategory', 'addons', 'id'));
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
        $validator = $this->validateInputs($request->all(),false);

        if($validator->fails()){
          return Response::json(['errors' => $validator->getMessageBag()->toArray()], 200);
        }

          try {

            DB::beginTransaction();
            $menuitem = MenuItem::find($id);

            if($request->main_image){
              $image  = ImageUploadHelper::uploadBase64($request->main_image);
              $menuitem->main_image    = $image;
            }

            $menuitem->name          = $request->name;
            $menuitem->price         = $request->price;
            $menuitem->qty           = $request->qty;
            $menuitem->menu_category = $request->menu_category;

            $menuitem->save();

            MenuIitemMenuOptionCategoryMenuOption::where('menu_item_id',$menuitem->id)->delete();

            MenuItemAddon::where('menu_item_id',$menuitem->id)->update(['status' => 0]);
            if (isset($request->options) && $request->options != null) {
                foreach($request->options as $menu_option){

                MenuIitemMenuOptionCategoryMenuOption::create([
                    'menu_item_id'                        => $menuitem->id,
                    'menu_option_category_menu_option_id' => $menu_option,
                ]);
                }
            }
            if(isset($request->addons) && $request->addons != null){
                foreach($request->addons as $key => $addon){

                  $MenuItemAddon = MenuItemAddon::where('menu_item_id',$menuitem->id)->where('addon_id',$addon)->update([
                    'amount' => $request->amount[$key],
                    'status' => 1
                  ]);

                  if(!$MenuItemAddon){
                      MenuItemAddon::create([
                        'menu_item_id'   => $menuitem->id,
                        'addon_id'       => $addon,
                        'amount'         => $request->amount[$key],
                        'status'         => '1',
                      ]);
                  }

                }
            }

            DB::commit();

        } catch (\Illuminate\Database\QueryException $e) {
          DB::rollback();

          return Response::json(['success' => "19199212", "message" => "Menu item not updated!"], 500);
        }

        if ($menuitem) {
          return Response::json(['success' => "19199212", "message" => "Menu item updated successfully!"], 200);
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
    private function validateInputs($inputs,$action)
    {

      if($action){
        $rules =[
          "name"          => "required",
          "main_image"    => "required",
          "menu_category" => "required",
          "options"       => "required",
          "price"         => "required|numeric",
          "qty"           => "required|numeric",
        ];
      }else{
        $rules =[
          "name"          => "required",
          "main_image"    => "nullable",
          "menu_category" => "required",
          "options"       => "required",
          "price"         => "required|numeric",
          "qty"           => "required|numeric",
        ];
      }

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

          $menuitem = MenuItem::find($id);

          if ($menuitem) {
            $menuitem->status = $status;
          }

          if ($menuitem->save()) {
              return Response::json(['success' => "19199212", "message" => "Menu item updated successfully"], 200);
          }
        }
    }

}
