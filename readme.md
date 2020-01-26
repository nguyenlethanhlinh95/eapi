## 1. Install laravel 5.5
composer create-project laravel/laravel laravel_api "5.5.*" --prefer-dist
## 2. Create model, migration, controller, resource, factory
<ul>
    <li>php artisan make:model Model/Product -a</li>
    <li>php artisan make:model Model/Revew -a</li>
</ul>

## 3. Create api route
<ul>
    <li>Route::apiResource('/products', 'ProductController');</li>
    <li>Route::group(['prefix' => 'products'], function (){
             Route::apiResource('/{product}/reviews', 'ReviewController');
        });</li>
</ul>

## 4. Create Seeder
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

## 5. Create a new resource
php artisan make:resource Product/ProductCollection

<p>- Trong file resource</p>
public function toArray($request)
{
    return [
        'name' => $this->name,
        'description' => $this->detail,
        'price' => $this->price,
        'stock' => $this->stock,
        'discount' => $this->discount,
    ];
}
<br><br>

<p>- Trong file controller</p>
public function index()
{
    //
    $products = Product::all();
    return ProductResource::collection($products);
}
<br><br>
public function show(Product $product)
{
    return new ProductResource($product);
}

## 5. Có thể thêm mối quan hệ

 public function toArray($request)
    {
        return [
            'name' => $this->name,
            'description' => $this->detail,
            'price' => $this->price,
            'stock' => $this->stock,
            'discount' => $this->discount,
            'rating' => $this->reviews->sum('star')/ $this->reviews->count(),
            'href' => [
                'revires' => route('reviews.index', $this->id)
            ]
        ];
    }
