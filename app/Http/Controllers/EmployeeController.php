<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function index()
    {
        $combinedData = DB::table('employee')
                    ->join('role_user', 'employee.user_id', '=', 'role_user.user_id')
                    ->join('roles', 'roles.id', '=', 'role_user.role_id')
                    ->join('users', 'users.id', '=', 'role_user.user_id')
                    ->select('employee.*', 'roles.*', 'users.*')
                    ->orderBy('users.id', 'ASC')
                    ->paginate(3);

        return view('Employee/Admin/Employee/show',compact('combinedData'));
    }

    public function create()
    {
        return view('Employee.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'photo'=> 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'address'=> ['required', 'regex:/[\pL\s\.0-9]+$/'],
            'birth'=> 'required|before_or_equal:today',
            'gender'=> 'required',
            'phone'=> 'required|numeric|starts_with:08',
        ]);
        
        $employee = Employee::create([
            'photo' => $request->photo,
            'address' => $request->address,
            'birth' => $request->birth,
            'gender' => $request->gender,
            'phone' => $request->phone,
        ]);

        if($request->hasFile('photo')){
            $request->file('photo')->move('uploads/Employee_Photo/', $request->file('photo')->getClientOriginalName());
            $employee->photo = $request->file('photo')->getClientOriginalName();
            $employee->save();
        }

        if(Auth::user()->hasRole('admin')){
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/')->with('success','Admin created');
        }elseif(Auth::user()->hasRole('customerServices')){
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/')->with('success','Customer Service created');
        }
    }

    public function search(Request $request)
    {
        $combinedData = DB::table('employee')
                    ->join('role_user', 'employee.user_id', '=', 'role_user.user_id')
                    ->join('roles', 'roles.id', '=', 'role_user.role_id')
                    ->join('users', 'users.id', '=', 'role_user.user_id')
                    ->select('employee.*', 'roles.*', 'users.*')
                    ->paginate(3);

        $search = $request['search']  ?? "";
        if($search != "")
        {
            $employeeUserRole = Role::join('role_user', function($join){
                $join->on('roles.id', '=', 'role_user.role_id');
            })->join('employee', function($join){
                $join->on('role_user.user_id', '=', 'employee.user_id');
            })->join('users', function($join){
                $join->on('employee.user_id', '=', 'users.id');
            })->where('users.name', 'like','%'.$search.'%')->paginate(3);
        }
        else
        {
            $employeeUserRole = Role::join('role_user', function($join){
                $join->on('roles.id', '=', 'role_user.role_id');
            })->join('employee', function($join){
                $join->on('role_user.user_id', '=', 'employee.user_id');
            })->join('users', function($join){
                $join->on('employee.user_id', '=', 'users.id');
            })->orderBy('users.id', 'ASC')->paginate(3);
        }
        
        return view('Employee/Admin/Employee/search', compact('employeeUserRole','combinedData'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        $employee = ['user_id' => $id];
        $employee = DB::table('employee')
                    ->join('users', 'users.id', '=', 'employee.user_id')
                    ->where('employee.user_id',$employee)
                    ->first();
        return view('Employee/Admin/Employee/edit',compact('employee','user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:rfc', 'max:255'],
            'photo'=> 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'address'=> ['required', 'regex:/[\pL\s\.0-9]+$/'],
            'birth'=> 'required|before_or_equal:today',
            'gender'=> 'required',
            'phone'=> 'required|numeric|starts_with:08',
            'user_id'=> 'required',
        ]);
        
        $user = User::find($id);
        $user = User::find($id)->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
               
        $employee =  Employee::where('user_id',$id)->first();

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

        $role = ['role_id' => $request->user_id];
        $role = DB::table('role_user')
                    ->join('users', 'users.id', '=', 'role_user.user_id')
                    ->join('roles', 'role_user.role_id', '=', 'roles.id')
                    ->join('employee', 'role_user.user_id', '=', 'employee.user_id')
                    ->where('role_user.user_id',$employee->user_id)
                    ->update($role);

        return redirect()->route('employee.index')->with('success','Employee Updated');
    }

    public function destroy($id)
    {
        $employee = ['user_id' => $id];
        $employee = DB::table('employee')
                    ->join('users', 'users.id', '=', 'employee.user_id')
                    ->where('employee.user_id',$employee)
                    ->delete(); 
        $role = ['role_id' => $id];
        $role = DB::table('role_user')
                    ->join('users', 'users.id', '=', 'role_user.user_id')
                    ->join('roles', 'role_user.role_id', '=', 'roles.id')
                    ->join('employee', 'role_user.user_id', '=', 'employee.user_id')
                    ->where('role_user.user_id',$role)
                    ->delete();
        User::find($id)->delete();

        return redirect()->route('employee.index',$id)->with('success','Employee Deleted');
    }

    public function show($id)
    {
        $employee = ['verifikasi_admin' => 'Verified'];
        $employee = DB::table('employee')->where('user_id','=',$id)->update($employee);
        return redirect()->route('employee.index')->with('success','Employee Verified');
    }
}
