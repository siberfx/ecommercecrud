<?php

namespace SmartyStudio\EcommerceCrud\app\Http\Controllers\Admin;

use SmartyStudio\EcommerceCrud\app\Http\Requests\ProductRequest;
use SmartyStudio\EcommerceCrud\app\Models\Product;
use SmartyStudio\EcommerceCrud\app\Models\ProductImage;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Illuminate\Http\Request;
use Storage;

/**
 * Class ProductCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class ProductCrudController extends CrudController
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
        $this->crud->setModel('SmartyStudio\EcommerceCrud\app\Models\Product');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/products');
        $this->crud->setEntityNameStrings('product', 'products');

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

	protected function setupUpdateOperation()
	{
		$this->crud->setValidation(ProductRequest::class);

		$this->crud->addField(
			[
				'name'          => 'dropzone',
				'type'          => 'dropzone',
				'disk'          => 'products', // disk where images will be uploaded
				'mimes'         => [
					'image/*'
				],
				'filesize'      => 5, // maximum file size in MB

				// TAB
				'tab'           => trans('product.product_images_tab'),
			]
		);
	}


	/**
	 * @return array
	 */
	private function getColumns()
	{
		return [
			[
				'name'  => 'name',
				'label' => trans('product.name'),
			],
			[
				'type'      => "select_multiple",
				'label'     => trans('category.categories'),
				'name'      => 'categories',
				'entity'    => 'categories',
				'attribute' => "name",
				'model'     => "App\Models\Category",
			],
			[
				'name'  => 'sku',
				'label' => trans('product.sku'),
			],
			[
				'name'  => 'price',
				'label' => trans('product.price'),
			],
			[
				'name'  => 'stock',
				'label' => trans('product.stock'),
			],
			[
				'name'      => 'active',
				'label'     => trans('common.status'),
				'type'      => 'boolean',
				'options'   => [
					0 => trans('common.inactive'),
					1 => trans('common.active')
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
				'label' => trans('product.name'),
				'type'  => 'text',

				// TAB
				'tab'   => trans('product.general_tab'),
			],
			[
				'name'  => 'description',
				'label' => trans('product.description'),
				'type'  => 'ckeditor',

				// TAB
				'tab'   => trans('product.general_tab'),
			],
			[
				'name'      => 'categories',
				'label'     => trans('category.categories'),
				'hint'      => trans('product.hint_category'),
				'type'      => 'select2_multiple',
				'entity'    => 'categories',
				'attribute' => 'name',
				'model'     => "App\Models\Category",
				'pivot'     => true,

				// TAB
				'tab'   => trans('product.general_tab'),
			],
			[
				'name'  => 'sku',
				'label' => trans('product.sku'),
				'type'  => 'text',

				// TAB
				'tab'   => trans('product.general_tab'),
			],
			[
				'name'  => 'stock',
				'label' => trans('product.stock'),
				'type'  => 'number',

				// TAB
				'tab'   => trans('product.general_tab'),
			],
			[
				'name'  => 'price_with_vat',
				'label' => trans('product.price'),
				'type'  => 'number',
				'attributes' => [
					'step' => 'any',
				],

				// TAB
				'tab'   => trans('product.general_tab'),
			],
			[
				'name'          => 'price',
				'label'         => trans('product.price_without_vat'),
				'type'          => 'text',
				'attributes'    => [
					'readonly'  => 'readonly',
				],

				// TAB
				'tab'   => trans('product.general_tab'),
			],
			[
				'name'  => 'price_vat_calculator',
				'type'  => 'product_vat',
				'tab'   => trans('product.general_tab'),

			],
			[
				'type'           => 'select2_tax',
				'label'          => trans('tax.tax'),
				'name'           => 'tax_id',
				'entity'         => 'tax',
				'attribute'      => 'name',
				'data_value'     => 'value',
				'model'          => "App\Models\Tax",
				'attributes'     => [
					'id'    	 => 'tax',
				],

				// TAB
				'tab'   => trans('product.general_tab'),
			],
			[
				'name'    => 'active',
				'label'   => trans('common.status'),
				'type'    => 'select_from_array',
				'options' => [
					'0' => trans('common.inactive'),
					'1' => trans('common.active'),
				],

				// TAB
				'tab'   => trans('product.general_tab'),
			],

		];
	}


	public function ajaxUploadProductImages(Request $request, Product $product)
	{
		$images = [];
		$disk   = "products";

		if ($request->file && $request->id) {
			$product = $product->find($request->id);
			$productImages = $product->images->toArray();

			if ($productImages) {
				$ord = count($productImages);
			} else {
				$ord = 0;
			}

			foreach ($request->file as $file) {
				$file_content   = file_get_contents($file);
				$path           = substr($product->id, 0, 1) . DIRECTORY_SEPARATOR . $product->id . DIRECTORY_SEPARATOR;
				$filename       = md5(uniqid('', true)) . '.' . $file->extension();

				Storage::disk($disk)->put($path . $filename, $file_content);

				$images[] = [
					'product_id'    => $product->id,
					'name'          => $filename,
					'order'         => $ord++
				];
			}

			$product->images()->insert($images);

			return response()->json($product->load('images')->images->toArray());
		}
	}

	public function ajaxReorderProductImages(Request $request, ProductImage $productImage)
	{
		if ($request->order) {
			foreach ($request->order as $position => $id) {
				$productImage->find($id)->update(['order' => $position]);
			}
		}
	}

	public function ajaxDeleteProductImage(Request $request, ProductImage $productImage)
	{
		$disk = "products";

		if ($request->id) {
			$productImage = $productImage->find($request->id);

			if (Storage::disk($disk)->has($productImage->name)) {
				if (Storage::disk($disk)->delete($productImage->name)) {
					$productImage->delete();

					return response()->json(['success' => true, 'message' => trans('product.image_deleted')]);
				}
			}

			return response()->json(['success' => false, 'message' => trans('product.image_not_found')]);
		}
	}

	public function store(ProductRequest $request)
	{
		$redirect_location = $this->traitStore();
		return $redirect_location;
	}


	public function update(ProductRequest $request, Product $product)
	{
		$id = request()->id;
		// Get current product data
		$product = $product->findOrFail($id);

		$redirect_location = $this->traitUpdate();

		return $redirect_location;
	}

	/**
	 * @param Product $product
	 * @param Request $request
	 *
	 * @return RedirectResponse
	 */
	public function cloneProduct(Product $product, Request $request)
	{
		$id = $request->input('product_id');
		$cloneSku = $request->input('clone_sku');
		$cloneImages = $request->input('clone_images');

		// Check if cloned product has sku
		if (!$cloneSku) {
			\Alert::error(trans('product.sku_required'))->flash();

			return redirect()->back();
		}

		// Check if product sku exist
		if ($product->where('sku', $cloneSku)->first()) {
			\Alert::error(trans('product.sku_unique'))->flash();

			return redirect()->back();
		}

		// Prepare relations
		$relations = ['categories'];

		if ($cloneImages) {
			array_push($relations, 'images');
		}

		// Find product and load relations specified
		$product = $product->with($relations)->find($id);

		// Redirect back if product what need to be cloned doesn't exist
		if (!$product) {
			\Alert::error(trans('product.cannot_find_product'))->flash();

			return redirect()->back();
		}

		// Create clone object
		$clone = $product->replicate();
		$clone->sku = $cloneSku;

		// Save cloned product
		$clone->push();

		// Clone product relations
		foreach ($product->getRelations() as $relationName => $values) {
			$relationType = getRelationType($product->{$relationName}());

			switch ($relationType) {
				case 'hasMany':
					if (count($product->{$relationName}) > 0) {
						foreach ($product->{$relationName} as $relationValue) {
							$values = $relationValue->toArray();

							// skip image name accessor
							if ($relationName === "images") {
								$values['name'] = $relationValue->getOriginal('name');
							}

							$clone->{$relationName}()->create($values);
						}
					}
					break;

				case 'hasOne':
					if ($product->{$relationName}) {
						$clone->{$relationName}()->create($values->toArray());
					}
					break;

				case 'belongsToMany':
					$clone->{$relationName}()->sync($values);
					break;
			}
		}

		// clone images on disk
		if ($cloneImages) {
			foreach ($product->images as $image) {
				$newpath = substr($clone->id, 0, 1) . DIRECTORY_SEPARATOR . $clone->id . DIRECTORY_SEPARATOR;

				Storage::disk('products')->copy($image->name, $newpath . $image->getOriginal('name'));
			}
		}

		\Alert::success(trans('product.clone_success'))->flash();

		return redirect()->back();
	}

	/**
	 * @param $productId
	 * @param $reduction
	 * @param $discountType
	 * @return bool
	 */
	public function validateReductionPrice($productId, $reduction, $discountType)
	{

		$product = Product::find($productId);
		$oldPrice = $product->price;
		if ($discountType == 'Amount') {
			$newPrice = $oldPrice - $reduction;
		}
		if ($discountType == 'Percent') {
			$newPrice = $oldPrice - $reduction / 100.00 * $oldPrice;
		}

		if ($newPrice < 0) {
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
        if ($user->can('list_products')) {
            $this->crud->allowAccess('list');
        }

        // Allow create access
        if ($user->can('create_product')) {
            $this->crud->allowAccess('create');
        }

        // Allow update access
        if ($user->can('update_product')) {
            $this->crud->allowAccess('update');
        }

        // Allow clone access
        if ($user->can('clone_product')) {
            $this->crud->addButtonFromView('line', trans('product.clone'), 'clone_product', 'end');
        }

        // Allow delete access
        if ($user->can('delete_product')) {
            $this->crud->allowAccess('delete');
        }
    }
}