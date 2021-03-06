@extends('admin.master')

@section('title')
  Change Price
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

                <div class="alert alert-primary" role="alert">
                    Product Name: {{$product->name}} <br>
                <?php
                    // Actual Cost: {{$product->cost}} <br>
                    // Current Selling Cost: {{$product->selling_cost}}
                    ?>
                </div>

            <form method="POST" action="{{route('updateProductPrice')}}" >
                @csrf

                <input type="hidden" name="product_id" value="{{ $product->id }}" />

                <div class="form-group">
                    <label for="input_selling_price">Product Selling Price</label>
                    <input type="text" name="selling_price" class="form-control" value="{{old('selling_price') != null ? old('selling_price') : $product->Current_Price()}}" id="input_selling_price" required>
                </div>

                <button type="submit" class="btn btn-primary" >Update Price</button>
                <a class="btn btn-primary" href="{{route('manage-products')}}">Cancel</a>
            </form>
        </div>
    </div>

@endsection
