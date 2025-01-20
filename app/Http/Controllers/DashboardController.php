<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Models\Customer;
use App\Models\Driver;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $employee = Employee::where('user_id', Auth::user()->id)->first();
        $customer = Customer::where('user_id', Auth::user()->id)->first();
        $driver = Driver::where('user_id', Auth::user()->id)->first();

        if(Auth::user()->hasRole('customer')){
            if($customer && $customer->verifikasi_CS == 'Verified')
            {
                return view('Customer/customerDashboard');
            }else{
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect('/')->with('success','Login Fail, Not Yet Verified by Customer Service!');
            }
        }elseif(Auth::user()->hasRole('admin')){
            if($employee && $employee->verifikasi_admin == 'Verified')
            {
                return view('Employee/admin/adminDashboard');
            }else{
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect('/')->with('success','Login Fail, Not Yet Verified by Admin!');
            }
        }elseif(Auth::user()->hasRole('customerServices')){
            if($employee && $employee->verifikasi_admin == 'Verified')
            {
                return view('Employee/customerservice/customerServicesDashboard');
            }else{
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                return redirect('/')->with('success','Login Fail, Not Yet Verified by Admin!');
            }
        }elseif(Auth::user()->hasRole('driver')){
            if($driver && $driver->verifikasi_admin == 'Verified')
            {
                return view('Driver/DriverDashboard');
            }else{
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                return redirect('/')->with('success','Login Fail, Not Yet Verified by Admin!');
            }
        }elseif(Auth::user()->hasRole('manager')){
            return view('Manager/managerDashboard');
        }
    }
}
