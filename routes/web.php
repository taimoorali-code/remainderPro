<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
// Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
//     Route::get('/', [AdminAuthController::class, 'getLogin'])->name('adminLogin');
//     Route::post('/login', [AdminAuthController::class, 'postLogin'])->name('adminLoginPost');

//     Route::group(['middleware' => 'adminauth'], function () {
//         Route::get('/', function () {
//             return view('welcome');
//         })->name('adminDashboard');

//     });
// });
// Route::middleware(['auth','isAdmin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('Admin.dashboard');
     });
// });
// Route::middleware(['auth','isAdmin'])->group(function () {
    Route::get('/dashboard','App\Http\Controllers\Admin\frontendController@index');

    // Categories Routes

    Route::get('/admin/users',[CategoriesController::class, 'index'])->name('admin.user');
    Route::get('/admin/subscriber',[AdminUserController::class, 'subscriber'])->name('admin.subscriber');
    Route::get('/admin/feedback',[AdminUserController::class, 'feedback'])->name('admin.feedback');

    Route::get('/add-category','App\Http\Controllers\Admin\CategoriesController@add');
    Route::post('insert-category' , 'App\Http\Controllers\Admin\CategoriesController@insert');
    Route::get('edit-category/{id}',[CategoriesController::class , 'edit']);
    Route::put('update-category/{id}',[CategoriesController::class , 'update']);
    Route::get('delete-category/{id}',[CategoriesController::class , 'delete']);
    
    
    // Product Routes
    Route::get('/products','App\Http\Controllers\Admin\ProductController@index');
    Route::get('/add-product','App\Http\Controllers\Admin\ProductController@add');
    Route::post('insert-product' , 'App\Http\Controllers\Admin\ProductController@insert');
    Route::get('edit-product/{id}',[ProductController::class, 'edit']);
    Route::put('update-product/{id}',[ProductController::class , 'update']);
    Route::get('delete-product/{id}',[ProductController::class , 'delete']);
    Route::put('update-order/{id}',[UserController::class , 'updateOrder']);

    
    Route::get('orders',[OrderController::class, 'index']);
    Route::get('admin/view-order/{id}',[OrderController::class, 'view']);
    Route::put('update-order/{id}',[OrderController::class , 'updateOrder']);
    Route::get('order-history',[OrderController::class , 'orderHistory']);
    
    Route::get('users',[DashboardController::class, 'users']);
    Route::get('view-user/{id}',[DashboardController::class, 'viewUser']);
    
    
    // Route::get('message',[contactComplains::class, 'viewcomplains']);
// });

// require __DIR__.'/auth.php';
