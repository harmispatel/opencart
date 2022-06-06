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
use App\Http\Controllers\Frontend\ContactUsController;
use App\Http\Controllers\Frontend\CustomerAuthController;
use App\Http\Controllers\GallaryController;
use App\Http\Controllers\LayoutController;
use App\Http\Controllers\LoyaltyController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\NewOrderController;
use App\Http\Controllers\ProductIconsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\MyBasketController;
use App\Http\Controllers\Frontend\Cartcontroller;
use App\Http\Controllers\Frontend\CustomerOrder;
use Illuminate\Support\Facades\Auth;

//frontend
use App\Http\Controllers\Frontend\HomeController as HomeControllerFront;
use App\Http\Controllers\Frontend\MemberController;
use App\Http\Controllers\Frontend\MenuController;
use App\Http\Controllers\Frontend\ReservationController;

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



Auth::routes();

Route::get('/logout', [LoginController::class, 'logout']);
Route::get('admin', [HomeController::class, 'adminLogin'])->name('admin');
Route::get('login', [HomeController::class, 'adminLogin'])->name('login');
// Route::get('/home', [HomeController::class, 'index'])->name('home');


// Group
Route::group(['middleware' => 'AuthUser'], function () {

    // Dashboard
    Route::get('dashboard', [HomeController::class, 'adminHome'])->name('dashboard');

    Route::post('setStore', [HomeController::class, 'setStore'])->name('setStore');


    // Create store
    Route::get('createstore', [SettingsController::class, 'createstore'])->name('createstore');
    Route::post('savestoredata', [SettingsController::class, 'savestoredata'])->name('savestoredata');

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
    // Route::post('getRegionbyCountry', [CustomerController::class, 'getRegionbyCountry'])->name('getRegionbyCountry');
    Route::post('getcustomerhistory', [CustomerController::class, 'getcustomerhistory'])->name('getcustomerhistory');
    Route::post('storecustomerhistory', [CustomerController::class, 'storecustomerhistory'])->name('storecustomerhistory');
    Route::post('getcustomertransactions', [CustomerController::class, 'getcustomertransactions'])->name('getcustomertransactions');
    Route::post('storecustomertransaction', [CustomerController::class, 'storecustomertransaction'])->name('storecustomertransaction');
    Route::post('getcustomerrewardpoints', [CustomerController::class, 'getcustomerrewardpoints'])->name('getcustomerrewardpoints');
    Route::post('storecustomerrewardpoint', [CustomerController::class, 'storecustomerrewardpoint'])->name('storecustomerrewardpoint');
    Route::post('delCustomerAddress', [CustomerController::class, 'delCustomerAddress'])->name('delCustomerAddress');
    Route::post('addcustomerbanip', [CustomerController::class, 'addcustomerbanip'])->name('addcustomerbanip');
    Route::post('removecustomerbanip', [CustomerController::class, 'removecustomerbanip'])->name('removecustomerbanip');


    // User Profile
    Route::get('profile/{id}', [AllUserController::class, 'userprofile'])->name('profile');
    Route::post('updateuserprofile', [AllUserController::class, 'updateprofile'])->name('updateuserprofile');


    // Permissions
    Route::get('permissions', [PermissionController::class, 'index'])->name('permissions');
    Route::post('storerelation', [PermissionController::class, 'storerelation'])->name('storerelation');


    // Category
    Route::get('category', [CategoryController::class, 'index'])->name('category');
    Route::post('getcategory', [CategoryController::class, 'getcategory'])->name('getcategory');
    Route::get('bulkcategory', [CategoryController::class, 'bulkcategory'])->name('bulkcategory');
    Route::post('storebulkcategory', [CategoryController::class, 'storebulkcategory'])->name('storebulkcategory');
    Route::post('categoryinsert', [CategoryController::class, 'categoryinsert'])->name('categoryinsert');
    Route::get('newcategory', [CategoryController::class, 'newcategory'])->name('newcategory');
    Route::get('categoryedit/{id}', [CategoryController::class, 'categoryedit'])->name('categoryedit');
    Route::post('categoryupdate', [CategoryController::class, 'categoryupdate'])->name('categoryupdate');
    Route::post('categorydelete', [CategoryController::class, 'categorydelete'])->name('categorydelete');
    Route::post('delOptionSize', [CategoryController::class, 'delOptionSize'])->name('delOptionSize');

    //Products
    Route::get('products', [ProductController::class, 'index'])->name('products');
    Route::get('bulkproducts', [ProductController::class, 'bulkproducts'])->name('bulkproducts');
    Route::post('storebulkproduct',[ProductController::class, 'storebulkproduct'])->name('storebulkproduct');
    Route::post('getcategoryproduct', [ProductController::class, 'getcategoryproduct'])->name('getcategoryproduct');
    Route::get('importproducts', [ProductController::class, 'importproducts'])->name('importproducts');
    Route::post('getproduct', [ProductController::class, 'getproduct'])->name('getproduct');
    Route::post('getproductbycategory', [ProductController::class, 'getproductbycategory'])->name('getproductbycategory');
    Route::get('addproduct', [ProductController::class, 'add'])->name('addproduct');
    Route::post('getoptionhtml', [ProductController::class, 'getoptionhtml'])->name('getoptionhtml');
    Route::get('getproductsearch', [ProductController::class, 'searchproduct'])->name('getproductsearch');
    Route::post('deleteproduct', [ProductController::class, 'deleteproduct'])->name('deleteproduct');
    Route::post('storeproduct',[ProductController::class, 'store'])->name('storeproduct');
    Route::get('editproduct/{id}', [ProductController::class, 'edit'])->name('editproduct');
    Route::post('addOptionValue', [ProductController::class, 'addOptionValue'])->name('addOptionValue');
    Route::post('updateproduct',[ProductController::class, 'update'])->name('updateproduct');



    //Orders
    Route::get('orders', [OrdersController::class, 'index'])->name('orders');
    Route::get('ordersinsert', [OrdersController::class, 'ordersinsert'])->name('ordersinsert');
    Route::post('getorders', [OrdersController::class, 'getorders'])->name('getorders');
    Route::get('vieworder/{id}', [OrdersController::class, 'vieworder'])->name('vieworder');
    Route::get('editorder', [OrdersController::class, 'editorder'])->name('editorder');
    Route::post('updateorder', [OrdersController::class, 'updateorder'])->name('updateorder');
    Route::post('deleteorder', [OrdersController::class, 'deleteorder'])->name('deleteorder');
    Route::get('orderdata/{id}', [OrdersController::class, 'getorderhistory'])->name('orderdata');
    Route::post('orderhistory', [OrdersController::class, 'orderhistoryinsert'])->name('orderhistory');
    Route::get('invoice/{id}', [OrdersController::class, 'invoice'])->name('invoice');
    Route::get('shipping/{id}', [OrdersController::class, 'shipping'])->name('shipping');
    Route::get('getproducts/{id}', [OrdersController::class, 'getproducts'])->name('getproducts');
    Route::post('addneworders', [OrdersController::class, 'addneworders'])->name('addneworders');
    Route::post('generateinvoice', [OrdersController::class, 'generateinvoice'])->name('generateinvoice');
    Route::get('autocompleteproduct', [OrdersController::class, 'autocompleteproduct'])->name('autocompleteproduct');
    Route::get('autocomplete', [OrdersController::class, 'autocomplete'])->name('autocomplete');
    // Route::get('getaddress/{id}', [OrdersController::class, 'getaddress'])->name('getaddress');
    Route::get('payment_and_shipping_address/{id}', [OrdersController::class, 'payment_and_shipping_address'])->name('payment_and_shipping_address');

    // Order returns
    Route::get('returns', [OrdersController::class, 'returns'])->name('returns');
    Route::get('addnewreturns', [OrdersController::class, 'addnewreturns'])->name('addnewreturns');
    Route::post('getcustomer', [OrdersController::class, 'getcustomer'])->name('getcustomer');
    Route::post('returnform', [OrdersController::class, 'returnform'])->name('returnform');
    // Route::post('getoptionhtml', [ProductController::class, 'getoptionhtml'])->name('getoptionhtml');
    Route::post('getcustomer', [OrdersController::class, 'getcustomer'])->name('getcustomer');






    // Attributes
    Route::get('addAttribute',[AttributesController::class,'index'])->name('addAttribute');
    Route::get('attribute', [AttributesController::class, 'attribute'])->name('attribute');
    Route::get('attributegroup', [AttributesController::class, 'attributegroup'])->name('attributegroup');
    Route::get('addAttributeGroup', [AttributesController::class, 'index1'])->name('addAttributeGroup');



    //Menu Options
    Route::get('menuoptions', [OptionController::class, 'index'])->name('menuoptions');
    Route::get('addmenuoptions', [OptionController::class, 'add'])->name('addmenuoptions');
    Route::post('newmodel', [OptionController::class, 'newmodel'])->name('newmodel');
    Route::post('gettoppings', [OptionController::class, 'gettoppings'])->name('gettoppings');
    Route::post('inserttopping', [OptionController::class, 'insert'])->name('inserttopping');
    Route::post('deletetopping', [OptionController::class, 'delete'])->name('deletetopping');
    Route::get('edittopping/{id}', [OptionController::class, 'edit'])->name('edittopping');
    Route::post('updatetopping', [OptionController::class, 'update'])->name('updatetopping');
    Route::post('delToppingOption', [OptionController::class, 'delToppingOption'])->name('delToppingOption');
    Route::post('storemapping', [OptionController::class, 'storemapping'])->name('storemapping');
    Route::post('editmapping', [OptionController::class, 'editmapping'])->name('editmapping');
    Route::post('updatemapping', [OptionController::class, 'updatemapping'])->name('updatemapping');
    Route::post('deletemapping', [OptionController::class, 'deletemapping'])->name('deletemapping');


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
    // Route::get('addreview',[ReviewsController::class,'add'])->name('addreview');
    Route::post('storereview',[ReviewsController::class,'store'])->name('storereview');
    // Route::post('deletereview',[ReviewsController::class,'deletemultireview'])->name('deletereview');
    // Route::get('editreview/{id}',[ReviewsController::class,'edit'])->name('editreview');
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
    Route::post('daterange', [TransactionsController::class, 'getdaterange'])->name('daterange');


    // New Order
    Route::get('neworders', [NewOrderController::class, 'index'])->name('neworders');

    // Loyalty
    Route::get('loyalty', [LoyaltyController::class, 'index'])->name('loyalty');
    Route::post('storeloyalty', [LoyaltyController::class, 'store'])->name('storeloyalty');

    // Coupons
    Route::get('coupons', [CouponController::class, 'index'])->name('coupons');
    Route::get('addcoupon', [CouponController::class, 'addcoupon'])->name('addcoupon');
    Route::get('editcoupon/{id}', [CouponController::class, 'editcoupon'])->name('editcoupon');
    Route::post('insertcoupon', [CouponController::class, 'insertcoupon'])->name('insertcoupon');
    Route::post('coupondelete', [CouponController::class, 'coupondelete'])->name('coupondelete');
    Route::post('couponupdate', [CouponController::class, 'couponupdate'])->name('couponupdate');
    Route::get('searchproduct', [CouponController::class, 'products'])->name('searchproduct');
    Route::get('searchcategory', [CouponController::class, 'searchcategory'])->name('searchcategory');
    Route::POST('getallcouponhistory', [CouponController::class, 'gegetallcouponhistorytallcouponhistory'])->name('getallcouponhistory');
    Route::POST('updonoff', [CouponController::class, 'updonoff'])->name('updonoff');
    // Route::post('updonoff', [CouponController::class, 'updonoff'])->name('updonoff');

    // Vouchers
    Route::get('giftvoucher', [VoucherController::class, 'giftvoucher'])->name('giftvoucher');
    Route::get('vouchertheme', [VoucherController::class, 'vouchertheme'])->name('vouchertheme');
    Route::post('voucherinsert', [VoucherController::class, 'voucherinsert'])->name('voucherinsert');
    Route::get('voucherlist', [VoucherController::class, 'voucherlist'])->name('voucherlist');
    Route::get('voucheredit/{id}', [VoucherController::class, 'voucheredit'])->name('voucheredit');
    Route::get('sendvouchercode/{id}', [VoucherController::class, 'sendvouchercode'])->name('sendvouchercode');
    Route::post('voucherdelete', [VoucherController::class, 'voucherdelete'])->name('voucherdelete');
    Route::post('voucherupdate', [VoucherController::class, 'voucherupdate'])->name('voucherupdate');
    Route::get('voucherthemeinsert', [VoucherController::class, 'voucherthemeinsert'])->name('voucherthemeinsert');
    Route::post('voucherthemeinsert', [VoucherController::class, 'voucherthemestore'])->name('voucherthemeinsert');
    Route::get('voucherthemelist', [VoucherController::class, 'voucherthemeshow'])->name('voucherthemelist');
    Route::get('voucherthemeedit/{id}', [VoucherController::class, 'voucherthemeedit'])->name('voucherthemeedit');
    Route::post('voucherthemeupdate', [VoucherController::class, 'voucherthemeupdate'])->name('voucherthemeupdate');
    Route::post('voucherthemedelete', [VoucherController::class, 'voucherthemedelete'])->name('voucherthemedelete');

    // Free Item
    Route::get('freeitems', [FreeItemController::class, 'freeitems'])->name('freeitems');
    Route::get('addfreeitems', [FreeItemController::class, 'addfreeitems'])->name('addfreeitems');
    Route::post('freeiteminsert',[FreeItemController::class, 'freeiteminsert'])->name('freeiteminsert');
    Route::get('freeitemlist', [FreeItemController::class, 'freeitemlist'])->name('freeitemlist');
    Route::get('freeitemedit/{id}', [FreeItemController::class, 'freeitemedit'])->name('freeitemedit');
    Route::post('freeitemdelete', [FreeItemController::class, 'freeitemdelete'])->name('freeitemdelete');
    Route::post('freeitemupdate/{id}', [FreeItemController::class, 'freeitemupdate'])->name('freeitemupdate');

    // Cart Rule
    Route::get('cartrule', [FreeItemController::class, 'cartrule'])->name('cartrule');
    Route::get('addfreerule', [FreeItemController::class, 'addfreerule'])->name('addfreerule');
    Route::get('editfreerule/{id}', [FreeItemController::class, 'editfreerule'])->name('editfreerule');
    Route::post('cartruleinsert', [FreeItemController::class, 'cartruleinsert'])->name('cartruleinsert');
    Route::post('cartruleupdate', [FreeItemController::class, 'cartruleupdate'])->name('cartruleupdate');
    Route::post('cartruledelete', [FreeItemController::class, 'cartruledelete'])->name('cartruledelete');

    // Gallary
    Route::get('gallarysettings', [GallaryController::class, 'gallarysettings'])->name('gallarysettings');
    Route::post('storeGallary',[GallaryController::class, 'store'])->name('storeGallary');
    Route::post('gallarysettingsstore',[GallaryController::class, 'gallarysettingsstore'])->name('gallarysettingsstore');


    // Layouts
    Route::get('templatesettings', [LayoutController::class, 'templatesettings'])->name('templatesettings');
    Route::post('updateTemplateSetting', [LayoutController::class, 'updateTemplateSetting'])->name('updateTemplateSetting');

    Route::get('slidersettings', [LayoutController::class, 'slidersettings'])->name('slidersettings');
    Route::get('bannerandblocks', [LayoutController::class, 'bannerandblocks'])->name('bannerandblocks');
    Route::get('activetheme/{id}', [LayoutController::class, 'activetheme'])->name('activetheme');

    // Messages
    Route::get('messages', [MessageController::class, 'index'])->name('messages');
    Route::get('sendmessages', [MessageController::class, 'add'])->name('sendmessages');
    Route::get('getmessage', [MessageController::class, 'getmessage'])->name('getmessage');
    Route::post('messageinsert', [MessageController::class, 'messageinsert'])->name('messageinsert');

    // Settings
    Route::get('mapandcategory', [SettingsController::class, 'mapandcategory'])->name('mapandcategory');
    Route::post('geteditregionbycountry', [SettingsController::class, 'geteditregionbycountry'])->name('geteditregionbycountry');
    Route::post('getregionbycountry', [SettingsController::class, 'getregionbycountry'])->name('getregionbycountry');
    Route::post('updatemapandcategory', [SettingsController::class, 'updatemapandcategory'])->name('updatemapandcategory');
    Route::get('shopsettings', [SettingsController::class, 'shopsettings'])->name('shopsettings');
    Route::get('appsettings', [SettingsController::class, 'appsettings'])->name('appsettings');
    Route::post('updateappsettings', [SettingsController::class, 'updateappsettings'])->name('updateappsettings');
    Route::get('openclosetime', [SettingsController::class, 'openclosetime'])->name('openclosetime');
    Route::post('openclosetimeset', [SettingsController::class, 'openclosetimeset'])->name('openclosetimeset');
    Route::get('daytime', [SettingsController::class, 'daytime'])->name('daytime');

    Route::get('deliverycollectionsetting', [SettingsController::class, 'deliverycollectionsetting'])->name('deliverycollectionsetting');
    Route::get('paymentsettings', [SettingsController::class, 'paymentsettings'])->name('paymentsettings');
    Route::get('sociallinks', [SettingsController::class, 'sociallinks'])->name('sociallinks');
    Route::post('updatesociallinks', [SettingsController::class, 'updatesociallinks'])->name('updatesociallinks');
    Route::post('calculateDistance', [SettingsController::class, 'calculateDistance'])->name('calculateDistance');
    Route::post('addGroup', [SettingsController::class, 'addGroup'])->name('addGroup');
    Route::post('deleteGroup', [SettingsController::class, 'deleteGroup'])->name('deleteGroup');
    Route::post('manageDeliveryCollection', [SettingsController::class, 'manageDeliveryCollection'])->name('manageDeliveryCollection');

    // Product icons
    Route::get('producticons', [ProductIconsController::class, 'index'])->name('producticons');
    Route::get('addproducticon', [ProductIconsController::class, 'add'])->name('addproducticon');
    Route::post('storeproducticons', [ProductIconsController::class, 'store'])->name('storeproducticons');
    Route::post('deleteproducticons', [ProductIconsController::class, 'delete'])->name('deleteproducticons');
    Route::get('editproducticons/{id}', [ProductIconsController::class, 'edit'])->name('editproducticons');
    Route::post('updateproducticons', [ProductIconsController::class, 'update'])->name('updateproducticons');

    //option
    Route::get('option', [OptionController::class, 'index'])->name('option');


    //Upload Gallary
    Route::group(['prefix' => 'uploadgallary','as'=>'n','middleware' => ['web']], function (){
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });
});


// ---------------------------------------------------------------------------------------------
// FRONTEND
Route::get('/', [HomeControllerFront::class, 'index'])->name('home');
Route::get('menu', [MenuController::class, 'index'])->name('menu');
Route::post('setDeliveyType', [MenuController::class, 'setDeliveyType'])->name('setDeliveyType');
Route::post('getid', [MenuController::class, 'addToCart'])->name('getid');
Route::post('deletecartproduct', [MenuController::class, 'deletecartproduct'])->name('deletecartproduct');
Route::post('reservation', [ReservationController::class, 'index'])->name('reservation');
Route::get('checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::post('voucher', [CheckoutController::class, 'voucher'])->name('voucher');
Route::post('checkZipCode', [HomeControllerFront::class, 'checkZipCode'])->name('checkZipCode');
Route::post('postcodes', [HomeControllerFront::class, 'postcodes'])->name('postcodes');
Route::get('success', [MyBasketController::class, 'success'])->name('success');
Route::get('cart', [Cartcontroller::class, 'cart'])->name('cart');


// Get state by conrty
Route::post('getRegionbyCountry', [CustomerController::class, 'getRegionbyCountry'])->name('getRegionbyCountry');

// Get customer Address
Route::get('getaddress/{id}', [OrdersController::class, 'getaddress'])->name('getaddress');
Route::get('getcustomeraddress/{id}', [CheckoutController::class, 'getcustomeraddress'])->name('getcustomeraddress');




// Member
Route::get('member', [MemberController::class, 'member'])->name('member');
Route::get('memberregister', [MemberController::class, 'memberregister'])->name('memberregister');
Route::get('addnewaddress', [MemberController::class, 'addnewaddress'])->name('addnewaddress');
Route::post('newaddress', [MemberController::class, 'newaddress'])->name('newaddress');
Route::post('changeDefAddress', [MemberController::class, 'changeDefAddress'])->name('changeDefAddress');
Route::get('customeraddressdelete/{id}', [MemberController::class, 'customeraddressdelete'])->name('customeraddressdelete');
Route::get('customeraddressedit/{id}', [MemberController::class, 'customeraddressedit'])->name('customeraddressedit');
Route::post('updatecustomeraddress', [MemberController::class, 'updatecustomeraddress'])->name('updatecustomeraddress');
Route::post('getcustomerorderdetail', [MemberController::class, 'getcustomerorderdetail'])->name('getcustomerorderdetail');

// Order review send
Route::post('orderreviwe',[MemberController::class , 'orderreviwe'])->name('orderreviwe');

// Order
Route::post('confirmorder', [CustomerOrder::class, 'confirmorder'])->name('confirmorder');
Route::post('customerdeliveryaddress', [CustomerOrder::class, 'customerdeliveryaddress'])->name('customerdeliveryaddress');
Route::post('checkorderstatus', [CustomerOrder::class, 'checkorderstatus'])->name('checkorderstatus');

// customer
Route::post('customerlogin', [CustomerAuthController::class, 'customerlogin'])->name('customerlogin');
Route::post('customerregister', [CustomerAuthController::class, 'customerregister'])->name('customerregister');
Route::post('customerlogout', [CustomerAuthController::class, 'customerlogout'])->name('customerlogout');
Route::post('customerdetailupdate', [CustomerAuthController::class, 'customerdetailupdate'])->name('customerdetailupdate');


// Guest User
Route::post('registerguestuser', [CustomerAuthController::class, 'registerguestuser'])->name('registerguestuser');

//  coupon
Route::post('coupon', [CheckoutController::class, 'coupon'])->name('coupon');
Route::post('getcoupon', [MenuController::class, 'getcoupon'])->name('getcoupon');
Route::get('searchcouponcode', [MenuController::class, 'searchcouponcode'])->name('searchcouponcode');

// Guest User
Route::get('contact',[ContactUsController::class, 'index'])->name('contact');
Route::post('contactstore',[ContactUsController::class,'contactstore'])->name('contactstore');
