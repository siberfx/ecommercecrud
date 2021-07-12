<?php

namespace SmartyStudio\EcommerceCrud\app\Http\Controllers\Admin;

use App\Http\Requests\CarrierRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;

/**
 * Class CarrierCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class CarrierCrudController extends CrudController
{
	use ListOperation;
	use CreateOperation;
	use UpdateOperation;
	use DeleteOperation;
	use ShowOperation;

    public function setUp()
    {
        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
        $this->crud->setModel('SmartyStudio\EcommerceCrud\app\Models\Carrier');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/carriers');
        $this->crud->setEntityNameStrings('carrier', 'carriers');

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
		$this->crud->setValidation(CarrierRequest::class);
	}

	protected function setupUpdateOperation()
	{
		$this->crud->setValidation(CarrierRequest::class);
	}

	/**
	 * @return array
	 */
	private function getColumns()
	{
		return [
			[
				'name'  => 'name',
				'label' => trans('category.name'),
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
				'label' => trans('carrier.name'),
				'type'  => 'text',
			],
			[
				'name'       => 'price',
				'label'      => trans('carrier.price'),
				'type'       => 'number',
				'attributes' => [
					'step' => 'any'
				]
			],
			[
				'name'  => 'delivery_text',
				'label' => trans('carrier.delivery_text'),
				'type'  => 'text',
			],
			[
				'name'    => "logo",
				'label'   => trans('carrier.logo'),
				'type'    => 'image',
				'upload'  => true,
				'crop'    => false,
				'default' => 'default.png',
				'prefix'  => 'uploads/carriers/'
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
        if ($user->can('list_carriers')) {
            $this->crud->allowAccess('list');
        }

        // Allow create access
        if ($user->can('create_carrier')) {
            $this->crud->allowAccess('create');
        }

        // Allow update access
        if ($user->can('update_carrier')) {
            $this->crud->allowAccess('update');
        }

        // Allow delete access
        if ($user->can('delete_carrier')) {
            $this->crud->allowAccess('delete');
        }
    }

    public function setFields()
    {
        $this->crud->addFields([
            [
                'name'  => 'name',
                'label' => trans('carrier.name'),
                'type'  => 'text',
            ],
            [
                'name'       => 'price',
                'label'      => trans('carrier.price'),
                'type'       => 'number',
                'attributes' => [
                    'step' => 'any'
                ]
            ],
            [
                'name'  => 'delivery_text',
                'label' => trans('carrier.delivery_text'),
                'type'  => 'text',
            ],
            [
                'name'    => "logo",
                'label'   => trans('carrier.logo'),
                'type'    => 'image',
                'upload'  => true,
                'crop'    => false,
                'default' => 'default.png',
                'prefix'  => 'uploads/carriers/'
            ]
        ]);
    }


	public function store(StoreRequest $request)
	{
        $redirect_location = parent::storeCrud();

        return $redirect_location;
	}

	public function update(UpdateRequest $request)
	{
        $redirect_location = parent::updateCrud();

        return $redirect_location;
	}
}
