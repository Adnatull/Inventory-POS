@extends('admin.master')

@section('title')
  Add Product
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

            <form method="POST" action="{{route('add-product')}}" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="code" value="{{ $code }}" />

                <div class="form-group">
                    <label for="input_product_name">Product Name</label>
                    <input type="text" name="name" class="form-control" value="{{old('name')}}" id="input_product_name" required>
                </div>

                <div class="form-group">
                    <label for="input_brand">Brand</label>
                    <select class="form-control" name="brand_id" id="input_brand">
                        @foreach($brands as $brand)
                            <option value="{{$brand->id}}"> {{$brand->name}}</option>
                        @endforeach

                    </select>
                </div>

                <div class="form-group">
                    <label for="input_unit">Unit</label>
                    <select class="form-control" name="unit_id" id="input_unit">
                        @foreach($units as $unit)
                            <option value="{{$unit->id}}"> {{$unit->type}}</option>
                        @endforeach

                    </select>
                </div>


                <div class="form-group">
                    <label for="input_parent_category">Category</label>
                    <select class="form-control" name="category_id" id="input_parent_category">
                        @foreach($categories as $category)
                            <option value="{{$category->id}}"> {{$category->title}}</option>
                        @endforeach

                    </select>
                </div>
                <button type="submit" class="btn btn-primary" >Create</button>
                <a class="btn btn-primary" href="{{route('manage-products')}}">Cancel</a>
            </form>
        </div>
    </div>

@endsection
