<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Orders;
use App\Models\Users;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        return view('admin.login');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        return view('home');
    }


    function adminLogin()
    {
        return view('admin.login');
    }


    public function adminHome(Request $request)
    {
        // current store id
        $current_store_id = currentStoreId();




        $user_details = user_details();

        if(isset($user_details))
        {
            $user_group_id = $user_details['user_group_id'];
        }
        $user_shop_id = $user_details['user_shop'];

        if($user_group_id == 1)
        {
            if($current_store_id == 0)
            {
                $customers = Customer::count();
                $product = Product::count();
                $categories = Category::count();
                $orders = Orders::count();
            }
            else
            {
                $customers = Customer::where('store_id',$current_store_id)->count();
                $product = Product::with(['hasOneProductToStore'])->whereHas('hasOneProductToStore',function($q) use($current_store_id)
                {
                    $q->where('store_id',$current_store_id);
                })->count();
                $categories = Category::with(['hasOneCategoryToStore'])->whereHas('hasOneCategoryToStore',function($q) use($current_store_id)
                {
                    $q->where('store_id',$current_store_id);
                })->count();
                $orders = Orders::where('store_id',$current_store_id)->count();
            }
        }
        else
        {
            $customers = Customer::where('store_id',$user_shop_id)->count();
            $product = Product::with(['hasOneProductToStore'])->whereHas('hasOneProductToStore',function($q) use($user_shop_id)
            {
                $q->where('store_id',$user_shop_id);
            })->count();
            $categories = Category::with(['hasOneCategoryToStore'])->whereHas('hasOneCategoryToStore',function($q) use($user_shop_id)
            {
                $q->where('store_id',$user_shop_id);
            })->count();
            $orders = Orders::where('store_id',$user_shop_id)->count();
        }


        return view('dashboard',['customers'=>$customers,'orders'=>$orders,'product'=>$product,'categories'=>$categories]);

    }

     public function getSalesReport(Request $request){

        $sales_reports=$request->SalesReport;
        $current_store_id = currentStoreId();

        switch ($sales_reports) {
            case 'day':
                $startDate = date('Y-m-d 00:00:00');
				$endDate = date('Y-m-d 23:59:59');
                $data=Orders::where('store_id',$current_store_id)->where('date_added','<=',$startDate)->get();
                print($data);
                break;
            case 'Yesterday':
                echo "Yesterday";
                $startDate = date('Y-m-d 00:00:00',strtotime("-1 days")); //date('Y-m-d 00:00:00');
				$endDate   = date('Y-m-d 23:59:59',strtotime("-1 days"));
                $data=Orders::where('store_id',$current_store_id)->where('date_added','>=',$startDate)->where('date_added','<=',$endDate)->get();
                print($data);
                break;
            case 'This Week':
                echo "This Week";
                break;
            case 'month':
                echo 'month';
                $startDate_this_month = date('Y-m-01 00:00:00'); // hard-coded '01' for first day
				$lastDate_this_month  = date('Y-m-t 23:59:59');
                $data=Orders::where('store_id',$current_store_id)->where('date_added','>=',$startDate_this_month)->where('date_added','<=',$lastDate_this_month)->get();
                print($data);
                break;

            case 'year':
                echo 'year';
                // $this_year_ini =date('Y-m-d', strtotime('first day of january this year'));
				// $this_year_end =date('Y-m-d', strtotime('last day of December this year'));

				// $this_year_strt = $this_year_ini->format('Y-m-d 00:00:00');
				// $this_year_end = $this_year_end->format('Y-m-d 23:59:59');
                break;

            case 'lastweek':
                echo 'lastweek';
                $previous_week = strtotime("-1 week +1 day");

				$start_week = strtotime("last monday midnight",$previous_week);
				$end_week = strtotime("next sunday",$start_week);

				$lst_monday = date("Y-m-d",$start_week);
				$lst_sunday = date("Y-m-d",$end_week);
                $data=Orders::where('store_id',$current_store_id)->where('date_added','>=',$lst_monday)->where('date_added','<=',$lst_sunday)->get();
                print($data);
                break;

            case 'lastmonth':
                echo 'lastmonth';
                // $month_ini = new DateTime("first day of last month");
				// $month_end = new DateTime("last day of last month");
				// $lst_month_strt = $month_ini->format('Y-m-d 00:00:00');
				// $lst_month_end = $month_end->format('Y-m-d 23:59:59');
                break;
            case 'lastyear':
                echo 'lastyear';
                // $year_ini = new DateTime('first day of January last year');
				// $year_end = new DateTime('last day of December last year');

				// $lst_year_strt = $year_ini->format('Y-m-d 00:00:00');
				// $lst_year_end = $year_end->format('Y-m-d 23:59:59');
                break;
            case 'alltime':
                echo "alltime";
            break;
            default:
                echo 0;
                break;
        }

     }

    function setStore(Request $request)
    {
        $storeId = $request->store_id;
        if($request->session()->has('store_id'))
        {
            $request->session()->forget('store_id');
            $request->session()->put('store_id', $storeId);
        }
        else
        {
            $request->session()->put('store_id', $storeId);
        }

        return response()->json([
            'success' => 1
        ]);
    }


}
