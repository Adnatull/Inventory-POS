@extends('admin.master')

@section('title')
  Sell Products
@endsection

@push('customcss')
<link rel="stylesheet" type="text/css" href="{{asset('/')}}customAssets/purchase.css" />

  <link rel="stylesheet" type="text/css" href="{{asset('/')}}customAssets/sale.css" />
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


<section class="container">
<h1> Sell Products </h1>
</section>

<div class="container">
  <section id="cart">
    <div class="form-group">


        <label for="input_search">Product Code</label>
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
<div class="container">
  <section id="cart">
    <div class="form-group">
      <label for="description">Description</label>
      <textarea class="form-control" id="description" name="description" rows="3"></textarea>
    </div>
  </section>
</div>




<footer id="site-footer">
  <div class="container clearfix">
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="row">
      <div class="col-4">
          <h2 class="subtotal">Subtotal: <span style="margin-left:53px;margin-right: 53px;">0</span>৳</h2>
          <h2 >Discount: <input type="text" name="discount" id="discount" class="discount" value="0" onchange="changeDiscount(this)"/>৳</h2>
          <h2 >Paid: <input type="text" name="paid" id="paid" class="paid" value="0" onchange="changePaid(this)"/>৳</h2>

          <h2 class="dues">Dues: <span style="margin-left:90px;margin-right: 53px;">0</span>৳</h2>
      </div>


      <div class="col-4">
        <h1 class="total">Total: <span>0</span>৳</h1>

        <button type="submit" class="btn1"> Checkout </button>
      </div>
    </div>

  </div>


  </div>
</footer>

</form>
@endsection
@push('jscripts')
  <script src="{{asset('/')}}customAssets/sale.js"></script>
@endpush
