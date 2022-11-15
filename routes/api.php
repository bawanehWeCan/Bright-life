<?php

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\RolesController;
use App\Http\Controllers\Api\WalletController;
use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\ProductController;

use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PromoCodeController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\SliderController;

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
Route::post('sociallogin', [AuthController::class, 'sociallogin']);

Route::post('/user-reg', [AuthController::class, 'store']);

Route::post('/otb-check', [AuthController::class, 'check']);

Route::post('/password-otb', [AuthController::class, 'password']);

Route::post('change-password', [AuthController::class, 'changePassword']);





//supp
Route::post('/user-supplier', [AuthController::class, 'storeSupplier']);
Route::get('/suppliers', [AuthController::class, 'list']);
Route::get('supplier/{id}', [AuthController::class, 'supprofile']);
Route::post('suppliers/category', [AuthController::class, 'addCategory']);
Route::post('suppliers/sub-category', [AuthController::class, 'addCategory3']);

Route::get('best-suppliers', [AuthController::class, 'bestSuppliers']);


Route::post('products/category', [AuthController::class, 'addCategory2']);
// cat

//only those have manage_user permission will get access
Route::get('categories', [CategoryController::class, 'list']);
Route::post('category-create', [CategoryController::class, 'store']);
Route::get('category/{id}', [CategoryController::class, 'profile']);
Route::get('category/delete/{id}', [CategoryController::class, 'delete']);


// cat

//only those have manage_user permission will get access
Route::get('services', [ServiceController::class, 'list']);
Route::post('service-create', [ServiceController::class, 'store']);
Route::get('services/{id}', [ServiceController::class, 'profile']);
Route::get('services/delete/{id}', [ServiceController::class, 'delete']);




//Reviews

Route::get('reviews', [ReviewController::class, 'test']);

Route::get('reviews', [ReviewController::class, 'list']);


Route::get('review/{id}', [ReviewController::class, 'view']);
Route::post('review/delete/{id}', [ReviewController::class, 'delete']);




/**new code */
//only those have manage_user permission will get access
Route::get('products', [ProductController::class, 'pagination']);
Route::post('products-create', [ProductController::class, 'save']);
Route::get('products/{id}', [ProductController::class, 'view']);
Route::get('products/delete/{id}', [ProductController::class, 'delete']);
Route::post('products/search', [ProductController::class, 'lookfor']);



Route::post('make-order', [OrderController::class, 'store']);
// Route::get('make-order', [OrderController::class, 'store']);
Route::post('update-order', [OrderController::class, 'update']);
Route::get('view-order/{order}', [OrderController::class, 'view']);
Route::get('search-order', [OrderController::class, 'orderSearch']);
Route::get('list-order', [OrderController::class, 'list']);
Route::post('order/review', [OrderController::class, 'addReviewToOrder']);



Route::post('suppliers/search/{value}', [OrderController::class, 'search']);


//only those have manage_user permission will get access
Route::get('promo-code', [PromoCodeController::class, 'list']);
Route::post('promo-code-create', [PromoCodeController::class, 'save']);
Route::get('promo-code/{id}', [PromoCodeController::class, 'view']);
Route::get('promo-code/delete/{id}', [PromoCodeController::class, 'delete']);
Route::post('add-code-to-order', [PromoCodeController::class, 'addCodeOrder']);

Route::get('faq', [FaqController::class, 'list']);
Route::post('faq-create', [FaqController::class, 'save']);
Route::get('faq/{id}', [FaqController::class, 'view']);
Route::get('faq/delete/{id}', [FaqController::class, 'delete']);


Route::get('sliders', [SliderController::class, 'list']);
Route::post('slider-create', [SliderController::class, 'save']);
Route::get('slider/{id}', [SliderController::class, 'view']);
Route::get('slider/delete/{id}', [SliderController::class, 'delete']);
























Route::post('users/search', [UserController::class, 'search']);





Route::middleware(['auth:api'])->group(function () {



    // Address
    Route::get('address', [AddressController::class, 'pagination']);
    Route::post('address-create', [AddressController::class, 'save']);
    Route::get('address/{id}', [AddressController::class, 'view']);
    Route::get('address/delete/{id}', [AddressController::class, 'delete']);
    Route::get('my-address', [AddressController::class, 'user_address']);



    Route::post('/review/edit/{id}', [ReviewController::class, 'edit']);
    Route::post('review-create', [ReviewController::class, 'save']);


    Route::get('cart', [CartController::class, 'getCart']);

    Route::post('cart',  [CartController::class, 'add']);

    Route::post('update-cart', [CartController::class, 'update']);


    Route::get('my-orders', [OrderController::class, 'myOrders']);
    Route::get('my-products', [OrderController::class, 'myProducts']);


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


    Route::get('wallet', [WalletController::class, 'list']);
    Route::post('wallet-create', [WalletController::class, 'save']);
    Route::get('get-wallet', [WalletController::class, 'get']);
    Route::get('wallet/delete/{id}', [WalletController::class, 'delete']);

    Route::post('transaction', [TransactionController::class, 'transaction']);
});
