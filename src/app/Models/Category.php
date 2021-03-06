<?php

namespace SmartyStudio\EcommerceCrud\app\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class Category extends Model
{
    use CrudTrait;

    /*
	|--------------------------------------------------------------------------
	| GLOBAL VARIABLES
	|--------------------------------------------------------------------------
	*/

    protected $table = 'categories';
    //protected $primaryKey = 'id';
    public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = [
    	'parent_id',
    	'name',
    	'slug',
    	'lft',
    	'rgt',
    	'depth'
	];
    // protected $hidden = [];
    // protected $dates = [];

    /*
	|--------------------------------------------------------------------------
	| FUNCTIONS
	|--------------------------------------------------------------------------
	*/

    /*
	|--------------------------------------------------------------------------
	| RELATIONS
	|--------------------------------------------------------------------------
	*/

	public function parent()
    {
        return $this->belongsTo('SmartyStudio\EcommerceCrud\App\Models\Category', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('SmartyStudio\EcommerceCrud\App\Models\Category', 'parent_id');
    }

    public function cartRules()
    {
        return $this->belongsToMany('SmartyStudio\EcommerceCrud\App\Models\CartRule');
    }

    /*
	|--------------------------------------------------------------------------
	| SCOPES
	|--------------------------------------------------------------------------
	*/

    /*
	|--------------------------------------------------------------------------
	| ACCESORS
	|--------------------------------------------------------------------------
	*/

    /*
	|--------------------------------------------------------------------------
	| MUTATORS
	|--------------------------------------------------------------------------
	*/
}
