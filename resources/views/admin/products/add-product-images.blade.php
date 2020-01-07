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
                <div class="alert alert-primary" role="alert">
                    {{$product->name}}
                </div>
            <form method="POST" action="{{route('submitPhotos')}}" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="product_id" value="{{ $product->id }}" />

                <div class="form-group">
                    <label for="input_product_name">Product Name</label>
                    <input id="browse" type="file" name="photos[]" class="form-control" onchange="previewFiles()" multiple required>
                </div>

                <button type="submit" class="btn btn-primary" >Upload</button>
                <a class="btn btn-primary" href="{{route('manage-products')}}">Cancel</a>
            </form>

                <div id="preview"></div>

        </div>
    </div>



@endsection
