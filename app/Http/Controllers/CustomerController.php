<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\User;
use PDF;

class CustomerController extends Controller
{
    public function index()
    {
        $combinedData = DB::table('customer')
                    ->join('users', 'users.id', '=', 'customer.user_id')
                    ->select('*')
                    ->orderBy('users.id', 'ASC')
                    ->paginate(2);

        return view('Employee/CustomerService/Customer/show',compact('combinedData'));
    }

    public function create()
    {
        return view('Customer.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'address'=> ['required', 'regex:/[\pL\s\.0-9]+$/'],
            'birth'=> 'required|before_or_equal:today',
            'gender'=> 'required',
            'phone'=> 'required|numeric|starts_with:08',
        ]);

        $customer = Customer::create([
            'address' => $request->address,
            'birth' => $request->birth,
            'gender' => $request->gender,
            'phone' => $request->phone,
        ]);

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('success','Customer created');
    }

    public function edit($id)
    {
        $user = User::find($id);
        $customer = ['user_id' => $id];
        $customer = DB::table('customer')
                    ->join('users', 'users.id', '=', 'customer.user_id')
                    ->where('customer.user_id',$customer)
                    ->first();
        return view('Employee/CustomerService/Customer/edit',compact('customer','user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:rfc', 'max:255'],
            'address'=> ['required', 'regex:/[\pL\s\.0-9]+$/'],
            'birth'=> 'required|before_or_equal:today',
            'gender'=> 'required',
            'phone'=> 'required|numeric|starts_with:08',
        ]);
        
        $user = User::find($id);
        $user = User::find($id)->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
               
        $customer =  Customer::where('user_id',$id)->first();

        $customer->update([
            'address' => $request->address,
            'birth' => $request->birth,
            'gender' => $request->gender,
            'phone' => $request->phone,
        ]);

        return redirect()->route('customer.index')->with('success','Customer Updated');
    }

    public function destroy($id)
    {
        $customer = ['user_id' => $id];
        $customer = DB::table('customer')
                    ->join('users', 'users.id', '=', 'customer.user_id')
                    ->where('customer.user_id',$customer)
                    ->delete(); 
        User::find($id)->delete();

        return redirect()->route('customer.index',$id)->with('success','Customer Deleted');
    }

    public function search(Request $request)
    {
        $combinedData = DB::table('customer')
                    ->join('users', 'users.id', '=', 'customer.user_id')
                    ->select('*')
                    ->paginate(3);

        $search = $request['search']  ?? "";
        if($search != "")
        {
            $customer = Customer::join('users', function($join){
                $join->on('customer.user_id', '=', 'users.id');
            })->where('users.name', 'like','%'.$search.'%')->paginate(3);
        }
        else
        {
            $customer = Customer::join('users', function($join){
                $join->on('customer.user_id', '=', 'users.id');
            })->orderBy('users.id', 'ASC')->paginate(3);
        }
        
        return view('Employee/CustomerService/Customer/search', compact('customer','combinedData'));
    }

    public function show($id)
    {
        $customer = ['verifikasi_CS' => 'Verified'];
        $customer = DB::table('customer')->where('user_id','=',$id)->update($customer);
        return redirect()->route('customer.index')->with('success','Customer Verified');
    }

    public function export($id)
    {
        $customers = Customer::find($id);
        view()->share('customers',$customers);
        $pdf = PDF::loadview('Customer.card');
        return $pdf->download('customer_card.pdf');
    }
}
