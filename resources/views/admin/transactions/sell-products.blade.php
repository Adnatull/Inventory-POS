@extends('admin.master')

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
      <!-- <input class="form-control" type="text" id="txtCustomer" placeholder="Customer Name">
      <a class="btn btn-primary" id="searchCustomers" href="#" role="button">Search</a>
      <select id="customersFromDB" name="customerID" class="form-control">
          <option>Default select</option>
      </select> -->
  </div>

  <div id="newCustomer">
      <!-- <input class="form-control" type="text" name="customerName" id="CustomerName" placeholder="Customer Name">
      <input class="form-control" type="text" name="customerAddress" id="CustomerAddress" placeholder="Customer Address">
      <input class="form-control" type="text" name="customerPhone" id="CustomerPhone" placeholder="Customer Phone"> -->
  </div>


</form>
@endsection
@push('jscripts')
  <script src="{{asset('/')}}style.js"></script>
@endpush
