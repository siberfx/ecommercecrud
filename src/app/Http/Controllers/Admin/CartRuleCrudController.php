<?php

namespace SmartyStudio\EcommerceCrud\app\Http\Controllers\Admin;

use SmartyStudio\EcommerceCrud\app\Http\Requests\CartRuleRequest;
use SmartyStudio\EcommerceCrud\app\Models\CartRuleDiscountType;
use SmartyStudio\EcommerceCrud\app\Models\Currency;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;

/**
 * Class CartRuleCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class CartRuleCrudController extends CrudController
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
        $this->crud->setModel('SmartyStudio\EcommerceCrud\app\Models\CartRule');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/cart-rules');
        $this->crud->setEntityNameStrings('cart rule', 'cart rules');

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

        // ------ CRUD FIELDS
        // $this->crud->addField($options, 'update/create/both');
        // $this->crud->addFields($array_of_arrays, 'update/create/both');
        // $this->crud->removeField('name', 'update/create/both');
        // $this->crud->removeFields($array_of_names, 'update/create/both');

        // ------ CRUD COLUMNS
        // $this->crud->addColumn(); // add a single column, at the end of the stack
        // $this->crud->addColumns(); // add multiple columns, at the end of the stack
        // $this->crud->removeColumn('column_name'); // remove a column from the stack
        // $this->crud->removeColumns(['column_name_1', 'column_name_2']); // remove an array of columns from the stack
        // $this->crud->setColumnDetails('column_name', ['attribute' => 'value']); // adjusts the properties of the passed in column (by name)
        // $this->crud->setColumnsDetails(['column_1', 'column_2'], ['attribute' => 'value']);

        // ------ CRUD BUTTONS
        // possible positions: 'beginning' and 'end'; defaults to 'beginning' for the 'line' stack, 'end' for the others;
        // $this->crud->addButton($stack, $name, $type, $content, $position); // add a button; possible types are: view, model_function
        // $this->crud->addButtonFromModelFunction($stack, $name, $model_function_name, $position); // add a button whose HTML is returned by a method in the CRUD model
        // $this->crud->addButtonFromView($stack, $name, $view, $position); // add a button whose HTML is in a view placed at resources\views\vendor\backpack\crud\buttons
        // $this->crud->removeButton($name);
        // $this->crud->removeButtonFromStack($name, $stack);
        // $this->crud->removeAllButtons();
        // $this->crud->removeAllButtonsFromStack('line');

        // ------ CRUD ACCESS
        // $this->crud->allowAccess(['list', 'create', 'update', 'reorder', 'delete']);
        // $this->crud->denyAccess(['list', 'create', 'update', 'reorder', 'delete']);

        // ------ CRUD REORDER
        // $this->crud->enableReorder('label_name', MAX_TREE_LEVEL);
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('reorder');

        // ------ CRUD DETAILS ROW
        // $this->crud->enableDetailsRow();
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('details_row');
        // NOTE: you also need to do overwrite the showDetailsRow($id) method in your EntityCrudController to show whatever you'd like in the details row OR overwrite the views/backpack/crud/details_row.blade.php

        // ------ REVISIONS
        // You also need to use \Venturecraft\Revisionable\RevisionableTrait;
        // Please check out: https://laravel-backpack.readme.io/docs/crud#revisions
        // $this->crud->allowAccess('revisions');

        // ------ AJAX TABLE VIEW
        // Please note the drawbacks of this though:
        // - 1-n and n-n columns are not searchable
        // - date and datetime columns won't be sortable anymore
        // $this->crud->enableAjaxTable();

        // ------ DATATABLE EXPORT BUTTONS
        // Show export to PDF, CSV, XLS and Print buttons on the table view.
        // Does not work well with AJAX datatables.
        // $this->crud->enableExportButtons();

        // ------ ADVANCED QUERIES
        // $this->crud->addClause('active');
        // $this->crud->addClause('type', 'car');
        // $this->crud->addClause('where', 'name', '==', 'car');
        // $this->crud->addClause('whereName', 'car');
        // $this->crud->addClause('whereHas', 'posts', function($query) {
        //     $query->activePosts();
        // });
        // $this->crud->addClause('withoutGlobalScopes');
        // $this->crud->addClause('withoutGlobalScope', VisibleScope::class);
        // $this->crud->with(); // eager load relationships
        // $this->crud->orderBy();
        // $this->crud->groupBy();
        // $this->crud->limit();
	}

	protected function setupListOperation()
	{
	}

	protected function setupCreateOperation()
	{
		$this->crud->setValidation(CartRuleRequest::class);
	}

	protected function setupUpdateOperation()
	{
		$this->crud->setValidation(CartRuleRequest::class);
	}

	/**
	 * @return array
	 */
	private function getColumns()
	{
		return [
			[
				'name'  => 'name',
				'label' => trans('cartrule.name'),
				'type'  => 'text',
			],
			[
				'name'  => 'code',
				'label' => trans('cartrule.code'),
			],
			[
				'name'  => 'priority',
				'label' => trans('cartrule.priority'),
			],
			[
				'name'  => 'start_date',
				'label' => trans('cartrule.start_date'),
			],
			[
				'name'  => 'expiration_date',
				'label' => trans('cartrule.expiration_date'),
			],
			[
				'name'  => 'status',
				'label' => trans('cartrule.status'),
			],
		];
	}

	/**
	 * @return array
	 */
	private function getFields()
	{
		$defaultCurrencyName = Currency::getDefaultCurrencyName();
		$defaultCurrencyId = Currency::getDefaultCurrencyId();

		return [
			[
				'name'      => 'name',
				'label'     => trans('cartrule.name'),
				'type'      => 'text',
				'attributes' => ['required' => 'true'],
				'tab'       => trans('cartrule.information_tab'),
			],
			[
				'name'  => 'code',
				'label' => trans('cartrule.code'),
				'tab'   => trans('cartrule.information_tab'),
			],
			[
				'name'  => 'highlight',
				'label' => trans('cartrule.highlight'),
				'type'  => 'toggle_switch',
				'tab'   => trans('cartrule.information_tab'),
			],
			[
				'name'      => 'priority',
				'label'     => trans('cartrule.priority'),
				'type'      => 'number',
				'attributes' => [
					'step'  => 'any',
				],
				'tab'       => trans('cartrule.information_tab'),
			],
			[
				'name'  => 'status',
				'label' => trans('cartrule.status'),
				'type'  => 'toggle_switch',
				'tab'   => trans('cartrule.information_tab'),
			],
			[
				'name'  => 'free_delivery',
				'label' => trans('cartrule.free_delivery'),
				'type'  => 'toggle_switch',
				'tab'   => trans('cartrule.information_tab'),
			],
			[
				'name'  => 'promo_label',
				'label' => trans('cartrule.promo_label'),
				'tab'   => trans('cartrule.information_tab'),
			],
			[
				'name'  => 'promo_text',
				'label' => trans('cartrule.promo_text'),
				'tab'   => trans('cartrule.information_tab'),
				'type'  => 'textarea',
			],

			// CONDITIONS TAB
			[
				'name'      => 'customers',
				'label'     => trans('cartrule.customer_groups_rule'),
				'type'      => 'select2_multiple',
				'attribute' => 'name',
				'entity'    => 'customers',
				'model'     => 'App\Models\User',
				'pivot'     => true,
				'tab'       => trans('cartrule.conditions_tab'),
			],
			[
				'name'  => 'start_date',
				'label' => trans('cartrule.start_date'),
				'type'  => 'datetime_picker',
				'tab'   => trans('cartrule.conditions_tab'),
			],
			[
				'name'  => 'expiration_date',
				'label' => trans('cartrule.expiration_date'),
				'type'  => 'datetime_picker',
				'tab'   => trans('cartrule.conditions_tab'),
			],
			[
				'name'      => 'total_available',
				'label'     => trans('cartrule.total_available'),
				'type'      => 'number',
				'attributes' => [
					'step'  => 'any',
				],
				'tab'       => trans('cartrule.conditions_tab'),
			],
			[
				'name'      => 'total_available_each_user',
				'label'     => trans('cartrule.total_available_each_user'),
				'type'      => 'number',
				'attributes' => [
					'step'  => 'any',
				],
				'tab'       => trans('cartrule.conditions_tab'),
			],
			[
				'name'      => 'min_nr_products',
				'label'     => trans('cartrule.min_nr_products'),
				'type'      => 'number',
				'attributes' => [
					'step'  => 'any',
				],
				'tab'       => trans('cartrule.conditions_tab'),
			],

			[
				'name'  => 'restrictions',
				'label' => '',
				'type'  => 'custom_html',
				'value' => '<h3>Restrictions</h3>',
				'tab'   => trans('cartrule.conditions_tab'),

			],
			[
				'name'      => 'categories',
				'label'     => trans('cartrule.categories_rule'),
				'type'      => 'select2_multiple',
				'entity'    => 'categories',
				'attribute' => 'name',
				'model'     => 'App\Models\Category',
				'pivot'     => true,
				'tab'       => trans('cartrule.conditions_tab'),
			],
			[
				'name'      => 'productGroups',
				'label'     => trans('cartrule.product_groups_rule'),
				'type'      => 'select2_multiple',
				'attribute' => 'id',
				'entity'    => 'productGroups',
				'model'     => 'App\Models\ProductGroup',
				'pivot'     => true,
				'tab'       => trans('cartrule.conditions_tab'),
			],
			[
				'name'      => 'products',
				'label'     => trans('cartrule.products_rule'),
				'type'      => 'select2_multiple',
				'attribute' => 'name',
				'entity'    => 'products',
				'model'     => 'App\Models\Product',
				'pivot'     => true,
				'tab'       => trans('cartrule.conditions_tab'),
			],
			[
				'name'      => 'compatibleCartRules',
				'label'     => trans('cartrule.compatible_with_rules'),
				'type'      => 'select2_multiple',
				'entity'    => 'compatibleCartRules',
				'attribute' => 'name',
				'model'     => 'App\Models\CartRule',
				'pivot'     => true,
				'tab'       => trans('cartrule.conditions_tab'),
			],
		];
	}

	public function setPermissions()
	{
		// Get authenticated user
		$user = auth()->user();

		// Deny all accesses
		$this->crud->denyAccess(['list', 'create', 'update', 'delete']);

		// Allow list access
		if ($user->can('list_cart_rules')) {
			$this->crud->allowAccess('list');
		}

		// Allow create access
		if ($user->can('create_cart_rule')) {
			$this->crud->allowAccess('create');
		}

		// Allow update access
		if ($user->can('update_cart_rule')) {
			$this->crud->allowAccess('update');
		}

		// Allow delete access
		if ($user->can('delete_cart_rule')) {
			$this->crud->allowAccess('delete');
		}
	}
}
