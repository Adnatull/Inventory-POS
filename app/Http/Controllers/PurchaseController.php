<?php

namespace App\Http\Controllers;

use App\Purchase;
use App\Supplier;
use App\Product;
use App\Category;
use App\Brand;
use App\Purchase_Detail;
use Illuminate\Http\Request;
use Helper;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
      $purchases = Purchase::where('status', true)->get();
      return view('admin.purchases.see-all',[
        'purchases' => $purchases
      ]);
    }

    public function purchaseDetail($id) {
      $purchase = Purchase::find($id);
      return view('admin.purchases.purchaseDetails', [
        'purchase' => $purchase
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
          'supplier_id'   => 'required',
          'code'        => 'required',
          'quantity'    => 'required',
        //  'quantity[]'    => 'required',
          'price'       => 'required',
          'discount'      => 'required',
          'paid'          => 'required'
      ]);

      if($validatedData->fails()) {
          return Redirect::route('buy-products')->withErrors($validatedData->messages());
      }

      $errors = array();

      $purchase = new Purchase();

      $purchase->supplier_id = $request->supplier_id;
      if(!Helper::isCurrency($request->discount) ) {
        $errors[] = "Purchase Discount must be in decimal!";
      } else {
        $purchase->discount = $request->discount;
      }

      if(!Helper::isCurrency($request->paid) ) {
        $errors[] = "Paid amount must be in decimal!";
      } else {
        $purchase->total_paid = $request->paid;
      }
      if($request->description) {
        $purchase->description = $request->description;
      }

      $purchase->created_by = Auth::user()->id;
      $purchase->updated_by = Auth::user()->id;
      $purchase->status = '1';
      if(count($errors)>0) {
          return Redirect::route('buy-products')->withErrors($errors)->withInput();
      } else {
        $purchase->save();
      }


      $cost = 0;

      for($i=0; $i<COUNT($request->code); $i++) {

        $product = Product::where('code', $request->code[$i])->get();
        $purchase_detail = new Purchase_Detail();
        if($product) {
            $purchase_detail->product_id = $product->first()->id;
        }

        $purchase_detail->quantity = $request->quantity[$i];
        if(!Helper::isCurrency($request->price[$i]) ) {
          $errors[] = "Price of every product must be in decimal!";
        } else {
          $purchase_detail->purchase_cost = $request->price[$i];
        }

        $purchase_detail->purchase_id = $purchase->id;
        $purchase_detail->created_by = Auth::user()->id;
        $purchase_detail->updated_by = Auth::user()->id;
        $purchase_detail->status = 1;

        if(count($error) == 0) {
          $cost += ($purchase_detail->quantity*$purchase_detail->purchase_cost);
        }

        if(count($errors)>0) {
            return Redirect::route('buy-products')->withErrors($errors)->withInput();
        } else {
          $purchase_detail->save();
        }
      }

      $purchase->total_purchases_cost = $cost;
      if(count($errors)>0) {
          return Redirect::route('buy-products')->withErrors($errors)->withInput();
      } else {
        $purchase->save();
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
      $all = array();
      $i = 0;
      foreach($products as $product) {
        $all[$i]['id']        = $product->id;
        $all[$i]['code']      = $product->code;
        $all[$i]['name']      = $product->name;
        $all[$i]['brand']     = $product->brand->name;
        $all[$i]['category']  = $product->category->title;
        $all[$i]['unit']      = $product->unit->type;
        $i++;
      }


      return response()->json(['success'=>$all]);
     }

     public function getSingleAjax($id) {
       $product = Product::with(['Category:id,title', 'Unit:id,type', 'Brand:id,name'])->find($id);
       if($product == null) {
          return response()->json(['fail'=>"fail"]);
        }

       $single = array();
       if(Product::find($id)->HasImages()) {
         $img = Product::find($id)->getRandomImage();
         $single['img'] = $img->image;
       }
       $single['id'] = $id;
       $single['code'] = $product->code;
       $single['name'] = $product->name;
       $single['brand'] = $product->brand->name;
       $single['category'] = $product->category->title;
       $single['unit'] = $product->unit->type;

       return response()->json(['success'=>$single]);
     }



}
