<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderMenuOptionCategoryMenuOption extends Model
{
    use HasFactory;

        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_menu_item_id',
        'menu_option_category_menu_option_id',
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
    protected $table = 'orders_menu_option_category_menu_option';

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

    /**
     * Get the user that owns the OrderMenuOptionCategoryMenuOption
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function menuOptionCategoryMenuOption()
    {
        return $this->belongsTo(MenuOptionCategoryMenuOption::class, 'menu_option_category_menu_option_id', 'id');
    }
}
