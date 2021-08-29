<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MenuItem;
use Response;

class MenuItemController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    |Public function / Get Menu items
    |--------------------------------------------------------------------------
    */
    public function getMenuItems(Request $request){

        $catId = (isset($request->cat_id)) ?  $request->cat_id : null;
        $item = (isset($request->item)) ?  $request->item : null;

        $menuitems = MenuItem::with(["activeMenuItemAddons", "menuItemCategoryOptions.menuOptionCategory", "menuItemCategoryOptions.menuOption"])
                                ->where('status',1);

        if($catId) {
            $menuitems = $menuitems->whereHas('menuCategory', function ($query) use ($catId){
                $query->where('id', $catId)->where('status', 1);
            });
        }else{
            $menuitems = $menuitems->whereHas('menuCategory', function ($query) {
                $query->where('status', 1);
            });
        }

        if($item) {
            $menuitems = $menuitems->where('name','LIKE','%'.$item.'%');
        }

        $menuitems = $menuitems->get()->makeHidden('menuItemCategoryOptions')->append("menu_option_categories");

        if($menuitems->isEmpty()){
            return response()->json(['data' => null, "status" => "success", "status_code" => "200", "message" => "No results found"], 200);
        }


        return response()->json(['data' => $menuitems, "status" => "success", "status_code" => "200", "message" => "done"], 200);

    }
}
