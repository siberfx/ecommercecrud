<?php

namespace SmartyStudio\EcommerceCrud\app\Http\Controllers\Admin;

use SmartyStudio\EcommerceCrud\app\Models\Attribute;
use SmartyStudio\EcommerceCrud\app\Http\Requests\Requests\AttributeSetRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Illuminate\Http\Request;

class AttributeSetCrudController extends CrudController
{
	use ListOperation;
	use CreateOperation;
	use UpdateOperation;
	use DeleteOperation;
	use ShowOperation;

	public function setup()
	{
		/*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
		$this->crud->setModel('SmartyStudio\EcommerceCrud\app\Models\AttributeSet');
		$this->crud->setRoute(config('backpack.base.route_prefix') . '/attributes-sets');
		$this->crud->setEntityNameStrings('attribute set', 'Attribute Sets');

		/*
        |--------------------------------------------------------------------------
        | COLUMNS
        |--------------------------------------------------------------------------
        */
		$this->crud->addColumns(
			$this->getColumns()
		);

		/*
        |--------------------------------------------------------------------------
        | FIELDS
        |--------------------------------------------------------------------------
        */
		$this->crud->addFields(
			$this->getFields()
		);

		/*
        |--------------------------------------------------------------------------
        | PERMISSIONS
        |-------------------------------------------------------------------------
        */
		$this->setPermissions();

		/*
        |--------------------------------------------------------------------------
        | AJAX TABLE VIEW
        |--------------------------------------------------------------------------
        */
		$this->crud->enableAjaxTable();
	}

	protected function setupListOperation()
	{
	}

	protected function setupCreateOperation()
	{
		$this->crud->setValidation(AttributeSetRequest::class);
	}

	protected function setupUpdateOperation()
	{
		$this->crud->setValidation(AttributeSetRequest::class);
	}

	/**
	 * @return array
	 */
	private function getColumns()
	{
		return [
			[
				'name'  => 'name',
				'label' => trans('attribute.name'),
			]
		];
	}

	/**
	 * @return array
	 */
	private function getFields()
	{
		return [
			[
				'name'      => 'name',
				'label'     => trans('attribute.name'),
				'type'      => 'text',
			],
			[
				'type'      => 'select2_multiple',
				'label'     => trans('attribute.attributes'),
				'name'      => 'attributes',
				'entity'    => 'attributes',
				'attribute' => 'name',
				'model'     => "App\Models\Attribute",
				'pivot'     => true,
			]
		];
	}

	public function ajaxGetAttributesBySetId(Request $request, Attribute $attribute)
	{
		// Init old as an empty array
		$old = [];

		// Set old inputs as array from $request
		if (isset($request->old)) {
			$old = json_decode($request->old, true);
		}

		// Get attributes with values by set id
		$attributes = $attribute->with('values')->whereHas('sets', function ($q) use ($request) {
			$q->where('id', $request->setId);
		})->get();

		return view('renders.product_attributes', compact('attributes', 'old'));
	}

	public function setPermissions()
	{
		// Get authenticated user
		$user = auth()->user();

		// Deny all accesses
		$this->crud->denyAccess(['list', 'create', 'update', 'delete']);

		// Allow list access
		if ($user->can('list_attribute_sets')) {
			$this->crud->allowAccess('list');
		}

		// Allow create access
		if ($user->can('create_attribute_set')) {
			$this->crud->allowAccess('create');
		}

		// Allow update access
		if ($user->can('update_attribute_set')) {
			$this->crud->allowAccess('update');
		}

		// Allow delete access
		if ($user->can('delete_attribute_set')) {
			$this->crud->allowAccess('delete');
		}
	}
}