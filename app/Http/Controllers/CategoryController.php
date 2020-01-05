<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    public function __construct()
    {
       // $this->middleware('auth');
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

        if($request->parent_id != 0) {
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

        $category->save();
        return Redirect::route('manage_category')->withErrors("The category has been created successfully");
    }

    public function manage_category() {

        return view('admin.categories.manage', [
            'categories' => Category::get()
        ]);
    }

    public function deleteCategory($id) {
        $res = Category::destroy($id);
        return Redirect::route('manage_category');
    }


    public function editCategory($id) {

        $category = Category::find($id);
        if($category == null) {
            return Redirect::route('manage_category')->withErrors("The category does not exist");
        }

        return view('admin.categories.editCategory', [
            'category' => Category::find($id),
            'allCategories' => Category::get()
        ]);
    }

    public function editedCategory(Request $request) {
        $validatedData = Validator::make($request->all(), [
            'title' => 'required|max:191',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:500'
        ]);

        if($validatedData->fails()) {
            return Redirect::route('editCategory',['id'=>$request->id])->withErrors($validatedData->messages());
          }
        $category = Category::find($request->id);
        if($category == null) {
            return Redirect::route('manage_category')->withErrors("The data has been tempered in the midway. Try again!");
        }

        $category->title = $request->title;


        $category->parent_id =  $request->parent_id;

        if(request()->image) {
            $content = file_get_contents(request()->image);
            $type = pathinfo(request()->image, PATHINFO_EXTENSION);
            $base64 = base64_encode($content);
            $base64 = 'data:image/'.$type.';base64,'.$base64;

            $category->image = $base64;
        }

        $category->status = $request->status;
        $category->created_by =  Auth::user()->id;
        $category->updated_by = Auth::user()->id;

        $category->save();
        return Redirect::route('manage_category')->withErrors("The category has been edited successfully");


    }
}
