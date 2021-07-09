# EcommerceCrud

An admin interface for [Laravel Backpack](laravelbackpack.com) to easily create ecommerce applications.

## Install

1. In your terminal:

``` bash
$ composer require smartystudio/backpackecommerce
```

2. If your Laravel version does not have package autodiscovery then add the service provider to your config/app.php file:

```php
Cviebrock\EloquentSluggable\ServiceProvider::class,
SmartyStudio\BackpackEcommerce\EcommerceCRUDServiceProvider::class,
```

3. Publish & run the migration file

```bash
$ php artisan vendor:publish --provider="SmartyStudio\EcommerceCrud\EcommerceCRUDServiceProvider" # publish migration file
$ php artisan migrate # create the testimonial table
```

4. [Optional] Add a menu item for it in resources/views/vendor/backpack/base/inc/sidebar.blade.php or menu.blade.php:

```html
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-shopping-cart"></i> Ecommerce</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('categories') }}"><i class="nav-icon la la-bars"></i><span>Categories</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('products') }}"><i class="nav-icon la la-list"></i><span>Products</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('orders') }}"><i class="nav-icon la la-list-ul"></i><span>Orders</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('clients') }}"><i class="nav-icon la la-users"></i><span>Clients</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('attributes') }}"><i class="nav-icon la la-tag"></i><span>Attributes</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('attributes-sets') }}"><i class="nav-icon la la-tags"></i><span>Attribute Sets</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('currencies') }}"><i class="nav-icon la la-usd"></i><span>Currencies</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('carriers') }}"><i class="nav-icon la la-truck"></i><span>Carriers</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('taxes') }}"><i class="nav-icon la la-balance-scale"></i><span>Taxes</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('order-statuses') }}"><i class="nav-icon la la-list-ul"></i><span>Statuses</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('cart-rules') }}"><i class="nav-icon la la-shopping-cart"></i><span>Cart Rules</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('specific-prices') }}"><i class="nav-icon la la-money"></i><span>Specific Prices</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('notification-templates') }}"><i class="nav-icon la la-list"></i><span>Notification Templates</span></a></li>
    </ul>
</li>
```

## How to use the package

...

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
// TODO
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email us instead of using the issue tracker.

## Credits

- Martin Nestorov - Web Developer @ Smarty Studio MBN Ltd.
- All Contributors

## License

The SmartyStudio\BackpackEcommerce is open-source software licensed under the MIT license.
