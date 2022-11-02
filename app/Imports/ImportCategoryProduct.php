<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\CategoryDetail;
use App\Models\CategoryPath;
use App\Models\CategorytoStore;
use App\Models\Product;
use App\Models\Product_to_category;
use App\Models\ProductDescription;
use App\Models\ProductStore;
use App\Models\Reward;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\Validator;

class ImportCategoryProduct implements ToCollection,WithStartRow,WithHeadingRow
{
    public function startRow(): int
    {
        return 2;
    }


    public function collection(Collection $collection)
    {

        if (isset($user_details)) {
            $user_group_id = $user_details['user_group_id'];
            $current_store_id = $user_details['user_shop'];
        }
        else
        {
            $current_store_id = currentStoreId();
        }


        if(count($collection) > 0)
        {
            $category_name = isset($collection[0]['caregory_name']) ? $collection[0]['caregory_name'] : '';

            // Insert Category
            $category = new CategoryDetail;
            $category->image = '';
            $category->img_banner = '';
            $category->availibleday = '0,1,2,3,4,5,6';
            $category->parent_id = 0;
            $category->top = 1;
            $category->column = 1;
            $category->sort_order = 0;
            $category->status = 1;
            $category->date_added = date("Y-m-d h:i:s");
            $category->date_modified = date("Y-m-d h:i:s");
            $category->save();
            $last_category_id = $category->category_id;

            // Category Path
            $cat_path = new CategoryPath;
            $cat_path->category_id = $last_category_id;
            $cat_path->path_id = $last_category_id;
            $cat_path->level = 0;
            $cat_path->save();

            // Insert Into Category to Store
            $category_to_store = new CategorytoStore;
            $category_to_store->category_id = $last_category_id;
            $category_to_store->store_id = $current_store_id;
            $category_to_store->save();

            // Insert Category Details
            $category_details = new Category;
            $category_details->category_id = $last_category_id;
            $category_details->language_id = '1';
            $category_details->name = $category_name;
            $category_details->description = "";
            $category_details->slug = '';
            $category_details->meta_description = "";
            $category_details->meta_keyword = "";
            $category_details->save();

            foreach($collection as $product)
            {
                $model = isset($product['model']) ? $product['model'] : 0;
                $sku = isset($product['sku']) ? $product['sku'] : '';
                $price = isset($product['price']) ? $product['price'] : 0;
                $delivery_price = isset($product['delivery_price']) ? $product['delivery_price'] : 0;
                $collection_price = isset($product['collection_price']) ? $product['collection_price'] : 0;
                $name = isset($product['name']) ? $product['name'] : '';
                $description = isset($product['description']) ? $product['description'] : '';

                // Insert Product
                $product = new Product;
                $product->model = $model;
                $product->sku = $sku;
                $product->upc = "";
                $product->ean = "";
                $product->jan = "";
                $product->isbn = "";
                $product->mpn = "";
                $product->location = "";
                $product->shipping = 1;
                $product->order_type = "both";
                $product->stock_status_id = 0;
                $product->manufacturer_id = 0;
                $product->date_available = 0;
                $product->date_added = date("Y-m-d h:i:s");
                $product->date_modified = date("Y-m-d h:i:s");
                $product->tax_class_id =  0;
                $product->price = $price;
                $product->delivery_price = $delivery_price;
                $product->collection_price = $collection_price;
                $product->status = 1;
                $product->sort_order = 0;
                $product->product_icons = 0;
                $product->availibleday = '1,2,3,4,5,6,0';
                $product->image = '';
                $product->save();
                $last_product_id = $product->product_id;


                // Product Description
                $product_description = new ProductDescription;
                $product_description->product_id = $last_product_id;
                $product_description->language_id = 1;
                $product_description->name = $name;
                $product_description->description = $description;
                $product_description->meta_description = '';
                $product_description->meta_keyword = '';
                $product_description->tag = '';
                $product_description->save();


                // Reward
                $reward = new Reward;
                $reward->product_id = $last_product_id;
                $reward->customer_group_id = 1;
                $reward->points = 0;
                $reward->save();


                // Product to Category
                $product_category = new Product_to_category;
                $product_category->product_id = $last_product_id;
                $product_category->category_id = $last_category_id;
                $product_category->save();


                // Product to Store
                $productstore = new ProductStore;
                $productstore->product_id = $last_product_id;
                $productstore->store_id = $current_store_id;
                $productstore->save();

                // return 1;

            }
        }
        else
        {
            Validator::make($collection->toArray(), [
                'name' => 'required',
            ])->validate();
        }

    }
}
