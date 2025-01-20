<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promo;

class PromoController extends Controller
{
    public function index()
    {
        return view('Manager/promo/show');
    }

    public function create()
    {
        return view('Manager/promo/create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'promo_code'=>'required|unique:promo',
            'promo_type'=>'required|unique:promo',
            'discount'=>'required|numeric',
            'description'=>['required', 'regex:/[\pL\s\.0-9]+$/'],
        ]);

        Promo::create($request->all());

        // //Redirect jika sukses menyimpan data
        // return redirect()->route('customers.index')
        // ->with('success','Item created successfully.');
        return redirect()->route('promo.index')->with('success','Promo Created');
    }

    public function edit($id)
    {
        $promo = Promo::query($id)->where('promo_code',$id)->first();
        return view('Manager/promo/edit',compact('promo'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'promo_code'=>'required',
            'promo_type'=>'required',
            'discount'=>'required',
            'description'=>['required', 'regex:/[\pL\s\.0-9]+$/'],
        ]);

        $promo = Promo::query($id)->where('promo_code',$id)->first();
        Promo::query($id)->where('promo_code',$id)->update([
            'promo_code' => $request->promo_code,
            'promo_type' => $request->promo_type,
            'description' => $request->description,
        ]);
        $promo->save();

        return redirect()->route('promo.index',$id)->with('success','Promo Updated');
    }

    public function destroy($id)
    {
        $id = Promo::query($id)->where('promo_code',$id)->delete();

        return redirect()->route('promo.index',$id)->with('success','Promo Deleted');
    }

    public function search(Request $request)
    {
        $search = $request['search']  ?? "";
        if($search != "")
        {
            $promo = Promo::where('promo_code', 'like','%'.$search.'%')->get();
        }
        else
        {
            $promo = Promo::orderBy('promo_code', 'ASC')->get();
        }
        
        return view('Manager/promo/search', compact('promo'));
    }
}
