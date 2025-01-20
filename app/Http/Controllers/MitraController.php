<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Mitra;

class MitraController extends Controller
{
    public function index()
    {
        $combinedData = DB::table('mitra')
                    ->join('users', 'mitra.user_id', '=', 'users.id')
                    ->join('customer', 'users.id', '=', 'customer.user_id')
                    ->select('mitra.*', 'users.name', 'customer.address', 'customer.phone')
                    ->where('mitra.user_id', Auth::user()->id)
                    ->orderBy('mitra.id', 'ASC')
                    ->paginate(1);

        return view('Customer/Mitra/show',compact('combinedData'));
    }

    public function create()
    {
        return view('Customer/Mitra/create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'car_name'=> ['required','regex:/^[A-Za-z]+$/'],
            'car_type'=> ['required','regex:/^[A-Za-z]+$/'],
            'transmission_type'=> ['required','regex:/^[A-Za-z]+$/'],
            'fuel_type'=> 'required',
            'fuel_volume'=> 'required|numeric',
            'color'=> ['required','regex:/^[A-Za-z]+$/'],
            'passenger_capasity'=> 'required|numeric',
            'facility'=> 'required',
            'license_plate'=> ['required','regex:/^[A-Za-z]{1,2}\s\d{1,4}\s[A-Za-z]{1,3}$/'],
            'vehicle_registration_number'=> ['required','numeric','regex:/^\d{8}$/'],
            'asset_category'=>'required',
            'owner_id'=>['required','numeric','regex:/^\d{15,17}$/'],
            'started_contract'=>'required|date|after_or_equal:today',
            'ending_contract'=>'required|date|after:started_contract',
            'latest_day_service'=>'required|date|before_or_equal:started_contract',
        ],[
            'car_name.regex' => 'The car name cannot be number',
            'car_type.regex' => 'The car type cannot be number',
            'transmission_type.regex' => 'The transmission type cannot be number',
            'color.regex' => 'The color cannot be number',
            'license_plate.regex' => 'The license plate should use this format XX 1234 XX',
            'vehicle_registration_number.regex' => 'The vehicle registration number must be 8 digit',
            'owner_id.regex' => 'The owner ID must be 15 - 17 digit',
        ]);

        Mitra::create([
            'car_name' => $request->car_name,
            'car_type' => $request->car_type,
            'transmission_type' => $request->transmission_type,
            'fuel_type' => $request->fuel_type,
            'fuel_volume' => $request->fuel_volume,
            'color' => $request->color,
            'passenger_capasity' => $request->passenger_capasity,
            'facility' => $request->facility,
            'license_plate' => $request->license_plate,
            'vehicle_registration_number' => $request->vehicle_registration_number,
            'asset_category' => $request->asset_category,
            'owner_id' => $request->owner_id,
            'started_contract' => $request->started_contract,
            'ending_contract' => $request->ending_contract,
            'latest_day_service' => $request->latest_day_service,
        ]);

        return redirect()->route('mitra.index')->with('success','Mitra Added');
    }

    public function edit($id)
    {
        $mitra = Mitra::find($id);
        if(Auth::user()->hasRole('customer'))
        {
            return view('Customer/Mitra/edit',compact('mitra'));
        }
        else if(Auth::user()->hasRole('admin'))
        {
            return view('Employee/Admin/Car/Mitra/edit',compact('mitra'));
        }
    }

    public function update(Request $request, $id)
    {
        if(Auth::user()->hasRole('customer'))
        {
            $request->validate([
                'car_name'=> ['required','regex:/^[A-Za-z]+$/'],
                'car_type'=> ['required','regex:/^[A-Za-z]+$/'],
                'transmission_type'=> ['required','regex:/^[A-Za-z]+$/'],
                'fuel_type'=> 'required',
                'fuel_volume'=> 'required|numeric',
                'color'=> ['required','regex:/^[A-Za-z]+$/'],
                'passenger_capasity'=> 'required|numeric',
                'facility'=> 'required',
                'license_plate'=> ['required','regex:/^[A-Za-z]{1,2}\s\d{1,4}\s[A-Za-z]{1,3}$/'],
                'vehicle_registration_number'=> ['required','numeric','regex:/^\d{8}$/'],
                'asset_category'=>'required',
                'owner_id'=>['required','numeric','regex:/^\d{15,17}$/'],
                'started_contract'=>'required|date|after_or_equal:today',
                'ending_contract'=>'required|date|after:started_contract',
                'latest_day_service'=>'required|date|before_or_equal:started_contract',
            ],[
                'car_name.regex' => 'The car name cannot be number',
                'car_type.regex' => 'The car type cannot be number',
                'transmission_type.regex' => 'The transmission type cannot be number',
                'color.regex' => 'The color cannot be number',
                'license_plate.regex' => 'The license plate should use this format XX 1234 XX',
                'vehicle_registration_number.regex' => 'The vehicle registration number must be 8 digit',
                'owner_id.regex' => 'The owner ID must be 15 - 17 digit',
            ]);

            Mitra::find($id)->update($request->all());
            
            return redirect()->route('mitra.index')->with('success','Mitra Updated');
        }
        else if(Auth::user()->hasRole('admin'))
        {
            $request->validate([
                'daily_price'=> 'required',
            ]);
    
            Mitra::find($id)->update([
                'daily_price' => $request->daily_price,
            ]);
    
            return redirect()->route('carMitra')->with('success','Daily Price Updated');
        }
    }

    public function destroy($id)
    {
        Mitra::find($id)->delete();
        if(Auth::user()->hasRole('customer'))
        {
            return redirect()->route('mitra.index')->with('success','Mitra Deleted');
        }
        else if(Auth::user()->hasRole('admin'))
        {
            return redirect()->route('carMitra')->with('success','Mitra Deleted');
        }
    }

    public function search(Request $request)
    {
        $search = $request['search']  ?? "";
        if($search != "")
        {
            $mitra = Mitra::join('users', function($join){
                $join->on('mitra.user_id', '=', 'users.id');
            })->join('customer', function($join){
                $join->on('customer.user_id', '=', 'users.id');
            })->where('mitra.car_name', 'like','%'.$search.'%')
            ->where('mitra.user_id', Auth::user()->id)->paginate(3);
        }
        else
        {
            $mitra = Mitra::join('users', function($join){
                $join->on('mitra.user_id', '=', 'users.id');
            })->join('customer', function($join){
                $join->on('customer.user_id', '=', 'users.id');
            })->where('mitra.user_id', Auth::user()->id)
            ->orderBy('mitra.id', 'ASC')->paginate(3);
        }
        
        return view('Customer/Mitra/search', compact('mitra'));
    }

    public function searchAdmin(Request $request)
    {
        $search = $request['search']  ?? "";
        if($search != "")
        {
            $mitra = Mitra::join('users', function($join){
                $join->on('mitra.user_id', '=', 'users.id');
            })->join('customer', function($join){
                $join->on('customer.user_id', '=', 'users.id');
            })->where('mitra.car_name', 'like','%'.$search.'%')->paginate(3);
        }
        else
        {
            $mitra = Mitra::join('users', function($join){
                $join->on('mitra.user_id', '=', 'users.id');
            })->join('customer', function($join){
                $join->on('customer.user_id', '=', 'users.id');
            })->orderBy('mitra.id', 'ASC')->paginate(3);
        }
        
        return view('Employee/Admin/Car/Mitra/search', compact('mitra'));
    }

    public function show($id)
    {
        $mitra = ['adminVerif' => 'Verified'];
        $mitra = DB::table('mitra')->where('id','=',$id)->update($mitra);
        return redirect()->route('carMitra')->with('success','Mitra Verified');
    }
}
