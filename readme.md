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

## Create Seeder
<ul>
    <li>use Faker\Generator as Faker;
        $factory->define(App\Model\Product::class, function (Faker $faker) {
            return [
                //
                'name' => $faker->word,
                'detail' => $faker->paragraph,
                'price' => $faker->numberBetween(100,1000),
                'stock' => $faker->randomDigit,
                'discount' => $faker->numberBetween(2,30),
            ];
        });</li>
    <li>php
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(UsersTableSeeder::class);
        factory(\App\Model\Product::class,50)->create();
        factory(\App\Model\Review::class,50)->create();
        factory(\App\User::class,50)->create();

    }
}</li>
</ul>
