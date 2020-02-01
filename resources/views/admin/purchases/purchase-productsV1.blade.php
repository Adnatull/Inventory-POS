@extends('admin.master')

@section('title')
  Purchase Products
@endsection

@push('customcss')
  <link rel="stylesheet" type="text/css" href="{{asset('/')}}customAssets/purchase.css" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush

@section('body')



@if($errors->count()>0)
    @foreach( $errors->all() as $message )
        <div class="alert alert-primary" role="alert">
            {{$message}}
        </div>
    @endforeach
@endif
<?php
// <header id="site-header">
//   <div class="container">
//     <h1>Buy Products <span>[</span> <em><a href="http://adnatull.github.io" target="_blank"> _____ By Adnatull</a></em> <span class="last-span is-open">]</span></h1>
//   </div>
// </header>
?>

<section class="container">
<h1> Search Products </h1>
</section>

<div class="container">
  <section id="cart">
    <div class="form-group">
        <label for="input_category">Category</label>
        <select class="form-control" name="category_id" id="input_category">
            <option value="0">None</option>
            @foreach($categories as $category)
                <option value="{{$category->id}}"> {{$category->title}} ({{$category->ParentCategory['title']}})</option>
            @endforeach
        </select>

        <label for="input_brand">Brand</label>
        <select class="form-control" name="brand_id" id="input_brand">
            <option value="0">None</option>
            @foreach($brands as $brand)
                <option value="{{$brand->id}}"> {{$brand->name}} </option>
            @endforeach
        </select>

        <label for="input_search">Search</label>
        <input type="text" name="searchProducts" class="form-control" id="input_search_products"  required>

        <button type="submit" name="searchButton" id="searchButton" class="btn btn-primary" onClick="searchProducts(this)">
          Search
        </button>


    </div>
  </section>
</div>

<div class="container">
  <section id="cart" >
    <table class="table" id="ProductsFromDB">

    </table>

  </section>

</div>



<form method="POST" action="{{route('purchase-products')}}" >
@csrf

    <div class="container">
      <section id="cart">
        <div class="form-group">
            <label for="input_supplier">Supplier</label>
            <select class="form-control" name="supplier_id" id="input_supplier">
                <option value="0">None</option>
                @foreach($suppliers as $supplier)
                    <option value="{{$supplier->id}}"> {{$supplier->supplier_name}} ({{$supplier->contact_person}})</option>
                @endforeach

            </select>
        </div>

      </section>
    </div>




<div class="container">

  <section id="cart">
    <div id="listOfProducts">

    </div>

  </section>

</div>

<footer id="site-footer">
  <div class="container clearfix">

    <div class="left">
        <h2 class="subtotal">Subtotal: <span>163.96</span>৳</h2>

      <?php
          // <h3 class="tax">Taxes (5%): <span>8.2</span>€</h3>
          // <h3 class="shipping">Shipping: <span>5.00</span>€</h3>
      ?>

    </div>

    <div class="right">
      <h1 class="total">Total: <span>177.16</span>€</h1>
      <a class="btn1">Checkout</a>
    </div>

  </div>
</footer>

</form>
@endsection

@push('jscripts')
  <script src="{{asset('/')}}customAssets/purchase.js"></script>
@endpush
