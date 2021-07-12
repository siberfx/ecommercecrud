<?php

namespace SmartyStudio\EcommerceCrud\app\Http\Controllers\Admin;

use SmartyStudio\EcommerceCrud\app\Http\Requests\NotificationTemplateRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;

/**
 * Class NotificationTemplateCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class NotificationTemplateCrudController extends CrudController
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
        $this->crud->setModel('SmartyStudio\EcommerceCrud\app\Models\NotificationTemplate');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/notification-templates');
        $this->crud->setEntityNameStrings(trans('notification_templates.notification_template'), trans('notification_templates.notification_templates'));

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
	}

	protected function setupListOperation()
	{
	}

	protected function setupCreateOperation()
	{
		$this->crud->setValidation(NotificationTemplateRequest::class);
	}

	protected function setupUpdateOperation()
	{
		$this->crud->setValidation(NotificationTemplateRequest::class);
	}

	/**
	 * @return array
	 */
	private function getColumns()
	{
		return [
			[
				'name'  => 'id',
				'label' => '#',
			],
			[
				'label'     => trans('notification_templates.name'),
				'type'      => 'text',
				'name'      => 'name',
			],
			[
				'label'     => trans('notification_templates.model'),
				'type'      => 'text',
				'name'      => 'model',
			],
			[
				'label'     => trans('notification_templates.slug'),
				'type'      => 'text',
				'name'      => 'name',
			],
		];
	}

	/**
	 * @return array
	 */
	private function getFields()
	{
		$availableModels = [
			'User' => 'App\Models\User',
			'Order' => 'App\Models\Order'
		];

		return [
			[
				'name'  => 'name',
				'label' => trans('notification_templates.name'),
				'type'  => 'text',
			],
			[
				'name'  => 'slug',
				'label' => trans('notification_templates.slug'),
				'type'  => 'slug',
				// 'attributes' => ['disabled' => 'disabled']
			],
			[
				'name'    => 'model',
				'label'   => trans('notification_templates.model'),
				'type'    => 'select2_from_array_notification_template_model',
				'options' => $availableModels
			],
			[
				'name'  => 'body',
				'label' => trans('notification_templates.body'),
				'type'  => 'ckeditor',
				'wrapperAttributes' => [
					'class' => 'form-group col-md-9 col-xs-12'
				]
			],
			[
				'name'  => 'notification_list_variables',
				'label' => trans('notification_templates.available_variables'),
				'type'  => 'notification_list_variables',
				'wrapperAttributes' => [
					'class' => 'form-group available-variables col-md-3 col-xs-12'
				]
			],
		];
	}

	public function listModelVars()
	{
		$modelClass = 'App\\Models\\' . $this->crud->request->model;

		if ($this->crud->request->model === 'User') {
			$modelClass = 'App\\' . $this->crud->request->model;
		}

		if (class_exists($modelClass)) {
			$model = new $modelClass;

			return response()->json($model->notificationVars);
		}

		return null;
	}


	/**
	 * Get model variables available to use in an email template
	 * @param  string $modelName
	 * @return array
	 */
	public function getModelVariables($modelName)
	{
		$modelClass = 'App\\Models\\' . $modelName;

		if ($modelName === 'User') {
			$modelClass = 'App\\' . $modelName;
		}

		if (class_exists($modelClass)) {
			$model = new $modelClass;
		}

		return $model->notificationVars;
	}

	/**
	 * Check variables in body to match the available variables from the model
	 * @param  $request
	 * @return boolean
	 */
	public function checkModelVariables($request)
	{
		preg_match_all(
			'/(\{{2}\s?(.*?)\s?\}{2})/mi',
			$request->body,
			$out,
			PREG_PATTERN_ORDER
		);

		if (count(array_diff($out[2], $this->getModelVariables($request->model))) > 0) {
			return false;
		}
		return true;
	}

    public function setPermissions()
    {
        // Get authenticated user
        $user = auth()->user();

        // Deny all accesses
        $this->crud->denyAccess(['list', 'create', 'update', 'delete']);

        // Allow list access
        if ($user->can('list_notification_templates')) {
            $this->crud->allowAccess('list');
        }

        // Allow create access
        if ($user->can('create_notification_template')) {
            $this->crud->allowAccess('create');
        }

        // Allow update access
        if ($user->can('update_notification_template')) {
            $this->crud->allowAccess('update');
        }

        // Uncomment if you want to allow delete functionality
        // Allow delete access
        // if ($user->can('delete_notification_template')) {
        //     $this->crud->allowAccess('delete');
        // }
    }
}