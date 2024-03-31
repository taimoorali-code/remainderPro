<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User; // Import User model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class frontendController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString(); // Convert to date string format
    
        // Aaj ke din me add huye users ko fetch karein
        $users = User::whereDate('created_at', $today)->get();
        // dd($users); // Debugging
        
        return view('Admin.dashboard', compact('users'));
    }
}
