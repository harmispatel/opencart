<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductDescription;
use App\Models\Category;
use App\Models\ProductIcon;
use App\Models\Reward;
use App\Models\Product_to_category;
use App\Models\ProductStore;
use DataTables;





use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    function index()
    {
        // Check User Permission
        if(check_user_role(58) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }

        $show_product = Product::join('oc_product_description', 'oc_product.product_id', '=', 'oc_product_description.product_id')->get();
        return view('admin.product.list', ['show_product' => $show_product]);
    }




    function add()
    {
         // Check User Permission
         if(check_user_role(59) != 1)
         {
             return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
         }

         $manufacturer = DB::table('oc_manufacturer')->select('*')->get();
         $category = DB::table('oc_category_description')->select('*')->get();
         $releted_product = DB::table('oc_product_description')->select('*')->get();
         $product_layout = DB::table('oc_layout')->select('*')->get();
         // $option = DB::table('oc_option')->select('*')->get();
         $stok_status = DB::table('oc_stock_status')->select('*')->get();
         $tex_class = DB::table('oc_tax_class')->select('*')->get();
         $lenght_class = DB::table('oc_length_class_description')->select('*')->get();
         $weight_class = DB::table('oc_weight_class_description')->select('*')->get();
         $category = Category::select('*')->get();
         $product_icon = ProductIcon::select('*')->get();

        //  echo '<pre>';
        //  print_r($productIcon);
        //  exit();

         $result['manufacturer'] = $manufacturer;
         $result['category'] = $category;
         $result['releted_product'] = $releted_product;
         $result['product_layout'] = $product_layout;
         // $result['option'] = $option;
         $result['stok_status'] = $stok_status;
         $result['tex_class'] = $tex_class;
         $result['lenght_class'] = $lenght_class;
         $result['weight_class'] = $weight_class;
         $result['category'] = $category;
         $result['product_icon'] = $product_icon;



         $option = DB::table('oc_option_description')->select('*')->get();

         return view('admin.product.add', ['result' => $result ,'option'=>$option]);
    }

    public function store(Request $request){
        
       
        $product= new Product();
        $product->model=isset($request->model) ? $request->model :0;
        $product->sku=isset($request->sku) ? $request->sku :0;
        $product->upc=isset($request->upc) ? $request->upc :0;
        $product->ean=isset($request->ean) ? $request->ean :0;
        $product->jan=isset($request->jan) ? $request->jan :0;
        $product->isbn=isset($request->isbn) ? $request->isbn :0;
        $product->mpn=isset($request->mpn) ? $request->mpn :0;
        $product->location=isset($request->location) ? $request->location :0;
        $product->stock_status_id=isset($request->stock_status_id) ? $request->stock_status_id :0;
        $product->manufacturer_id=isset($request->manufacturer_id) ? $request->manufacturer_id :0;
        $product->date_available=isset($request->date_available) ? $request->date_available :0;
        $product->date_added=isset($request->date_added) ? $request->date_added :0;
        $product->date_modified=isset($request->date_modified) ? $request->date_modified :0;
        $product->tax_class_id=isset($request->tax_class_id) ? $request->tax_class_id :0;
        $product->price=isset($request->mainprice) ? $request->mainprice :0;
        $product->delivery_price=isset($request->deliveryprice) ? $request->deliveryprice :0;
        $product->collection_price=isset($request->collectionprice) ? $request->collectionprice :0;
        $product->status=isset($request->status) ? $request->status :0;
        $product->sort_order=isset($request->sort_order) ? $request->sort_order :0;
        $icon=$request['product_icons'];
        $product_icons=implode(',',$icon);
        $product->product_icons=isset($product_icons) ? $product_icons :0;
        $data=$request['order_type'];
        $order_type=implode('',$data);
        $product->order_type=isset($order_type) ? $order_type :0;
        $day=$request['day'];
        $days=implode(',',$day);
        $product->availibleday=isset($days) ? $days :0;
        if ($request->hasfile('image')) {
            $Image = $request->file('image');
            $filename = $Image->getClientOriginalName();
            $Image->move(public_path('/admin/product/'), $filename);
            $product->image = $filename;
        }
        $product->save();

        $product_description=new ProductDescription();
        $product_description->product_id= $product->id;
        $product_description->language_id=1;
        $product_description->name=isset($request->product) ? $request->product :0;
        $product_description->description=isset($request->description) ? $request->description :0;
        $product_description->meta_description=isset($request->meta_description) ? $request->meta_description :'';
        $product_description->meta_keyword=isset($request->meta_keyword) ? $request->meta_keyword :'';
        $product_description->tag=isset($request->tag) ? $request->tag :'';
        $product_description->save();

        $reward=new Reward();
        $reward->product_id= $product->id;
        $reward->customer_group_id=1;
        $reward->points=0;
        $reward->save();

        $product_category= new Product_to_category();
        $product_category->product_id= $product->id;
        $product_category->category_id=isset($request->category) ? $request->category :0; 
        $product_category->save();

        $productstore= new ProductStore();
        $productstore->product_id= $product->id;
        $productstore->store_id=isset($request->store_id) ? $request->store_id :0; 
        $productstore->save();
        return redirect()->route('products')->with('success', "Product Inserted Successfully..");


    }


      public function getproduct(Request $request){
        if ($request->ajax()) {
            // $data =  Product::select('*')->join('oc_product_description', 'oc_product.product_id', '=', 'oc_product_description.product_id');
            $data =ProductDescription::select('*')->join('oc_product','oc_product_description.product_id','=','oc_product.product_id')->get();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){

                $edit_url = route('editcustomer',$row->product_id);
                $btn = '<a href="'.$edit_url.'" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>';

                return $btn;
            })
            
            ->addColumn('image', function($row){
                if(!empty($row->image)){
                    $image_path = asset('public/admin/product/'.$row->image);
                    $image = '<img src="'.$image_path.'" alt="Not Found" width="40">';
                }else{
                    $image_path = asset('public/admin/product/no_image.jpg');
                    $image = '<img src="'.$image_path.'" alt="Not Found" width="40">';
                }
               
                return $image;
            })
            
            ->addColumn('checkbox', function($row){
                $pid = $row->product_id;
                $checkbox = '<input type="checkbox" name="del_all" class="del_all" value="'.$pid.'">';
                return $checkbox;
            })
            ->rawColumns(['action','checkbox','image'])
            ->make(true);
        }
      }





    public function getoptionhtml(Request $request){
        $option = DB::table('oc_option')->where('type',$request->type)->get();
        return response()->json([
            'option' => $option,
        ]);
    }
    public function addOptionValue(Request $request){
       echo '<pre>';
       print_r($request->optionTypeId);
       exit();   
        $option_value = DB::table('oc_option_value_description')->where('option_id',$request->optionTypeId)->get();
        print_r($option_value);die;
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


}
