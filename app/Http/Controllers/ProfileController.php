<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Driver;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        if(Auth::user()->hasRole('customer'))
        {
            $customer = ['user_id' => $request->user()->id];
            $customer = DB::table('customer')
                    ->join('users', 'users.id', '=', 'customer.user_id')
                    ->where('customer.user_id',$customer)
                    ->first();

            return view('profile.edit', [
                'user' => $request->user(),
                'customer' => $customer,
            ]);
        }elseif(Auth::user()->hasRole('customerServices') || Auth::user()->hasRole('admin'))
        {
            $employee = ['user_id' => $request->user()->id];
            $employee = DB::table('employee')
                    ->join('users', 'users.id', '=', 'employee.user_id')
                    ->where('employee.user_id',$employee)
                    ->first();

            return view('profile.edit', [
                'user' => $request->user(),
                'employee' => $employee,
            ]);
        }elseif(Auth::user()->hasRole('driver'))
        {
            $driver = ['user_id' => $request->user()->id];
            $driver = DB::table('driver')
                    ->join('users', 'users.id', '=', 'driver.user_id')
                    ->where('driver.user_id',$driver)
                    ->first();

            return view('profile.edit', [
                'user' => $request->user(),
                'driver' => $driver,
            ]);
        }else
        {
            return view('profile.edit', [
                'user' => $request->user(),
            ]);
        }
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        if(Auth::user()->hasRole('customer'))
        {
            $request->validate([
                'address'=> ['required', 'regex:/[\pL\s\.0-9]+$/'],
                'birth'=> 'required|before_or_equal:today',
                'gender'=> 'required',
                'phone'=> 'required|numeric|starts_with:08',
            ]);
    
            $customer =  Customer::where('user_id',$request->user()->id)->first();
    
            $customer->update([
                'address' => $request->address,
                'birth' => $request->birth,
                'gender' => $request->gender,
                'phone' => $request->phone,
            ]);
        }
        elseif(Auth::user()->hasRole('customerServices') || Auth::user()->hasRole('admin'))
        {
            $request->validate([
                'photo'=> 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'address'=> ['required', 'regex:/[\pL\s\.0-9]+$/'],
                'birth'=> 'required|before_or_equal:today',
                'gender'=> 'required',
                'phone'=> 'required|numeric|starts_with:08',
            ]);
    
            $employee =  Employee::where('user_id',$request->user()->id)->first();
    
            $employee->update([
                'address' => $request->address,
                'birth' => $request->birth,
                'gender' => $request->gender,
                'phone' => $request->phone,
            ]);

            if($request->hasFile('photo')){
                $request->file('photo')->move('uploads/employee_photo/', $request->file('photo')->getClientOriginalName());
                $employee->photo = $request->file('photo')->getClientOriginalName();
                $employee->save();
            }
        }
        elseif(Auth::user()->hasRole('driver'))
        {
            $request->validate([
                'photo'=> 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'address'=> ['required', 'regex:/[\pL\s\.0-9]+$/'],
                'birth'=> 'required|before_or_equal:today',
                'gender'=> 'required',
                'phone'=> 'required|numeric|starts_with:08',
                'language'=> 'required',
            ]);
    
            $driver =  Driver::where('user_id',$request->user()->id)->first();

            $driver->update([
                'address' => $request->address,
                'birth' => $request->birth,
                'gender' => $request->gender,
                'phone' => $request->phone,
                'language' => $request->language,
            ]);

            if($request->hasFile('photo')){
                $request->file('photo')->move('uploads/driver_photo/', $request->file('photo')->getClientOriginalName());
                $driver->photo = $request->file('photo')->getClientOriginalName();
                $driver->save();
            }
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
