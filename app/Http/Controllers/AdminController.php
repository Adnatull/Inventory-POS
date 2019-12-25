<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

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

        Category::addCategory($request);
        return view('admin.categories.manage');
    }

    public function manage_category() {
        return view('admin.categories.manage');
    }
}
