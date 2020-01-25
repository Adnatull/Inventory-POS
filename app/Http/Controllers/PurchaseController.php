<?php

namespace App\Http\Controllers;

use App\Purchase;
use App\Supplier;
use App\Product;
use App\Category;
use App\Brand;
use Illuminate\Http\Request;
use Helper;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Collection;
// use Illuminate\Support\Collection;


class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $purchases = Purchase::get();
      return view('admin.purchases.see-all',[
        'purchases' => $purchases
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suppliers = Supplier::where('status', true)->get();
        $products = Product::where('is_ready_for_sale', true)->get();
        $categories = Category::where('status', true)->get();
        $brands = Brand::where('status', true)->get();
        return view('admin.purchases.purchase-productsV1', [
          'suppliers'   => $suppliers,
          'products'    => $products,
          'categories'  => $categories,
          'brands'      => $brands
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $validatedData = Validator::make($request->all(), [
          'product_id' => 'required',
          'supplier_id' => 'required',
          'quantity' => 'required|integer',
          'purchase_cost' => 'required',
          'paid' => 'required'
      ]);

      if($validatedData->fails()) {
          return Redirect::route('buy-products')->withErrors($validatedData->messages())->withInput();
      }
      $purchase = new Purchase();

      $purchase->product_id = $request->product_id;
      $purchase->supplier_id = $request->supplier_id;
      $purchase->quantity = $request->quantity;
      $purchase->purchase_cost = $request->purchase_cost;
      $purchase->paid = $request->paid;

      if($request->description) {
        $purchase->description = $request->description;
      }

      $purchase->created_by = Auth::user()->id;
      $purchase->updated_by = Auth::user()->id;
      $purchase->status = '1';

      $errors = [];

      if(!Helper::isCurrency($purchase->purchase_cost) ) {
        $errors[] = "Purchase Cost must be in decimal!";
      }

      if(!Helper::isCurrency($purchase->paid) ) {
        $errors[] = "Total Paid must be in decimal!";
      }

      if(count($errors)>0) {
          return Redirect::route('buy-products')->withErrors($errors)->withInput();
      }


      try{
          $purchase->save();
      }
      catch(\Exception $e) {
          return Redirect::route('buy-products')->withErrors("The data has been tempered in midway! try again")->withInput();
      }
      return redirect(route('see-all-purchases'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        //
    }

    /**
     * Search products.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
     public function search(Request $request)
     {
      //  $input = $request->all();
      // \Log::info($input);

      $validatedData = Validator::make($request->all(), [
          'categoryId' => 'required|integer',
          'brandId' => 'required|integer',
          // 'product' => 'required',
      ]);

      if($validatedData->fails()) {
      //    return Redirect::route('buy-products')->withErrors($validatedData->messages())->withInput();
          return response()->json(['errors'=>$validatedData->messages()]);
      }
      $categoryId = $request->categoryId;
      $brandId = $request->brandId;
      $productTxt = $request->product;
      $products = null;
      if($request->categoryId == 0 && $request->brandId == 0) {
        $products = Product::where(function($query) use($productTxt) {
              $query->where('name', 'LIKE', '%'.$productTxt.'%')
                    ->orWhere('code', $productTxt);
            })->with(['Category:id,title', 'Unit:id,type', 'Brand:id,name'])->get();
      } else if($request->categoryId == 0) {
        $products = Product::where( function($query) use($brandId) {
              $query->where('brand_id', $brandId);
            })->where(function($query) use($productTxt) {
              $query->where('name', 'LIKE', '%'.$productTxt.'%')
                    ->orWhere('code', $productTxt);
            })->with(['Category:id,title', 'Unit:id,type', 'Brand:id,name'])->get();
      } else if ($request->brandId == 0) {
        $products = Product::where( function($query) use($categoryId) {
              $query->where('category_id', $categoryId);
            })->where(function($query) use($productTxt) {
              $query->where('name', 'LIKE', '%'.$productTxt.'%')
                    ->orWhere('code', $productTxt);
            })->with(['Category:id,title', 'Unit:id,type', 'Brand:id,name'])->get();
      } else {
        $products = Product::where( function($query) use($categoryId, $brandId) {
              $query->where([ ['category_id', $categoryId],
                            ['brand_id', $brandId]
                        ]);
            })->where(function($query) use($productTxt) {
              $query->where('name', 'LIKE', '%'.$productTxt.'%')
                    ->orWhere('code', $productTxt);
            })->with(['Category:id,title', 'Unit:id,type', 'Brand:id,name'])->get();
      }

    //  $products = Product::with(['Category',  'Unit', 'Brand'])->get();


      return response()->json(['success'=>$products]);
     }



}
