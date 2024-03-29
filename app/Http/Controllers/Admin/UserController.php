<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function user()
    {
        // $category = Category::all();
        return view('Admin.category.index');
    }
    public function subscriber()
    {
        // $category = Category::all();
        return view('Admin.subscriber.index');
    }
    public function feedback()
    {
        return view('Admin.feedback.index');

    }
}