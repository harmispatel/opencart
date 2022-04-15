<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reviews;
use App\Models\ProductDescription;


class ReviewsController extends Controller
{

    // Function of All Reviews List
    public function index()
    {
        // Current Store ID
        $current_store_id = currentStoreId();

        // Check User Permission
        if(check_user_role(78) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }

        $data['reviews'] = Reviews::with(['hasOneCustomer','hasOneOrder'])->where('store_id',$current_store_id)->get();

        return view('admin.reviews.list',$data);
    }


    function reviewStatus(Request $request)
    {
        $status = $request->val;
        $review_id = $request->rid;

        $review = Reviews::find($review_id);
        $review->status = $status;
        $review->update();

        return response()->json([
            'success' => 1,
        ]);

    }


    // Function of add Review View
    public function add()
    {
        // Check User Permission
        if(check_user_role(79) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }

        // Fetch All Products
        $data['products'] = ProductDescription::get();
        return view('admin.reviews.add',$data);
    }





    // Function of Store Reviews
    function store(Request $request)
    {
        // Reviews Validation
        $request->validate([
            'author' => 'required',
            'productid' => 'required',
            'description' => 'required',
            'rating' => 'required',
            'date' => 'required',
        ]);

        // New Reviews
        $review = new Reviews;
        $review->product_id = $request['productid'];
        $review->author = $request['author'];
        $review->text = $request['description'];
        $review->rating= $request['rating'];
        $review->status= $request['status'];
        $review->date_added= $request['date'];
        $review->date_modified= date('d-m-y');


        // If Not empty customer ID Then Insert Customer Id Otherwise 0
        if(!empty($request['customer_id']))
        {
            $review->customer_id= $request['customer_id'];
        }
        else
        {
            $review->customer_id= 0;
        }

        $review->save();
        return redirect()->route('review')->with('success','Review has been Inserted Successfully');

    }



    // Function of Delete Review
    function deletemultireview(Request $request)
    {
        // Check User Permission
        if(check_user_role(81) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }

        //Multiple Id's
       $ids = $request['id'];

       // When not empty ids Then Delete Reviews Otherwise Not
       if(count($ids) > 0)
       {

           // Delete Reviews
           Reviews::whereIn('review_id',$ids)->delete();

           return response()->json([
               'success' => 1,
           ]);
       }
    }




    // Function of Edit Review View
    function edit($id)
    {
        //Check User Permission
        if(check_user_role(80) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }

        // Get Reviews Details by Review Id
        $reviews = Reviews::where('review_id',$id)->first();

        // When Empty Reviews Then Redirect to Reviews List
        if(empty($reviews))
        {
            return redirect()->route('review');
        }

        // Give Reviews Details to Array
        $data['reviews'] = $reviews;

        // Get All Products
        $data['products'] = ProductDescription::get();

        return view('admin.reviews.edit',$data);
    }




    // Function of Update Review
    function update(Request $request)
    {
        // Validation of Reviews
        $request->validate([
            'author' => 'required',
            'productid' => 'required',
            'description' => 'required',
            'rating' => 'required',
            'date' => 'required',
        ]);

        // Reviews ID
        $review_id = $request->id;

        // Get Review By Review ID
        $review = Reviews::find($review_id);

        $review->product_id = $request['productid'];
        $review->author = $request['author'];
        $review->text = $request['description'];
        $review->rating= $request['rating'];
        $review->status= $request['status'];
        $review->date_added= $request['date'];
        $review->date_modified= date('d-m-y');

        if(!empty($request['customer_id']))
        {
            $review->customer_id= $request['customer_id'];
        }

        // Update Review Details
        $review->update();

        return redirect()->route('review')->with('success','Review has been Updated successfully!');
    }



}
