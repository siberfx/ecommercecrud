<?php

namespace SmartyStudio\EcommerceCrud\app\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class Address extends Model
{
    use CrudTrait;

    /*
	|--------------------------------------------------------------------------
	| GLOBAL VARIABLES
	|--------------------------------------------------------------------------
	*/

    protected $table = 'addresses';
    //protected $primaryKey = 'id';
    // public $timestamps = true;
    // protected $guarded = ['id'];
    protected $fillable = [
    	'user_id',
    	'country_id',
    	'name',
    	'address1',
    	'address2',
    	'county',
    	'city',
    	'postal_code',
    	'phone',
    	'mobile_phone',
    	'comment'
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
	public function country()
	{
		return $this->hasOne('SmartyStudio\EcommerceCrud\App\Models\Country', 'id', 'country_id');
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
