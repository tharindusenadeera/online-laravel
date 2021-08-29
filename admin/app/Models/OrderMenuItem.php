<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderMenuItem extends Model
{
    use HasFactory;
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;

        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'menu_item_id',
        'price',
        'qty',
        'order_menu_item_',
        'comment'

    ];

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
    protected $table = 'order_menu_items';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    //const CREATED_AT = 'creation_date';
    //const UPDATED_AT = 'updated_date';

    public function menuitem()
    {
        return $this->belongsTo(MenuItem::class,'menu_item_id');
    }

    public function orderMenuOptionCategoryMenuOptions()
    {
        return $this->hasMany(OrderMenuOptionCategoryMenuOption::class, 'order_menu_item_id');
    }

    public function orderMenuItemAddOns(){
        return $this->belongsToMany(OrderMenuItemAddon::class, "order_menu_item_id");
    }

    public function MenuItemAddOns()
    {
        return $this->belongsToMany(MenuItemAddon::class, OrderMenuItemAddon::class, "order_menu_item_id", "menu_item_addon_id")->withPivot('price');
    }

    public function fullOrderMenuItemAddOns()
    {
        return $this->hasManyDeepFromRelations($this->MenuItemAddOns(), (new MenuItemAddon)->addon());
    }

    public function orderMenuItemTotal()
    {
        $addonsSum = isset($this->order_menu_item_addons) ? $this->order_menu_item_addons->pivot->sum('price') : 0.0;
        return ($this->qty * ($this->price + $addonsSum));
    }

}
