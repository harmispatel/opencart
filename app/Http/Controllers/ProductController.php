<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductDescription;
use App\Models\Category;
use App\Models\ProductIcons;
use App\Models\Reward;
use App\Models\Product_to_category;
use App\Models\ProductStore;
use App\Models\ProductToppingType;
use App\Models\ToppingSize;
use App\Models\ToppingProductPriceSize;


use DataTables;


use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;

class ProductController extends Controller
{
    function index()
    {
        $category = Category::select('*')->get();
        return view('admin.product.list', ['category' => $category]);
    }


    function bulkproducts()
    {
        return view('admin.product.bulkproducts');
    }


    function importproducts()
    {
        return view('admin.product.importproducts');
    }


    function add()
    {
        // Check User Permission
        if (check_user_role(59) != 1) {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }

        $manufacturer = DB::table('oc_manufacturer')->select('*')->get();
        $category = DB::table('oc_category_description')->select('*')->get();
        $releted_product = DB::table('oc_product_description')->select('*')->get();
        $product_layout = DB::table('oc_layout')->select('*')->get();
        $stok_status = DB::table('oc_stock_status')->select('*')->get();
        $tex_class = DB::table('oc_tax_class')->select('*')->get();
        $lenght_class = DB::table('oc_length_class_description')->select('*')->get();
        $weight_class = DB::table('oc_weight_class_description')->select('*')->get();
        $category = Category::select('*')->get();
        $product_icon = ProductIcons::select('*')->get();
        $result['manufacturer'] = $manufacturer;
        $result['category'] = $category;
        $result['releted_product'] = $releted_product;
        $result['product_layout'] = $product_layout;
        $result['stok_status'] = $stok_status;
        $result['tex_class'] = $tex_class;
        $result['lenght_class'] = $lenght_class;
        $result['weight_class'] = $weight_class;
        $result['category'] = $category;
        $result['product_icon'] = $product_icon;



        $option = DB::table('oc_option_description')->select('*')->get();

        return view('admin.product.add', ['result' => $result, 'option' => $option]);
    }

    public function store(Request $request)
    {


        $product = new Product();
        $product->model = isset($request->model) ? $request->model : 0;
        $product->sku = isset($request->sku) ? $request->sku : 0;
        $product->upc = isset($request->upc) ? $request->upc : 0;
        $product->ean = isset($request->ean) ? $request->ean : 0;
        $product->jan = isset($request->jan) ? $request->jan : 0;
        $product->isbn = isset($request->isbn) ? $request->isbn : 0;
        $product->mpn = isset($request->mpn) ? $request->mpn : 0;
        $product->location = isset($request->location) ? $request->location : 0;
        $product->stock_status_id = isset($request->stock_status_id) ? $request->stock_status_id : 0;
        $product->manufacturer_id = isset($request->manufacturer_id) ? $request->manufacturer_id : 0;
        $product->date_available = isset($request->date_available) ? $request->date_available : 0;
        $product->date_added = isset($request->date_added) ? $request->date_added : 0;
        $product->date_modified = isset($request->date_modified) ? $request->date_modified : 0;
        $product->tax_class_id = isset($request->tax_class_id) ? $request->tax_class_id : 0;
        $product->price = isset($request->mainprice) ? $request->mainprice : 0;
        $product->delivery_price = isset($request->deliveryprice) ? $request->deliveryprice : 0;
        $product->collection_price = isset($request->collectionprice) ? $request->collectionprice : 0;
        $product->status = isset($request->status) ? $request->status : 0;
        $product->sort_order = isset($request->sort_order) ? $request->sort_order : 0;
        $icon = $request['product_icons'];
        $product_icons = implode(',', $icon);
        $product->product_icons = isset($product_icons) ? $product_icons : 0;
        $data = $request['order_type'];
        $order_type = implode('', $data);
        $product->order_type = isset($order_type) ? $order_type : 0;
        $day = $request['day'];
        $days = implode(',', $day);
        $product->availibleday = isset($days) ? $days : 0;
        if ($request->hasFile('image')) {
            $Image = $request->file('image');
            $filename = time() . '.' . $Image->getClientOriginalExtension();
            $Image->move(public_path('admin/product/'), $filename);
            $product->image = $filename;
        }
        $product->save();

        $product_description = new ProductDescription();
        $product_description->product_id = $product->id;
        $product_description->language_id = 1;
        $product_description->name = isset($request->product) ? $request->product : 0;
        $product_description->description = isset($request->description) ? $request->description : 0;
        $product_description->meta_description = isset($request->meta_description) ? $request->meta_description : '';
        $product_description->meta_keyword = isset($request->meta_keyword) ? $request->meta_keyword : '';
        $product_description->tag = isset($request->tag) ? $request->tag : '';
        $product_description->save();

        $reward = new Reward();
        $reward->product_id = $product->id;
        $reward->customer_group_id = 1;
        $reward->points = 0;
        $reward->save();

        $product_category = new Product_to_category();
        $product_category->product_id = $product->id;
        $product_category->category_id = isset($request->category) ? $request->category : 0;
        $product_category->save();

        $productstore = new ProductStore();
        $productstore->product_id = $product->id;
        $productstore->store_id = isset($request->store_id) ? $request->store_id : 0;
        $productstore->save();
        return redirect()->route('products')->with('success', "Product Inserted Successfully..");
    }

    function getproductbycategory(Request $request)
    {
        $category_id = $request->category_id;
        $data = Product_to_category::select('p.*', 'pd.name as pname')->join('oc_product as p', 'p.product_id', '=', 'oc_product_to_category.product_id')->join('oc_product_description as pd', 'pd.product_id', '=', 'p.product_id')->where('category_id', $category_id)->get();
        $headers = ToppingSize::where('id_category', $category_id)->get();
        $head_count = count($headers) + 1;
        $html = '';
        $html .= '<tr>';
        $html .= '<th><input type="checkbox" name="checkall" id="delall"></th>';
        $html .= '<th>Image</th>';
        $html .= '<th>Product Name</th>';
        if (isset($head_count)) {
            $html .= '<th colspan="' . $head_count . '" class="text-center">Price</th>';
        } else {
            $html .= '<th class="text-center">Price</th>';
        }
        $html .= '<th>Status</th>';
        $html .= '<th>Sort Order</th>';
        $html .= '<th>Action</th>';
        $html .= '</tr>';

        $html .= '<tr><td colspan="3"></td><th style="background:lightgray">Main Price</th>';

        if (count($headers) > 0) {
            foreach ($headers as $header) {
                $html .= '<th style="background:lightgray">' . $header->size . '</th>';
            }
        }
        $html .= '<td colspan="3"></td> </tr>';

        if (count($data) > 0) {
            foreach ($data as $category) {

                $html .= '<tr>';
                $html .= '<td><input type="checkbox"></td>';
                if (!empty($category->image)) {
                    $image_path = asset('public/admin/product/' . $category->image);
                    $html .= '<td><img src="' . $image_path . '" alt="Not Found" width="40"></td>';
                } else {
                    $image_path = asset('public/admin/product/no_image.jpg');
                    $html .= '<td><img src="' . $image_path . '" alt="Not Found" width="40"></td>';
                }
                $html .= '<td>' . $category->pname . '</td>';
                $sizes = ToppingProductPriceSize::where('id_product', $category->product_id)->get();
                $html .= '<td>' . $category->price . '</td>';
                foreach ($sizes as $size) {
                    $html .= '<td>' . $size->price . '</td>';
                }
                if ($category->status == 1) {
                    $html .= '<td>Enabled</td>';
                } else {
                    $html .= '<td>Disabled</td>';
                }
                $html .= '<td>' . $category->sort_order . '</td>';
                $edit_url = route('editproduct', $category->product_id);

                $html .= '<td><a href="' . $edit_url . '" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a></td>';
                $html .= '</tr>';
            }
            return response()->json($html);
        } else {
            $html .= '<tr><td colspan="7">Product Not Available</td></tr>';
            return response()->json($html);
        }
    }

    public function getproduct(Request $request)
    {
        if ($request->ajax()) {
            $data = ProductDescription::select('*')->join('oc_product', 'oc_product_description.product_id', '=', 'oc_product.product_id')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $edit_url = route('editproduct', $row->product_id);
                    $btn = '<a href="' . $edit_url . '" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>';

                    return $btn;
                })
                ->addColumn('image', function ($row) {
                    if (!empty($row->image)) {
                        $image_path = asset('public/admin/product/' . $row->image);
                        $image = '<img src="' . $image_path . '" alt="Not Found" width="40">';
                    } else {
                        $image_path = asset('public/admin/product/no_image.jpg');
                        $image = '<img src="' . $image_path . '" alt="Not Found" width="40">';
                    }

                    return $image;
                })
                ->addColumn('checkbox', function ($row) {
                    $pid = $row->product_id;
                    $checkbox = '<input type="checkbox" name="del_all" class="del_all" value="' . $pid . '">';
                    return $checkbox;
                })
                ->rawColumns(['action', 'checkbox', 'image'])
                ->make(true);
        }
    }








    public function getoptionhtml(Request $request)
    {
        $option = DB::table('oc_option')->where('type', $request->type)->get();
        return response()->json([
            'option' => $option,
        ]);
    }
    public function addOptionValue(Request $request)
    {
        echo '<pre>';
        print_r($request->optionTypeId);
        exit();
        $option_value = DB::table('oc_option_value_description')->where('option_id', $request->optionTypeId)->get();
        print_r($option_value);
        die;
        return response()->json([
            'option_value' => $option_value,
        ]);
    }
    public function deleteproduct(Request $request)
    {
        $ids = $request['id'];
        // print_r($ids);die;
        if (count($ids) > 0) {
            Product::whereIn('product_id', $ids)->delete();
            ProductDescription::whereIn('product_id', $ids)->delete();
            Reward::whereIn('product_id', $ids)->delete();
            Product_to_category::whereIn('product_id', $ids)->delete();
            ProductStore::whereIn('product_id', $ids)->delete();

            return response()->json([
                'success' => 1,
            ]);
        }
    }



    public function edit($id)
    {
        $product=Product::select('*')->join('oc_product_description', 'oc_product.product_id', '=', 'oc_product_description.product_id')->leftjoin('oc_product_to_category', 'oc_product.product_id', '=', 'oc_product_to_category.product_id')->where('oc_product.product_id',$id)->first();
        $header=ToppingSize::where('id_category', $product->category_id)->get();
        $price = ToppingProductPriceSize::where('id_product',$id)->get();
        $category = Category::select('*')->get();
        $product_icon = ProductIcons::select('*')->get();
        // $toppingType =ProductToppingType::where('id_product',$product->product_id)->first();
    //    echo '<pre>';
    //    print_r($toppingType);
    //    exit();

        $result['category'] = $category;
        $result['product_icon'] = $product_icon;
        $result['header']=$header;
        $result['price']=$price;
        // $result['toppingType']=$toppingType;

        return view('admin.product.edit', ['product' => $product, 'result' => $result]);
    }
}
