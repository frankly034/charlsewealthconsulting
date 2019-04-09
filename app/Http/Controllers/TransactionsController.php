<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductStatus;
use App\Transaction;
class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $status = ProductStatus::all();
        $order = Transaction::latest()->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function show($id)
    {
        $order = Transaction::findOrFail($id);
        //return view('trransaction.show_transaction', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function editStatus($id){
        $order = Transaction::findOrFail($id);
        //return view('transaction.edit_status');
    }

    public function changeStatus($id)
    {
        $order = Transaction::findOrFail($id);
        $order->status = request()->status;
        $order->update();    
    }

    }
