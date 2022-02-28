<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Manufacturers;
use App\Models\Seo;
use App\Models\ManufacturerstoStore;

class ManufacturersController extends Controller
{

    // Manufacturers List
    public function index()
    {
        // Check User Permission
        if(check_user_role(70) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }

        $data['manufacturers'] = Manufacturers::get();
        return view('admin.manufacturers.list',$data);
    }



    //Function of Add Manufacturers View
    function add()
    {
        // Check User Permission
        if(check_user_role(71) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }

        return view('admin.manufacturers.add');
    }



    // Function of Store new Manufacturer
    function store(Request $request)
    {
        // Validation of Manufacturer
        $request->validate([
            'manufacturername' => 'required',
        ]);

        // New Manufacturer
        $manufacturer = new Manufacturers;
        $manufacturer->name = $request['manufacturername'];

        // When not empty Sort Order Then Insert Sort Order Otherwise Not
        if(!empty($request['sortorder']))
        {
            $manufacturer->sort_order = $request['sortorder'];
        }

        // When not empty Manufacturer Image Then Insert Manufacturer Image Otherwise Not
        if($request->hasFile('image'))
        {
            $imagename = time().'.'.$request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('admin/manufacturers/'),$imagename);
            $manufacturer->image = $imagename;
        }

        $manufacturer->save();

        // Last Inserted Manufacturer ID
        $manufacturer_id = $manufacturer->id;

        // New Menufacturer Store
        $manustore = new ManufacturerstoStore;
        $manustore->manufacturer_id = $manufacturer_id;
        $manustore->store_id = 0;
        $manustore->save();

        // When not empty SEO Keyword Then Insert SEO Keyword Otherwise Not
        if(!empty($request['keyword']))
        {
            $seo = new Seo;
            $seo->store_id = 0;
            $seo->language_id = 1;
            $seo->tag_id = $manufacturer_id;
            $seo->query = 'manufacturer_id='.$manufacturer_id;
            $seo->keyword = $request['keyword'];
            $seo->save();
        }

        return redirect()->route('manufacturer')->with('success',"Manufacturer Inserted Successfully..");

    }



    // Function of Delete Manufacturers
    function deletemultimanufacturer(Request $request)
    {
       // Check User Permission
       if(check_user_role(73) != 1)
       {
           return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
       }

       //Multiple Id's
       $ids = $request['id'];

       // When not empty ids Then Delete Manufacturer Otherwise Not
       if(count($ids) > 0)
       {
            // One by One Delete Manufacturer Images
           foreach($ids as $id)
           {
               // Get Single Manufacturer Details
               $manufacturer = Manufacturers::where('manufacturer_id',$id)->first();

               // Image of Manufacturers
               $image = $manufacturer->image;

               // When not empty Image Then Delete Image Otherwise Not
               if(!empty($image))
               {
                    if(file_exists('public/admin/manufacturers/'.$image))
                    {
                        unlink('public/admin/manufacturers/'.$image);
                    }
               }

           }

           // Delete Manufacturers
           Manufacturers::whereIn('manufacturer_id',$ids)->delete();

           // Delete Manufacturer Store
           ManufacturerstoStore::whereIn('manufacturer_id',$ids)->delete();

           // Delete Manufacturer SEO
           Seo::whereIn('tag_id',$ids)->delete();

           return response()->json([
               'success' => 1,
           ]);
       }
    }



    function edit($id)
    {
        //Check User Permission
        if(check_user_role(72) != 1)
        {
            return redirect()->route('dashboard')->with('error',"Sorry you haven't Access.");
        }

        // Get Manufacturer Details by Manufacturer_ID
        $manufacturer = Manufacturers::where('manufacturer_id',$id)->first();

        // When Empty Manufacturer Then Redirect to Manufacturer List
        if(empty($manufacturer))
        {
            return redirect()->route('manufacturer');
        }

        // Give Manufacturer Details to Array
        $data['manufacturer'] = $manufacturer;

        // Giv Manufacturer SEO Details to Array
        $data['seo'] = Seo::where('tag_id',$id)->first();

        return view('admin.manufacturers.edit',$data);
    }




    function update(Request $request)
    {
        // Validation of Manufacturer
        $request->validate([
            'manufacturername' => 'required',
        ]);

        // Manufacturer ID
        $manufacturer_id = $request->id;

        // Get Manufacturer By Manufacturer ID
        $manufacturer = Manufacturers::find($manufacturer_id);

        // Get Old Image of Manufacturer
        $old_img = $manufacturer->image;

        $manufacturer->name = $request['manufacturername'];
        $manufacturer->sort_order = $request['sortorder'];

        // When not empty Manufacturer Image Then Insert Manufacturer Image Otherwise Not
        if($request->hasFile('image'))
        {
            // When already have a Old Image Then Delete Old Image
            if(!empty($old_img))
            {
                unlink('public/admin/manufacturers/'.$old_img);
            }

            // Insert New Image
            $imagename = time().'.'.$request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('admin/manufacturers/'),$imagename);
            $manufacturer->image = $imagename;

        }

        // Update Manufacturer Details
        $manufacturer->update();

        // Find Manufcaturer SEO by manufacturer ID
        $seo = Seo::find($manufacturer_id);

        // If empty SEO then Insert New SEO otherwise Not
        if(empty($seo))
        {
            $seonew = new Seo;
            $seonew->store_id = 0;
            $seonew->language_id = 1;
            $seonew->tag_id = $manufacturer_id;
            $seonew->query = 'manufacturer_id='.$manufacturer_id;
            $seonew->keyword = $request['keyword'];
            $seonew->save();
            return redirect()->route('manufacturer')->with('success','Manufacturer Updated successfully!');
        }

        // If already have SEO then Update SEO
        $seo->keyword = $request['keyword'];
        $seo->update();

        return redirect()->route('manufacturer')->with('success','Manufacturer Updated successfully!');
    }


}
