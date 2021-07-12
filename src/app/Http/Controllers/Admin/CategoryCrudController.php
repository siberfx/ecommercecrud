<?php

namespace SmartyStudio\EcommerceCrud\app\Http\Controllers\Admin;

use SmartyStudio\EcommerceCrud\app\Requests\CategoryRequest;
use SmartyStudio\EcommerceCrud\app\Models\Category;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;

/**
 * Class CategoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class CategoryCrudController extends CrudController
{

	use ListOperation;
	use CreateOperation;
	use UpdateOperation;
	use DeleteOperation;
	use ShowOperation;
	use ReorderOperation;

    public function setup()
    {
        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
        $this->crud->setModel('SmartyStudio\EcommerceCrud\app\Models\Category');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/categories');
        $this->crud->setEntityNameStrings('category', 'categories');

        /*
        |--------------------------------------------------------------------------
        | BUTTONS
        |--------------------------------------------------------------------------
        */
        $this->crud->enableReorder('name', 0);

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

	protected function setupReorderOperation()
	{
		// define which model attribute will be shown on draggable elements
		$this->crud->set('reorder.label', 'name');
		// define how deep the admin is allowed to nest the items
		// for infinite levels, set it to 0
		$this->crud->set('reorder.max_level', 2);
	}

	protected function setupListOperation()
	{
	}

	protected function setupCreateOperation()
	{
		$this->crud->setValidation(CategoryRequest::class);
	}

	protected function setupUpdateOperation()
	{
		$this->crud->setValidation(CategoryRequest::class);
	}

	/**
	 * @return array
	 */
	private function getColumns()
	{
		return [
			[
				'type'      => "select",
				'label'     => trans('category.parent'),
				'name'      => 'parent_id',
				'entity'    => 'parent',
				'attribute' => "name",
				'model'     => "App\Models\Category",
			],
			[
				'name'  => 'name',
				'label' => trans('category.name'),
			],
			[
				'name'  => 'slug',
				'label' => trans('category.slug'),
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
				'label' => trans('category.parent'),
				'type' => 'select_from_array',
				'options' => Category::pluck('name', 'id'),
				'name' => 'parent_id',
				'allows_null' => true,
			],
			[
				'name'  => 'name',
				'label' => trans('category.name'),
				'type'  => 'text',
			],
			[
				'name'  => 'slug',
				'label' => trans('category.slug'),
				'type'  => 'text',
			]
		];
	}

    public function setPermissions()
    {
        // Get authenticated user
        $user = auth()->user();

        // Deny all accesses
        $this->crud->denyAccess(['list', 'create', 'update', 'reorder', 'delete']);

        // Allow list access
        if ($user->can('list_categories')) {
            $this->crud->allowAccess('list');
        }

        // Allow create access
        if ($user->can('create_category')) {
            $this->crud->allowAccess('create');
        }

        // Allow update access
        if ($user->can('update_category')) {
            $this->crud->allowAccess('update');
        }

        // Allow reorder access
        if ($user->can('reorder_categories')) {
            $this->crud->allowAccess('reorder');
        }

        // Allow delete access
        if ($user->can('delete_category')) {
            $this->crud->allowAccess('delete');
        }
    }
}