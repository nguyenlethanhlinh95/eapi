## 1. Install laravel 5.5
composer create-project laravel/laravel laravel_api "5.5.*" --prefer-dist
## 2. Create model, migration, controller, resource, factory
<ul>
    <li>php artisan make:model Model/Product -a</li>
    <li>php artisan make:model Model/Revew -a</li>
</ul>

## Create api route
<ul>
    <li>Route::apiResource('/products', 'ProductController');</li>
    <li>Route::group(['prefix' => 'products'], function (){
             Route::apiResource('/{product}/reviews', 'ReviewController');
        });</li>
</ul>