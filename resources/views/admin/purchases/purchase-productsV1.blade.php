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

        <button type="submit" name="searchButton" id="searchButton" class="btn btn-primary" onClick="searchProducts()">
          Search
        </button>

    </div>
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
    @foreach($products as $product)

    <article class="product">
      <header>
        <a class="remove">
          <img src="{{$product->HasImages()? $product->getRandomImage()->image: asset('/Images/Image-Unavailable.jpg')}}" alt="">

          <h3>Remove product</h3>
        </a>
      </header>

      <div class="content">

        <h1>Lorem ipsum</h1>

        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Soluta, numquam quis perspiciatis ea ad omnis provident laborum dolore in atque.

        <div title="You have selected this product to be shipped in the color yellow." style="top: 0" class="color yellow"></div>
        <div style="top: 43px" class="type small">XXL</div>
      </div>

      <footer class="content">
        <span class="qt-minus">-</span>
        <span class="qt">2</span>
        <span class="qt-plus">+</span>

        <h2 class="full-price">
          29.98€
        </h2>

        <h2 class="price">
          14.99€
        </h2>
      </footer>
    </article>

    @endforeach
    <article class="product">
      <header>
        <a class="remove">
          <img src="http://www.astudio.si/preview/blockedwp/wp-content/uploads/2012/08/1.jpg" alt="">

          <h3>Remove product</h3>
        </a>
      </header>

      <div class="content">

        <h1>Lorem ipsum</h1>

        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Soluta, numquam quis perspiciatis ea ad omnis provident laborum dolore in atque.

        <div title="You have selected this product to be shipped in the color yellow." style="top: 0" class="color yellow"></div>
        <div style="top: 43px" class="type small">XXL</div>
      </div>

      <footer class="content">
        <span class="qt-minus">-</span>
        <span class="qt">2</span>
        <span class="qt-plus">+</span>

        <h2 class="full-price">
          29.98€
        </h2>

        <h2 class="price">
          14.99€
        </h2>
      </footer>
    </article>

    <article class="product">
      <header>
        <a class="remove">
          <img src="http://www.astudio.si/preview/blockedwp/wp-content/uploads/2012/08/3.jpg" alt="">

          <h3>Remove product</h3>
        </a>
      </header>

      <div class="content">

        <h1>Lorem ipsum dolor</h1>

        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Soluta, numquam quis perspiciatis ea ad omnis provident laborum dolore in atque.

        <div title="You have selected this product to be shipped in the color red." style="top: 0" class="color red"></div>
        <div title="You have selected this product to be shipped sized Small."  style="top: 43px" class="type small">Small</div>
      </div>

      <footer class="content">

        <span class="qt-minus">-</span>
        <span class="qt">1</span>
        <span class="qt-plus">+</span>

        <h2 class="full-price">
          79.99€
        </h2>

        <h2 class="price">
          79.99€
        </h2>
      </footer>
    </article>

    <article class="product">
      <header>
        <a class="remove">
          <img src="http://www.astudio.si/preview/blockedwp/wp-content/uploads/2012/08/5.jpg" alt="">

          <h3>Remove product</h3>
        </a>
      </header>

      <div class="content">

        <h1>Lorem ipsum dolor ipsdu</h1>

        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Soluta, numquam quis perspiciatis ea ad omnis provident laborum dolore in atque.

        <div title="You have selected this product to be shipped in the color blue." style="top: 0" class="color blue"></div>
        <div style="top: 43px" class="type small">Large</div>
      </div>

      <footer class="content">

        <span class="qt-minus">-</span>
        <span class="qt">3</span>
        <span class="qt-plus">+</span>

        <h2 class="full-price">
          53.99€
        </h2>

        <h2 class="price">
          17.99€
        </h2>
      </footer>
    </article>

  </section>

</div>

<footer id="site-footer">
  <div class="container clearfix">

    <div class="left">
      <h2 class="subtotal">Subtotal: <span>163.96</span>€</h2>
      <h3 class="tax">Taxes (5%): <span>8.2</span>€</h3>
      <h3 class="shipping">Shipping: <span>5.00</span>€</h3>
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
