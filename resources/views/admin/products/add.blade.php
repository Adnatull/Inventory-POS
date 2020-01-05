@extends('admin.master')

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
                    <input type="text" name="name" class="form-control" id="input_product_name" required>
                </div>

                <div class="form-group">
                    <label for="input_cost">Product Cost</label>
                    <input type="text" name="cost" class="form-control" id="input_cost" required>
                </div>

                <div class="form-group">
                    <label for="input_selling_cost">Product Selling Cost</label>
                    <input type="text" name="selling_cost" class="form-control" id="input_selling_cost" required>
                </div>

                <div class="form-group">
                    <label for="input_quantity">Quantity</label>
                    <input type="text" name="quantity" class="form-control" id="input_quantity" required>
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
                <a class="btn btn-primary" href="{{route('admin')}}">Cancel</a>
            </form>
        </div>
    </div>

@endsection
