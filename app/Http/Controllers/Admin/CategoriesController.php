<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Followup;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class CategoriesController extends Controller
{
    public function index()
    {
        $category = User::all();
        // dd($category);
        return view('Admin.category.index', compact('category'));
    }
    public function add()
    {
        return view('Admin.category.add');
    }
    public function insert(Request $request)
    {
        $category = new Category();
        if ($request->hasFile('image')) {
            $file =  $request->File('image');
            $ext = $file->getClientOriginalExtension();
            $fileName = time() . '.' . $ext;
            $file->move('upload/category', $fileName);
            $category->image = $fileName;
        }

        $category->name = $request->input('name');
        $category->slug = $request->input('slug');
        $category->description = $request->input('description');
        $category->status = $request->input('status')   == True ? '1' : '0';
        $category->popular = $request->input('popular')  == True ? '1' : '0';
        $category->meta_title = $request->input('meta_title');
        $category->meta_keyword = $request->input('meta_keyword');
        $category->meta_description = $request->input('meta_description');

        $category->save();
        return redirect('/categories')->with('status', "Category Added Successfully");
    }

    public function edit($id)
    {
        $category = User::find($id); // Assuming Category model is used
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }
        $user_followups = Followup::where('user_id', $id)
            ->where('status', 0)
            ->get();

        $done_followups = Followup::where('user_id', $id)
            ->where('status', 1)
            ->get();



        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();

        $today_followups = Followup::where('user_id', $id)
            ->whereDate('follow_date', $today)
            ->where('status', 0)
            ->orderBy('follow_date', 'asc')
            ->get();

        $tomorrow_Followups = Followup::where('user_id', $id)
            ->whereDate('follow_date', $tomorrow)
            ->where('status', 0)
            ->orderBy('follow_date', 'asc')
            ->get();

        $past_Followups = Followup::where('user_id', $id)
            ->where('follow_date', '<', $today)
            ->where('status', 0)
            ->orderBy('follow_date', 'desc')
            ->get();

        return view('Admin.category.edit', compact('category', 'today_followups', 'past_Followups', 'tomorrow_Followups', 'user_followups', 'done_followups'));
    }


    public function update(Request $request,  $id)
    {
        $category = Category::find($id);
        if ($request->hasFile('image')) {
            $path  = 'upload/category/' . $category->image;
            if (File::exists($path)) {
                File::delete($path);
            }
            $file =  $request->File('image');
            $ext = $file->getClientOriginalExtension();
            $fileName = time() . '.' . $ext;
            $file->move('upload/category', $fileName);
            $category->image = $fileName;
        }
        $category->name = $request->input('name');
        $category->slug = $request->input('slug');
        $category->description = $request->input('description');
        $category->status = $request->input('status')   == True ? '1' : '0';
        $category->popular = $request->input('popular')  == True ? '1' : '0';
        $category->meta_title = $request->input('meta_title');
        $category->meta_keyword = $request->input('meta_keyword');
        $category->meta_description = $request->input('meta_description');

        $category->update();
        return redirect('/categories')->with('status', "Category Updated Successfully");
    }

    public function delete($id)
    {
        $category = Category::find($id);
        if ($category->image) {
            $path  = 'upload/category/' . $category->image;
            if (File::exists($path)) {
                File::delete($path);
            }
        }
        $category->delete();
        return redirect('/categories')->with('status', "Category deleted Successfully");
    }
}
