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

            // Delete Topping Options Mapping
            foreach($ids as $id)
            {
                ProductOptionMapping::where('topping_id',$id)->delete();
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


   function update(Request $request)
   {
       $id_topping = $request->id_topping;
       $option_toppings = $request->optiontopping;

        $request->validate([
            'groupName'=> 'required',
        ]);

        $groupname = $request->groupName;
        $grouptitle = $request->show_group_title;
        $grouptitlecolor = $request->group_title_color;
        $headermessage = $request->topping_header_message;
        $footermessage = $request->topping_footer_message;

        $topping = Topping::find($id_topping);
        $topping->name_topping = $groupname;
        $topping->show_group_title = $grouptitle;
        $topping->group_title_color = $grouptitlecolor;
        $topping->topping_header_message = isset($headermessage) ? $headermessage : '';
        $topping->topping_footer_message = isset($footermessage) ? $footermessage : '';
        $topping->update();

        foreach($option_toppings as $optopping)
        {
            $name = $optopping['name'];
            $main_price = $optopping['price_main'];
            $order = $optopping['order'];
            $sub_option = isset($optopping['sub_option']) ? $optopping['sub_option'] : '';

            if(!empty($optopping['id_topping_option']))
            {
                $option_topp = ToppingOption::find($optopping['id_topping_option']);
                $option_topp->name = isset($name) ? $name : '';
                $option_topp->price_main = isset($main_price) ? $main_price : 0;
                $option_topp->order = isset($order) ? $order : 0;
                $option_topp->sub_option = isset($sub_option) ? serialize($sub_option) : '';
                $option_topp->update();
            }
            else
            {
                $option_topp = new ToppingOption;
                $option_topp->name = isset($name) ? $name : '';
                $option_topp->price_main = isset($main_price) ? $main_price : 0;
                $option_topp->id_group_topping = $id_topping;
                $option_topp->order = isset($order) ? $order : 0;
                $option_topp->sub_option = isset($sub_option) ? serialize($sub_option) : '';
                $option_topp->line_title = '';
                $option_topp->price_font_color = '';
                $option_topp->save();
            }

        }

        return redirect()->route('option')->with('success','Topping has been Updated Successfully..');

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
        $mapping->category_id = isset($category_id) ? $category_id : 0;
        $mapping->product_id = isset($product_id) ? $product_id : 0;
        $mapping->min_item = isset($min_item) ? $min_item : '';
        $mapping->max_item = isset($max_item) ? $max_item : '';
        $mapping->days = isset($days) ? $days : '';
        $mapping->start_time = isset($start) ? $start : '00:00:00';
        $mapping->end_time = isset($end) ? $end : '00:00:00';
        $mapping->no_free = isset($numFree) ? $numFree : 0;
        $mapping->price = isset($price) ? $price : 0;
        $mapping->style = isset($style) ? $style : '';
        $mapping->sort_order = isset($sort_order) ? $sort_order : 0;
        $mapping->sub_option = isset($sub_option) ? $sub_option : '';
        $mapping->size = isset($size_id) ? $size_id : '';
        $mapping->save();

       return response()->json('success');

   }


   function updatemapping(Request $request)
   {
        $map_id = $request->map_id;
        $order_type = $request->order_type;
        $category_id = $request->category;
        $product_id = $request->product;
        $topping_rename = $request->rename;
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

        $mapping = ProductOptionMapping::find($map_id);
        $mapping->topping_rename = isset($topping_rename) ? $topping_rename : '';
        $mapping->order_type = isset($order_type) ? $order_type : '';
        $mapping->category_id = isset($category_id) ? $category_id : 0;
        $mapping->product_id = isset($product_id) ? $product_id : 0;
        $mapping->min_item = isset($min_item) ? $min_item : '';
        $mapping->max_item = isset($max_item) ? $max_item : '';
        $mapping->days = isset($days) ? $days : '';
        $mapping->start_time = isset($start) ? $start : '00:00:00';
        $mapping->end_time = isset($end) ? $end : '00:00:00';
        $mapping->no_free = isset($numFree) ? $numFree : 0;
        $mapping->price = isset($price) ? $price : 0;
        $mapping->style = isset($style) ? $style : '';
        $mapping->sort_order = isset($sort_order) ? $sort_order : 0;
        $mapping->sub_option = isset($sub_option) ? $sub_option : '';
        $mapping->size = isset($size_id) ? $size_id : '';
        $mapping->update();

       return response()->json('success');

   }


   function deletemapping(Request $request)
   {
        $ids = $request['id'];

        if(count($ids) > 0)
        {
            // Delete Topping
            ProductOptionMapping::whereIn('id',$ids)->delete();

            return response()->json([
                'success' => 1,
            ]);
        }
   }

   function editmapping(Request $request)
   {
       $map_id = $request->id;

       $map_details = ProductOptionMapping::where('id',$map_id)->first();

       $categoriesbystore = CategorytoStore::select('oc_category_to_store.*','cd.name as cname')->join('oc_category_description as cd','cd.category_id','=','oc_category_to_store.category_id')->where('oc_category_to_store.store_id','=',1)->get();

       $productsbystore = ProductStore::select('oc_product_to_store.*','pd.name as pname')->join('oc_product_description as pd','pd.product_id','=','oc_product_to_store.product_id')->where('oc_product_to_store.store_id','=',1)->get();

       $toppingsizebystore = CategorytoStore::select('oc_category_to_store.*','ts.size as tsize','ts.id_size as size_id')->join('oc_topping_size as ts','ts.id_category','=','oc_category_to_store.category_id')->where('oc_category_to_store.store_id','=',1)->get();

       $suboptions = Topping::where('store_topping',1)->where('id_topping','!=',$map_details->topping_id)->get();

        $html = '';

        $html .= '<tr class="trow'.$map_id.'">';

        $html .= '<td></td>';

        $html .= '<td class="align-middle"><select name="order_type" id="order_type_'.$map_id.'"><option value="*"'; ($map_details->order_type == '*') ? $html .= 'selected' : ''; $html .='>*</option><option value="delivery"'; ($map_details->order_type == 'delivery') ? $html .= 'selected' : ''; $html .='>Delivery</option><option value="collection"'; ($map_details->order_type == 'collection') ? $html .= 'selected' : ''; $html .='>Collection</option></select><input type="hidden" name="map_id" id="map_id_'.$map_id.'" value="'.$map_details->id.'">';

        $html .= '<td class="align-middle"><select name="category" id="category_'.$map_id.'"><option value=""> -- Select Category -- </option>';
        foreach($categoriesbystore as $category)
        {
            $html .= '<option value="'.$category->category_id.'"';
            ($category->category_id == $map_details->category_id) ? $html .= 'selected' : '';
            $html .='>'.$category->cname.'</option>';
        }
        $html .= '</select></td>';

        $html .= '<td class="align-middle"><select name="product" id="product_'.$map_id.'"><option value=""> -- Select Product -- </option>';
        foreach($productsbystore as $product)
        {
            $html .= '<option value="'.$product->product_id.'"';
            ($product->product_id == $map_details->product_id) ? $html .= 'selected' : '';
            $html .='>'.$product->pname.'</option>';
        }
        $html .= '</select></td>';

        $html .= '<td class="align-middle"><input type="text" value="'.$map_details->topping_rename.'" name="topping_rename" id="topping_rename_'.$map_id.'"></td>';

        $html .= '<td class="align-middle"><select name="size" id="size_'.$map_id.'"><option value=""> -- Select Size -- </option>';
        foreach($toppingsizebystore as $size)
        {
            $html .= '<option value="'.$size->size_id.'"';
            ($size->size_id == $map_details->size) ? $html .= 'selected' : '';
            $html .='>'.$size->tsize.'</option>';
        }
        $html .= '</select></td>';

        $html .= '<td class="align-middle"><input type="number" name="min_item" id="min_item_'.$map_id.'" value="'.$map_details->min_item.'"></td>';

        $html .= '<td class="align-middle"><input type="number" name="max_item" id="max_item_'.$map_id.'" value="'.$map_details->max_item.'"></td>';

        $arr = explode(',',$map_details->days);

        $html .= '<td class="align-middle"><select name="days[]" id="days_'.$map_id.'" multiple><option value="Sun"'; (in_array("Sun",$arr)) ? $html .= 'selected' : '';  $html .= '>Sunday</option><option value="Mon"'; (in_array("Mon",$arr)) ? $html .= 'selected' : '';  $html .= '>Monday</option><option value="Tue"'; (in_array("Tue",$arr)) ? $html .= 'selected' : '';  $html .= '>Tuesday</option><option value="Wed"'; (in_array("Wed",$arr)) ? $html .= 'selected' : '';  $html .= '>Wedensday</option><option value="Thu"'; (in_array("Thu",$arr)) ? $html .= 'selected' : '';  $html .= '>Thursday</option><option value="Fri"'; (in_array("Fri",$arr)) ? $html .= 'selected' : '';  $html .= '>Friday</option><option value="Sat"'; (in_array("Sat",$arr)) ? $html .= 'selected' : '';  $html .= '>Saturday</option></select></td>';

        $html .= '<td class="align-middle"><input type="time" name="start_time" id="start_time_'.$map_id.'" value="'.$map_details->start_time.'"></td>';

        $html .= '<td class="align-middle"><input type="time" name="end_time" id="end_time_'.$map_id.'" value="'.$map_details->end_time.'"></td>';

        $html .= '<td class="align-middle"><input type="number" name="num_free" id="num_free_'.$map_id.'" value="'.$map_details->no_free.'"></td>';

        $html .= '<td class="align-middle"><input type="number" name="price" id="price_'.$map_id.'" value="'.$map_details->price.'"></td>';

        $arr2 = explode(',',$map_details->sub_option);

        $html .= '<td class="align-middle"><select name="sub_option[]" id="sub_option_'.$map_id.'" multiple>';
        foreach($suboptions as $suboption)
        {
            $html .= '<option value="'.$suboption->id_topping.'"';
            ($suboption->id_topping == in_array($suboption->id_topping,$arr2)) ? $html .= 'selected' : '';
            $html .='>'.$suboption->name_topping.'</option>';
        }
        $html .= '</select></td>';

        $html .= '<td class="align-middle"><select name="style" id="style_'.$map_id.'"><option value="tick_boxes"'; ($map_details->style == 'tick_boxes') ? $html .= 'selected' : ''; $html .='>Tick Boxes</option><option value="button_box"'; ($map_details->style == 'button_box') ? $html .= 'selected' : ''; $html .='>Button Box</option></select>';

        $html .= '<td class="align-middle"><input type="number" name="sort_order" id="sort_order_'.$map_id.'" value="'.$map_details->sort_order.'"></td>';

        $html .= '<td class="align-middle"><a class="btn btn-sm btn-success" onclick="updateMapping('.$map_id.')"><i class="fa fa-save"></i></a></td>';

        $html .= '</tr>';

        return response()->json($html);

   }


}
