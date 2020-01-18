<?php

namespace App\Http\Controllers;

use App\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Redirect;

class BrandController extends Controller
{
    public function addBrand() {
      return view('admin.products.brands.add-brand');
    }

    public function postBrand(Request $request) {
      $validatedData = Validator::make($request->all(), [
        'name' => 'required|max:191',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:500'
      ]);

      if($validatedData->fails()) {
          return Redirect::route('add-brand')->withErrors($validatedData->messages())->withInput();
      }

      $brand = new Brand();
      $brand->name = $request->name;
      $brand->status = '1';

      $content = file_get_contents(request()->image);
      $type = pathinfo(request()->image, PATHINFO_EXTENSION);
      $base64 = base64_encode($content);
      $base64 = 'data:image/'.$type.';base64,'.$base64;

      $brand->image = $base64;

      $brand->created_by =  Auth::user()->id;
      $brand->updated_by = Auth::user()->id;

      $brand->save();
      return Redirect::route('manage-brands')->withErrors("The brand has been created successfully");
    }



    public function manageBrand() {
      return view('admin.products.brands.manage-brands', ['brands' => Brand::get()]);

    }

    public function deleteBrand($id) {
      $res = Brand::destroy($id);
      return Redirect::route('manage-brands');
    }

    public function editBrand($id) {
      $brand = Brand::find($id);
      if($brand == null) {
          return Redirect::route('manage-brands')->withErrors("The brand does not exist");
      }

      return view('admin.products.brands.edit-brand', [
          'brand' => $brand
      ]);
    }

    public function editedBrand(Request $request) {
      $validatedData = Validator::make($request->all(), [
          'name' => 'required|max:191',
          'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:500'
      ]);

      if($validatedData->fails()) {
          return Redirect::route('edit-brand',['id'=>$request->id])->withErrors($validatedData->messages())->withInput();
        }
      $brand = Brand::find($request->id);
      if($brand == null) {
          return Redirect::route('manage-brands')->withErrors("The data has been tempered in the midway. Try again!");
      }

      $brand->name = $request->name;

      if(request()->image) {
          $content = file_get_contents(request()->image);
          $type = pathinfo(request()->image, PATHINFO_EXTENSION);
          $base64 = base64_encode($content);
          $base64 = 'data:image/'.$type.';base64,'.$base64;

          $brand->image = $base64;
      }

      $brand->status = $request->status;
      $brand->updated_by = Auth::user()->id;

      $brand->save();
      return Redirect::route('manage-brands')->withErrors("The brand has been edited successfully");

    }
}
