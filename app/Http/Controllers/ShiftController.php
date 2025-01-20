<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Shift;

class ShiftController extends Controller
{
    public function index()
    {
        $combinedData = DB::table('employee')
                    ->join('users', 'employee.user_id', '=', 'users.id')
                    ->join('role_user', 'users.id', '=', 'role_user.user_id')
                    ->join('roles', 'roles.id', '=', 'role_user.role_id')
                    ->join('shift', 'shift.user_id', '=', 'users.id')
                    ->select('employee.*', 'roles.*', 'users.*', 'shift.*')
                    ->orderBy('shift.id', 'ASC')
                    ->paginate(2);

        return view('Manager/shift/show',compact('combinedData'));
    }

    public function create()
    {
        return view('Manager/shift/create');
    }

    public function store(Request $request)
    {
         $request->validate([
            'shift_time'=> 'required',
            'day'=> 'required',
            'user_id'=> 'required',
        ]);

        $existingRecord = Shift::where('shift_time', $request->shift_time)
                        ->where('day', $request->day)
                        ->where('user_id', $request->user_id)
                        ->first();

        $maxShift = 6;
        $userShiftCount  = DB::table('shift')
                        ->where('user_id', $request->user_id)
                        ->count();
                
        if(!$existingRecord)
        {
            if($userShiftCount < $maxShift)
            {
                Shift::create($request->all());
                return redirect()->route('shift.index')->with('success','Shift Schedule Created');
            }
            else
            {
                return redirect()->route('shift.index')->with('success','Shift Schedule Full');
            }
        }
        else
        {
            return redirect()->route('shift.index')->with('success','Shift Schedule Already Exist');
        }
    }

    public function edit($id)
    {
        $shift = Shift::find($id);
        return view('Manager/shift/edit',compact('shift'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'shift_time'=> 'required',
            'day'=> 'required',
        ]);

        $existingRecord = Shift::where('shift_time', $request->shift_time)
                        ->where('day', $request->day)
                        ->where('user_id', $request->user_id)
                        ->first();

        if(!$existingRecord)
        {
            Shift::find($id)->update([
                'shift_time' => $request->shift_time,
                'day' => $request->day,
            ]);

            return redirect()->route('shift.index')->with('success','Shift Schedule Updated');
        }
        else
        {
            return redirect()->route('shift.index')->with('success','Shift Schedule Already Exist');
        }
    }

    public function destroy($id)
    {
        Shift::find($id)->delete();
        return redirect()->route('shift.index',$id)->with('success','Shift Schedule Deleted');
    }

    public function search(Request $request)
    {
        $combinedData = DB::table('employee')
                    ->join('users', 'employee.user_id', '=', 'users.id')
                    ->join('role_user', 'users.id', '=', 'role_user.user_id')
                    ->join('roles', 'roles.id', '=', 'role_user.role_id')
                    ->join('shift', 'shift.user_id', '=', 'users.id')
                    ->select('employee.*', 'roles.*', 'users.*', 'shift.*')
                    ->orderBy('users.id', 'ASC')
                    ->paginate(3);

        $search = $request['search']  ?? "";
        if($search != "")
        {
            $employeeUserRole = DB::table('employee')
                    ->join('users', 'employee.user_id', '=', 'users.id')
                    ->join('role_user', 'users.id', '=', 'role_user.user_id')
                    ->join('roles', 'roles.id', '=', 'role_user.role_id')
                    ->join('shift', 'shift.user_id', '=', 'users.id')
                    ->select('employee.*', 'roles.*', 'users.*', 'shift.*')
                    ->where('users.name', 'like','%'.$search.'%')->paginate(3);
        }
        else
        {
            $employeeUserRole = DB::table('employee')
                    ->join('users', 'employee.user_id', '=', 'users.id')
                    ->join('role_user', 'users.id', '=', 'role_user.user_id')
                    ->join('roles', 'roles.id', '=', 'role_user.role_id')
                    ->join('shift', 'shift.user_id', '=', 'users.id')
                    ->select('employee.*', 'roles.*', 'users.*', 'shift.*')
                    ->orderBy('users.id', 'ASC')->paginate(3);
        }
        
        return view('Manager/shift/search', compact('employeeUserRole','combinedData'));
    }
}
