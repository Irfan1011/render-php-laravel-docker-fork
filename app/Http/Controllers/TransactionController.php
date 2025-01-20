<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\Customer;
use App\Models\Car;
use App\Models\Mitra;
use App\Models\Driver;
use DateTime;

class TransactionController extends Controller
{
    public function index()
    {
        if(Auth::user()->hasRole('customer'))
        {
            $combinedData = DB::table('transaction')
                            ->join('users','transaction.user_id','=','users.id')
                            ->join('customer','transaction.customer_id','=','customer.user_id')
                            ->leftjoin('driver','transaction.driver_id','=','driver.user_id')
                            ->leftjoin('employee','transaction.employee_id','=','employee.user_id')
                            ->leftjoin('car','transaction.car_id','=','car.id')
                            ->leftjoin('mitra','transaction.mitra_id','=','mitra.id')
                            ->leftjoin('promo','transaction.promo_code','=','promo.promo_code')
                            ->select(
                                'transaction.*', 
                                'transaction.id as id_transaction', 
                                'users.*',
                                'users.name as user_name', 
                                'customer.*', 
                                'driver.*', 
                                'driver.phone as driver_phone', 
                                'driver.daily_price as driver_price', 
                                'employee.*', 
                                'car.*',
                                'car.license_plate as car_license_plate' ,
                                'car.daily_price as car_daily_price' ,
                                'mitra.*', 
                                'mitra.license_plate as mitra_license_plate' ,
                                'mitra.daily_price as mitra_daily_price' ,
                                'promo.*'
                            )
                            ->where('transaction.user_id', Auth::user()->id)
                            ->where('transaction.status', 'Null')
                            ->orderBy('transaction.id', 'ASC')
                            ->paginate(1);

            $driver_names = DB::table('driver')
                            ->join('users', 'driver.user_id', '=', 'users.id')
                            ->join('transaction', 'driver.user_id', '=', 'transaction.driver_id')
                            ->pluck('users.name', 'transaction.driver_id')
                            ->toArray();

            return view('Customer/Rental/show',compact('combinedData','driver_names'));
        }
        elseif(Auth::user()->hasRole('customerServices') || Auth::user()->hasRole('driver'))
        {
            $combinedData = DB::table('transaction')
                            ->join('users','transaction.user_id','=','users.id')
                            ->join('customer','transaction.customer_id','=','customer.user_id')
                            ->leftjoin('driver','transaction.driver_id','=','driver.user_id')
                            ->leftjoin('employee','transaction.employee_id','=','employee.user_id')
                            ->leftjoin('car','transaction.car_id','=','car.id')
                            ->leftjoin('mitra','transaction.mitra_id','=','mitra.id')
                            ->leftjoin('promo','transaction.promo_code','=','promo.promo_code')
                            ->select(
                                'transaction.*', 
                                'transaction.id as id_transaction', 
                                'users.*',
                                'users.name as user_name', 
                                'customer.*', 
                                'driver.*', 
                                'driver.phone as driver_phone', 
                                'driver.daily_price as driver_price', 
                                'employee.*', 
                                'car.*',
                                'car.license_plate as car_license_plate' ,
                                'car.daily_price as car_daily_price' ,
                                'mitra.*', 
                                'mitra.license_plate as mitra_license_plate' ,
                                'mitra.daily_price as mitra_daily_price' ,
                                'promo.*'
                            )
                            ->where('transaction.status','=','Null')
                            ->orderBy('transaction.id', 'ASC')
                            ->paginate(1);

            $driver_names = DB::table('driver')
                            ->join('users', 'driver.user_id', '=', 'users.id')
                            ->join('transaction', 'driver.user_id', '=', 'transaction.driver_id')
                            ->pluck('users.name', 'transaction.driver_id')
                            ->toArray();

            if(Auth::user()->hasRole('driver'))
                return view('Driver/Order/show',compact('combinedData','driver_names'));
            else
                return view('Employee/CustomerService/Rental/show',compact('combinedData','driver_names'));
        }
    }

    public function create()
    {
        $customer = Auth::user();
        $maxRental = DB::table('transaction')
                    ->join('customer','transaction.customer_id','=','customer.user_id')
                    ->select('transaction.*')
                    ->where('transaction.customer_id','=', $customer->id)
                    ->where('transaction.status','=','Null')
                    ->first();

        if($maxRental)
            return redirect()->route('transaction.index')->with('success','Max Rental');
        else
            return view('Customer/Rental/create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_IDCard' => ['required','numeric','regex:/^\d{15,17}$/'],
            'transaction_date' => 'required|date|date_equals:today',
            'date_and_time_transaction_started' => 'required|date|after_or_equal:today',
            'date_and_time_transaction_end' => 'required|date|after:date_and_time_trasaction_started',
            'payment_method' => 'required',
            'isDriver' => 'required',
        ],[
            'customer_IDCard.regex' => 'The customer ID card must be 15 - 17 digit',
        ]);

        $user = Auth::user();
        $customer = Customer::where('user_id', $user->id)->value('user_id');

        $startDate = new DateTime($request->date_and_time_transaction_started);
        $endDate = new DateTime($request->date_and_time_transaction_end);
        $interval = $startDate->diff($endDate);
        $numberOfDays = $interval->days + 1;

        if($request->car_id == 0)
        {
            $rentalCosts = Mitra::select('daily_price')->where('id', '=', $request->mitra_id)->first();
            $car_rental_costs_a_day = $rentalCosts->daily_price;
            $car_rental_costs = $numberOfDays * $car_rental_costs_a_day;

            Mitra::select('status')->where('id', '=', $request->mitra_id)->update([
                'status' => 'Rent',
            ]);
        }elseif($request->mitra_id == 0)
        {
            $rentalCosts = Car::select('daily_price')->where('id', '=', $request->car_id)->first();
            $car_rental_costs_a_day = $rentalCosts->daily_price;
            $car_rental_costs = $numberOfDays * $car_rental_costs_a_day;

            Car::select('status')->where('id', '=', $request->car_id)->update([
                'status' => 'Rent',
            ]);
        }

        Transaction::create([
            'user_id' => $user->id,
            'customer_id' => $customer,
            'driver_id' => $request->driver_id,
            'employee_id' => null,
            'car_id' => $request->car_id,
            'mitra_id' => $request->mitra_id,
            'promo_code' => $request->promo_code,
            'customer_IDCard' => $request->customer_IDCard,
            'customer_license' => 0,
            'transaction_date' => $request->transaction_date,
            'date_and_time_transaction_started' => $request->date_and_time_transaction_started,
            'date_and_time_transaction_end' => $request->date_and_time_transaction_end,
            'payment_method' => $request->payment_method,
            'car_rental_costs' => $car_rental_costs,
            'driver_costs' => 0,
            'loan_extension' => 0,
            'payment_total' => $car_rental_costs,
            'isDriver' => $request->isDriver,
        ]);

        if($request->isDriver == 'No')
        {
            $transaction = Transaction::where($request->id)->first();
            return view('Customer/Rental/isDriver/without',compact('transaction'));
        }
        elseif($request->isDriver == 'Yes')
        {
            return redirect()->route('transaction.index')->with('success','Rental Created');
        }
    }

    public function edit($id)
    {
        $transaction = Transaction::find($id);
        return view('Customer/Rental/Edit',compact('transaction'));
    }

    public function update(Request $request, $id)
    {
        if($request->isDriver == 'No')
        {
            $request->validate([
                'customer_license' => ['required','numeric','regex:/^\d{14}$/'],
            ],[
                'customer_license.regex' => 'The customer license must be 14 digit',
            ]);
        }
        
        $request->validate([
            'customer_IDCard' => ['required','numeric','regex:/^\d{15,17}$/'],
            'transaction_date' => 'required|date|date_equals:today',
            'date_and_time_transaction_started' => 'required|date|after_or_equal:today',
            'date_and_time_transaction_end' => 'required|date|after:date_and_time_trasaction_started',
            'payment_method' => 'required',
        ],[
            'customer_IDCard.regex' => 'The customer ID card must be 15 - 17 digit',
            'customer_license.regex' => 'The customer license must be 14 digit',
        ]);

        $transaction =  Transaction::where('id',$id)->first();

        $startDate = new DateTime($request->date_and_time_transaction_started);
        $endDate = new DateTime($request->date_and_time_transaction_end);
        $interval = $startDate->diff($endDate);
        $numberOfDays = $interval->days + 1;

        if($request->car_id == 0)
        {
            $rentalCosts = Mitra::select('daily_price')->where('id', '=', $request->mitra_id)->first();
            $car_rental_costs_a_day = $rentalCosts->daily_price;
            $car_rental_costs = $numberOfDays * $car_rental_costs_a_day;

            Mitra::select('status')->where('id', '=', $transaction->mitra_id)->update([
                'status' => 'Null',
            ]);
            Mitra::select('status')->where('id', '=', $request->mitra_id)->update([
                'status' => 'Rent',
            ]);
            Car::select('status')->where('id', '=', $request->car_id)->update([
                'status' => 'NULL',
            ]);
        }elseif($request->mitra_id == 0)
        {
            $rentalCosts = Car::select('daily_price')->where('id', '=', $request->car_id)->first();
            $car_rental_costs_a_day = $rentalCosts->daily_price;
            $car_rental_costs = $numberOfDays * $car_rental_costs_a_day;

            Car::select('status')->where('id', '=', $transaction->car_id)->update([
                'status' => 'Null',
            ]);
            Car::select('status')->where('id', '=', $request->car_id)->update([
                'status' => 'Rent',
            ]);
            Mitra::select('status')->where('id', '=', $request->mitra_id)->update([
                'status' => 'NULL',
            ]);
        }

        if($request->isDriver == 'No')
        {
            $transaction->update([
                'customer_license' => $request->customer_license,
            ]);
        }

        $transaction->update([
            'driver_id' => $request->driver_id,
            'car_id' => $request->car_id,
            'mitra_id' => $request->mitra_id,
            'promo_code' => $request->promo_code,
            'customer_IDCard' => $request->customer_IDCard,
            'transaction_date' => $request->transaction_date,
            'date_and_time_transaction_started' => $request->date_and_time_transaction_started,
            'date_and_time_transaction_end' => $request->date_and_time_transaction_end,
            'payment_method' => $request->payment_method,
            'car_rental_costs' => $car_rental_costs,
            'driver_costs' => 0,
            'loan_extension' => 0,
            'payment_total' => 0,
        ]);

        if(Auth::user()->hasRole('customer'))
            return redirect()->route('transaction.index')->with('success','Rental Updated');
        elseif(Auth::user()->hasRole('customerServices'))
            return redirect()->route('transactionCS.index')->with('success','Rental Updated');
    }

    public function destroy($id)
    {
        $transaction = Transaction::find($id);

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
        
        $transaction->delete();

        if(Auth::user()->hasRole('customer'))
            return redirect()->route('transaction.index',$id)->with('success','Rental Cancel');
        elseif(Auth::user()->hasRole('customerServices'))
            return redirect()->route('transactionCS.index',$id)->with('success','Rental Cancel');
    }

    public function search(Request $request)
    {
        $search = $request['search']  ?? "";
        if($search != "")
        {
            $transaction = DB::table('transaction')
            ->join('users','transaction.user_id','=','users.id')
            ->join('customer','transaction.customer_id','=','customer.user_id')
            ->leftjoin('driver','transaction.driver_id','=','driver.user_id')
            ->leftjoin('employee','transaction.employee_id','=','employee.user_id')
            ->leftjoin('car','transaction.car_id','=','car.id')
            ->leftjoin('mitra','transaction.mitra_id','=','mitra.id')
            ->leftjoin('promo','transaction.promo_code','=','promo.promo_code')
            ->select(
                'transaction.*', 
                'transaction.id as id_transaction', 
                'users.*',
                'users.name as user_name', 
                'customer.*', 
                'driver.*', 
                'driver.phone as driver_phone', 
                'driver.daily_price as driver_price', 
                'employee.*', 
                'car.*',
                'car.license_plate as car_license_plate' ,
                'car.daily_price as car_daily_price' ,
                'mitra.*', 
                'mitra.license_plate as mitra_license_plate' ,
                'mitra.daily_price as mitra_daily_price' ,
                'promo.*'
            )->where('users.name', 'like','%'.$search.'%')->paginate(1);
        }
        else
        {
            $transaction = DB::table('transaction')
            ->join('users','transaction.user_id','=','users.id')
            ->join('customer','transaction.customer_id','=','customer.user_id')
            ->leftjoin('driver','transaction.driver_id','=','driver.user_id')
            ->leftjoin('employee','transaction.employee_id','=','employee.user_id')
            ->leftjoin('car','transaction.car_id','=','car.id')
            ->leftjoin('mitra','transaction.mitra_id','=','mitra.id')
            ->leftjoin('promo','transaction.promo_code','=','promo.promo_code')
            ->select(
                'transaction.*', 
                'transaction.id as id_transaction', 
                'users.*',
                'users.name as user_name', 
                'customer.*', 
                'driver.*', 
                'driver.phone as driver_phone', 
                'driver.daily_price as driver_price', 
                'employee.*', 
                'car.*',
                'car.license_plate as car_license_plate' ,
                'car.daily_price as car_daily_price' ,
                'mitra.*', 
                'mitra.license_plate as mitra_license_plate' ,
                'mitra.daily_price as mitra_daily_price' ,
                'promo.*'
            )->orderBy('transaction.id', 'ASC')->paginate(1);
        }
        
        return view('Employee/CustomerService/Rental/search', compact('transaction'));
    }

    public function show($id)
    {
        $transaction = ['CS_Verif' => 'Verified'];
        $transaction = DB::table('transaction')->where('id','=',$id)->update($transaction);
        
        $employee = Auth::user()->id;

        Transaction::find($id)->update([
            'employee_id' =>$employee,
        ]);

        return redirect()->route('transactionCS.index')->with('success','Transaction Verified');
    }
}
