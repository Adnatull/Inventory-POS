<?php

namespace App\Http\Controllers;

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

    public function manage_category() {
        return view('admin.categories.manage');
    }
}
