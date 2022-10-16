<?php

use App\Http\Controllers\Api\AddressController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RolesController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Auth
Route::post('login', [AuthController::class, 'login']);

Route::post('/user-reg', [AuthController::class, 'store']);

Route::post('/otb-check', [AuthController::class, 'check']);

Route::post('/password-otb', [AuthController::class, 'password']);

Route::post('change-password', [AuthController::class, 'changePassword']);




//supp
Route::post('/user-supplier', [AuthController::class, 'store']);
Route::get('/suppliers', [AuthController::class, 'list']);
Route::get('supplier/{id}', [AuthController::class, 'supprofile']);
Route::post('suppliers/category', [AuthController::class, 'addCategory']);
Route::post('suppliers/sub-category', [AuthController::class, 'addCategory3']);


Route::post('products/category', [AuthController::class, 'addCategory2']);
// cat

//only those have manage_user permission will get access
Route::get('categories', [CategoryController::class, 'list']);
Route::post('category-create', [CategoryController::class, 'store']);
Route::get('category/{id}', [CategoryController::class, 'profile']);
Route::get('category/delete/{id}', [CategoryController::class, 'delete']);

//only those have manage_user permission will get access
Route::get('address', [AddressController::class, 'list']);
Route::post('address-create', [AddressController::class, 'save']);
Route::get('address/{id}', [AddressController::class, 'profile']);
Route::get('address/delete/{id}', [AddressController::class, 'delete']);


// cat

//only those have manage_user permission will get access
Route::get('services', [ServiceController::class, 'list']);
Route::post('service-create', [ServiceController::class, 'store']);
Route::get('services/{id}', [ServiceController::class, 'profile']);
Route::get('services/delete/{id}', [ServiceController::class, 'delete']);






/**new code */
//only those have manage_user permission will get access
Route::get('products', [ProductController::class, 'pagination']);
Route::post('products-create', [ProductController::class, 'save']);
Route::get('products/{id}', [ProductController::class, 'view']);
Route::get('products/delete/{id}', [ProductController::class, 'delete']);


Route::post('make-order', [OrderController::class, 'store']);
Route::post('update-order', [OrderController::class, 'update']);


Route::post('suppliers/search/{value}', [OrderController::class, 'search']);































Route::middleware(['auth:api'])->group(function () {


    Route::get('cart', function () {
        $cart = Cart::session(Auth::user()->id);

        dd($cart->getContent());
    });

    Route::post('cart', function (Request $request) {

        dd($request->product_id);

        $Product = Product::find($request->product_id); // assuming you have a Product model with id, name, description & price
        $rowId = $Product->id . Auth::user()->id; // generate a unique() row ID

        // add the product to cart
        \Cart::session(Auth::user()->id)->add(array(
            'id' => $rowId,
            'name' => $Product->name,
            'price' => $Product->price,
            'quantity' => $request->quantity,
            'attributes' => array(
                'size_id'=>$request->size_id,
                'extras'=>$request->extras
            ),
            'associatedModel' => $Product
        ));



        print_r(\Cart::session(55)->getContent());
    });


    Route::get('my-orders', [OrderController::class, 'myOrders']);
    Route::get('my-products', [OrderController::class, 'myProducts']);
    Route::get('my-address', [AddressController::class, 'user_address']);

    Route::get('logout', [AuthController::class, 'logout']);

    Route::get('profile', [AuthController::class, 'profile']);
    Route::post('change-password', [AuthController::class, 'changePassword']);
    Route::post('update-profile', [AuthController::class, 'updateProfile']);

    //only those have manage_user permission will get access
    Route::get('/users', [UserController::class, 'list']);
    Route::post('/user-create', [UserController::class, 'store']);
    Route::get('/user/{id}', [UserController::class, 'profile']);
    Route::get('/user/delete/{id}', [UserController::class, 'delete']);
    Route::post('/user/change-role/{id}', [UserController::class, 'changeRole']);

    //only those have manage_role permission will get access
    Route::group(['middleware' => 'can:manage_role|manage_user'], function () {
        Route::get('/roles', [RolesController::class, 'list']);
        Route::post('/role/create', [RolesController::class, 'store']);
        Route::get('/role/{id}', [RolesController::class, 'show']);
        Route::get('/role/delete/{id}', [RolesController::class, 'delete']);
        Route::post('/role/change-permission/{id}', [RolesController::class, 'changePermissions']);
    });


    //only those have manage_permission permission will get access
    Route::group(['middleware' => 'can:manage_permission|manage_user'], function () {
        Route::get('/permissions', [PermissionController::class, 'list']);
        Route::post('/permission/create', [PermissionController::class, 'store']);
        Route::get('/permission/{id}', [PermissionController::class, 'show']);
        Route::get('/permission/delete/{id}', [PermissionController::class, 'delete']);
    });
});
