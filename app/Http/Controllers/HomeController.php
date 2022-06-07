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
        if(session()->has('password_hash_web'))
        {
            return redirect()->route('dashboard');
        }
        else
        {
            return view('admin.login');
        }
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

     public function getSalesReport(Request $request)
     {
        $range = 'year';
        $html = '';

		if(isset($request->SalesReport))
        {
			$range = $request->SalesReport;
		}

        $top_10 = getTopTenSales($range);

        if(count($top_10) > 0)
        {
            foreach($top_10 as $store)
            {
                $total_sale = isset($store->total_sale) ? $store->total_sale : 0;
                $order_count = isset($store->order_count) ? $store->order_count : 0;
                $cod_total = isset($store->cod_total) ? $store->cod_total : 0;
                $card_total = isset($store->card_total) ? $store->card_total : 0;
                $customer_count = isset($store->customer_count) ? $store->customer_count : 0;

                $html .= '<div class="dash-sales">';
                $html .= '<table class="table">';
                $html .= '<h6 class="mb-2"><b>'.$store->store_name.'</b></h6>';
                $html .= '<tr><td><b>Total Sales : </b></td><td class="align-middle">£ '.number_format($total_sale,2).'</td></tr>';
                $html .= '<tr><td><b>Total Orders : </b></td><td class="align-middle">'.$order_count.'</td></tr>';
                $html .= '<tr><td><b>Total Cash Order Amount : </b></td><td class="align-middle">£ '.number_format($cod_total,2).'</td></tr>';
                $html .= '<tr><td><b>Total Card Order Amount : </b></td><td class="align-middle">£ '.number_format($card_total,2).'</td></tr>';
                $html .= '<tr><td><b>No. of Customers : </b></td><td class="align-middle">'.$customer_count.'</td></tr>';
                $html .= '</table>';
                $html .= '</div>';
            }

            return response()->json([
                'success' => 1,
                'html'=>$html,
            ]);
        }
        else
        {
            $html .= '<div class="text-center"><h6>Records Not Found !</h6></div>';
            return response()->json([
                'success' => 1,
                'html'=>$html,
            ]);
        }

     }

     function getTopTenCustomer(Request $request)
     {
        $range = 'year';
        $html = '';

        if(isset($request->range))
        {
			$range = $request->range;
		}

        $top_10_customers = getTop10Customers($range);

        if(count($top_10_customers) > 0)
        {
            $html .= '<table class="table">';
            $html .= '<thead>';
            $html .= '<tr><th>Customer</th><th>Total Sales</th><th>Total Cash Order Amount</th><th>Total Card Order Amount</th></tr>';
            $html .= '</thead>';
            $html .= '<tbody>';

            foreach($top_10_customers as $store)
            {
                $total_sale = isset($store->total_sale) ? $store->total_sale : 0;
                $cod_total = isset($store->cod_total) ? $store->cod_total : 0;
                $card_total = isset($store->card_total) ? $store->card_total : 0;
                $cust_name = $store->firstname.' '.$store->lastname;

                if($store->customer_id == 0)
                {
                    $cust_name = "Guest User's";
                }

                $html .= '<tr>';
                $html .= '<td>'.$cust_name.'</td>';
                $html .= '<td>£ '.number_format($total_sale,2).'</td>';
                $html .= '<td>£ '.number_format($cod_total,2).'</td>';
                $html .= '<td>£ '.number_format($card_total,2).'</td>';
                $html .= '</tr>';

            }

            $html .= '</tbody>';
            $html .= '</table>';

            return response()->json([
                'success' => 1,
                'html'=>$html,
            ]);

        }
        else
        {
            $html .= '<div class="text-center"><h6>Records Not Found !</h6></div>';
            return response()->json([
                'success' => 1,
                'html'=>$html,
            ]);
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
