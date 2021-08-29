<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'billing_address_1',
        'billing_address_2',
        'billing_city_id',
        'delivery_address_line_1',
        'delivery_address_line_2',
        'status',
        'discount_type',
        'discount_value',
        'tracking_code',
        'order_type',
        'user_id',
        'table_id',
        'total',
        'delivery_charge',
        'litchen_user_id',
        'customer_id',
        'delivery_city_id',
        'billing_city_id',
        'delivery_first_name',
        'delivery_last_name',
        'delivery_phone_number',
        'payment_type',
        'payment_method',
        'payment_reference',
        'payment_status'

    ];

    protected $appends = ['order_menu_items_full', 'order_menu_items_total', 'order_tax_amount', 'order_total'];

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
    protected $table = 'orders';

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

    public function ordermenuitems()
    {
        return $this->hasMany(OrderMenuItem::class);
    }

    public function customer()
    {
        return $this->hasOne(Customers::class, 'id', 'customer_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getOrderMenuItemsFullAttribute()
    {
        $orderMenuOptionCategories = collect();
        foreach ($this->ordermenuitems as $ordermenuitem) {
            $tempMenuItem = $ordermenuitem->menuitem;
            $tempMenuItem->setAttribute("order_menu_item_id", $ordermenuitem->id);
            $tempMenuItem->setAttribute("order_menu_item_price", $ordermenuitem->price);
            $tempMenuItem->setAttribute("order_menu_item_qty", $ordermenuitem->qty);
            $tempMenuItem->setAttribute("order_menu_item_comment", $ordermenuitem->comment);
            $tempMenuItem->setAttribute("order_menu_item_total", $ordermenuitem->orderMenuItemTotal());

            $menuItemAddons = $this->getUpdatedMenuAddOns($ordermenuitem->menuitem->id, $ordermenuitem->fullOrderMenuItemAddOns, $ordermenuitem->MenuItemAddOns);

            $tempMenuItem->setAttribute("order_menu_item_addons", $menuItemAddons);

            $optionCategories = collect();
            foreach ($ordermenuitem->orderMenuOptionCategoryMenuOptions as $key => $orderMenuOptionCategoryMenuOption) {
                if(isset($orderMenuOptionCategoryMenuOption->menuOptionCategoryMenuOption->menu_option_category_id)){
                    if (!$optionCategories->contains("id", $orderMenuOptionCategoryMenuOption->menuOptionCategoryMenuOption->menu_option_category_id)) {
                        $optionCategories->push($orderMenuOptionCategoryMenuOption->menuOptionCategoryMenuOption->menuOptionCategory);
                    }

                    $optionCategories = $this->getUpdatedMenuOptionCategory($optionCategories, $orderMenuOptionCategoryMenuOption, $key);
                }

            }
            $tempMenuItem->setAttribute("order_menu_item_option_categories", $optionCategories);
            $orderMenuOptionCategories->push($tempMenuItem);
        }

        return $orderMenuOptionCategories;
    }

    public function getUpdatedMenuOptionCategory($optionCategories, $orderMenuOptionCategoryMenuOption, $key)
    {
        foreach ($optionCategories as $key => $optionCategory) {
            if ($optionCategory->id == $orderMenuOptionCategoryMenuOption->menuOptionCategoryMenuOption->menu_option_category_id) {
                if (!isset($optionCategory->order_menu_item_options)) {
                    $optionCategory->setAttribute("order_menu_item_options", collect());
                }
                $orderMenuOptionCategoryMenuOption->menuOptionCategoryMenuOption->menuOption->setAttribute("menu_option_category_menu_option_id", $orderMenuOptionCategoryMenuOption->menuOptionCategoryMenuOption->id);
                $optionCategory->order_menu_item_options->push($orderMenuOptionCategoryMenuOption->menuOptionCategoryMenuOption->menuOption);
                $optionCategories[$key] = $optionCategory;
                break;
            }
        }

        return $optionCategories;
    }

    public function getUpdatedMenuAddOns($menuItemId, $fullOrderMenuItemAddOns, $MenuItemAddOns){
        $returnMenuAddons = collect();
        foreach ($fullOrderMenuItemAddOns as $key => $fullOrderMenuItemAddOn) {
            $MenuItemAddOn = $MenuItemAddOns->where("menu_item_id", $menuItemId)->where("addon_id", $fullOrderMenuItemAddOn->id)->first();
            if($MenuItemAddOn){
                $fullOrderMenuItemAddOn->setAttribute("order_menu_item_addon_price", $MenuItemAddOn->pivot->price);
                $returnMenuAddons->push($fullOrderMenuItemAddOn);
            }
        }

        return $returnMenuAddons;
    }
    public function getOrderMenuItemsTotalAttribute()
    {
        $total = 0;
        foreach ($this->ordermenuitems as $ordermenuitem) {
            $total += $ordermenuitem->orderMenuItemTotal();
        }
        return $total;
    }

    public function getOrderTaxAmountAttribute()
    {
        $taxPercentage = 0;
        return  (($this->order_menu_items_total * $taxPercentage) / 100);
    }

    public function getOrderTotalAttribute()
    {

        return ($this->order_menu_items_total + $this->order_tax_amount+ $this->delivery_charge);
    }

}
