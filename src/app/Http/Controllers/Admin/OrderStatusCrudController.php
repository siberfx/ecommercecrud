<?php

namespace SmartyStudio\EcommerceCrud\app\Http\Controllers\Admin;

use SmartyStudio\EcommerceCrud\app\Http\Requests\OrderStatusRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;

/**
 * Class OrderStatusCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class OrderStatusCrudController extends CrudController
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
        $this->crud->setModel('SmartyStudio\EcommerceCrud\app\Models\OrderStatus');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/order-statuses');
        $this->crud->setEntityNameStrings('order status', 'order statuses');

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
		$this->crud->setValidation(OrderStatusRequest::class);
	}

	protected function setupUpdateOperation()
	{
		$this->crud->setValidation(OrderStatusRequest::class);
	}

	/**
	 * @return array
	 */
	private function getColumns()
	{
		return [
			[
				'name'  => 'name',
				'label' => trans('order.status_name'),
			],
			[
				'name'  => 'notification',
				'label' => trans('order.notification'),
				'type'  => 'boolean',
				'options' => [0 => 'Disabled', 1 => 'Enabled']
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
				'label' => trans('order.status_name'),
				'type'  => 'text',
			],
			[
				'name'  => 'notification',
				'type'  => 'select_from_array',
				'options' => [
					1 => 'Enabled',
					0 => 'Disabled'
				]
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
        if ($user->can('list_order_statuses')) {
            $this->crud->allowAccess('list');
        }

        // Allow create access
        if ($user->can('create_order_status')) {
            $this->crud->allowAccess('create');
        }

        // Allow update access
        if ($user->can('update_order_status')) {
            $this->crud->allowAccess('update');
        }

        // Allow delete access
        if ($user->can('delete_order_status')) {
            $this->crud->allowAccess('delete');
        }
    }
}