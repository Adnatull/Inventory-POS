@extends('admin.master')

@section('title')
  Purchase Products
@endsection

@section('body')
<div class="card card-login mx-auto mt-5">
    <div class="card-body">
        @if($errors->count()>0)
            @foreach( $errors->all() as $message )
                <div class="alert alert-primary" role="alert">
                    {{$message}}
                </div>
            @endforeach
        @endif

        <form method="POST" action="{{route('purchase-products')}}" enctype="multipart/form-data">
            @csrf



            <div class="form-group">
                <label for="input_product">Product</label>
                <select class="form-control" name="product_id" id="input_product">
                    <option value="0">None</option>
                    @foreach($products as $product)
                        <option value="{{$product->id}}"> {{$product->name}} ({{$product->code}})</option>
                    @endforeach

                </select>
            </div>

            <div class="form-group">
                <label for="input_supplier">Supplier</label>
                <select class="form-control" name="supplier_id" id="input_supplier">
                    <option value="0">None</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{$supplier->id}}"> {{$supplier->supplier_name}} ({{$supplier->contact_person}})</option>
                    @endforeach

                </select>
            </div>

            <div class="form-group">
                <label for="input_quantity">Quantity</label>
                <input type="text" name="quantity" class="form-control" id="input_quantity" value="{{ old('quantity')}}" required>
            </div>

            <div class="form-group">
                <label for="input_total_cost">Total Cost</label>
                <input type="text" name="purchase_cost" class="form-control"  value="{{ old('purchase_cost')}}" id="input_total_cost" required>
            </div>

            <div class="form-group">
                <label for="input_total_paid">Total Paid</label>
                <input type="text" name="paid" class="form-control" value="{{ old('paid')}}" id="input_total_paid" required>
            </div>

            <div class="form-group">
                <label for="input_description">Description</label>
                <textarea name="description" class="form-control"  id="input_description" rows="3"> {{ old('description')}} </textarea>
            </div>


            <button type="submit" class="btn btn-primary" >Create</button>
            <a class="btn btn-primary" href="{{route('see-all-purchases')}}">Cancel</a>
        </form>
    </div>
</div>
@endsection
