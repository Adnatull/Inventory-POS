<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use mysql_xdevapi\Exception;

class ProductController extends Controller
{
    public function add() {

        $unique = false;
        $code = "";

        $tested = [];
        do{
            $random = Str::random(6);
            if( in_array($random, $tested) ){
                continue;
            }
            $count = Product::where('code', $random)->count();
            $tested[] = $random;
            if( $count == 0){
                $unique = true;
                $code = $random;
            }
        }
        while(!$unique);

        return view('admin.products.add', [
            'code'=>$code,
            'categories' => Category::get()
        ]);
    }

    function isCurrency($number)
    {
        return preg_match("/^-?[0-9]+(?:\.[0-9]{1,2})?$/", $number);
    }

    public function submitProduct(Request $request) {
        $validatedData = Validator::make($request->all(), [
            'code' => 'required|max:6|min:6|unique:products',
            'name' => 'required|max:191',
            'cost' => 'required',
            'selling_cost' => 'required',
            'quantity' => 'required|integer',
            'category_id' => 'required',
        ]);

        if($validatedData->fails()) {
            return Redirect::action('ProductController@add')->withErrors($validatedData->messages());
        }

        $product = new Product();
        $product->code = $request->code;
        $product->name = $request->name;
        $product->cost = $request->cost;
        $product->selling_cost = $request->selling_cost;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->created_by = Auth::user()->id;
        $product->updated_by = Auth::user()->id;
        $product->is_ready_for_sale = '1';


        $errors = [];

        if(!$this->isCurrency($request->cost)) {
            $errors[] = "The Product cost must be decimal!";
        }

        if(!$this->isCurrency($request->selling_cost)) {
            $errors[] = "Product Selling Cost must be decimal!";
        }

        if(count($errors)>0) {
            return Redirect::action('ProductController@add')->withErrors($errors);
        }

        try{
            $product->save();
        }
        catch(\Exception $e) {
            return Redirect::action('ProductController@add')->withErrors("The data has been tempered in midway! try again");
        }
        return redirect(route('manage-products'));
    }

    public function manage_products() {
        return view('admin.products.manage-products', [
            'products' => Product::get()
        ]);
    }
}
