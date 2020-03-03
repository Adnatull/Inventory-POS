@extends('admin.master')

@section('title')
  Sell Products
@endsection

@push('customcss')
  <link rel="stylesheet" type="text/css" href="{{asset('/')}}customAssets/sale.css" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush

@section('body')

<!-- <a class="btn btn-secondary active" href="#" role="button" onclick="hasCustomer(this)">Want to provide Customer Information?</a> -->
<form>
  <div class="form-check" id="provideCustomer">
    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" onclick="provideCustomer()">
    <label class="form-check-label" id="label" for="defaultCheck1">
      Want to provide Customer Information?
    </label>
  </div>

  <div id="customerExist">

  </div>

  <div id="getCustomerFromDB">

  </div>

  <div id="newCustomer">

  </div>


</form>
@endsection
@push('jscripts')
  <script src="{{asset('/')}}customAssets/sale.js"></script>
@endpush
