<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuOptionCategoryMenuOption extends Model
{
    use HasFactory;

    /**
 * The attributes that are mass assignable.
 *
 * @var array
 */
protected $fillable = [
    'menu_option_category_id',
    'menu_option_id',
    'status',
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
protected $table = 'menu_option_category_menu_option';

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

    public function menuOption()
    {
        return $this->belongsTo(MenuOption::class,'menu_option_id');
    }

    public function menuOptionCategory()
    {
        return $this->belongsTo(MenuOptionCategory::class,'menu_option_category_id');
    }
}
