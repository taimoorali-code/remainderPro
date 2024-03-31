<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
    use Carbon\Carbon;
    

class DashboardController extends Controller
{
    
    public function users()
    {
        // Aaj ka date lein
        $today = Carbon::today();
    
        // Aaj ke din me add huye users ko fetch karein
        $users = DB::table('users')
            ->whereDate('created_at', $today)
            ->get();
    
        // 'users' view ko render karein aur usme 'users' variable pass karein
        return view('layouts.inc.dashboardContent', compact('users'));
    }
    
    public function viewUser($id)
    {
        $users = User::find($id);
        return view('Admin.users.view', compact('users'));
    }
}
