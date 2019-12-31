<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function add_category() {

        return view('admin.categories.add-category', [
            'categories' => Category::get()
        ]);
    }

    public function post_category(Request $request) {
        $validatedData = Validator::make($request->all(), [
            'title' => 'required|max:191',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:500'
        ]);

        if($validatedData->fails()) {
            return Redirect::action('CategoryController@add_category')->withErrors($validatedData->messages());
        }

        $category = new Category();
        $category->title = $request->title;

        if($request->parent_id) {
            $category->parent_id =  $request->parent_id;
        }

        $content = file_get_contents(request()->image);
        $type = pathinfo(request()->image, PATHINFO_EXTENSION);
        $base64 = base64_encode($content);
        $base64 = 'data:image/'.$type.';base64,'.$base64;

        $category->image = $base64;

        $category->status = '1';
        $category->created_by =  Auth::user()->id;
        $category->updated_by = Auth::user()->id;
        // var_dump(Auth::user()->getId());
        //var_dump($category);
        // return response()->json($category);
        $category->save();
        return $this->manage_category();
    }

    public function manage_category() {

        return view('admin.categories.manage', [
            'categories' => Category::get()
        ]);
    }
}
