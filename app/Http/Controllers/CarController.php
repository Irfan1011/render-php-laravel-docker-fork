<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Car;
use App\Models\Mitra;

class CarController extends Controller
{
    public function index()
    {
        $combinedData = Car::select('*')->orderBy('id', 'ASC')->paginate(2);

        return view('Employee/Admin/Car/show',compact('combinedData'));
    }

    public function edit($id)
    {
        $car = Car::find($id);
        return view('Employee/Admin/Car/edit',compact('car'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'license_plate'=> ['required','regex:/^[A-Za-z]{1,2}\s\d{1,4}\s[A-Za-z]{1,3}$/'],
        ],[
            'license_plate.regex' => 'The license plate should use this format XX 1234 XX',
        ]);

        Car::find($id)->update([
            'license_plate' => $request->license_plate,
        ]);

        return redirect()->route('car.index')->with('success','License Plate Updated');
    }

    public function search(Request $request)
    {
        $combinedData = Car::select('*')->orderBy('id', 'ASC')->paginate(2);

        $search = $request['search']  ?? "";
        if($search != "")
        {
            $car = Car::where('name', 'like','%'.$search.'%')->get();
        }
        else
        {
            $car = Car::orderBy('id', 'ASC')->paginate(2);
        }
        
        return view('Employee/Admin/Car/search', compact('car','combinedData'));
    }

    public function mitra()
    {
        $combinedData = DB::table('mitra')
                    ->join('users', 'mitra.user_id', '=', 'users.id')
                    ->join('customer', 'users.id', '=', 'customer.user_id')
                    ->select('mitra.*', 'users.name', 'customer.address', 'customer.phone')
                    ->orderBy('mitra.id', 'ASC')
                    ->paginate(3);

        return view('Employee/Admin/Car/Mitra/show',compact('combinedData'));
    }
}
