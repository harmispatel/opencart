<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryDetail;
use App\Models\CategoryLayout;
use App\Models\CategoryPath;
use App\Models\CategorytoStore;
use App\Models\Topping;
use App\Models\ToppingCatOption;
use App\Models\ToppingSize;
use Illuminate\Http\Request;
use DataTables;

class CategoryController extends Controller
{
    // Function of Category View
    function index()
    {
        // Check User Permission
        if (check_user_role(50) != 1) 
        {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }

        return view('admin.category.CategoryList');
    }





    // Function of Get all Categories
    public function getcategory(Request $request)
    {
        // Current Store ID;
        $current_store_id = currentStoreId();

        if($request->ajax())
        {
            // Get Categories By Selected Store
            $data = CategoryDetail::with(['hasOneCategory','hasManyCategoryStore'])->whereHas('hasManyCategoryStore', function ($query) use ($current_store_id){
                $query->where('store_id',$current_store_id);
            })->get();

            return DataTables::of($data)->addIndexColumn()
            ->addColumn('action', function($row){
                $edit_url = route('categoryedit',$row->category_id);
                $btn = '<a href="'.$edit_url.'" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>';
                return $btn;
            })
            ->addColumn('cat_name', function($row){
                $name = $row->hasOneCategory->name;
                return $name;
            })
            ->addColumn('checkbox', function($row){
                $cid = $row->category_id;
                $checkbox = '<input type="checkbox" name="del_all" class="del_all" value="'.$cid.'">';
                return $checkbox;
            })
            ->rawColumns(['action','checkbox','cat_name'])
            ->make(true);
        }
    }





    // Function of Insert Category
    function categoryinsert(Request $request)
    {
        // Current Store ID
        $current_store_id = currentStoreId();

        // Validation Of Category Fields
        $request->validate([
            'category' => 'required',
        ]);

        // Insert Category Details
        $catdetail = new CategoryDetail;

        // Insert Category Image
        if ($request->hasFile('image'))
        {
            $imgname = time() . "." . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('admin/category'), $imgname);
        }

        // Insert Banner Image
        if ($request->hasFile('banner')) {
            $bannerimgname = time() . "." . $request->file('banner')->getClientOriginalExtension();
            $request->file('banner')->move(public_path('admin/category/banner'), $bannerimgname);
        }

        $catdetail->image = isset($imgname) ? $imgname : '';
        $catdetail->img_banner = isset($bannerimgname) ? $bannerimgname : '';
        $availibleday = implode(",", $request->availibleday);
        $catdetail->parent_id = isset($request->parent) ? $request->parent : 0;
        $catdetail->top = isset($request->top) ? $request->top : 1;
        $catdetail->column = isset($request->columns) ? $request->columns : 1;
        $catdetail->sort_order = isset($request->sortorder) ? $request->sortorder : 0;
        $catdetail->status = isset($request->status) ? $request->status : 0;
        date_default_timezone_set('Asia/Kolkata');
        $catdetail->date_added = date("Y-m-d h:i:s");
        $catdetail->date_modified = date("Y-m-d h:i:s");
        $catdetail->availibleday = $availibleday;
        $catdetail->save();
        $lastid = $catdetail->category_id;

        // Category Path
        $cat_path = new CategoryPath;
        $cat_path->category_id = $lastid;
        $cat_path->path_id = $lastid;
        $cat_path->level = 0;
        $cat_path->save();

        // Insert Into Category to Store
        $cat_to_store = new CategorytoStore;
        $cat_to_store->category_id = $lastid;
        $cat_to_store->store_id = $current_store_id;
        $cat_to_store->save();

        // Insert Category
        $cat = new Category;
        $cat->category_id = $lastid;
        $cat->language_id = '1';
        $cat->name = $request->category;
        $cat->description = isset($request->description) ? $request->description : "";
        $replaceslug = str_replace(' ','-',$request->category);
        $slug = strtolower($replaceslug);
        $cat->slug = $slug;
        $cat->meta_description = isset($request->metadesc) ? $request->metadesc : "";
        $cat->meta_keyword = isset($request->metakey) ? $request->metakey : "";
        $cat->save();

        return redirect()->route('category')->with('success','Category has been Inserted Successfully');
    }





    // Function of Bulk Category View
    function bulkcategory()
    {
        $data['optiongroups'] = Topping::where('store_topping',1)->get();
        return view('admin.category.bulkcategory',$data);
    }





    // Function of Store Multiple Category
    function storebulkcategory(Request $request)
    {

        foreach($request->category as $key => $cat)
        {
            $name = isset($cat['name']) ? $cat['name'] : '';
            $description = isset($cat['description']) ? $cat['description'] : '';
            $enable_size = $cat['enable_size'];
            $size = isset($cat['size']) ? $cat['size'] : '';
            $short_order = isset($cat['short_order']) ? $cat['short_order'] : '';
            $ispizza = $cat['ispizza'];
            $group = $cat['group'];
            $enable_comment = $cat['enable_comment'];
            $numbercharacter = $cat['numbercharacter'];
            $image = isset($cat['image']) ? $cat['image'] : '';

            // Insert Category
            $catdetail = new CategoryDetail;

            // Insert Category Image
            if (!empty($image) || $image != '')
            {
                $imgname = time() . "." . $image->getClientOriginalExtension();
                $image->move(public_path('admin/category'), $imgname);
                $catdetail->image = $imgname;
            }

            $catdetail->img_banner = '';
            $availibleday = '';
            $catdetail->top = isset($request->top) ? $request->top : 1;
            $catdetail->column = isset($request->columns) ? $request->columns : 1;
            $catdetail->sort_order = isset($request->sortorder) ? $request->sortorder : 0;
            $catdetail->status = isset($request->status) ? $request->status : 0;
            date_default_timezone_set('Asia/Kolkata');
            $catdetail->date_added = date("Y-m-d h:i:s");
            $catdetail->date_modified = date("Y-m-d h:i:s");
            $catdetail->availibleday = $availibleday;
            $catdetail->save();
            $lastid = $catdetail->category_id;


            // Insert CategoryDetail
            $cat = new Category;
            $cat->category_id = $lastid;
            $cat->language_id = '1';
            $cat->name = $name;
            $cat->description = $description;

            $replaceslug = str_replace(' ','-',$name);
            $slug = strtolower($replaceslug);

            $cat->slug = $slug;
            $cat->meta_description = isset($request->metadesc) ? $request->metadesc : "";
            $cat->meta_keyword = isset($request->metakey) ? $request->metakey : "";
            $cat->save();

        }
        return redirect()->route('category')->with('success','Category has been Inserted Successfully');
    }





    // Function of Add Category View
    function newcategory()
    {
        // Check User Permission
        if (check_user_role(55) != 1) {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }
        
        return view('admin.category.newcategory');
    }





    // Function of Update Category
    public function categoryupdate(Request $request)
    {
        // Validation Of Category Fields
        $request->validate([
            'category' => 'required',
        ]);

        // update Category Details
        $catdetail = CategoryDetail::find($request->id);

        // update Category Image
        if ($request->hasFile('image'))
        {
            $image = isset($catdetail['image']) ? $catdetail['image'] : '';
            if(!empty($image) || $image != '')
            {
                if(file_exists('public/admin/category/'.$image))
                {
                    unlink('public/admin/category/'.$image);
                }
            }

            $imgname = time().".". $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('admin/category/'), $imgname);
            $catdetail->image = $imgname;
        }

        // Insert Banner Image
        if ($request->hasFile('banner'))
        {
            $banner = isset($catdetail['img_banner']) ? $catdetail['img_banner'] : '';
            if(!empty($banner) || $banner != '')
            {
                if(file_exists('public/admin/category/banner/'.$banner))
                {
                    unlink('public/admin/category/banner/'.$banner);
                }
            }

            $bannerimgname = time().".". $request->file('banner')->getClientOriginalExtension();
            $request->file('banner')->move(public_path('admin/category/banner'), $bannerimgname);
            $catdetail->img_banner = $bannerimgname;
        }

        $availibleday = implode(",", $request->availibleday);

        $catdetail->top =  isset($request->top) ? $request->top : 0;
        $catdetail->column = isset($request->columns) ? $request->columns : 1;
        $catdetail->sort_order = $request->sortorder;
        $catdetail->status = isset($request->status) ? $request->status : 0;
        $catdetail->status = isset($request->status) ? $request->status : 0;
        date_default_timezone_set('Asia/Kolkata');
        $catdetail->availibleday = $availibleday;
        $catdetail->update();


        // update Category
        $cat = Category::find($request->id);
        $cat->language_id = '1';
        $cat->name = $request->category;
        $cat->description = isset($request->description) ? $request->description : "";
        $cat->meta_description = isset($request->metadesc) ? $request->metadesc : "";
        $cat->meta_keyword = isset($request->metakey) ? $request->metakey : "";
        $cat->update();


        // Add Size & Update Size
        $size = isset($request->size) ? $request->size : '';

        if(!empty($size) || $size != '')
        {
            foreach($size as $val)
            {
                $sizename = $val['sizename'];
                $sort_order = $val['short_order'];
                $size_id = isset($val['size_id']) ? $val['size_id'] : '';

                if( (!empty($size_id)) || ($size_id != ''))
                {
                    $update_topp_size = ToppingSize::find($size_id);
                    $update_topp_size->size = isset($sizename) ? $sizename : '-';
                    $update_topp_size->short_order = isset($sort_order) ? $sort_order : 0;
                    $update_topp_size->update();
                }
                else
                {
                    if(!empty($sizename) || $sizename != '')
                    {
                        $topp_size = new ToppingSize;
                        $topp_size->id_category = $request->id;
                        $topp_size->size = isset($sizename) ? $sizename : '';
                        $topp_size->short_order = isset($sort_order) ? $sort_order : 0;
                        $topp_size->save();
                    }
                }

            }
        }


        // Get Topping Category Option
        $top_cat_option = ToppingCatOption::where('id_category',$request->id)->first();

        $group = isset($request->group) ? serialize($request->group) : '';


        // Insert and Update Topping Category Option
        if($top_cat_option == '' || empty($top_cat_option))
        {
            $toppingCatOption = new ToppingCatOption;
            $toppingCatOption->id_category = $request->id;
            $toppingCatOption->enable_size = $request->sizeval;
            $toppingCatOption->enable_option = $request->options;
            $toppingCatOption->enable_boxcomment = $request->enable_comment;
            $toppingCatOption->character = $request->numbercharacter;
            $toppingCatOption->group = $group;
            $toppingCatOption->save();
        }
        else
        {
            $toppingCatOptionupdate = ToppingCatOption::find($request->top_cat_option_id);
            $toppingCatOptionupdate->enable_size = $request->sizeval;
            $toppingCatOptionupdate->enable_option = $request->options;
            $toppingCatOptionupdate->enable_boxcomment = $request->enable_comment;
            $toppingCatOptionupdate->character = $request->numbercharacter;
            $toppingCatOptionupdate->group = $group;
            $toppingCatOptionupdate->update();
        }

        return redirect()->route('category')->with('success','Category has been updated Successfully.');
    }





    // Function of edit Category
    public function categoryedit($id)
    {

        // Check User Permission
        if (check_user_role(56) != 1) {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }

        // Get Category Top Option
        $topcatoption = ToppingCatOption::where('id_category',$id)->first();

        // Get Topping Size
        $toppingsizes = ToppingSize::where('id_category',$id)->get();

        // Fetch Category Layout
        $category_layout = CategoryLayout::select('layout_id', 'name')->get();

        // Get Option Groups
        $optiongroups = Topping::where('store_topping',1)->get();

        // Get Single Category Description
        $data = Category::where('oc_category_description.category_id', '=', $id)->join('oc_category', 'oc_category_description.category_id', '=', 'oc_category.category_id')->first();

        return view('admin.category.categoryedit', ['data' => $data, 'category_layout' => $category_layout, 'optiongroups' => $optiongroups, 'topcatoption' => $topcatoption, 'toppingsizes' => $toppingsizes]);
    }





    // Delete Option Size
    function delOptionSize(Request $request)
    {
        $size_id = $request->size_id;

        // Delete Topping Option
        ToppingSize::where('id_size',$size_id)->delete();

        return response()->json([
            'success' => 1,
        ]);
    }





    // Function of Delete Category
    function categorydelete(Request $request)
    {
        $ids = $request['id'];

        if (count($ids) > 0)
        {
            // Delete Category Image & Banner Image
            foreach($ids as $id)
            {
                $category = CategoryDetail::where('category_id',$id)->first();
                $image = isset($category['image']) ? $category['image'] : '';
                $banner = isset($category['img_banner']) ? $category['img_banner'] : '';
                if(!empty($image) || $image != '')
                {
                    if(file_exists('public/admin/category/'.$image))
                    {
                        unlink('public/admin/category/'.$image);
                    }
                }
                if(!empty($banner) || $banner != '')
                {
                    if(file_exists('public/admin/category/banner/'.$banner))
                    {
                        unlink('public/admin/category/banner/'.$banner);
                    }
                }
            }

             // Delete Category
             Category::whereIn('category_id', $ids)->delete();

             // Delete Category Description
             CategoryDetail::whereIn('category_id', $ids)->delete();

            return response()->json([
                'success' => 1,
            ]);
        }
    }


}
