<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductDescription;
use App\Models\Category;
use App\Models\ProductIcons;
use App\Models\Reward;
use App\Models\Product_to_category;
use App\Models\ProductOptionMapping;
use App\Models\ProductStore;
use App\Models\ProductToppingType;
use App\Models\ToppingSize;
use App\Models\ToppingProductPriceSize;
use App\Models\Topping;
use App\Models\ToppingCatOption;
use App\Models\ToppingOption;
use DataTables;


use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;

class ProductController extends Controller
{
    function index()
    {
        // Current Store ID
        $current_store_id = currentStoreId();
        $category = Category::with(['hasOneCategoryToStore'])->whereHas('hasOneCategoryToStore', function ($query) use ($current_store_id) {
            $query->where('store_id', $current_store_id);
        })->get();
        return view('admin.product.list', ['category' => $category]);
    }


    function bulkproducts()
    {
        $current_store_id = currentStoreId();
        $category = Category::with(['hasOneCategoryToStore'])->whereHas('hasOneCategoryToStore', function ($query) use ($current_store_id) {
            $query->where('store_id', $current_store_id);
        })->get();
        return view('admin.product.bulkproducts', ['category' => $category]);
    }

    function getcategoryproduct(Request $request)
    {


        $category_id = $request->category_id;
        $lastid = $request->lastid + 1;

        $data = Product_to_category::select('p.*', 'pd.name as pname')->join('oc_product as p', 'p.product_id', '=', 'oc_product_to_category.product_id')->join('oc_product_description as pd', 'pd.product_id', '=', 'p.product_id')->where('category_id', $category_id)->first();

        $html = '';
        $thead = '';
        $header = ToppingSize::where('id_category', $category_id)->count();
        $headers = ToppingSize::where('id_category', $category_id)->get();

        if ($header > 0) {
            $head_count = $header + 1;
        } else {
            $head_count = $header;
        }
        $thead .= '<tr>';
        $thead .= '<th style="min-width:220px!important">Product Name</th>';
        $thead .= '<th style="min-width:220px!important">Description</th>';
        if ($head_count > 0) {
            $thead .= '<th colspan="' . $head_count . '" class="text-center" style="min-width:100px!important">Price</th>';
        } else {
            $thead .= '<th class="text-center" style="min-width:300px!important">Price</th>';
        }
        $thead .= '<th style="min-width:240px!important">Image</th>';
        $thead .= '<th style="min-width:300px!important">Options</th>';
        $thead .= '<th>Action</th>';
        $thead .= '</tr>';
        $thead .= '<tr><td colspan="2"></td><th style="background:lightgray;min-width:100px;">Main Price</th>';


        if ($header > 0) {
            foreach ($headers as $head) {
                $thead .= '<th style="background:lightgray;min-width:100px;">' . $head->size . '</th>';
            }
        }

        $thead .= '<td colspan="3"></td> </tr>';
        $thead .= '</tr>';

        $html .= '<tr class="productone" id="productone' . $lastid . '">';
        $html .= '<td style="vertical-align: middle;"><input type="text" name="product[' . $lastid . '][name]" class="form-control"></td>';
        $html .= '<td style="vertical-align: middle;"><textarea type="text" name="product[' . $lastid . '][description]" class="form-control"></textarea></td>';
        if (isset($data->product_id)) {
            $sizes = ToppingProductPriceSize::where('id_product', $data->product_id)->get();
        }
        $html .= '<td style="vertical-align: middle;"><input type="text" name="product[' . $lastid . '][price]" class="form-control"></td>';

        if (isset($data->product_id)) {
            foreach ($sizes as $key => $size) {
                $html .= '<td style="vertical-align: middle;"><input type="text" name="product['.$lastid.'][price_size]['. $size->id_size.']" class="form-control"></td>';
            }
        }

        $html .= '<td style="vertical-align: middle;"><input type="file" name="product[' . $lastid . '][image]" class="form-control"></td>';

        if (isset($data->product_id)) {
            $toppingType = ToppingCatOption::select('group')->where('id_category', $category_id)->first();
            $group = unserialize($toppingType->group);
            unset($group['number_group']);
        }
        $html .= '<th>';

        if (isset($data->product_id)) {

            foreach ($group as $key=>$value) {

                $productvalue=$value['id_group_option'];
                $top = Topping::select('oc_topping.*', 'ptd.typetopping')->join('oc_product_topping_type as ptd', 'ptd.id_group_topping', '=', 'id_topping')->where('id_topping', $value['id_group_option'])->first();
                $dropdown = ToppingOption::where('id_group_topping', $top->id_topping)->get();
                $html .= '<h3>' . $top->name_topping . '</h3>
                <div style="margin-bottom: 10px;">
                <input type="radio" class="typetopping_'.$lastid.'_'.$key.'" name="product[' .$lastid .'][typetopping]['.$productvalue.']" value="select" onclick="radiocheck('.$lastid.','.$key.');"';
                ($top->typetopping == "select") ? $html .= ' checked' : '';
                $html .= '> Select&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="product[' .$lastid .'][typetopping]['.$productvalue.']" class="typetopping_'.$lastid.'_'.$key.'" value="checkbox" onclick="radiocheck('.$lastid.','.$key.');"';
                ($top->typetopping == "checkbox") ? $html .= 'checked' : '';
                $html .= '> Checkbox&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
                <div style="margin-bottom: 10px;"><input type="radio" name="product[' .$lastid .'][enable]['.$productvalue.']" value="1"';
                ($top->enable == 1) ? $html .= ' checked' : '';
                $html .= '>Enable&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="product[' .$lastid .'][enable]['.$productvalue.']" value="0"';
                ($top->enable == 0) ? $html .= 'checked' : '';
                $html .= '>Disable&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
                <div class="form-floating">
                    <label for="rename" class="form-label">Rename to</label>
                    <input type="text" name="product['.$lastid.'][renamegroup]['.$productvalue.']" class="form-control">
                </div>';
                    $html .='<div id="checkbox_'.$lastid.'_'.$key.'" style="display:none">';
                    $html .='<lable>Default selected</lable>';
                    $html .='<table>';
                    $html .='<tbody>';
                    $html .='<tr>';
                    foreach($dropdown as $dropdowns){
                    $html .='<td><input type="checkbox" value="'.$dropdowns->name.'" name="product['.$lastid.'][product_topping_checkbox]['.$productvalue.']" ></td>';
                    $html .='<td>'.$dropdowns->name.'</td>';
                    $html .='</tr>';
                    }
                    $html .='</tbody>';
                    $html .='</table>';
                    $html .='</div>';
                    $html .='<div id="select_'.$lastid.'_'.$key.'" style="display:none">';
                    $html .='<lable>Default selected</lable>';
                    $html .='<select  class="form-control" name="product['.$lastid.'][product_topping_select]['.$productvalue.']">';
                    foreach($dropdown as $dropdowns){
                        $html .='<option>'.$dropdowns->name.'</option>';
                    }
                    $html .='</select>';
                    $html .='</div>';
            }

        } else {
            $html .= 'No Topping';
        }
        $html .= '</th>';
        $html .= '<td><a href="javascript:void(0)" class="delete_option btn btn-danger"><i class="fa fa-minus-circle"></i></a></td>';
        $html .= '</tr>';

        if (isset($data->product_id)) {
            return response()->json(['html' => $html, 'lastid' => $lastid, 'thead' => $thead]);
        } else {
            return response()->json(['html' => $html, 'lastid' => $lastid, 'thead' => $thead]);
        }
    }


    function storebulkproduct(Request $request)
    {

        $current_store_id = currentStoreId();

        foreach($request->product as $key => $prod){

            $name = isset($prod['name']) ? $prod['name'] : '';
            $description = isset($prod['description']) ? $prod['description'] : '';
            $price = isset($prod['price']) ? $prod['price'] : '';
            $image = isset($prod['image']) ? $prod['image'] : '';
            $price_size = isset($prod['price_size']) ? $prod['price_size'] : '';
            $toppingtype= isset($prod['typetopping']) ? $prod['typetopping'] : '';
            $enable= isset($prod['enable']) ? $prod['enable'] : '';
            $renamegroup= isset($prod['renamegroup']) ? $prod['renamegroup'] : '';


            $product = new Product();
            date_default_timezone_set('Asia/Kolkata');
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
            $product->date_added = isset($request->date_added) ? $request->date_added : date("Y-m-d h:i:s");
            $product->date_modified = isset($request->date_modified) ? $request->date_modified : date("Y-m-d h:i:s");
            $product->tax_class_id = isset($request->tax_class_id) ? $request->tax_class_id : 0;
            $product->price = $price;
            $product->delivery_price = isset($request->deliveryprice) ? $request->deliveryprice : 0;
            $product->collection_price = isset($request->collectionprice) ? $request->collectionprice : 0;
            $product->status = isset($request->status) ? $request->status : 0;
            $product->sort_order = isset($request->sort_order) ? $request->sort_order : 0;
            // $icon = $request['product_icons'];
            // $product_icons = implode(',', $icon);
            $product->product_icons = isset($request->product_icons) ? $request->product_icons : 0;
            // $data = $request['order_type'];
            // $order_type = implode('', $data);
            $product->order_type = isset($request->order_type) ? $request->order_type : 0;
            // $day = $request['day'];
            // $days = implode(',', $day);
            $product->availibleday = isset($request->days) ? $request->days : 0;
            if (!empty($image) || $image != '')
            {
                $imgname = time() . "." . $image->getClientOriginalExtension();
                $image->move(public_path('admin/product'), $imgname);
                $product->image = $imgname;
            }
            $product->save();

            $product_description = new ProductDescription();
            $product_description->product_id = $product->product_id;
            $product_description->language_id = 1;
            $product_description->name = $name;
            $product_description->description = $description;
            $product_description->meta_description = isset($request->meta_description) ? $request->meta_description : '';
            $product_description->meta_keyword = isset($request->meta_keyword) ? $request->meta_keyword : '';
            $product_description->tag = isset($request->tag) ? $request->tag : '';
            $product_description->save();

            $productstore = new ProductStore();
            $productstore->product_id = $product->product_id;
            $productstore->store_id =$current_store_id;
            $productstore->save();

            $product_category = new Product_to_category();
            $product_category->product_id = $product->product_id;
            $product_category->category_id = isset($request->category) ? $request->category : 0;
            $product_category->save();

              if(!empty($toppingtype) || $toppingtype != ''){
                foreach($toppingtype as $key=>$value){

                    $producttoppingtype = new ProductToppingType();
                    $producttoppingtype->id_product=$product->product_id;
                    $producttoppingtype->id_group_topping=isset($request->id_group_topping) ? $request->id_group_topping : "";
                    $producttoppingtype->typetopping=$toppingtype[$key];
                    $producttoppingtype->min_check=isset($request->min_check) ? $request->min_check : 0;
                    $producttoppingtype->max_check=isset($request->max_check) ? $request->max_check : 0;
                    $producttoppingtype->choose=isset($request->choose) ? $request->choose : 0;
                    $producttoppingtype->enable=$enable[$key];
                    $producttoppingtype->renamegroup=$renamegroup[$key];
                    $producttoppingtype->topping_sort_order=isset($request->topping_sort_order) ? $request->topping_sort_order : 0;
                    $producttoppingtype->save();
              }
              }

              if(!empty($price_size) || $price_size != ''){
                foreach($price_size as $key=>$price_sizes){
                    $query = ToppingProductPriceSize::max('id_product_price_size');
                    $lastidsize=$query+1;
                    $toppingProductPriceSize = new ToppingProductPriceSize;
                    $toppingProductPriceSize->id_product_price_size= $lastidsize;
                    $toppingProductPriceSize->price =$price_sizes;
                    $toppingProductPriceSize->id_size =$key;
                    $toppingProductPriceSize->id_product =$product->product_id;
                    $toppingProductPriceSize->delivery_price ='';
                    $toppingProductPriceSize->collection_price ='';
                    $toppingProductPriceSize->save();
                }
            }


        }
        return redirect()->route('products');

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
        $current_store_id = currentStoreId();
        $category = Category::with(['hasOneCategoryToStore'])->whereHas('hasOneCategoryToStore', function ($query) use ($current_store_id) {
            $query->where('store_id', $current_store_id);
        })->get();
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

        $request->validate([
            'product' => 'required',
            'product_icons' => 'required',
        ]);

        $product = new Product();
        date_default_timezone_set('Asia/Kolkata');
        $product->model = isset($request->model) ? $request->model : 0;
        $product->sku = isset($request->sku) ? $request->sku : "";
        $product->upc = isset($request->upc) ? $request->upc : "";
        $product->ean = isset($request->ean) ? $request->ean : "";
        $product->jan = isset($request->jan) ? $request->jan : "";
        $product->isbn = isset($request->isbn) ? $request->isbn : "";
        $product->mpn = isset($request->mpn) ? $request->mpn : "";
        $product->location = isset($request->location) ? $request->location : "";
        $product->stock_status_id = isset($request->stock_status_id) ? $request->stock_status_id : 0;
        $product->manufacturer_id = isset($request->manufacturer_id) ? $request->manufacturer_id : 0;
        $product->date_available = isset($request->date_available) ? $request->date_available : 0;
        $product->date_added = isset($request->date_added) ? $request->date_added : date("Y-m-d h:i:s");
        $product->date_modified = isset($request->date_modified) ? $request->date_modified : date("Y-m-d h:i:s");
        $product->tax_class_id = isset($request->tax_class_id) ? $request->tax_class_id : 0;
        $product->price = isset($request->mainprice) ? $request->mainprice : 0;
        $product->delivery_price = isset($request->deliveryprice) ? $request->deliveryprice : 0;
        $product->collection_price = isset($request->collectionprice) ? $request->collectionprice : 0;
        $product->status = isset($request->status) ? $request->status : 0;
        $product->sort_order = isset($request->sort_order) ? $request->sort_order : 0;
        if (!empty($icon = $request['product_icons'])) {
            $product_icons = implode(',', $icon);
            $product->product_icons = isset($product_icons) ? $product_icons : 0;
        }
        $data = $request->order_type;
        $order_type = implode('', $data);
        $product->order_type = isset($order_type) ? $order_type : 0;
        if (!empty($day = $request['day'])) {
            $days = implode(',', $day);
            $product->availibleday = isset($days) ? $days : 0;
        }
        if ($request->hasFile('image')) {
            $Image = $request->file('image');
            $filename = time() . '.' . $Image->getClientOriginalExtension();
            $Image->move(public_path('admin/product/'), $filename);
            $product->image = $filename;
        }
        $product->save();

        $product_description = new ProductDescription();
        $product_description->product_id = $product->product_id;
        $product_description->language_id = 1;
        $product_description->name = isset($request->product) ? $request->product : 0;
        $product_description->description = isset($request->description) ? $request->description : 0;
        $product_description->meta_description = isset($request->meta_description) ? $request->meta_description : '';
        $product_description->meta_keyword = isset($request->meta_keyword) ? $request->meta_keyword : '';
        $product_description->tag = isset($request->tag) ? $request->tag : '';
        $product_description->save();

        $reward = new Reward();
        $reward->product_id = $product->product_id;
        $reward->customer_group_id = 1;
        $reward->points = 0;
        $reward->save();

        $product_category = new Product_to_category();
        $product_category->product_id = $product->product_id;
        $product_category->category_id = isset($request->category) ? $request->category : 0;
        $product_category->save();

        $productstore = new ProductStore();
        $productstore->product_id = $product->product_id;
        $current_store_id = currentStoreId();
        $productstore->store_id = $current_store_id;
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
        $html .= '<th><input type="checkbox" name="checkall" id="delall" value="' . $category_id . '"></th>';
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
                $html .= '<td><input type="checkbox" name="del_all" id="del_all" value="' . $category->product_id . '"></td>';
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

                if(count($sizes) > 0)
                {
                    foreach ($sizes as $size)
                    {
                        $html .= '<td>' . $size->price . '</td>';
                    }
                }
                else
                {
                    foreach ($headers as $header)
                    {
                        $html .= '<td>-</td>';
                    }
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
        // $category_id=$request->cat_id;
        // $current_store_id = currentStoreId();
        // $columns = array(
        //     0 =>'product_id',
        //     3 =>'name',
        // );

        // // Get data
        // $totledata = ProductDescription::with(['hasOneProduct','hasOneProductToStore'])->whereHas('hasOneProductToStore', function ($query) use ($current_store_id) {
        //     $query->where('store_id', $current_store_id);
        // })->count();

        // $totalFiltered = $totledata;
        // $limit = $request->request->get('length');
        // $start = $request->request->get('start');
        // $order = $columns[$request->input('order.0.column')];
        // $dir = $request->input('order.0.dir');


        // if (!empty($request->input('search.value'))) {
        //     $search = $request->input('search.value');

        //     $posts =  ProductDescription::with(['hasOneProduct','hasOneProductToStore'])->where(function ($query) use ($search) {
        //         $query->where('name', 'LIKE', "%{$search}%");
        //         })
        //         ->whereHas('hasOneProductToStore', function ($query) use ($current_store_id){
        //         $query->where('store_id',$current_store_id);
        //     })->offset($start)->orderBy($order, $dir)->limit($limit)->get();


        //     $totalFiltered = ProductDescription::with(['hasOneStore','hasOneProductToStore'])->where(function ($query) use ($search){
        //         $query->where('name','LIKE',"%{$search}%");
        //     })->whereHas('hasOneProductToStore', function ($query) use ($current_store_id){
        //         $query->where('store_id',$current_store_id);
        //     })->offset($start)->orderBy($order,$dir)->limit($limit)->count();
        // } else {

        //     $posts = ProductDescription::with(['hasOneProduct','hasOneProductToStore','hasOnecategorytostore'])->whereHas('hasOneProductToStore', function ($query) use ($current_store_id) {
        //         $query->where('store_id', $current_store_id);
        //     })
        //     ->orwhereHas('hasOnecategorytostore', function ($query) use ($category_id) {
        //         $query->where('category_id', $category_id);
        //     })
        //     ->offset($start)->limit($limit)->orderBy($order,$dir)->get();

        //     // echo '<pre>';
        //     // print_r($posts);
        //     // exit();


        // }

        // $data = array();
        // $data1 = array();

        // if ($posts) {
        //     foreach ($posts as $post) {
        //         $product_id = $post->product_id;
        //         // $name = isset($post->name) ? $post->name : '';
        //         $status = isset($post->status) ? $post->status : '';
        //         $edit_url = route('editproduct', $post->product_id);
        //         // $price = isset($post->price) ? $post->price : '';


        //         $data['checkbox'] = "<input type='checkbox' name='del_all' class='del_all' value='$product_id'>";
        //         $data['product_id'] = $product_id;
        //         $data['image'] = $post->image;
        //         if (!empty($data['image'])) {
        //             $image_path = asset('public/admin/product/' . $data['image']);
        //             $data['image'] = '<img src="' . $image_path . '" alt="Not Found" width="40">';
        //         } else {
        //             $image_path = asset('public/admin/product/no_image.jpg');
        //             $data['image'] = '<img src="' . $image_path . '" alt="Not Found" width="40">';
        //         }
        //         $data['name'] = $post->name;
        //         $data['price'] = $post->hasOneProduct->price;
        //         $data['status'] = $post->hasOneProduct->status;

        //         if ($status == 0) {
        //             $data['status'] ='<td>Enabled</td>';
        //         } else {
        //             $data['status'] = '<td>Disabled</td>';
        //         }

        //         $data['sort_order'] = $post->hasOneProduct->sort_order;
        //         $data['action'] = '<a href="' . $edit_url . '" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>';

        //         $data1[] = $data;
        //     }
        // }

        // $json_data = array(
        //     "draw"            => intval($request->request->get('draw')),
        //     "recordsTotal"    => intval($totledata),
        //     "recordsFiltered" => intval(isset($totalFiltered) ? $totalFiltered : ''),
        //     "data"            => $data1
        // );

        // echo json_encode($json_data);

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
            ToppingProductPriceSize::whereIn('id_product', $ids)->delete();
            return response()->json([
                'success' => 1,
            ]);
        }
    }



    public function edit($id)
    {
        $product = Product::select('*')->join('oc_product_description', 'oc_product.product_id', '=', 'oc_product_description.product_id')->leftjoin('oc_product_to_category', 'oc_product.product_id', '=', 'oc_product_to_category.product_id')->where('oc_product.product_id', $id)->first();

        $prod_id = isset($product->category_id) ? $product->category_id : '';

        $header = ToppingSize::where('id_category', $prod_id)->get();

        $price = ToppingProductPriceSize::where('id_product', $id)->get();
        $current_store_id = currentStoreId();
        $category = Category::with(['hasOneCategoryToStore'])->whereHas('hasOneCategoryToStore', function ($query) use ($current_store_id) {
            $query->where('store_id', $current_store_id);
        })->get();
        $product_icon = ProductIcons::select('*')->get();
        $toppingType = Topping::join('oc_product_topping_type', 'oc_topping.id_topping', '=', 'oc_product_topping_type.id_group_topping')->where('oc_product_topping_type.id_product', $prod_id)->first();

        $result['category'] = $category;
        $result['product_icon'] = $product_icon;
        $result['header'] = $header;
        $result['price'] = $price;
        $result['toppingType'] = $toppingType;

        return view('admin.product.edit', ['product' => $product, 'result' => $result]);
    }

    public function update(Request $request)
    {
        $product_id = $request->product_id;
        $product = Product::find($product_id);
        date_default_timezone_set('Asia/Kolkata');
        $product->model = isset($request->model) ? $request->model : "";
        $product->model = $request->model;
        $product->sku = isset($request->sku) ? $request->sku : "";
        $product->upc = isset($request->upc) ? $request->upc : "";
        $product->ean = isset($request->ean) ? $request->ean : "";
        $product->jan = isset($request->jan) ? $request->jan : "";
        $product->isbn = isset($request->isbn) ? $request->isbn : "";
        $product->mpn = isset($request->mpn) ? $request->mpn : "";
        $product->location = isset($request->location) ? $request->location : "";
        $product->stock_status_id = isset($request->stock_status_id) ? $request->stock_status_id : 0;
        $product->manufacturer_id = isset($request->manufacturer_id) ? $request->manufacturer_id : 0;
        $product->date_available = isset($request->date_available) ? $request->date_available : 0;
        // $product->date_added = isset($request->date_added) ? $request->date_added : 0;
        $product->date_modified = date("Y-m-d h:i:s");
        $product->tax_class_id = isset($request->tax_class_id) ? $request->tax_class_id : 0;
        $product->price = isset($request->mainprice) ? $request->mainprice : 0;
        $product->delivery_price = isset($request->deliveryprice) ? $request->deliveryprice : 0;
        $product->collection_price = isset($request->collectionprice) ? $request->collectionprice : 0;
        $product->status = isset($request->status) ? $request->status : 0;
        $product->sort_order = isset($request->sort_order) ? $request->sort_order : 0;
        $icon = $request['product_icons'];
        $product_icons = implode(',', $icon);
        $product->product_icons = isset($product_icons) ? $product_icons : 0;
        $order_type = $request['order_type'];
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
        $product->update();

        $product_description = ProductDescription::find($product_id);

        $product_description->language_id = 1;
        $product_description->name = isset($request->product) ? $request->product : 0;
        $product_description->description = isset($request->description) ? $request->description : 0;
        $product_description->meta_description = isset($request->meta_description) ? $request->meta_description : '';
        $product_description->meta_keyword = isset($request->meta_keyword) ? $request->meta_keyword : '';
        $product_description->tag = isset($request->tag) ? $request->tag : '';
        $product_description->update();

        // $reward = Reward::find($product_id);
        // $reward->customer_group_id = 1;
        // $reward->points = 0;
        // $reward->update();

        $product_category = Product_to_category::find($product_id);
        $product_category->category_id = isset($request->category) ? $request->category : 0;
        $product_category->update();

        // $productstore =ProductStore::find($product_id);
        // $productstore->store_id =isset($request->store_id) ? $request->store_id : 0;
        // $productstore->update();
        $type_topping = isset($request->typetopping) ? $request->typetopping : '';

        if (!empty($type_topping) || $type_topping != '') {
            $toppingtype = ProductToppingType::find($product_id);
            $toppingtype->typetopping =  $type_topping;
            $toppingtype->min_check = isset($request->minimum) ? $request->minimum : 0;
            $toppingtype->max_check = isset($request->maximum) ? $request->maximum : 0;;
            $toppingtype->choose = isset($request->choose) ? $request->choose : '';
            $toppingtype->enable = $request->enable;
            $toppingtype->renamegroup = $request->renamegroup;
            $toppingtype->topping_sort_order = $request->topping_sort_order;
            $toppingtype->update();
        }

        $mainprice = isset($request->mainprices) ? $request->mainprices : "";
        $mainprice = $request->mainprices;
        $collectionprice =isset($request->collectionprices) ? $request->collectionprices : "";
        $deliveryprice = isset($request->deliveryprices) ? $request->deliveryprices : "";
        $price_size_id = $request->id_product_price_size;
        $id_size = $request->id_size;
        if (!empty($price_size_id)) {
            foreach ($mainprice as $key => $mainprices) {
                $where = $price_size_id[$key];
                $toppingProductPriceSize = ToppingProductPriceSize::find($where);
                $toppingProductPriceSize->price = $mainprices;
                $toppingProductPriceSize->delivery_price = $deliveryprice[$key];
                $toppingProductPriceSize->collection_price = $collectionprice[$key];
                $toppingProductPriceSize->update();
            }
        } else {
            foreach ($mainprice as $key => $mainprices) {
                $toppingProductPriceSize = new ToppingProductPriceSize;
                $toppingProductPriceSize->id_size = $id_size[$key];
                $toppingProductPriceSize->id_product = $product_id;
                $toppingProductPriceSize->price = $mainprices;
                $toppingProductPriceSize->delivery_price = $deliveryprice[$key];
                $toppingProductPriceSize->collection_price = $collectionprice[$key];
                $toppingProductPriceSize->save();
            }
        }


        return redirect()->route('products')->with('success', "Product Updated Successfully..");
    }
}

