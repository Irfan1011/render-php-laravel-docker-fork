<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\Driver;

class IsDriverController extends Controller
{
    public function index()
    {
        //
    }

    public function create($id)
    {
        $transaction = Transaction::find($id);
        return view('Employee/CustomerService/Rental/create',compact('transaction'));
    }

    public function store(Request $request, $id)
    {
        $employee = Auth::user()->id;

        Transaction::find($id)->update([
            'driver_id' => $request->driver_id,
            'employee_id' =>$employee,
        ]);

        Driver::where('user_id','=',$request->driver_id)->update([
            'daily_price' => $request->daily_price,
        ]);
        
        return redirect()->route('transactionCS.index')->with('success','Driver Jobs'); 
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_license' => ['required','numeric','regex:/^\d{14}$/'],
        ],[
            'customer_license.regex' => 'The customer license must be 14 digit',
        ]);

        Transaction::find($id)->update([
            'customer_license' => $request->customer_license,
        ]);
        
        return redirect()->route('transaction.index')->with('success','Transaction Created'); 
    }

    public function destroy($id)
    {
        //
    }
}
