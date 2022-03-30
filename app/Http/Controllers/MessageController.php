<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\NotificationMessage;
use Illuminate\Http\Request;
use DataTables;

class MessageController extends Controller
{

    public function index()
    {

        return view('admin.messages.list');
    }

    public function getmessage(Request $request)
    {
        if($request->ajax())
        {
            // Current Store ID;
            $current_store_id = currentStoreId();
            // $data =Message::where('sore_id', $current_store_id)->get();
            $data = Message::with('hasOneStore')->whereHas('hasOneStore', function ($query) use ($current_store_id){
                $query->where('store_id',$current_store_id);
            })->get();

            return DataTables::of($data)->addIndexColumn()
            ->addColumn('message', function($row){
                $message = html_entity_decode($row->message);
                return $message;
            })
            ->addColumn('name', function($row){
                $cname = $row->firstname.' '.$row->lastname;
                return $cname;
            })
            ->addColumn('store_name', function($row){
                $storename = html_entity_decode($row->hasOneStore->name);
                return $storename;
            })
            ->rawColumns(['name'.'store_name'])
            ->make(true);
        }
    }

    public function messageinsert(Request $request)
    {
        $current_store_id = currentStoreId();
        $message = new NotificationMessage;
        $message->store_id = $current_store_id;
        $message->title = $request->title;
        $message->message = $request->message;
        $message->save();

        return redirect()->route('messages');
    }


    public function add()
    {
        return view('admin.messages.add');
    }


}
