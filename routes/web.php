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
use App\Http\Controllers\InformationController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\AttributesController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\CustomerGroupController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CountryController;
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

    // Users Group
    Route::get('usersgroup', [UserGroupController::class, 'index'])->name('usersgroup');
    Route::get('addusergroup', [UserGroupController::class, 'add'])->name('addusergroup');
    Route::post('storeusergroup', [UserGroupController::class, 'store'])->name('storeusergroup');
    Route::post('deleteusersgroup', [UserGroupController::class, 'deletemultiusergroup'])->name('deleteusersgroup');
    Route::get('editusersgroup/{id}', [UserGroupController::class, 'edit'])->name('editusersgroup');
    Route::post('updateusersgroup', [UserGroupController::class, 'update'])->name('updateusersgroup');

    // Customer Group
    Route::get('customersgroup', [CustomerGroupController::class, 'index'])->name('customersgroup');
    Route::get('addcustomergroup', [CustomerGroupController::class, 'add'])->name('addcustomergroup');
    Route::post('storecustomergroup', [CustomerGroupController::class, 'store'])->name('storecustomergroup');
    Route::post('deletecustomergroup', [CustomerGroupController::class, 'delete'])->name('deletecustomergroup');
    Route::get('editcustomergroup/{id}', [CustomerGroupController::class, 'edit'])->name('editcustomergroup');
    Route::post('updatecustomergroup', [CustomerGroupController::class, 'update'])->name('updatecustomergroup');

    //Customers
    Route::get('customers', [CustomerController::class, 'index'])->name('customers');
    Route::get('addcustomer', [CustomerController::class, 'add'])->name('addcustomer');
    Route::post('storecustomer', [CustomerController::class, 'store'])->name('storecustomer');
    Route::post('deletecustomer', [CustomerController::class, 'delete'])->name('deletecustomer');
    Route::get('editcustomer/{id}', [CustomerController::class, 'edit'])->name('editcustomer');
    Route::post('updatecustomer', [CustomerController::class, 'update'])->name('updatecustomer');

    // User Profile
    Route::get('profile/{id}', [AllUserController::class, 'userprofile'])->name('profile');
    Route::post('updateuserprofile', [AllUserController::class, 'updateprofile'])->name('updateuserprofile');


    // Permissions
    Route::get('permissions', [PermissionController::class, 'index'])->name('permissions');
    Route::post('storerelation', [PermissionController::class, 'storerelation'])->name('storerelation');


    // Category
    Route::post('categoryinsert', [CategoryController::class, 'categoryinsert'])->name('categoryinsert');
    Route::get('category', [CategoryController::class, 'index'])->name('category');
    Route::get('newcategory', [CategoryController::class, 'newcategory'])->name('newcategory');
    Route::get('categoryedit/{id}', [CategoryController::class, 'categoryedit'])->name('categoryedit');
    Route::post('categoryupdate/', [CategoryController::class, 'categoryupdate'])->name('categoryupdate');
    Route::post('categorydelete/', [CategoryController::class, 'categorydelete'])->name('categorydelete');

    //Products
    Route::get('products', [ProductController::class, 'index'])->name('products');
    Route::get('addproduct', [ProductController::class, 'add'])->name('addproduct');
    Route::post('getoptionhtml', [ProductController::class, 'getoptionhtml'])->name('getoptionhtml');
     Route::get('getproductsearch', [ProductController::class, 'searchproduct'])->name('getproductsearch');

    Route::post('addOptionValue', [ProductController::class, 'addOptionValue'])->name('addOptionValue');


    //Orders
    Route::get('orders', [OrdersController::class, 'index'])->name('orders');
    Route::get('vieworder/{id}', [OrdersController::class, 'vieworder'])->name('vieworder');
    Route::get('editorder', [OrdersController::class, 'editorder'])->name('editorder');
    Route::post('updateorder', [OrdersController::class, 'updateorder'])->name('updateorder');
    Route::post('deleteorder', [OrdersController::class, 'deleteorder'])->name('deleteorder');
    Route::get('orderdata', [OrdersController::class, 'getorderhistory'])->name('orderdata');
    // Route::post('getoptionhtml', [ProductController::class, 'getoptionhtml'])->name('getoptionhtml');



    // Attributes
    Route::get('addAttribute',[AttributesController::class,'index'])->name('addAttribute');
    Route::get('attribute', [AttributesController::class, 'attribute'])->name('attribute');
    Route::get('attributegroup', [AttributesController::class, 'attributegroup'])->name('attributegroup');
    Route::get('addAttributeGroup', [AttributesController::class, 'index1'])->name('addAttributeGroup');



    //Options
    Route::get('addOption',[OptionController::class,'index'])->name('addOption');
    Route::get('option', [OptionController::class, 'options'])->name('option');

    //Recurring Profiles
    Route::get('recurringprofiles', [RecurringProfilesController::class, 'index'])->name('recurringprofiles');
    Route::get('addRecurring', [RecurringProfilesController::class, 'add'])->name('addRecurring');
    Route::post('addRecurring',[RecurringProfilesController::class, 'store'])->name('addRecurring');
    Route::post('deleterecurring', [RecurringProfilesController::class, 'deleterecurring'])->name('deleterecurring');
    Route::get('edit/{id}', [RecurringProfilesController::class, 'edit'])->name('edit');
    Route::post('updaterecurring',[RecurringProfilesController::class, 'update'])->name('updaterecurring');



    //Filters
    Route::get('filter', [FiltersController::class, 'index'])->name('filter');
    Route::get('addfilter', [FiltersController::class, 'add'])->name('addfilter');
    Route::post('storeFilter',[FiltersController::class, 'store'])->name('storeFilter');
    Route::get('editfilter/{id}',[FiltersController::class, 'edit'])->name('editfilter');
    Route::post('deletefilter',[FiltersController::class, 'delete'])->name('deletefilter');
    Route::post('updatefilter',[FiltersController::class,'update'])->name('updatefilter');

    // Route::get('showId',[FiltersController::class, 'showId'])->name('showId');




    //Manufacturers
    Route::get('manufacturer', [ManufacturersController::class, 'index'])->name('manufacturer');
    Route::get('addmanufacturer', [ManufacturersController::class, 'add'])->name('addmanufacturer');
    Route::post('storemanufacturer', [ManufacturersController::class, 'store'])->name('storemanufacturer');
    Route::post('deletemanufacturer', [ManufacturersController::class, 'deletemultimanufacturer'])->name('deletemanufacturer');
    Route::get('editmanufacturer/{id}', [ManufacturersController::class, 'edit'])->name('editmanufacturer');
    Route::post('updatemanufacturer', [ManufacturersController::class, 'update'])->name('updatemanufacturer');

    //Downloads
    Route::get('download', [DownloadsController::class, 'download'])->name('download');
    Route::get('addDownload',[DownloadsController::class,'index'])->name('addDownload');

    //Informations
    Route::get('information', [InformationController::class, 'index'])->name('information');
    Route::get('addinformation',[InformationController::class,'add'])->name('addinformation');
    Route::post('storeinformation',[InformationController::class,'store'])->name('storeinformation');
    Route::post('deleteinformation',[InformationController::class,'delete'])->name('deleteinformation');
    Route::get('editinformation/{id}', [InformationController::class, 'edit'])->name('editinformation');
    Route::post('updateinformation', [InformationController::class, 'update'])->name('updateinformation');


    //Reviews
    Route::get('review', [ReviewsController::class, 'index'])->name('review');
    Route::get('addreview',[ReviewsController::class,'add'])->name('addreview');
    Route::post('storereview',[ReviewsController::class,'store'])->name('storereview');
    Route::post('deletereview',[ReviewsController::class,'deletemultireview'])->name('deletereview');
    Route::get('editreview/{id}',[ReviewsController::class,'edit'])->name('editreview');
    Route::post('updatereview',[ReviewsController::class,'update'])->name('updatereview');

    // Countries
    Route::get('countries', [CountryController::class, 'index'])->name('countries');
    Route::get('addcountry', [CountryController::class, 'add'])->name('addcountry');
    Route::post('storecountry', [CountryController::class, 'store'])->name('storecountry');


});
