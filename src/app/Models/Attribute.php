<?php

namespace SmartyStudio\EcommerceCrud\app\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class Attribute extends Model
{
	use CrudTrait;

	/*
	|--------------------------------------------------------------------------
	| GLOBAL VARIABLES
	|--------------------------------------------------------------------------
	*/

	protected $table = 'attributes';
	//protected $primaryKey = 'id';
	public $timestamps = false;
	// protected $guarded = ['id'];
	protected $fillable = [
		'type',
		'name'
	];
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
			if (count($model->sets) == 0) {
				$model->values()->delete();
			} else {
				return $model;
			}
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
	public function values()
	{
		return $this->hasMany('SmartyStudio\EcommerceCrud\App\Models\AttributeValue', 'attribute_id');
	}

	public function sets()
	{
		return $this->belongsToMany('SmartyStudio\EcommerceCrud\App\Models\AttributeSet', 'attribute_attribute_set', 'attribute_id', 'attribute_set_id');
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
