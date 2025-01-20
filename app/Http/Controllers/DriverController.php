<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Driver;
use App\Models\User;
use App\Models\Mitra;
use App\Models\Car;
use App\Models\Transaction;
use DateTime;

class DriverController extends Controller
{
    public function index()
    {
        $combinedData = DB::table('driver')
                    ->join('users', 'driver.user_id', '=', 'users.id')
                    ->select('*')
                    ->orderBy('driver.id', 'ASC')
                    ->paginate(1);

        return view('Employee/Admin/Driver/show',compact('combinedData'));
    }

    public function create()
    {
        return view('Driver.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'photo'=> 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'address'=> ['required', 'regex:/[\pL\s\.0-9]+$/'],
            'birth'=> 'required|before_or_equal:today',
            'gender'=> 'required',
            'phone'=> 'required|numeric|starts_with:08',
            'language'=> 'required',
            'photocopy_scanDriverLicense' => 'required|mimes:pdf|max:2048',
            'drug_free_letter' => 'required|mimes:pdf|max:2048',
            'mental_health_letter' => 'required|mimes:pdf|max:2048',
            'physical_health_certificate' => 'required|mimes:pdf|max:2048',
            'criminal_record_certificate' => 'required|mimes:pdf|max:2048',
        ]);
        
        $driver = Driver::create([
            'photo' => $request->photo,
            'address' => $request->address,
            'birth' => $request->birth,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'language' => $request->language,
            'photocopy_scanDriverLicense' => $request->photocopy_scanDriverLicense,
            'drug_free_letter' => $request->drug_free_letter,
            'mental_health_letter' => $request->mental_health_letter,
            'physical_health_certificate' => $request->physical_health_certificate,
            'criminal_record_certificate' => $request->criminal_record_certificate,
        ]);

        if($request->hasFile('photo')){
            $request->file('photo')->move('uploads/Driver_Photo/', $request->file('photo')->getClientOriginalName());
            $driver->photo = $request->file('photo')->getClientOriginalName();
            $driver->save();
        }

        if($request->hasFile('photocopy_scanDriverLicense')){
            $request->file('photocopy_scanDriverLicense')->move('uploads/Driver_File/', $request->file('photocopy_scanDriverLicense')->getClientOriginalName());
            $driver->photocopy_scanDriverLicense = $request->file('photocopy_scanDriverLicense')->getClientOriginalName();
            $driver->save();
        }

        if($request->hasFile('drug_free_letter')){
            $request->file('drug_free_letter')->move('uploads/Driver_File/', $request->file('drug_free_letter')->getClientOriginalName());
            $driver->drug_free_letter = $request->file('drug_free_letter')->getClientOriginalName();
            $driver->save();
        }

        if($request->hasFile('mental_health_letter')){
            $request->file('mental_health_letter')->move('uploads/Driver_File/', $request->file('mental_health_letter')->getClientOriginalName());
            $driver->mental_health_letter = $request->file('mental_health_letter')->getClientOriginalName();
            $driver->save();
        }
        
        if($request->hasFile('physical_health_certificate')){
            $request->file('physical_health_certificate')->move('uploads/Driver_File/', $request->file('physical_health_certificate')->getClientOriginalName());
            $driver->physical_health_certificate = $request->file('physical_health_certificate')->getClientOriginalName();
            $driver->save();
        }

        if($request->hasFile('criminal_record_certificate')){
            $request->file('criminal_record_certificate')->move('uploads/Driver_File/', $request->file('criminal_record_certificate')->getClientOriginalName());
            $driver->criminal_record_certificate = $request->file('criminal_record_certificate')->getClientOriginalName();
            $driver->save();
        }

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success','Driver created');
    }

    public function search(Request $request)
    {
        $search = $request['search']  ?? "";
        if($search != "")
        {
            $driver = Driver::join('users', function($join){
                $join->on('driver.user_id', '=', 'users.id');
            })->where('users.name', 'like','%'.$search.'%')->paginate(3);
        }
        else
        {
            $driver = Driver::join('users', function($join){
                $join->on('driver.user_id', '=', 'users.id');
            })->orderBy('users.id', 'ASC')->paginate(3);
        }
        
        return view('Employee/Admin/Driver/search', compact('driver'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        $driver = ['user_id' => $id];
        $driver = DB::table('driver')
                    ->join('users', 'users.id', '=', 'driver.user_id')
                    ->where('driver.user_id',$driver)
                    ->first();
        return view('Employee/Admin/Driver/edit',compact('driver','user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'photo'=> 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'address'=> ['required', 'regex:/[\pL\s\.0-9]+$/'],
            'birth'=> 'required|before_or_equal:today',
            'gender'=> 'required',
            'phone'=> 'required|numeric|starts_with:08',
            'language'=> 'required',
            'photocopy_scanDriverLicense' => 'required|mimes:pdf|max:2048',
            'drug_free_letter' => 'required|mimes:pdf|max:2048',
            'mental_health_letter' => 'required|mimes:pdf|max:2048',
            'physical_health_certificate' => 'required|mimes:pdf|max:2048',
            'criminal_record_certificate' => 'required|mimes:pdf|max:2048',
        ]);

        $user = User::find($id);
        $user = User::find($id)->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $driver =  Driver::where('user_id',$id)->first();

        $driver->update([
            'address' => $request->address,
            'birth' => $request->birth,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'language' => $request->language,
        ]);

        if($request->hasFile('photo')){
            $request->file('photo')->move('uploads/Driver_Photo/', $request->file('photo')->getClientOriginalName());
            $driver->photo = $request->file('photo')->getClientOriginalName();
            $driver->save();
        }

        if($request->hasFile('photocopy_scanDriverLicense')){
            $request->file('photocopy_scanDriverLicense')->move('uploads/Driver_File/', $request->file('photocopy_scanDriverLicense')->getClientOriginalName());
            $driver->photocopy_scanDriverLicense = $request->file('photocopy_scanDriverLicense')->getClientOriginalName();
            $driver->save();
        }

        if($request->hasFile('drug_free_letter')){
            $request->file('drug_free_letter')->move('uploads/Driver_File/', $request->file('drug_free_letter')->getClientOriginalName());
            $driver->drug_free_letter = $request->file('drug_free_letter')->getClientOriginalName();
            $driver->save();
        }

        if($request->hasFile('mental_health_letter')){
            $request->file('mental_health_letter')->move('uploads/Driver_File/', $request->file('mental_health_letter')->getClientOriginalName());
            $driver->mental_health_letter = $request->file('mental_health_letter')->getClientOriginalName();
            $driver->save();
        }
        
        if($request->hasFile('physical_health_certificate')){
            $request->file('physical_health_certificate')->move('uploads/Driver_File/', $request->file('physical_health_certificate')->getClientOriginalName());
            $driver->physical_health_certificate = $request->file('physical_health_certificate')->getClientOriginalName();
            $driver->save();
        }

        if($request->hasFile('criminal_record_certificate')){
            $request->file('criminal_record_certificate')->move('uploads/Driver_File/', $request->file('criminal_record_certificate')->getClientOriginalName());
            $driver->criminal_record_certificate = $request->file('criminal_record_certificate')->getClientOriginalName();
            $driver->save();
        }

        return redirect()->route('driver.index')->with('success','Driver Updated');
    }

    public function destroy($id)
    {
        $driver = ['user_id' => $id];
        $driver = DB::table('driver')
                    ->join('users', 'users.id', '=', 'driver.user_id')
                    ->where('driver.user_id', $driver)
                    ->delete();
        $role = ['role_id' => $id];
        $role = DB::table('role_user')
                    ->join('users', 'users.id', '=', 'role_user.user_id')
                    ->join('roles', 'role_user.role_id', '=', 'roles.id')
                    ->join('driver', 'role_user.user_id', '=', 'driver.user_id')
                    ->where('role_user.user_id',$role)
                    ->delete();  
        User::find($id)->delete();

        return redirect()->route('driver.index',$id)->with('success','Driver Deleted');
    }

    public function show($id)
    {
        $driver = ['verifikasi_admin' => 'Verified'];
        $driver = DB::table('driver')->where('user_id','=',$id)->update($driver);
        return redirect()->route('driver.index')->with('success','Driver Verified');
    }

    public function acceptOrder($id)
    {
        $transaction = Transaction::find($id);
        $driver = DB::table('driver')->select('*')->first();

        $startDate = new DateTime($transaction->date_and_time_transaction_started);
        $endDate = new DateTime($transaction->date_and_time_transaction_end);
        $interval = $startDate->diff($endDate);
        $numberOfDays = $interval->days + 1;

        $driverCosts = $numberOfDays * $driver->daily_price;

        Transaction::find($id)->update([
            'driver_costs' => $driverCosts,
            'payment_total' => $transaction->car_rental_costs + $driverCosts + $transaction->loan_extension,
        ]);

        Driver::where('user_id', $transaction->driver_id)->update([
            'rental_verif' => 'Accept',
        ]);

        return redirect()->route('transactionDriver.index')->with('success','Accepted');
    }

    public function declineOrder($id)
    {
        Transaction::find($id)->update([
            'driver_id' => NULL,
        ]);

        $transaction = Transaction::find($id);
        
        Driver::where('user_id', $transaction->driver_id)->update([
            'rental_verif' => 'Null',
        ]);
        
        return redirect()->route('transactionDriver.index')->with('success','Decline');
    }

    public function finishOrder(Request $request, $id)
    {
        $transaction = Transaction::find($id);

        $transaction->update([
            'date_return' => now(),
            'status' => 'Finish',
        ]);

        Driver::where('user_id', $transaction->driver_id)->update([
            'rental_verif' => 'Null',
        ]);

        if($transaction->car_id == 0)
        {
            Mitra::select('status')->where('id', '=', $transaction->mitra_id)->update([
                'status' => 'Null',
            ]);
        }elseif($transaction->mitra_id == 0)
        {
            Car::select('status')->where('id', '=', $transaction->car_id)->update([
                'status' => 'Null',
            ]);
        }
        
        if(Auth::user()->hasRole('driver'))
            return redirect()->route('transactionDriver.index')->with('success','Finish Rental');
        elseif(Auth::user()->hasRole('customer'))
            return redirect()->route('transaction.index')->with('success','Finish Rental');
    }
}
