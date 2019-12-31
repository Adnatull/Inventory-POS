<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.dashboard.dashboard');
    }

    public function add_category() {
        return view('admin.categories.add-category');
    }

    public function post_category(Request $request) {

        $validatedData = $request->validate([
            'title' => 'required|max:191'
        ]);

        $category = new Category();
        $category->title = $request->title;

        if($request->parent_id) {
            $category->parent_id =  $request->parent_id;
        }

        $category->image = "dssd";
        $category->status = '1';
        $category->created_by =  Auth::user()->id;
        $category->updated_by = Auth::user()->id;
        // var_dump(Auth::user()->getId());
        $category->save();
        return $this->manage_category();
    }

    public function manage_category() {
        return view('admin.categories.manage', [
            'categories' => Category::get()
        ]);
    }
}
