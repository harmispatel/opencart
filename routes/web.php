<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AllUserController;
use App\Http\Controllers\UserGroupController;
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

// Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('dashboard', [HomeController::class, 'adminHome'])->name('dashboard');


//Users
Route::get('users', [AllUserController::class, 'index'])->name('users');
Route::get('adduser', [AllUserController::class, 'add'])->name('adduser');
Route::post('storeuser', [AllUserController::class, 'store'])->name('storeuser');


// Users Group
Route::get('usersgroup', [UserGroupController::class, 'index'])->name('usersgroup');
Route::get('addusergroup', [UserGroupController::class, 'add'])->name('addusergroup');
Route::post('storeusergroup', [UserGroupController::class, 'store'])->name('storeusergroup');
Route::post('deleteusersgroup', [UserGroupController::class, 'deletemultiusergroup'])->name('deleteusersgroup');
Route::get('editusersgroup/{id}', [UserGroupController::class, 'edit'])->name('editusersgroup');
Route::post('updateusersgroup', [UserGroupController::class, 'update'])->name('updateusersgroup');

// Category
Route::post('categoryAdd', [CategoryController::class, 'categoryAdd'])->name('categoryAdd');
Route::get('category', [CategoryController::class, 'index'])->name('category');
Route::get('newcategory', [CategoryController::class, 'newcategory'])->name('newcategory');
Route::get('getcategory', [CategoryController::class, 'getcategory'])->name('getcategory');
Route::post('deleteCategory', [CategoryController::class, 'deleteCategory'])->name('deleteCategory');
