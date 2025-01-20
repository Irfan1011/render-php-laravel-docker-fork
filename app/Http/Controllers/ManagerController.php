<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Manager;
use Illuminate\Support\Facades\DB;

class ManagerController extends Controller
{
    public function index()
    {
        return view('Manager/managerDashboard');
    }

    public function Promo()
    {
        return view('Manager/promo/show');
    }

    public function Shift()
    {
        $combinedData = DB::table('employee')
                    ->join('users', 'employee.user_id', '=', 'users.id')
                    ->join('role_user', 'users.id', '=', 'role_user.user_id')
                    ->join('roles', 'roles.id', '=', 'role_user.role_id')
                    ->join('shift', 'shift.user_id', '=', 'users.id')
                    ->select('employee.*', 'roles.*', 'users.*', 'shift.*')
                    ->orderBy('shift.id', 'ASC')
                    ->paginate(3);

        return view('Manager/shift/show',compact('combinedData'));
    }
}
