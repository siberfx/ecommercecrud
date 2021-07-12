<?php

namespace SmartyStudio\EcommerceCrud\app\Http\Controllers\Admin;

use SmartyStudio\EcommerceCrud\app\Http\Requests\TaxRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;

/**
 * Class TaxCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TaxCrudController extends CrudController
{
	use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
	use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
	use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
	use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
	use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setUp()
    {
        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
        $this->crud->setModel('SmartyStudio\EcommerceCrud\app\Models\Tax');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/taxes');
        $this->crud->setEntityNameStrings('tax', 'taxes');

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
		$this->crud->setValidation(TaxRequest::class);
	}

	protected function setupUpdateOperation()
	{
		$this->crud->setValidation(TaxRequest::class);
	}

	/**
	 * @return array
	 */
	private function getColumns()
	{
		return [
			[
				'name'  => 'name',
				'label' => __('tax.name'),
			],
			[
				'name'  => 'value',
				'label' => __('tax.value'),
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
				'name'  => 'name',
				'label' => __('tax.name'),
				'type'  => 'text',
			],
			[
				'name'  => 'value',
				'label' => __('tax.value'),
				'hint'  => __('tax.hint_value'),
				'type'  => 'text',
			]
		];
	}

    public function setPermissions()
    {
        // Get authenticated user
        $user = auth()->user();

        // Deny all accesses
        $this->crud->denyAccess(['list', 'create', 'update', 'delete']);

        // Allow list access
        if ($user->can('list_taxes')) {
            $this->crud->allowAccess('list');
        }

        // Allow create access
        if ($user->can('create_tax')) {
            $this->crud->allowAccess('create');
        }

        // Allow update access
        if ($user->can('update_tax')) {
            $this->crud->allowAccess('update');
        }

        // Allow delete access
        if ($user->can('delete_tax')) {
            $this->crud->allowAccess('delete');
        }
    }
}