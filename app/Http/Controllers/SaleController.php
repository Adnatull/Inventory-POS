<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Product;
use App\Purchase_Detail;
use App\SaleDetail;
use App\Sale;

use Helper;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SaleController extends Controller
{

    public function index()
    {
      $sales = Sale::where('status', true)->get();
      return view('admin.transactions.see-all',[
        'sales' => $sales
      ]);
    }

    public function saleDetail($id) {
      $sale = Sale::find($id);
      return view('admin.transactions.saleDetails', [
        'sale' => $sale
      ]);
    }

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

    public function getRemainingProductByCodeAjax(Request $request)
    {

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
         return response()->json(['errors'=>"Product not found"]);
       }

       $totalBought = Purchase_Detail::where('product_id', $product->id)->get()->sum('quantity');
       $totalSold = SaleDetail::where('product_id', $product->id)->get()->sum('quantity');
       if($totalBought<=$totalSold) {
         return response()->json(['errors'=> 'The product is not available']);
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
      $single['quantity'] = $totalBought - $totalSold;

      return response()->json(['success'=>$single]);
    }

    public function store(Request $request)
    {
      $validatedData = Validator::make($request->all(), [
          'customer_id'   => 'required',
          'code'        => 'required',
          'quantity'    => 'required',
        //  'quantity[]'    => 'required',
          'price'       => 'required',
          'discount'      => 'required',
          'paid'          => 'required'
      ]);

      if($validatedData->fails()) {
          return Redirect::route('sell-products')->withErrors($validatedData->messages());
      }

      $errors = array();

      $sale = new Sale();

      if($request->customer_id != 0) {
        $sale->customer_id = $request->customer_id;
      }

      if(!Helper::isCurrency($request->discount) ) {
        $errors[] = "Sale Discount must be in decimal!";
      } else {
        $sale->discount = $request->discount;
      }

      if(!Helper::isCurrency($request->paid) ) {
        $errors[] = "Paid amount must be in decimal!";
      } else {
        $sale->total_paid = $request->paid;
      }
      if($request->description) {
        $sale->description = $request->description;
      }

      $sale->created_by = Auth::user()->id;
      $sale->updated_by = Auth::user()->id;
      $sale->status = '1';
      if(count($errors)>0) {
          return Redirect::route('sell-products')->withErrors($errors)->withInput();
      } else {
        $sale->save();
      }


      $cost = 0;

      for($i=0; $i<COUNT($request->code); $i++) {

        $product = Product::where('code', $request->code[$i])->get();
        $sale_detail = new SaleDetail();
        if($product) {
            $sale_detail->product_id = $product->first()->id;
        }

        $sale_detail->quantity = $request->quantity[$i];
        if(!Helper::isCurrency($request->price[$i]) ) {
          $errors[] = "Price of every product must be in decimal!";
        } else {
          $sale_detail->sale_cost = $request->price[$i];
        }

        $sale_detail->sale_id = $sale->id;
        $sale_detail->created_by = Auth::user()->id;
        $sale_detail->updated_by = Auth::user()->id;
        $sale_detail->status = 1;

        if(count($errors) == 0) {
          $cost += ($sale_detail->quantity*$sale_detail->sale_cost);
        }

        if(count($errors)>0) {
            return Redirect::route('sell-products')->withErrors($errors)->withInput();
        } else {
          $sale_detail->save();
        }
      }

      $sale->total_sales_cost = $cost;
      if(count($errors)>0) {
          return Redirect::route('sale-products')->withErrors($errors)->withInput();
      } else {
        $sale->save();
      }

      return redirect(route('see-all-sales'));
    }
}
