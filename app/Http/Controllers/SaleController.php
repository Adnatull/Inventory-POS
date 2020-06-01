<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Product;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SaleController extends Controller
{
    public function getCustomers(Request $request) {
      // dd($request)
      $validatedData = Validator::make($request->all(), [
          'name' => 'required'
      ]);

      if($validatedData->fails()) {
        return response()->json(['errors'=>$validatedData->messages()]);
      }
      $info = $request['name'];
      $customersByName = Customer::where('name', 'LIKE', '%'.$info.'%')->get();
      $customersByPhone = Customer::where('phone', 'LIKE', '%'.$info.'%')->get();

      $all = array();
      $i = 0;
      foreach($customersByName as $customer) {
        $all[$i]['id']          = $customer->id;
        $all[$i]['name']        = $customer->name;
        $all[$i]['phone']       = $customer->phone;
        $all[$i]['email']       = $customer->email;
        $all[$i]['address']     = $customer->address;
        $i++;
      }

      foreach($customersByPhone as $customer) {
        $all[$i]['id']          = $customer->id;
        $all[$i]['name']        = $customer->name;
        $all[$i]['phone']       = $customer->phone;
        $all[$i]['email']       = $customer->email;
        $all[$i]['address']     = $customer->address;
        $i++;
      }
      return response()->json(['success'=>$all]);

    }

    public function getProductByCodeAjax(Request $request) {
      // dd($request)
      $validatedData = Validator::make($request->all(), [
          'productCode' => 'required'
      ]);
      if($validatedData->fails()) {
      //    return Redirect::route('buy-products')->withErrors($validatedData->messages())->withInput();
          return response()->json(['errors'=>$validatedData->messages()]);
      }
      $productCode = $request->productCode;

      $product = null;
      $product = Product::where('code', $productCode)->first();
      // dump($product);

      if($product == null) {
         return response()->json(['fail'=>"fail"]);
       }

      $single = array();
      if(Product::find($product->id)->HasImages()) {
        $img = Product::find($id)->getRandomImage();
        $single['img'] = $img->image;
      }

      $single['id'] = $product->id;

      $single['code'] = $product->code;

      $single['name'] = $product->name;

      $single['brand'] = $product->brand->name;

      $single['category'] = $product->category->title;

      $single['unit'] = $product->unit->type;
      $single['price'] = Product::find($product->id)->Current_Price();
// return response()->json($single);
      return response()->json(['success'=>$single]);
    }
}
