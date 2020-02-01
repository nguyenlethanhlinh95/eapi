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

## 6. Cài đặt Laravel Passport cho Laravel 5.5.*
<h4>1. Cài đặt<h4>
<p>composer require paragonie/random_compat:2.*</p>
<p>composer require laravel/passport "4.0.*"</p>
<h4>2. Chạy Migrate<h4>
<p>php artisan migrate</p>
<h4>2. Chạy Migrate<h4>
<p>php artisan migrate</p>

## 7. Cấu hình Laravel Passport cho Laravel 5.5.*
1. Tạo accept token:
    php artisan passport:install
2.  Vào App/User
    namespace App;
    
    use Laravel\Passport\HasApiTokens;
    use Illuminate\Notifications\Notifiable;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    
    class User extends Authenticatable
    {
        use HasApiTokens, Notifiable;
    }
    
3.  Vào file AuthServiceProvider thêm dòng
    public function boot()
        {
            $this->registerPolicies();
    
            Passport::routes();
        }
4.  Vào file config/auth.php thêm dòng
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
    
        'api' => [
            'driver' => 'passport',
            'provider' => 'users',
        ],
    ],
    
5.  Vào PostMan thêm Post request 
    -   http://localhost/laravel_api/public/oauth/token
    -   Body raw json
        {
        	"grant_type": "password",
        	"client_id": 9,
        	"client_secret": "B86a5o5QJ6xq4viDH0PcibD19eCojJAFTOWkVC1o",
        	"username": "itvdn1995@gmail.com",
        	"password": 123123
        }
        
6.  Ở Postman khi truy cập vào đường dẫn cần thêm trước Headers 3 key như sau
    +  Ví Dụ đường dẫn: http://localhost/laravel_api/public/api/user
    -   Accept:application/json
    -   Content-Type: application/json
    -   Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImFmZDE0OTlhODc2ODAyMjI3NTA2ZDk5OTA2YjAyYzViMDJlM2Y5MjYyZjkwMzJmMWNjMTUwNGQ3MTUwODI2YzI4Y2ZmNzBkZTJmNWVmNWU3In0.eyJhdWQiOiI5IiwianRpIjoiYWZkMTQ5OWE4NzY4MDIyMjc1MDZkOTk5MDZiMDJjNWIwMmUzZjkyNjJmOTAzMmYxY2MxNTA0ZDcxNTA4MjZjMjhjZmY3MGRlMmY1ZWY1ZTciLCJpYXQiOjE1ODAyODU2NzksIm5iZiI6MTU4MDI4NTY3OSwiZXhwIjoxNjExOTA4MDc5LCJzdWIiOiI1MSIsInNjb3BlcyI6W119.hvgYfJ9hinfDhJIOsAcbXcAm6GFGwZxa_S4gtkiE6qBXWS95WBKttEtwqYHnuzYEJ1Z62xXiQkhCDON4q_RXxApfySfXy9UT66-q-8Bep7-xEvKZ-IKugMiXDL_Ij0oObt7T-__sRo_-ci0Vb4HuFnPYXj0D6L_knnJB3IUqUOJvyx_zg9iNfyUfGw0AXILdowUlf-camqW8xFYPQdMhw6Rn4xopjrmmAzAZpmvzIvgf-4BPJ7muz75QQ_K_lOmzeOiMvULmbvswc-2E-DpkkWI85c13nS1u5-NFmTHFhwGCUIWzCqe1VjZbQly8n3xoZ3cs9CX2UvuiKxpYF8cDx7-P5vwP5Do75kWSLefy2upvS4uB4Oljv2t63fx2dZ99cPJUMFR8XX286hy9DqAppvKT-2wbnSqXW9m_AcVb1WyYR5dgJ1U289y6HHJvVpFrsemnhYsRqe_aNo0VrnTrvwnU9yyMaFZfP-JndJXce3oHLQpvV4aWhG9CpvQ7C2IZuIp9P7mdYuJz8_2ejEaQlN340tmyL-PNKxA8jv2rT52-9sdnsPPudOvXKTpIotOtdmhxD5xYYUIhdCn21It2vRoT63pA_G94j3Jx4F8rRwDedZ5AA9VqBCSZtFTK_Bt6TZ8yrrZ1Gwt4lt24AxOXU3FR_kIRGjzDA_yH9aOAmyI
    
    - Bearer và token nhận được
    
##8.  Sử dụng Transaction
    DB::beginTransaction();
        try {
            DB::table('users')->update(['votes' => 1]);
            DB::table('posts')->delete();
            
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            
            throw new Exception($e->getMessage());
        }
        
##9. Code vi du
    DB::beginTransaction();
            try{
                $formInput = $request->all();
                $product = Product::create($formInput);
    
                DB::commit();
                return $this->showOne($product,Response::HTTP_CREATED);
            }
            catch (\Exception $exception)
            {
                DB::rollBack();
                return $this->errorResponse();
            }
            
##10. Api resource
Route::apiResource('/products', 'ProductController');

##11. Các Method trong Api
    - Gồm: index, store, show, update, destroy
    - sử dung câu lệnh để tạo controller nhanh:
    php artisan make:controller Tên Controller --api (chỉ sử dụng trong Laravel 5.6)