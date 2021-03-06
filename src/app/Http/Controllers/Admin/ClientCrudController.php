<?php

namespace SmartyStudio\EcommerceCrud\app\Http\Controllers\Admin;

use SmartyStudio\EcommerceCrud\app\Http\UserStoreRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\PermissionManager\app\Http\Requests\UserUpdateCrudRequest;

/**
 * Class ClientCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 *
 * @todo create or update has problem because of password confirmation issue
 */
class ClientCrudController extends CrudController
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
        $this->crud->setModel('SmartyStudio\EcommerceCrud\app\Models\User');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/clients');
        $this->crud->setEntityNameStrings('client', 'clients');
        $this->crud->addClause('whereHas', 'roles', function ($query) {
            $clientRoleName = env('CLIENT_ROLE_NAME');
            $query->whereName($clientRoleName ?: 'client');
        });

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

		if (request()->segment(4) === 'edit') {
			$this->crud->addFields([
				[
					'name'          => 'client_address',
					'type'          => 'client_address',
					'country_model' => 'App\Models\Country',
					'tab'           => trans('client.tab_address'),
				],
				[
					'name'          => 'client_company',
					'type'          => 'client_company',
					'country_model' => 'App\Models\Company',
					'tab'           => trans('client.tab_company'),
				],
			]);
		}

        /*
        |--------------------------------------------------------------------------
        | AJAX TABLE VIEW
        |--------------------------------------------------------------------------
        */
        $this->crud->enableAjaxTable();

    }

	protected function setupListOperation()
	{
		$this->crud->addClause('whereHas', 'roles', function ($query) {
			$clientRoleName = env('CLIENT_ROLE_NAME');
			$query->whereName($clientRoleName ?: 'client');
		});
	}

	public function store(UserStoreRequest $request)
	{

		$request->request->set('password', bcrypt($this->crud->request->input('password')));

		$response = $this->traitStore();
		// $clientRoleID = \DB::table('roles')->whereName($clientRoleName ?: 'client')->first()->id;
		// $this->crud->entry->roles()->attach($clientRoleID);

		return $response;
	}

	public function update(UserUpdateCrudRequest $request)
	{
		$request->request->set('password', bcrypt($this->crud->request->input('password')));

		$response = $this->traitUpdate();

		return $response;
	}

	/**
	 * @return array
	 */
	private function getColumns()
	{
		return [
			[
				'name'        => 'salutation',
				'label'       => trans('client.salutation'),
			],
			[
				'name'  => 'name',
				'label' => trans('client.name'),
			],
			[
				'name'      => 'gender',
				'label'     => trans('client.gender'),
				'type'      => 'boolean',
				'options'   => [
					1 => trans('client.male'),
					2 => trans('client.female'),
				],
			],
			[
				'name'  => 'email',
				'label' => trans('client.email'),
			],
			[
				'name'      => 'active',
				'label'     => trans('common.status'),
				'type'      => 'boolean',
				'options'   => [
					0 => trans('common.inactive'),
					1 => trans('common.active'),
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
				'name'  => 'salutation',
				'label' => trans('client.salutation'),
				'type'  => 'text',

				'tab'   => trans('client.tab_general'),
			],
			[
				'name'  => 'name',
				'label' => trans('client.name'),
				'type'  => 'text',

				'tab'   => trans('client.tab_general'),
			],
			[
				'name'  => 'email',
				'label' => trans('client.email'),
				'type'  => 'email',

				'tab'   => trans('client.tab_general'),
			],
			[
				'name'  => 'password',
				'label' => trans('client.password'),
				'type'  => 'password',

				'tab'   => trans('client.tab_general'),
			],
			[
				'name'  => 'password_confirmation',
				'label' => trans('client.password_confirmation'),
				'type'  => 'password',

				'tab'   => trans('client.tab_general'),
			],
			[
				'name'      => 'gender',
				'label'     => trans('client.gender'),
				'type'      => 'select_from_array',
				'options'   => [
					1 => trans('client.male'),
					2 => trans('client.female'),
				],

				'tab'   => trans('client.tab_general'),
			],
			[
				'name'  => 'birthday',
				'label' => trans('client.birthday'),
				'type'  => 'date',

				'tab'   => trans('client.tab_general'),
			],
			[
				'name'      => 'active',
				'label'     => trans('common.status'),
				'type'      => 'select_from_array',
				'options'   => [
					0 => trans('common.inactive'),
					1 => trans('common.active'),
				],

				'tab'   => trans('client.tab_general'),
			],
			[
				// two interconnected entities
				'label'             => trans('permissionmanager.user_role_permission'),
				'field_unique_name' => 'user_role_permission',
				'type'              => 'checklist_dependency',
				'name'              => 'roles_and_permissions',
				'subfields'         => [
					'primary' => [
						'label'            => trans('permissionmanager.roles'),
						'name'             => 'roles',
						'entity'           => 'roles',
						'entity_secondary' => 'permissions',
						'attribute'        => 'name',
						'model'            => config('permission.models.role'),
						'pivot'            => true,
						'number_columns'   => 3, //can be 1,2,3,4,6
					],
					'secondary' => [
						'label'          => ucfirst(trans('permissionmanager.permission_singular')),
						'name'           => 'permissions',
						'entity'         => 'permissions',
						'entity_primary' => 'roles',
						'attribute'      => 'name',
						'model'          => "Backpack\PermissionManager\app\Models\Permission",
						'pivot'          => true,
						'number_columns' => 3, //can be 1,2,3,4,6
					],
				],

				'tab'   => trans('client.tab_permissions'),
			],
		];
	}
}
