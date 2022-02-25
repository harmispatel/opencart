<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AllUserController;
use App\Http\Controllers\UserGroupController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RecurringProfilesController;
use App\Http\Controllers\FiltersController;
use App\Http\Controllers\ManufacturersController;
use App\Http\Controllers\DownloadsController;
use App\Http\Controllers\ReviewsController;




use Illuminate\Support\Facades\Auth;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
  return view('welcome');
});

Auth::routes();

Route::get('/logout', [LoginController::class, 'logout']);
Route::get('admin', [HomeController::class, 'adminLogin'])->name('admin');
Route::get('login', [HomeController::class, 'adminLogin'])->name('login');
// Route::get('/home', [HomeController::class, 'index'])->name('home');


// Group
Route::group(['middleware' => 'AuthUser'], function () {

  // Dashboard
  Route::get('dashboard', [HomeController::class, 'adminHome'])->name('dashboard');

  //Users
  Route::get('users', [AllUserController::class, 'index'])->name('users');
  Route::get('adduser', [AllUserController::class, 'add'])->name('adduser');
  Route::post('storeuser', [AllUserController::class, 'store'])->name('storeuser');
  Route::post('deleteuser', [AllUserController::class, 'deletemultiuser'])->name('deleteuser');
  Route::get('edituser/{id}', [AllUserController::class, 'edit'])->name('edituser');
  Route::post('updateusers', [AllUserController::class, 'update'])->name('updateusers');

  Route::get('profile/{id}', [AllUserController::class, 'userprofile'])->name('profile');
  Route::post('updateuserprofile', [AllUserController::class, 'updateprofile'])->name('updateuserprofile');


        // Permissions
        Route::get('permissions', [PermissionController::class, 'index'])->name('permissions');
        Route::post('storerelation', [PermissionController::class, 'storerelation'])->name('storerelation');


  // Users Group
  Route::get('usersgroup', [UserGroupController::class, 'index'])->name('usersgroup');
  Route::get('addusergroup', [UserGroupController::class, 'add'])->name('addusergroup');
  Route::post('storeusergroup', [UserGroupController::class, 'store'])->name('storeusergroup');
  Route::post('deleteusersgroup', [UserGroupController::class, 'deletemultiusergroup'])->name('deleteusersgroup');
  Route::get('editusersgroup/{id}', [UserGroupController::class, 'edit'])->name('editusersgroup');
  Route::post('updateusersgroup', [UserGroupController::class, 'update'])->name('updateusersgroup');

        // Category
        Route::post('categoryinsert', [CategoryController::class, 'categoryinsert'])->name('categoryinsert');
        Route::get('category', [CategoryController::class, 'index'])->name('category');
        Route::get('newcategory', [CategoryController::class, 'newcategory'])->name('newcategory');
        Route::get('getcategory', [CategoryController::class, 'getcategory'])->name('getcategory');
        Route::post('deleteCategory', [CategoryController::class, 'deleteCategory'])->name('deleteCategory');
        Route::get('categoryedit/{id}', [CategoryController::class, 'categoryedit'])->name('categoryedit');
        Route::post('categoryupdate/', [CategoryController::class, 'categoryupdate'])->name('categoryupdate');

  //Products
  Route::get('productlist', [ProductController::class, 'productlist'])->name('productlist');
  Route::get('addproduct', [ProductController::class, 'index'])->name('addproduct');
  Route::get('option', [ProductController::class, 'option'])->name('option');

  //Recurring Profiles
  Route::get('recurringprofiles', [RecurringProfilesController::class, 'recurring'])->name('recurringprofiles');

  //Filters
  Route::get('filter', [FiltersController::class, 'filters'])->name('filter');

  //Manufacturers
  Route::get('manufacturer', [ManufacturersController::class, 'manufacturer'])->name('manufacturer');

  //Downloads
  Route::get('download', [DownloadsController::class, 'download'])->name('download');

  //Reviews
  Route::get('review', [ReviewsController::class, 'reviews'])->name('review');
});
