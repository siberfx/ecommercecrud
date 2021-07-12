<?php

namespace SmartyStudio\EcommerceCrud\app\Http\Controllers\Admin;

use SmartyStudio\EcommerceCrud\app\Http\Requests\CurrencyRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use DB;

/**
 * Class CurrencyCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class CurrencyCrudController extends CrudController
{
	use ListOperation;
	use CreateOperation { store as traitStore; }
	use UpdateOperation { update as traitUpdate; }
	use DeleteOperation;
	use ShowOperation;

    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('SmartyStudio\EcommerceCrud\app\Models\Currency');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/currencies');
        $this->crud->setEntityNameStrings('currency', 'currencies');

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

	/**
	 * @return array
	 */
	private function getColumns()
	{
		return [
			[
				'name'  => 'name',
				'label' => __('currency.name'),
			],
			[
				'name'  => 'iso',
				'label' => __('currency.iso'),
			],
			[
				'name'  => 'value',
				'label' => __('currency.value'),
			],
			[
				'name'    => 'default',
				'label'   => __('currency.default'),
				'type'    => 'boolean',
				'options' => [
					'0' => '',
					'1' => __('currency.default'),
				],
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
				'label' => trans('currency.name'),
				'type'  => 'text',
			],
			[
				'name'  => 'iso',
				'label' => trans('currency.iso'),
				'type'  => 'text',
			],
			[
				'name'  => 'value',
				'label' => trans('currency.value'),
				'type'  => 'text',
			],
			[
				'name'  => 'default',
				'label' => trans('currency.default'),
				'type'  => 'checkbox',
			]
		];
	}


	public function store(CurrencyRequest $request)
	{
		if ($request->default == 1) {
			$table = $this->crud->model->getTable();
			DB::table($table)->update(['default' => 0]);
		}

		$redirect_location = $this->traitStore();

		if ($request->default == 1) {
			$this->crud->model->find($this->crud->entry->id)->update(['value' => 1]);
		}

		return $redirect_location;
	}

	public function update(CurrencyRequest $request)
	{
		if ($request->default == 1) {
			$table = $this->crud->model->getTable();
			DB::table($table)->update(['default' => 0]);
		}

		$redirect_location = $this->traitUpdate();

		if ($request->default == 1) {
			$this->crud->model->find($request->id)->update(['value' => 1]);
		}

		return $redirect_location;
	}

    public function setPermissions()
    {
        // Get authenticated user
        $user = auth()->user();

        // Deny all accesses
        $this->crud->denyAccess(['list', 'create', 'update', 'delete']);

        // Allow list access
        if ($user->can('list_currencies')) {
            $this->crud->allowAccess('list');
        }

        // Allow create access
        if ($user->can('create_currency')) {
            $this->crud->allowAccess('create');
        }

        // Allow update access
        if ($user->can('update_currency')) {
            $this->crud->allowAccess('update');
        }

        // Allow delete access
        if ($user->can('delete_currency')) {
            $this->crud->allowAccess('delete');
        }
    }
}