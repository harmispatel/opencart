<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{

    public function index()
    {
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
