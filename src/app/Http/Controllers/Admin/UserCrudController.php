<?php

namespace SmartyStudio\EcommerceCrud\app\Http\Controllers\Admin;

use SmartyStudio\EcommerceCrud\app\Http\Requests\UserRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class UserCrudController extends CrudController
{
	use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
	use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
	use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
	use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
	use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

	public function setup()
	{
		/*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
		$this->crud->setModel('App\Models\User');
		$this->crud->setRoute(config('backpack.base.route_prefix') . '/users');
		$this->crud->setEntityNameStrings('user', 'users');

		// Include all users except clients
		$this->crud->addClause('whereDoesntHave', 'roles', function ($query) {
			$clientRoleName = env('CLIENT_ROLE_NAME');
			return $query->where("name", $clientRoleName ?: 'client');
		});
	}

	protected function setupListOperation()
	{
		// TODO: remove setFromDb() and manually define Columns, maybe Filters
		$this->crud->setFromDb();
	}

	protected function setupCreateOperation()
	{
		$this->crud->setValidation(UserRequest::class);

		// TODO: remove setFromDb() and manually define Fields
		$this->crud->setFromDb();
	}

	protected function setupUpdateOperation()
	{
		$this->setupCreateOperation();
	}
}
