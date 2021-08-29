<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'main_image',
        'price',
        'qty',
        'status',
        'created_by',
        'menu_category'

    ];



    public function menuItemCategoryOptions()
    {
        return $this->hasManyThrough(MenuOptionCategoryMenuOption::class, MenuIitemMenuOptionCategoryMenuOption::class, 'menu_item_id', 'id', 'id', 'menu_option_category_menu_option_id');
    }

    public function getMenuOptionCategoriesAttribute()
    {
        $optionCategories = collect();
        foreach ($this->menuItemCategoryOptions as $menuItemCategoryOption) {
            if(!$optionCategories->contains("id", $menuItemCategoryOption->menuOptionCategory->id)){
                $tempCats = $menuItemCategoryOption->menuOptionCategory;
                $tempOps = collect();

                foreach($this->menuItemCategoryOptions->where("menu_option_category_id", $menuItemCategoryOption->menuOptionCategory->id) as $menuItemCategoryOption){
                    $menuItemCategoryOption->menuOption->setAttribute("menu_option_category_menu_option_id", $menuItemCategoryOption->id);
                    $tempOps->push($menuItemCategoryOption->menuOption);
                }
                $tempCats->setAttribute("menu_item_options", $tempOps);
                $optionCategories->push($tempCats);
            }
        }

        return $optionCategories;
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    /*protected $hidden = [
        'password',
    ];*/

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'menu_item';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    // public $timestamps = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    //const CREATED_AT = 'creation_date';
    //const UPDATED_AT = 'updated_date';

    public function menuIitemMenuOptionCategoryMenuOption()
    {
        return $this->hasMany(MenuIitemMenuOptionCategoryMenuOption::class);
    }

    public function menuCategory()
    {
        return $this->hasOne(MenuCategory::class , 'id', 'menu_category');
    }

    public function menuItemAddons()
    {
        return $this->belongsToMany(Addon::class, MenuItemAddon::class, "menu_item_id", "addon_id")->withPivot('amount');
    }

    public function activeMenuItemAddons()
    {
        return $this->belongsToMany(Addon::class, MenuItemAddon::class, "menu_item_id", "addon_id")->where('menu_item_addon.status', '=', 1)->withPivot('amount');
    }
}
