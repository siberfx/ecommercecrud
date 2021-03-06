<?php

namespace SmartyStudio\EcommerceCrud\app\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class AttributeSet extends Model
{
	use CrudTrait;

	/*
	|--------------------------------------------------------------------------
	| GLOBAL VARIABLES
	|--------------------------------------------------------------------------
	*/

	protected $table = 'attribute_sets';
	//protected $primaryKey = 'id';
	public $timestamps = false;
	// protected $guarded = ['id'];
	protected $fillable = ['name'];
	// protected $hidden = [];
	// protected $dates = [];

	/*
	|--------------------------------------------------------------------------
	| EVENTS
	|--------------------------------------------------------------------------
	*/
	protected static function boot()
	{
		parent::boot();

		static::deleting(function ($model) {
			$model->attributes()->detach();
		});
	}

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

	public function attributes()
	{
		return $this->belongsToMany('SmartyStudio\EcommerceCrud\App\Models\Attribute', 'attribute_attribute_set', 'attribute_set_id', 'attribute_id');
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
