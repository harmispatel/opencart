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


    // Function of Category List
    function index()
    {
        // Check User Permission
        if (check_user_role(45) != 1) {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }
        return view('admin.category.CategoryList');
    }





    // Function of Get all Categories
    public function getcategory(Request $request)
    {
        // Current Store ID
        $current_store_id = currentStoreId();

        $columns = array(
            0 => 'category_id',
            1 => 'name',
            2 => 'sort_order',
        );

        $user_details = user_details();

        if (isset($user_details)) {
            $user_group_id = $user_details['user_group_id'];
        }

        if ($user_group_id == 1) {
            if ($current_store_id == 0) {
                // Get Total Categories
                $totalData = CategoryDetail::with(['hasOneCategory', 'hasManyCategoryStore'])->count();

                $totalFiltered = $totalData;
                $limit = $request->request->get('length');
                $start = $request->request->get('start');
                $order = $columns[$request->input('order.0.column')];
                $dir = $request->input('order.0.dir');

                if (!empty($request->input('search.value'))) {
                    $search = $request->input('search.value');

                    $posts =  CategoryDetail::with(['hasOneCategory', 'hasManyCategoryStore'])->where(function ($query) use ($search) {
                        $query->where('sort_order', 'LIKE', "%{$search}%")
                            ->orwhereHas('hasOneCategory', function ($query) use ($search) {
                                $query->where('name', 'LIKE', "%{$search}%");
                            });
                    });

                    if ($order == 'name') {
                        if ($dir == 'asc') {
                            $posts = $posts->orderBy(Category::select($order)->whereColumn('oc_category_description.category_id', 'oc_category.category_id'));
                        } else {
                            $posts = $posts->orderByDesc(Category::select($order)->whereColumn('oc_category_description.category_id', 'oc_category.category_id'));
                        }
                    } else {
                        $posts = $posts->orderBy($order, $dir);
                    }
                    $posts = $posts->offset($start)->limit($limit)->get();

                    $totalFiltered = CategoryDetail::with(['hasOneCategory', 'hasManyCategoryStore'])->where(function ($query) use ($search) {
                        $query->where('sort_order', 'LIKE', "%{$search}%");
                    })

                        ->offset($start)->limit($limit)->count();
                } else {
                    $posts = CategoryDetail::with(['hasOneCategory', 'hasManyCategoryStore'])->offset($start)->limit($limit);

                    if ($order == 'name') {
                        if ($dir == 'asc') {
                            $posts = $posts->orderBy(Category::select($order)->whereColumn('oc_category_description.category_id', 'oc_category.category_id'));
                        } else {
                            $posts = $posts->orderByDesc(Category::select($order)->whereColumn('oc_category_description.category_id', 'oc_category.category_id'));
                        }
                    } else {
                        $posts = $posts->orderBy($order, $dir);
                    }
                    $posts = $posts->offset($start)->limit($limit)->get();
                }
            } else {
                // Get Total Categories
                $totalData = CategoryDetail::with(['hasOneCategory', 'hasManyCategoryStore'])->whereHas('hasManyCategoryStore', function ($query) use ($current_store_id) {
                    $query->where('store_id', $current_store_id);
                })->count();

                $totalFiltered = $totalData;
                $limit = $request->request->get('length');
                $start = $request->request->get('start');
                $order = $columns[$request->input('order.0.column')];
                $dir = $request->input('order.0.dir');

                if (!empty($request->input('search.value'))) {
                    $search = $request->input('search.value');

                    // Search  All Categories
                    $posts =  CategoryDetail::with(['hasOneCategory', 'hasManyCategoryStore'])->where(function ($query) use ($search) {
                        $query->where('sort_order', 'LIKE', "%{$search}%")
                            ->orwhereHas('hasOneCategory', function ($query) use ($search) {
                                $query->where('name', 'LIKE', "%{$search}%");
                            });
                    })
                        ->whereHas('hasManyCategoryStore', function ($query) use ($current_store_id) {
                            $query->where('store_id', $current_store_id);
                        });

                    if ($order == 'name') {
                        if ($dir == 'asc') {
                            $posts = $posts->orderBy(Category::select($order)->whereColumn('oc_category_description.category_id', 'oc_category.category_id'));
                        } else {
                            $posts = $posts->orderByDesc(Category::select($order)->whereColumn('oc_category_description.category_id', 'oc_category.category_id'));
                        }
                    } else {
                        $posts = $posts->orderBy($order, $dir);
                    }
                    $posts = $posts->offset($start)->limit($limit)->get();

                    $totalFiltered = CategoryDetail::with(['hasOneCategory', 'hasManyCategoryStore'])->where(function ($query) use ($search) {
                        $query->where('sort_order', 'LIKE', "%{$search}%");
                    })

                        ->whereHas('hasManyCategoryStore', function ($query) use ($current_store_id) {
                            $query->where('store_id', $current_store_id);
                        })->offset($start)->limit($limit)->count();
                } else {
                     // Get Categories
                    $posts = CategoryDetail::with(['hasOneCategory', 'hasManyCategoryStore'])
                        ->whereHas('hasManyCategoryStore', function ($query) use ($current_store_id) {
                            $query->where('store_id', $current_store_id);
                        })->offset($start)->limit($limit);

                    if ($order == 'name') {
                        if ($dir == 'asc') {
                            $posts = $posts->orderBy(Category::select($order)->whereColumn('oc_category_description.category_id', 'oc_category.category_id'));
                        } else {
                            $posts = $posts->orderByDesc(Category::select($order)->whereColumn('oc_category_description.category_id', 'oc_category.category_id'));
                        }
                    } else {
                        $posts = $posts->orderBy($order, $dir);
                    }
                    $posts = $posts->offset($start)->limit($limit)->get();
                }
            }
        } else {
            $user_shop_id = $user_details['user_shop'];

            // Get Total Categories
            $totalData = CategoryDetail::with(['hasOneCategory', 'hasManyCategoryStore'])->whereHas('hasManyCategoryStore', function ($query) use ($user_shop_id) {
                $query->where('store_id', $user_shop_id);
            })->count();

            $totalFiltered = $totalData;
            $limit = $request->request->get('length');
            $start = $request->request->get('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            if (!empty($request->input('search.value'))) {
                $search = $request->input('search.value');

                $posts =  CategoryDetail::with(['hasOneCategory', 'hasManyCategoryStore'])->where(function ($query) use ($search) {
                    $query->where('sort_order', 'LIKE', "%{$search}%")
                        ->orwhereHas('hasOneCategory', function ($query) use ($search) {
                            $query->where('name', 'LIKE', "%{$search}%");
                        });
                })
                    ->whereHas('hasManyCategoryStore', function ($query) use ($user_shop_id) {
                        $query->where('store_id', $user_shop_id);
                    });

                if ($order == 'name') {
                    if ($dir == 'asc') {
                        $posts = $posts->orderBy(Category::select($order)->whereColumn('oc_category_description.category_id', 'oc_category.category_id'));
                    } else {
                        $posts = $posts->orderByDesc(Category::select($order)->whereColumn('oc_category_description.category_id', 'oc_category.category_id'));
                    }
                } else {
                    $posts = $posts->orderBy($order, $dir);
                }
                $posts = $posts->offset($start)->limit($limit)->get();

                $totalFiltered = CategoryDetail::with(['hasOneCategory', 'hasManyCategoryStore'])->where(function ($query) use ($search) {
                    $query->where('sort_order', 'LIKE', "%{$search}%");
                })

                    ->whereHas('hasManyCategoryStore', function ($query) use ($user_shop_id) {
                        $query->where('store_id', $user_shop_id);
                    })->offset($start)->limit($limit)->count();
            } else {
                $posts = CategoryDetail::with(['hasOneCategory', 'hasManyCategoryStore'])
                    ->whereHas('hasManyCategoryStore', function ($query) use ($user_shop_id) {
                        $query->where('store_id', $user_shop_id);
                    })->offset($start)->limit($limit);

                if ($order == 'name') {
                    if ($dir == 'asc') {
                        $posts = $posts->orderBy(Category::select($order)->whereColumn('oc_category_description.category_id', 'oc_category.category_id'));
                    } else {
                        $posts = $posts->orderByDesc(Category::select($order)->whereColumn('oc_category_description.category_id', 'oc_category.category_id'));
                    }
                } else {
                    $posts = $posts->orderBy($order, $dir);
                }
                $posts = $posts->offset($start)->limit($limit)->get();
            }
        }

        $data = array();
        $data1 = array();

        if ($posts) {
            foreach ($posts as $post) {
                $category_id = $post->category_id;
                $edit_url = route('categoryedit', $category_id);

                $data['checkbox'] = "<input type='checkbox' name='del_all' class='del_all' value='$category_id'>";
                $data['name'] = isset($post->hasOneCategory->name) ? $post->hasOneCategory->name : '';
                $data['sort_order'] = $post->sort_order;

                if (check_user_role(47) == 1) {
                    $data['action'] = '<a href="' . $edit_url . '" class="btn btn-sm btn-primary"><i class="fa fa-edit text-white"></i><a>';
                } else {
                    $data['action'] = '-';
                }

                $data1[] = $data;
            }
        }

        $json_data = array(
            "draw"            => intval($request->request->get('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval(isset($totalFiltered) ? $totalFiltered : ''),
            "data"            => $data1
        );

        echo json_encode($json_data);
    }





    // Function of Insert Category
    function categoryinsert(Request $request)
    {
        $currentURL = public_url();
        $current_store_id = currentStoreId();

        $user_details = user_details();

        if (isset($user_details)) {
            $user_group_id = $user_details['user_group_id'];
        }
        $user_shop_id = $user_details['user_shop'];

        // Validation Of Category Fields
        $request->validate([
            'category' => 'required',
            // 'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // 'banner' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        // Insert Category Details
        $catdetail = new CategoryDetail;

        // Insert Category Image
        // if ($request->hasFile('image')) {
        //     $imgname = time() . "." . $request->file('image')->getClientOriginalExtension();
        //     $request->file('image')->move(public_path('admin/category'), $imgname);
        //     $categoryurl = $currentURL . '/public/admin/category/';
        // }
        $catdetail->image =$request->image;

        // Insert Banner Image
        // if ($request->hasFile('banner')) {
        //     $bannerimgname = time() . "." . $request->file('banner')->getClientOriginalExtension();
        //     $request->file('banner')->move(public_path('admin/category/banner'), $bannerimgname);
        //     $bannerurl = $currentURL . '/public/admin/category/banner/';
        //     $catdetail->img_banner = $bannerurl . $bannerimgname;
        // }
        $catdetail->img_banner = $request->banner;
        $days = isset($request->availibleday) ? $request->availibleday : 0;
        if ($days != 0) {
            $availibleday = implode(",", $days);
        } else {
            $availibleday = "";
        }

        $catdetail->parent_id = isset($request->parent) ? $request->parent : 0;
        $catdetail->top = isset($request->top) ? $request->top : 1;
        $catdetail->column = isset($request->columns) ? $request->columns : 1;
        $catdetail->sort_order = isset($request->sortorder) ? $request->sortorder : 0;
        $catdetail->status = isset($request->status) ? $request->status : 0;

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
        if ($user_group_id == 1) {
            $cat_to_store->store_id = $current_store_id;
        } else {
            $cat_to_store->store_id = $user_shop_id;
        }
        $cat_to_store->save();

        // Insert Category
        $cat = new Category;
        $cat->category_id = $lastid;
        $cat->language_id = '1';
        $cat->name = $request->category;
        $cat->description = isset($request->description) ? $request->description : "";
        $replaceslug = str_replace(' ', '-', $request->category);
        $slug = strtolower($replaceslug);
        $cat->slug = $slug;
        $cat->meta_description = isset($request->metadesc) ? $request->metadesc : "";
        $cat->meta_keyword = isset($request->metakey) ? $request->metakey : "";
        $cat->save();

        return redirect()->route('category')->with('success', 'Category has been Inserted Successfully');
    }





    // Function of Bulk Category View
    function bulkcategory()
    {

        // Check User Permission
        if (check_user_role(54) != 1) {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }

        // Current Store ID
        $current_store_id = currentStoreId();

        $user_details = user_details();
        if (isset($user_details)) {
            $user_group_id = $user_details['user_group_id'];
        }
        $user_shop_id = $user_details['user_shop'];

        // Get Options Group By Current Store
        if ($user_group_id == 1) {
            $data['optiongroups'] = Topping::where('store_topping', $current_store_id)->get();
        } else {
            $data['optiongroups'] = Topping::where('store_topping', $user_shop_id)->get();
        }


        return view('admin.category.bulkcategory', $data);
    }





    // Function of Store Multiple Category
    function storebulkcategory(Request $request)
    {
        // Current Store ID
        $current_store_id = currentStoreId();

        $user_details = user_details();
        if (isset($user_details)) {
            $user_group_id = $user_details['user_group_id'];
        }
        $user_shop_id = $user_details['user_shop'];

        foreach ($request->category as $key => $cat) {
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
            // if (!empty($image) || $image != '') {
            //     $imgname = time() . "." . $image->getClientOriginalExtension();
            //     $image->move(public_path('admin/category'), $imgname);
            // }
            $catdetail->image = $image;

            $catdetail->img_banner = '';
            $availibleday = '';
            $catdetail->top = isset($request->top) ? $request->top : 1;
            $catdetail->column = isset($request->columns) ? $request->columns : 1;
            $catdetail->sort_order = isset($request->sortorder) ? $request->sortorder : 0;
            $catdetail->status = isset($request->status) ? $request->status : 0;

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
            $replaceslug = str_replace(' ', '-', $name);
            $slug = strtolower($replaceslug);
            $cat->slug = $slug;
            $cat->meta_description = isset($request->metadesc) ? $request->metadesc : "";
            $cat->meta_keyword = isset($request->metakey) ? $request->metakey : "";
            $cat->save();

            // Category Path
            $cat_path = new CategoryPath;
            $cat_path->category_id = $lastid;
            $cat_path->path_id = $lastid;
            $cat_path->level = 0;
            $cat_path->save();

            // Insert Into Category to Store
            $cat_to_store = new CategorytoStore;
            $cat_to_store->category_id = $lastid;
            if ($user_group_id == 1) {
                $cat_to_store->store_id = $current_store_id;
            } else {
                $cat_to_store->store_id = $user_shop_id;
            }
            $cat_to_store->save();

            // Insert Category Size
            if (!empty($size) || $size != '') {
                foreach ($size as $key => $val) {
                    $sizename = $val;
                    $sort_order = $short_order[$key];
                    if (!empty($sizename) || $sizename != '') {
                        $topp_size = new ToppingSize;
                        $topp_size->id_category = $lastid;
                        $topp_size->size = isset($sizename) ? $sizename : '';
                        $topp_size->short_order = isset($sort_order) ? $sort_order : 0;
                        $topp_size->save();
                    }
                }
            }

            // Insert Category Topping Option
            if (!empty($group) || $group != '') {
                $toppingCatOption = new ToppingCatOption;
                $toppingCatOption->id_category = $lastid;
                $toppingCatOption->enable_size = $enable_size;
                $toppingCatOption->enable_option = $ispizza;
                $toppingCatOption->enable_boxcomment = $enable_comment;
                $toppingCatOption->character = $numbercharacter;
                $toppingCatOption->group = serialize($group);
                $toppingCatOption->save();
            }
        }
        return redirect()->route('category')->with('success', 'Category has been Inserted Successfully');
    }





    // Function of Add Category View
    function newcategory()
    {
        // Check User Permission
        if (check_user_role(46) != 1) {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }

        return view('admin.category.newcategory');
    }





    // Function of edit Category
    public function categoryedit($id)
    {
        //Current Store ID
        $current_store_id = currentStoreId();

        // Check User Permission
        if (check_user_role(47) != 1) {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }

        $user_details = user_details();

        if (isset($user_details)) {
            $user_group_id = $user_details['user_group_id'];
        }
        $user_shop_id = $user_details['user_shop'];

        // Get Category Top Option
        $topcatoption = ToppingCatOption::where('id_category', $id)->first();

        // Get Topping Size
        $toppingsizes = ToppingSize::where('id_category', $id)->get();

        // Get Category Layout
        $category_layout = CategoryLayout::select('layout_id', 'name')->get();

        //Get Toppings By Current Store
        if ($user_group_id == 1) {
            $optiongroups = Topping::where('store_topping', $current_store_id)->get();
        } else {
            $optiongroups = Topping::where('store_topping', $user_shop_id)->get();
        }

        // Get Single Category Description
        $data = CategoryDetail::with('hasOneCategory')->whereHas('hasOneCategory', function ($query) use ($id) {
            $query->where('category_id', $id);
        })->first();

        return view('admin.category.categoryedit', ['data' => $data, 'category_layout' => $category_layout, 'optiongroups' => $optiongroups, 'topcatoption' => $topcatoption, 'toppingsizes' => $toppingsizes])->with('error', "Sorry you haven't Access.");
    }





    // Function of Update Category
    public function categoryupdate(Request $request)
    {
        // Validation Of Category Fields
        $request->validate([
            'category' => 'required',
            // 'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // 'banner' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $currentURL = public_url();
        // update Category Details
        $catdetail = CategoryDetail::find($request->id);


        if($request->image !=''){
            $catdetail->image =isset($request->image) ? $request->image : '';
        }
        if($request->banner !=''){
            $catdetail->img_banner =isset($request->banner) ? $request->banner : '';
        }


        $days = isset($request->availibleday) ? $request->availibleday : 0;
        if ($days != 0) {
            $availibleday = implode(",", $days);
        } else {
            $availibleday = "";
        }

        $catdetail->top =  isset($request->top) ? $request->top : 0;
        $catdetail->column = isset($request->columns) ? $request->columns : 1;
        $catdetail->sort_order = $request->sortorder;
        $catdetail->status = isset($request->status) ? $request->status : 0;
        $catdetail->status = isset($request->status) ? $request->status : 0;

        $catdetail->availibleday = $availibleday;
        $catdetail->update();


        // update Category
        $cat = Category::find($request->id);
        $cat->language_id = '1';
        $cat->name = $request->category;
        $replaceslug = str_replace(' ', '-', $request->category);
        $slug = strtolower($replaceslug);
        $cat->slug = $slug;
        $cat->description = isset($request->description) ? $request->description : "";
        $cat->meta_description = isset($request->metadesc) ? $request->metadesc : "";
        $cat->meta_keyword = isset($request->metakey) ? $request->metakey : "";
        $cat->update();


        // Add Size & Update Size
        $size = isset($request->size) ? $request->size : '';

        if (!empty($size) || $size != '') {
            foreach ($size as $val) {
                $sizename = $val['sizename'];
                $sort_order = $val['short_order'];
                $size_id = isset($val['size_id']) ? $val['size_id'] : '';

                if ((!empty($size_id)) || ($size_id != '')) {
                    $update_topp_size = ToppingSize::find($size_id);
                    $update_topp_size->size = isset($sizename) ? $sizename : '-';
                    $update_topp_size->short_order = isset($sort_order) ? $sort_order : 0;
                    $update_topp_size->update();
                } else {
                    if (!empty($sizename) || $sizename != '') {
                        $topp_size = new ToppingSize;
                        $topp_size->id_category = $request->id;
                        $topp_size->size = isset($sizename) ? $sizename : '';
                        $topp_size->short_order = isset($sort_order) ? $sort_order : 0;
                        $topp_size->save();
                    }
                }
            }
        }

        // Check Have a Topping Category Option ?
        $top_cat_option = ToppingCatOption::where('id_category', $request->id)->first();

        // Serialize Topping Option
        $group = isset($request->group) ? serialize($request->group) : '';


        // Insert & Update Topping Cat Option
        if ($top_cat_option == '' || empty($top_cat_option)) {
            $toppingCatOption = new ToppingCatOption;
            $toppingCatOption->id_category = $request->id;
            $toppingCatOption->enable_size = $request->sizeval;
            $toppingCatOption->enable_option = $request->options;
            $toppingCatOption->enable_boxcomment = $request->enable_comment;
            $toppingCatOption->character = $request->numbercharacter;
            $toppingCatOption->group = $group;
            $toppingCatOption->save();
        } else {
            $toppingCatOptionupdate = ToppingCatOption::find($request->top_cat_option_id);
            $toppingCatOptionupdate->enable_size = $request->sizeval;
            $toppingCatOptionupdate->enable_option = $request->options;
            $toppingCatOptionupdate->enable_boxcomment = $request->enable_comment;
            $toppingCatOptionupdate->character = $request->numbercharacter;
            $toppingCatOptionupdate->group = $group;
            $toppingCatOptionupdate->update();
        }

        if ($request->has('save_and_stay')) {
            return redirect()->route('categoryedit', $request->id)->with('success', 'Category has been updated Successfully.');
        }

        return redirect()->route('category')->with('success', 'Category has been updated Successfully.');
    }




    // Function of Delete Option Size
    function delOptionSize(Request $request)
    {

        $size_id = $request->size_id;

        // Delete Topping Option
        ToppingSize::where('id_size', $size_id)->delete();

        return response()->json([
            'success' => 1,
        ]);
    }





    // Function of Delete Category
    function categorydelete(Request $request)
    {
        // Check User Permission
        if (check_user_role(48) != 1) {
            return redirect()->route('dashboard')->with('error', "Sorry you haven't Access.");
        }

        $ids = $request['id'];

        if (count($ids) > 0) {
            // Delete Category Image & Banner Image
            foreach ($ids as $id) {
                $category = CategoryDetail::where('category_id', $id)->first();
                $image = isset($category['image']) ? $category['image'] : '';
                $banner = isset($category['img_banner']) ? $category['img_banner'] : '';
                if (!empty($image) || $image != '') {
                    if (file_exists('public/admin/category/' . $image)) {
                        unlink('public/admin/category/' . $image);
                    }
                }
                if (!empty($banner) || $banner != '') {
                    if (file_exists('public/admin/category/banner/' . $banner)) {
                        unlink('public/admin/category/banner/' . $banner);
                    }
                }
            }

            // Delete Category Size
            foreach ($ids as $id) {
                ToppingSize::where('id_category', $id)->delete();
            }

            // Delete Category
            Category::whereIn('category_id', $ids)->delete();

            // Delete Category Description
            CategoryDetail::whereIn('category_id', $ids)->delete();

            //  Delete Topping Options
            ToppingCatOption::whereIn('id_category', $ids)->delete();

            // Delete Category to Store
            CategorytoStore::whereIn('category_id', $ids)->delete();

            // Delete Category to Path
            CategoryPath::whereIn('category_id', $ids)->delete();

            return response()->json([
                'success' => 1,
            ]);
        }
    }




}
