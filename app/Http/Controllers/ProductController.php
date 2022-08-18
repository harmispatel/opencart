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

    // Function of Product List
    function index()
    {
        // Check User Permission
        if (check_user_role(50) != 1) {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }

        // Current Store ID
        $current_store_id = currentStoreId();
        if ($current_store_id == 0) {
            $category = Category::with(['hasOneCategoryToStore'])->orderBy('category_id','DESC')->get();
        } else {

            $category = Category::with(['hasOneCategoryToStore'])->whereHas('hasOneCategoryToStore', function ($query) use ($current_store_id) {
                $query->where('store_id', $current_store_id);
            })->orderBy('category_id','DESC')->get();
        }
        return view('admin.product.list', ['category' => $category]);
    }





    // Get All bulkproducts
    function bulkproducts()
    {
        // Check User Permission
        if (check_user_role(56) != 1) {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }

        $current_store_id = currentStoreId();
        $category = Category::with(['hasOneCategoryToStore'])->whereHas('hasOneCategoryToStore', function ($query) use ($current_store_id) {
            $query->where('store_id', $current_store_id);
        })->get();
        return view('admin.product.bulkproducts', ['category' => $category]);
    }





    // Get All bulk Product
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
                $html .= '<td style="vertical-align: middle;"><input type="text" name="product[' . $lastid . '][price_size][' . $size->id_size . ']" class="form-control"></td>';
            }
        }

        // $html .= '<td style="vertical-align: middle;"><input type="file" name="product[' . $lastid . '][image]" class="form-control"></td>';
        $html .= '<td class="align-middle">';
        $html .='<div class="input-group">';
        $html .='<span class="input-group-btn">';
        $html .='<a id="lfm[' . $lastid . ']" data-input="thumbnail[' . $lastid . ']" data-preview="holder[' . $lastid . ']" onclick="setimage(this)" class="btn btn-primary" style="padding: 7px">';
        $html .='<i class="fa fa-picture-o"></i>';
        $html .='Choose';
        $html .='</a>';
        $html .='</span>';
        $html .='<input id="thumbnail[' . $lastid . ']" class="form-control" type="text" name="product[' . $lastid . '][image]">';
        $html .='</div>';
        $html .='<img id="holder[' . $lastid . ']" style="margin-top:15px;max-height:100px;">';
        $html .= '</td>';

        if (isset($data->product_id)) {
            $toppingType = ToppingCatOption::select('group')->where('id_category', $category_id)->first();
            $group = unserialize(isset($toppingType->group) ? $toppingType->group : '');
            $demo = isset($group) ? $group : '';
            unset($demo['number_group']);
        }
        $html .= '<th>';

        if (isset($data->product_id)) {
            if ($demo != '') {
                foreach ($demo as $key => $value) {

                    $productvalue = $value['id_group_option'];
                    $top = Topping::select('oc_topping.*', 'ptd.typetopping')->join('oc_product_topping_type as ptd', 'ptd.id_group_topping', '=', 'id_topping')->where('id_topping', $value['id_group_option'])->first();
                    $dropdown = ToppingOption::where('id_group_topping', $top->id_topping)->get();
                    $html .= '<h3>' . $top->name_topping . '</h3>
                     <div style="margin-bottom: 10px;">
                     <input type="radio" class="typetopping_' . $lastid . '_' . $key . '" name="product[' . $lastid . '][typetopping][' . $productvalue . ']" value="select" onclick="radiocheck(' . $lastid . ',' . $key . ');"';
                    ($top->typetopping == "select") ? $html .= ' checked' : '';
                    $html .= '> Select&nbsp;&nbsp;&nbsp;&nbsp;
                     <input type="radio" name="product[' . $lastid . '][typetopping][' . $productvalue . ']" class="typetopping_' . $lastid . '_' . $key . '" value="checkbox" onclick="radiocheck(' . $lastid . ',' . $key . ');"';
                    ($top->typetopping == "checkbox") ? $html .= 'checked' : '';
                    $html .= '> Checkbox&nbsp;&nbsp;&nbsp;&nbsp;
                     </div>
                     <div style="margin-bottom: 10px;"><input type="radio" name="product[' . $lastid . '][enable][' . $productvalue . ']" value="1"';
                    ($top->enable == 1) ? $html .= ' checked' : '';
                    $html .= '>Enable&nbsp;&nbsp;&nbsp;&nbsp;
                         <input type="radio" name="product[' . $lastid . '][enable][' . $productvalue . ']" value="0"';
                    ($top->enable == 0) ? $html .= 'checked' : '';
                    $html .= '>Disable&nbsp;&nbsp;&nbsp;&nbsp;
                     </div>
                     <div class="form-floating">
                         <label for="rename" class="form-label">Rename to</label>
                         <input type="text" name="product[' . $lastid . '][renamegroup][' . $productvalue . ']" class="form-control">
                     </div>';
                    $html .= '<div id="checkbox_' . $lastid . '_' . $key . '" style="display:none">';
                    $html .= '<lable>Default selected</lable>';
                    $html .= '<table>';
                    $html .= '<tbody>';
                    $html .= '<tr>';
                    foreach ($dropdown as $dropdowns) {
                        $html .= '<td><input type="checkbox" value="' . $dropdowns->name . '" name="product[' . $lastid . '][product_topping_checkbox][' . $productvalue . ']" ></td>';
                        $html .= '<td>' . $dropdowns->name . '</td>';
                        $html .= '</tr>';
                    }
                    $html .= '</tbody>';
                    $html .= '</table>';
                    $html .= '</div>';
                    $html .= '<div id="select_' . $lastid . '_' . $key . '" style="display:none">';
                    $html .= '<lable>Default selected</lable>';
                    $html .= '<select  class="form-control" name="product[' . $lastid . '][product_topping_select][' . $productvalue . ']">';
                    foreach ($dropdown as $dropdowns) {
                        $html .= '<option>' . $dropdowns->name . '</option>';
                    }
                    $html .= '</select>';
                    $html .= '</div>';
                }
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





     //  Insert bulkproduct
    function storebulkproduct(Request $request)
    {


        $current_store_id = currentStoreId();

        foreach ($request->product as $key => $prod) {

            $name = isset($prod['name']) ? $prod['name'] : '';
            $description = isset($prod['description']) ? $prod['description'] : '';
            $price = isset($prod['price']) ? $prod['price'] : '';
            $image = isset($prod['image']) ? $prod['image'] : '';
            $price_size = isset($prod['price_size']) ? $prod['price_size'] : '';
            $toppingtype = isset($prod['typetopping']) ? $prod['typetopping'] : '';
            $enable = isset($prod['enable']) ? $prod['enable'] : '';
            $renamegroup = isset($prod['renamegroup']) ? $prod['renamegroup'] : '';

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
            // if (!empty($image) || $image != '') {
            //     $imgname = time() . "." . $image->getClientOriginalExtension();
            //     $image->move(public_path('admin/product'), $imgname);
            //     $product->image = $imgname;
            // }
            $product->image = $image;
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
            $productstore->store_id = $current_store_id;
            $productstore->save();

            $product_category = new Product_to_category();
            $product_category->product_id = $product->product_id;
            $product_category->category_id = isset($request->category) ? $request->category : 0;
            $product_category->save();

            if (!empty($toppingtype) || $toppingtype != '') {
                foreach ($toppingtype as $key => $value) {

                    $producttoppingtype = new ProductToppingType();
                    $producttoppingtype->id_product = $product->product_id;
                    $producttoppingtype->id_group_topping = isset($request->id_group_topping) ? $request->id_group_topping : "";
                    $producttoppingtype->typetopping = $toppingtype[$key];
                    $producttoppingtype->min_check = isset($request->min_check) ? $request->min_check : 0;
                    $producttoppingtype->max_check = isset($request->max_check) ? $request->max_check : 0;
                    $producttoppingtype->choose = isset($request->choose) ? $request->choose : 0;
                    $producttoppingtype->enable = $enable[$key];
                    $producttoppingtype->renamegroup = $renamegroup[$key];
                    $producttoppingtype->topping_sort_order = isset($request->topping_sort_order) ? $request->topping_sort_order : 0;
                    $producttoppingtype->save();
                }
            }

            if (!empty($price_size) || $price_size != '') {
                foreach ($price_size as $key => $price_sizes) {
                    $query = ToppingProductPriceSize::max('id_product_price_size');
                    $lastidsize = $query + 1;
                    $toppingProductPriceSize = new ToppingProductPriceSize;
                    $toppingProductPriceSize->id_product_price_size = $lastidsize;
                    $toppingProductPriceSize->price = $price_sizes;
                    $toppingProductPriceSize->id_size = $key;
                    $toppingProductPriceSize->id_product = $product->product_id;
                    $toppingProductPriceSize->delivery_price = '';
                    $toppingProductPriceSize->collection_price = '';
                    $toppingProductPriceSize->save();
                }
            }
        }
        return redirect()->route('products');
    }




    //  Import Products
    function importproducts()
    {
        // Check User Permission
        if (check_user_role(61) != 1) {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }

        return view('admin.product.importproducts');
    }




   //  Insert Products
    function add()
    {
        // Check User Permission
        if (check_user_role(49) != 1) {
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
        if ($current_store_id == 0) {
            $category = Category::with(['hasOneCategoryToStore'])->get();
        } else {
            $category = Category::with(['hasOneCategoryToStore'])->whereHas('hasOneCategoryToStore', function ($query) use ($current_store_id) {
                $query->where('store_id', $current_store_id);
            })->get();
        }
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





   //  Insert Products
    public function store(Request $request)
    {


        $request->validate([
            'product' => 'required',
            'mainprice' => 'required',
            // 'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'mainprice' => 'required',
            'category' => 'required',
        ]);

        $product = new Product();

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
        // $currentURL = public_url();
        // if ($request->hasFile('image'))
        // {
        //     $image = isset($catdetail['image']) ? $catdetail['image'] : '';
        //     if(!empty($image) || $image != '')
        //     {
        //         if(file_exists('public/admin/product/'.$image))
        //         {
        //             unlink('public/admin/product/'.$image);
        //         }
        //     }
        //     $imgname = time().".". $request->file('image')->getClientOriginalExtension();
        //     $request->file('image')->move(public_path('admin/product/'), $imgname);
        //     $producturl = $currentURL.'public/admin/product/';
        // }
        $product->image = $request->image;
        $product->save();

        $product_description = new ProductDescription();
        $product_description->product_id = $product->product_id;
        $product_description->language_id = 1;
        $product_description->name = isset($request->product) ? $request->product : 0;
        $product_description->description = isset($request->description) ? $request->description : '';
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


    // product size header
        public function productsizeprice(Request $request)
        {
            $category_id = $request->cat_id;

        $data = Product_to_category::select('p.*', 'pd.name as pname')->join('oc_product as p', 'p.product_id', '=', 'oc_product_to_category.product_id')->join('oc_product_description as pd', 'pd.product_id', '=', 'p.product_id')->where('category_id', $category_id)->orderBy('product_id','DESC')->get();

        $headers = ToppingSize::where('id_category', $category_id)->get();
        $head_count = count($headers) + 1;
        $html = '';
        $html .= '<tr>';
        $html .= '<th style="width:5%;"><input type="checkbox" name="checkall" id="del_all"></th>';
        $html .= '<th style="width:10%;">Image</th>';
        $html .= '<th style="width:20%;">Product Name</th>';
        // if (isset($head_count)) {
            $html .= '<th style="width:35%;" class="text-center">
                <p>Price</p>';
                $html .='<table class="table">';
                    $html .='<tr>';
                        $html .='<td style="width:50%;">Main Price</td>';
                        if (count($headers) > 0) {
                            foreach ($headers as $header) {
                                $html .= '<td style="background:lightgray">' . $header->size . '</td>';
                            }
                        }
                    $html .= '</tr>';
                $html .='</table>';
            $html .='</th>';
        // }
        // else {
        //     $html .= '<th class="text-center">Price</th>';
        // }
        $html .= '<th style="width:10%;">Status</th>';
        $html .= '<th style="width:10%;">Sort Order</th>';
        $html .= '<th style="width:10%;">Action</th>';
        $html .= '</tr>';


            return response()->json([
                // 'head_count' => $head_count,
                'subheader' => $html,
            ]);

        }


    // Get All Products
    public function getproduct(Request $request)
    {
        $category_id = $request->cat_id;

        if(!empty($category_id) || $category_id != ''){
            session()->put('current_category_id',$category_id);
        }
        $current_store_id = currentStoreId();
        $columns = array(
            0 => 'product_id',
            5 => 'sort_order',
        );

        // Get data
        $totledata = ProductDescription::with(['hasOneProduct', 'hasOneProductToStore', 'hasOnecategorytostore'])->whereHas('hasOnecategorytostore', function ($query) use ($category_id) {
            $query->where('category_id', $category_id);
        })->count();

        $totalFiltered = $totledata;
        $limit = $request->request->get('length');
        $start = $request->request->get('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');



        if (!empty($request->input('search.value'))) {
            $search = $request->input('search.value');

            $posts =  ProductDescription::with(['hasOneProduct', 'hasOneProductToStore', 'hasOnecategorytostore'])->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%");
            })
                ->whereHas('hasOnecategorytostore', function ($query) use ($category_id) {
                    $query->where('category_id', $category_id);
                })->offset($start)->orderBy($order, $dir)->limit($limit)->get();
            // print_r($posts);

            $totalFiltered = ProductDescription::with(['hasOneStore', 'hasOneProductToStore', 'hasOnecategorytostore'])->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%");
            })->whereHas('hasOnecategorytostore', function ($query) use ($category_id) {
                $query->where('category_id', $category_id);
            })->offset($start)->orderBy($order, $dir)->limit($limit)->count();
        } else {

            $posts = ProductDescription::with(['hasOneProduct', 'hasOneProductToStore', 'hasOnecategorytostore'])->orwhereHas('hasOnecategorytostore', function ($query) use ($category_id) {
                $query->where('category_id', $category_id);
            })->offset($start)->limit($limit)->orderBy($order, $dir)->get();


        }


        // echo '<pre>';
        // print_r($posts->toArray());
        // exit();
        $data = array();
        $data1 = array();

        $headers = ToppingSize::where('id_category',$category_id)->get();

        if ($posts) {
           $i=1; foreach ($posts as $post) {
                $product_id = $post->hasOneProduct->product_id;
                // $name = isset($post->name) ? $post->name : '';
                $status = isset($post->status) ? $post->status : '';
                $edit_url = route('editproduct', $post->product_id);
                $sizes = ToppingProductPriceSize::where('id_product', $post->hasOneProduct->product_id)->get();

                $data['checkbox'] = "<input type='checkbox' name='del_all' class='del_all' value='$product_id'>";
                $data['product_id'] = $product_id;
                $data['image'] = $post->hasOneProduct['image'];
                if (!empty($data['image'])) {
                    $image_path = $data['image'];
                    $data['image'] = '<img src="' . $image_path . '" alt="Not Found" width="40">';
                } else {
                    $image_path = asset('public/admin/no_image.jpg');
                    $data['image'] = '<img src="' . $image_path . '" alt="Not Found" width="40">';
                }
                $data['name'] = $post->name;

                 $html="";

                    $html.='<table class="table">';
                        $html.='<tbody>';
                            $html.='<tr>';
                                $html.='<td style="width:50%;">'.$post->hasOneProduct->price.'</td>';
                                 if (count($sizes) > 0) {
                                    foreach ($sizes as $value1) {
                                        $header1 = ToppingSize::where('id_size',$value1->id_size)->first();
                                        if(!empty($header1))
                                        {
                                                $html.= '<td>' . $value1->price . '</td>';
                                        }
                                    }
                                }else{
                                    foreach ($headers as $header){

                                        {
                                            $html.= '<td>-</td>';
                                        }
                                    }
                                }
                            $html.='</tr>';
                        $html.='</tbody>';
                    $html.='</table>';



                $data['price'] = $html;
                $data['status'] = $post->hasOneProduct->status == 1 ? 'Enabled' : 'Disabled';
                $data['sort_order'] = $post->hasOneProduct->sort_order;
                $data['action'] = '<a href="' . $edit_url . '" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>';

                $data1[] = $data;
            $i++;
            }
        }

        $json_data = array(
            "draw"            => intval($request->request->get('draw')),
            "recordsTotal"    => intval($totledata),
            "recordsFiltered" => intval(isset($totalFiltered) ? $totalFiltered : ''),
            "data"            => $data1,
        );

        echo json_encode($json_data);
    }





   // Get Option
    public function getoptionhtml(Request $request)
    {
        $option = DB::table('oc_option')->where('type', $request->type)->get();
        return response()->json([
            'option' => $option,
        ]);
    }




    // Add Option
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




   // Delete Products
    public function deleteproduct(Request $request)
    {
        // Check User Permission
        if (check_user_role(52) != 1) {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }

        $ids = $request['id'];

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




   // Edit Products
    public function edit($id)
    {

        $product = Product::select('*')->join('oc_product_description', 'oc_product.product_id', '=', 'oc_product_description.product_id')->leftjoin('oc_product_to_category', 'oc_product.product_id', '=', 'oc_product_to_category.product_id')->where('oc_product.product_id', $id)->first();

        $prod_id = isset($product->category_id) ? $product->category_id : '';

        $header = ToppingSize::where('id_category', $prod_id)->get();

        $price = ToppingProductPriceSize::where('id_product', $id)->get();
        $current_store_id = currentStoreId();
        $category = Category::with(['hasOneCategoryToStore'])->whereHas('hasOneCategoryToStore', function ($query) use ($current_store_id) {
            $query->where('store_id', $current_store_id);
        })->orderBy('category_id','DESC')->get();
        $product_icon = ProductIcons::select('*')->get();
        $toppingType = ProductToppingType::leftJoin('oc_topping', 'oc_topping.id_topping', '=', 'oc_product_topping_type.id_group_topping')->where('oc_product_topping_type.id_product', $id)->first();


        $result['category'] = $category;
        $result['product_icon'] = $product_icon;
        $result['header'] = $header;
        $result['price'] = $price;
        $result['toppingType'] = $toppingType;

        return view('admin.product.edit', ['product' => $product, 'result' => $result]);
    }




    // Update Products
    public function update(Request $request)
    {
        $request->validate([
            'product' => 'required',
            // 'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $product_id = $request->product_id;

        $product = Product::find($product_id);
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
        // $icon = $request['product_icons'];
        // $product_icons = implode(',', $icon);
        if (!empty($icon = $request['product_icons'])) {
            $product_icons = implode(',', $icon);
            $product->product_icons = isset($product_icons) ? $product_icons : 0;
        }
        $product->product_icons = isset($product_icons) ? $product_icons : 0;
        $order_type = $request['order_type'];
        $product->order_type = isset($order_type) ? $order_type : 0;
        $day = $request['day'];
        if (!empty($day))
        {
            $days = implode(',', $day);
            $product->availibleday = isset($days) ? $days : '';
        }

        // $currentURL = public_url();
        // if ($request->hasFile('image'))
        // {
        //     $image = isset($catdetail['image']) ? $catdetail['image'] : '';
        //     if(!empty($image) || $image != '')
        //     {
        //         if(file_exists('public/admin/product/'.$image))
        //         {
        //             unlink('public/admin/product/'.$image);
        //         }
        //     }
        //     $imgname = time().".". $request->file('image')->getClientOriginalExtension();
        //     $request->file('image')->move(public_path('admin/product/'), $imgname);
        //     $producturl = $currentURL.'public/admin/product/';
        //     $product->image = $producturl.$imgname;
        // }
        if($request->image != ''){
            $product->image = $request->image;
        }
        $product->update();

        $product_description = ProductDescription::find($product_id);
        $product_description->language_id = 1;
        $product_description->name = isset($request->product) ? $request->product : 0;
        $product_description->description = isset($request->description) ? $request->description : '';
        $product_description->meta_description = isset($request->meta_description) ? $request->meta_description : '';
        $product_description->meta_keyword = isset($request->meta_keyword) ? $request->meta_keyword : '';
        $product_description->tag = isset($request->tag) ? $request->tag : '';
        $product_description->update();

        $product_category = Product_to_category::find($product_id);
        $product_category->category_id = isset($request->category) ? $request->category : 0;
        $product_category->update();

        $type_topping = isset($request->topping) ? $request->topping : '';


        if (!empty($type_topping) || $type_topping != '')
        {

            foreach($type_topping as $topping)
            {
                $id_group_topping = isset($topping['id']) ? $topping['id'] : '';
                $typetopping = isset($topping['typetopping']) ? $topping['typetopping'] : '';
                $maximum = isset($topping['maximum']) ? $topping['maximum'] : '';
                $minimum = isset($topping['minimum']) ? $topping['minimum'] : '';
                $status = isset($topping['status']) ? $topping['status'] : 1;
                $rename = isset($topping['rename']) ? $topping['rename'] : 1;
                $sortorder = isset($topping['sortorder']) ? $topping['sortorder'] : 1;


                $toppingtype = ProductToppingType::where('id_group_topping',$id_group_topping)->where('id_product',$product_id)->first();

                $id_topping = isset($toppingtype['id']) ? $toppingtype['id'] : '';

                if(!empty($id_topping) || $id_topping != '')
                {
                    $edit_toppingtype = ProductToppingType::find($id_topping);
                    $edit_toppingtype->typetopping =  $typetopping;
                    $edit_toppingtype->min_check = $minimum;
                    $edit_toppingtype->max_check = $maximum;
                    $edit_toppingtype->choose = isset($request->choose) ? $request->choose : '';
                    $edit_toppingtype->enable = $status;
                    $edit_toppingtype->renamegroup = $rename;
                    $edit_toppingtype->topping_sort_order = $sortorder;
                    $edit_toppingtype->update();
                }
                else
                {
                    $new_toppingtype = new ProductToppingType;
                    $new_toppingtype->id_product =  $product_id;
                    $new_toppingtype->id_group_topping = $id_group_topping;
                    $new_toppingtype->typetopping =  $typetopping;
                    $new_toppingtype->min_check = $minimum;
                    $new_toppingtype->max_check = $maximum;
                    $new_toppingtype->choose = isset($request->choose) ? $request->choose : '';
                    $new_toppingtype->enable = $status;
                    $new_toppingtype->renamegroup = $rename;
                    $new_toppingtype->topping_sort_order = $sortorder;
                    $new_toppingtype->save();
                }

            }

        }

        $mainprice = isset($request->mainprices) ? $request->mainprices : "";
        $mainprice = $request->mainprices;
        $collectionprice = isset($request->collectionprices) ? $request->collectionprices : "";
        $deliveryprice = isset($request->deliveryprices) ? $request->deliveryprices : "";
        $price_size_id = $request->id_product_price_size;
        $id_size = $request->id_size;

        if(!empty($id_size) || $id_size != '')
        {
            if (!empty($price_size_id))
            {
                foreach ($mainprice as $key => $mainprices)
                {
                    $where = $price_size_id[$key];
                    $toppingProductPriceSize = ToppingProductPriceSize::find($where);
                    $toppingProductPriceSize->price = $mainprices;
                    $toppingProductPriceSize->delivery_price = $deliveryprice[$key];
                    $toppingProductPriceSize->collection_price = $collectionprice[$key];
                    $toppingProductPriceSize->update();
                }
            }
            else
            {
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
        }

        return redirect()->route('products')->with('success', "Product Updated Successfully..");
    }





}
