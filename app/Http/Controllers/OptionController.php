<?php

namespace App\Http\Controllers;

use App\Models\CategorytoStore;
use Illuminate\Http\Request;
use App\Models\Option;
use App\Models\OptionDescription;
use App\Models\ProductOptionMapping;
use App\Models\ProductStore;
use App\Models\Settings;
use App\Models\Topping;
use App\Models\ToppingOption;
use App\Models\ToppingSize;
use DataTables;

class OptionController extends Controller
{
   function index()
   {
       return view('admin.menuoptions.list');
   }

   function add()
   {
       $data['suboptions'] = Topping::where('store_topping',1)->get();
       return view('admin.menuoptions.add',$data);
   }


   function insert(Request $request)
   {
        $option_toppings = $request->optiontopping;

        $request->validate([
            'groupName'=> 'required',
        ]);

        $groupname = $request->groupName;
        $grouptitle = $request->show_group_title;
        $grouptitlecolor = $request->group_title_color;
        $headermessage = $request->topping_header_message;
        $footermessage = $request->topping_footer_message;

        $topping = new Topping;
        $topping->store_topping = 1;
        $topping->name_topping = $groupname;
        $topping->show_group_title = $grouptitle;
        $topping->group_title_color = $grouptitlecolor;
        $topping->topping_header_message = isset($headermessage) ? $headermessage : '';
        $topping->topping_footer_message = isset($footermessage) ? $footermessage : '';
        $topping->save();


        foreach($option_toppings as $optopping)
        {

            $name = $optopping['name'];
            $main_price = $optopping['price_main'];
            $order = $optopping['order'];
            $sub_option = isset($optopping['sub_option']) ? $optopping['sub_option'] : '';

            $option_topp = new ToppingOption;
            $option_topp->name = isset($name) ? $name : '';
            $option_topp->price_main = isset($main_price) ? $main_price : 0;
            $option_topp->id_group_topping = $topping->id_topping;
            $option_topp->order = isset($order) ? $order : 0;
            $option_topp->sub_option = isset($sub_option) ? serialize($sub_option) : '';
            $option_topp->line_title = '';
            $option_topp->price_font_color = '';
            $option_topp->save();
        }

        return redirect()->route('option')->with('success','Topping has been Added Successfully..');

   }


   function newmodel(Request $request)
   {
       $val = $request->val;
       $key = 'new_module_status';

       if($val == 1)
       {

            $getnewmodel = Settings::where('key',$key)->first();

            if(!empty($getnewmodel) || $getnewmodel != '')
            {
                $html = '';
                $html .= '<button class="btn btn-xs btn-success" onclick="newModel(1)">Enabled</button>';
                $html .= '<button class="btn btn-xs btn-secondary" onclick="newModel(0)">Disabled</button>';

                return response()->json([
                    'success' => 1,
                    'html' => $html
                ]);
            }
            else
            {
                $setting = new Settings;
                $setting->store_id = 0;
                $setting->group = 'config';
                $setting->key = $key;
                $setting->value = $val;
                $setting->serialized = 0;
                $setting->save();

                $html = '';
                $html .= '<button class="btn btn-xs btn-success" onclick="newModel(1)">Enabled</button>';
                $html .= '<button class="btn btn-xs btn-secondary" onclick="newModel(0)">Disabled</button>';

                return response()->json([
                    'success' => 1,
                    'html' => $html
                ]);
            }
       }
       else
       {
            Settings::where('key',$key)->delete();
            $html = '';
            $html .= '<button class="btn btn-xs btn-secondary" onclick="newModel(1)">Enabled</button>';
            $html .= '<button class="btn btn-xs btn-danger" onclick="newModel(0)">Disabled</button>';

            return response()->json([
                'success' => 1,
                'html' => $html
            ]);
       }

   }




   function gettoppings(Request $request)
   {
    if ($request->ajax()) {
        $data = Topping::select('*');
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){

            $edit_url = route('edittopping',$row->id_topping);
            $btn = '<a href="'.$edit_url.'" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>';

            return $btn;
        })
        ->addColumn('checkbox', function($row){
            $tid = $row->id_topping;
            $checkbox = '<input type="checkbox" name="del_all" class="del_all" value="'.$tid.'">';
            return $checkbox;
        })
        ->rawColumns(['action','checkbox'])
        ->make(true);
    }

    return view('admin.customers.list');
   }



   function delete(Request $request)
   {
        $ids = $request['id'];

        if(count($ids) > 0)
        {
            // Delete Topping
            Topping::whereIn('id_topping',$ids)->delete();

            // Delete Topping Options
            foreach($ids as $id)
            {
                ToppingOption::where('id_group_topping',$id)->delete();
            }

            return response()->json([
                'success' => 1,
            ]);
        }
   }


   function edit(Request $request,$id)
   {
        $data['suboptions'] = Topping::where('store_topping',1)->where('id_topping','!=',$id)->get();

        $data['topping'] = Topping::where('id_topping',$id)->first();

        $data['toppingoptions'] = ToppingOption::where('id_group_topping',$id)->get();

        $data['optionsmappings'] = ProductOptionMapping::select('oc_product_options_mapping.*','cd.name as cname','pd.name as pname','ts.size as sizename')->leftJoin('oc_category_description as cd','cd.category_id','=','oc_product_options_mapping.category_id')->leftJoin('oc_product_description as pd','pd.product_id','=','oc_product_options_mapping.product_id')->leftJoin('oc_topping_size as ts','ts.id_size','=','oc_product_options_mapping.size')->where('topping_id',$id)->get();

        $data['categoriesbystore'] = CategorytoStore::select('oc_category_to_store.*','cd.name as cname')->join('oc_category_description as cd','cd.category_id','=','oc_category_to_store.category_id')->where('oc_category_to_store.store_id','=',1)->get();

        $data['productsbystore'] = ProductStore::select('oc_product_to_store.*','pd.name as pname')->join('oc_product_description as pd','pd.product_id','=','oc_product_to_store.product_id')->where('oc_product_to_store.store_id','=',1)->get();

        $data['toppingsizebystore'] = CategorytoStore::select('oc_category_to_store.*','ts.size as tsize','ts.id_size as size_id')->join('oc_topping_size as ts','ts.id_category','=','oc_category_to_store.category_id')->where('oc_category_to_store.store_id','=',1)->get();

       return view('admin.menuoptions.edit',$data);
   }



   function delToppingOption(Request $request)
   {
       $topping_option_id = $request->top_opt_Id;

       // Delete Topping Option
       ToppingOption::where('id_topping_option',$topping_option_id)->delete();

       return response()->json([
           'success' => 1,
       ]);
   }


   function storemapping(Request $request)
   {
       $topping_id = $request->top_id;
       $order_type = $request->order_type;
       $category_id = $request->category;
       $product_id = $request->product;
       $topping_rename = $request->topping_rename;
       $size_id = $request->size;
       $min_item = $request->min_item;
       $max_item = $request->max_item;
       $days = isset($request->days) ? implode(",",$request->days) : '';
       $start = $request->start_time;
       $end = $request->end_time;
       $numFree = $request->num_free;
       $price = $request->price;
       $sub_option = isset($request->sub_option) ? implode(',',$request->sub_option) : '';
       $style = $request->style;
       $sort_order = $request->sort_order;

        $mapping = new ProductOptionMapping;
        $mapping->store_id = 1;
        $mapping->topping_id = isset($topping_id) ? $topping_id : '';
        $mapping->topping_rename = isset($topping_rename) ? $topping_rename : '';
        $mapping->order_type = isset($order_type) ? $order_type : '';
        $mapping->category_id = isset($category_id) ? $category_id : '';
        $mapping->product_id = isset($product_id) ? $product_id : '';
        $mapping->min_item = isset($min_item) ? $min_item : '';
        $mapping->max_item = isset($max_item) ? $max_item : '';
        $mapping->days = isset($days) ? $days : '';
        $mapping->start_time = isset($start) ? $start : '';
        $mapping->end_time = isset($end) ? $end : '';
        $mapping->no_free = isset($numFree) ? $numFree : '';
        $mapping->price = isset($price) ? $price : '';
        $mapping->style = isset($style) ? $style : '';
        $mapping->sort_order = isset($sort_order) ? $sort_order : '';
        $mapping->sub_option = isset($sub_option) ? $sub_option : '';
        $mapping->size = isset($size_id) ? $size_id : '';
        $mapping->save();

       return response()->json('success');

   }


}
