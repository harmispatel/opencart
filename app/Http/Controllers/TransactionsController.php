<?php

namespace App\Http\Controllers;

use App\Models\CustomerOrder;
use App\Models\Store;
use App\Models\Transactions;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    public function index()
    {
        $customerorder = CustomerOrder::paginate(50);
        $store = Store::paginate(50);
        
        $data = array_merge([$customerorder,$store]);
        echo '<pre>';
        print_r($data);
        exit();
        return view('admin.transactions.list');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Transactions $transactions)
    {
        //
    }

    public function edit(Transactions $transactions)
    {
        //
    }

    public function update(Request $request, Transactions $transactions)
    {
        //
    }

    public function destroy(Transactions $transactions)
    {
        //
    }
}
