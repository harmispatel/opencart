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
use App\Http\Controllers\CouponController;
use App\Http\Controllers\FreeItemController;
use App\Http\Controllers\GallaryController;
use App\Http\Controllers\LayoutController;
use App\Http\Controllers\LoyaltyController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\NewOrderController;
use App\Http\Controllers\ProductIconsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\VoucherController;
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
    Route::get('getcustomers', [CustomerController::class, 'getcustomers'])->name('getcustomers');
    Route::get('addcustomer', [CustomerController::class, 'add'])->name('addcustomer');
    Route::post('storecustomer', [CustomerController::class, 'store'])->name('storecustomer');
    Route::post('deletecustomer', [CustomerController::class, 'delete'])->name('deletecustomer');
    Route::get('editcustomer/{id}', [CustomerController::class, 'edit'])->name('editcustomer');
    Route::post('updatecustomer', [CustomerController::class, 'update'])->name('updatecustomer');
    Route::post('updatecustomer', [CustomerController::class, 'update'])->name('updatecustomer');
    Route::post('getRegionbyCountry', [CustomerController::class, 'getRegionbyCountry'])->name('getRegionbyCountry');


    // User Profile
    Route::get('profile/{id}', [AllUserController::class, 'userprofile'])->name('profile');
    Route::post('updateuserprofile', [AllUserController::class, 'updateprofile'])->name('updateuserprofile');


    // Permissions
    Route::get('permissions', [PermissionController::class, 'index'])->name('permissions');
    Route::post('storerelation', [PermissionController::class, 'storerelation'])->name('storerelation');


    // Category
    Route::get('category', [CategoryController::class, 'index'])->name('category');
    Route::get('getcategory', [CategoryController::class, 'getcategory'])->name('getcategory');
    Route::get('bulkcategory', [CategoryController::class, 'bulkcategory'])->name('bulkcategory');
    Route::post('categoryinsert', [CategoryController::class, 'categoryinsert'])->name('categoryinsert');
    Route::get('newcategory', [CategoryController::class, 'newcategory'])->name('newcategory');
    Route::get('categoryedit/{id}', [CategoryController::class, 'categoryedit'])->name('categoryedit');
    Route::post('categoryupdate/', [CategoryController::class, 'categoryupdate'])->name('categoryupdate');
    Route::post('categorydelete/', [CategoryController::class, 'categorydelete'])->name('categorydelete');

    //Products
    Route::get('products', [ProductController::class, 'index'])->name('products');
    Route::get('bulkproducts', [ProductController::class, 'bulkproducts'])->name('bulkproducts');
    Route::get('importproducts', [ProductController::class, 'importproducts'])->name('importproducts');
    Route::get('getproduct', [ProductController::class, 'getproduct'])->name('getproduct');
    Route::post('getproductbycategory', [ProductController::class, 'getproductbycategory'])->name('getproductbycategory');
    Route::get('addproduct', [ProductController::class, 'add'])->name('addproduct');
    Route::post('getoptionhtml', [ProductController::class, 'getoptionhtml'])->name('getoptionhtml');
    Route::get('getproductsearch', [ProductController::class, 'searchproduct'])->name('getproductsearch');
    Route::post('deleteproduct', [ProductController::class, 'deleteproduct'])->name('deleteproduct');
    Route::post('storeproduct',[ProductController::class, 'store'])->name('storeproduct');
    Route::post('addOptionValue', [ProductController::class, 'addOptionValue'])->name('addOptionValue');


    //Orders
    Route::get('orders', [OrdersController::class, 'index'])->name('orders');
    Route::get('ordersinsert', [OrdersController::class, 'ordersinsert'])->name('ordersinsert');
    Route::get('getorders', [OrdersController::class, 'getorders'])->name('getorders');
    Route::get('vieworder/{id}', [OrdersController::class, 'vieworder'])->name('vieworder');
    Route::get('editorder', [OrdersController::class, 'editorder'])->name('editorder');
    Route::post('updateorder', [OrdersController::class, 'updateorder'])->name('updateorder');
    Route::post('deleteorder', [OrdersController::class, 'deleteorder'])->name('deleteorder');
    Route::get('orderdata/{id}', [OrdersController::class, 'getorderhistory'])->name('orderdata');
    Route::post('orderhistory', [OrdersController::class, 'orderhistoryinsert'])->name('orderhistory');
    Route::get('invoice/{id}', [OrdersController::class, 'invoice'])->name('invoice');
    Route::get('shipping/{id}', [OrdersController::class, 'shipping'])->name('shipping');
    Route::get('getcustomername', [OrdersController::class, 'getcustomername'])->name('getcustomername');

    // Order returns
    Route::get('returns', [OrdersController::class, 'returns'])->name('returns');
    Route::get('addnewreturns', [OrdersController::class, 'addnewreturns'])->name('addnewreturns');
    Route::post('getcustomer', [OrdersController::class, 'getcustomer'])->name('getcustomer');
    Route::post('returnform', [OrdersController::class, 'returnform'])->name('returnform');
    // Route::post('getoptionhtml', [ProductController::class, 'getoptionhtml'])->name('getoptionhtml');

    // Oto complete customer
    // Route::get('autocomcustomer', [autocomplete::class, 'autocomcustomer'])->name('autocomplete');
    // Route::get('/autocomplete-search', [autocomplete::class, 'autocompleteSearch']);



    // Attributes
    Route::get('addAttribute',[AttributesController::class,'index'])->name('addAttribute');
    Route::get('attribute', [AttributesController::class, 'attribute'])->name('attribute');
    Route::get('attributegroup', [AttributesController::class, 'attributegroup'])->name('attributegroup');
    Route::get('addAttributeGroup', [AttributesController::class, 'index1'])->name('addAttributeGroup');



    //Menu Options
    Route::get('menuoptions', [OptionController::class, 'index'])->name('menuoptions');

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
    Route::post('deletecountry', [CountryController::class, 'deletecountry'])->name('deletecounty');
    Route::get('editcountry/{id}', [CountryController::class, 'edit'])->name('editcountry');
    Route::post('updatecountry', [CountryController::class, 'update'])->name('updatecountry');


    // Transactions
    Route::get('transactions', [TransactionsController::class, 'index'])->name('transactions');


    // New Order
    Route::get('neworders', [NewOrderController::class, 'index'])->name('neworders');

    // Loyalty
    Route::get('loyalty', [LoyaltyController::class, 'index'])->name('loyalty');

    // Coupons
    Route::get('coupons', [CouponController::class, 'index'])->name('coupons');

    // Vouchers
    Route::get('giftvoucher', [VoucherController::class, 'giftvoucher'])->name('giftvoucher');
    Route::get('vouchertheme', [VoucherController::class, 'vouchertheme'])->name('vouchertheme');

    // Free Item
    Route::get('freeitems', [FreeItemController::class, 'freeitems'])->name('freeitems');
    Route::get('cartrule', [FreeItemController::class, 'cartrule'])->name('cartrule');

    // Gallary
    Route::get('gallarysettings', [GallaryController::class, 'gallarysettings'])->name('gallarysettings');
    Route::get('uploadgallary', [GallaryController::class, 'uploadgallary'])->name('uploadgallary');

    // Layouts
    Route::get('templatesettings', [LayoutController::class, 'templatesettings'])->name('templatesettings');
    Route::get('slidersettings', [LayoutController::class, 'slidersettings'])->name('slidersettings');
    Route::get('bannerandblocks', [LayoutController::class, 'bannerandblocks'])->name('bannerandblocks');

    // Messages
    Route::get('messages', [MessageController::class, 'index'])->name('messages');
    Route::get('sendmessages', [MessageController::class, 'add'])->name('sendmessages');

    // Settings
    Route::get('mapandcategory', [SettingsController::class, 'mapandcategory'])->name('mapandcategory');
    Route::get('shopsettings', [SettingsController::class, 'shopsettings'])->name('shopsettings');
    Route::get('appsettings', [SettingsController::class, 'appsettings'])->name('appsettings');
    Route::get('openclosetime', [SettingsController::class, 'openclosetime'])->name('openclosetime');
    Route::get('deliverycollectionsetting', [SettingsController::class, 'deliverycollectionsetting'])->name('deliverycollectionsetting');
    Route::get('paymentsettings', [SettingsController::class, 'paymentsettings'])->name('paymentsettings');
    Route::get('sociallinks', [SettingsController::class, 'sociallinks'])->name('sociallinks');

    // Product icons
    Route::get('producticons', [ProductIconsController::class, 'index'])->name('producticons');

});
