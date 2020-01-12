@extends('admin.master')

@section('title')
  Add Product Brand
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

        <form method="POST" action="{{route('add-brand')}}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="input_brand_name">Brand Name</label>
                <input type="text" name="name" class="form-control" id="input_brand_name" required>
            </div>

            <div class="form-group">
                <label for="input_image_field">Select Brand Image</label>
                <input type="file" name="image" class="form-control-file" id="input_image_field">
            </div>

            <button type="submit" class="btn btn-primary" >Create</button>
            <a class="btn btn-primary" href="{{route('manage-brands')}}">Cancel</a>
        </form>
    </div>
</div>

@endsection
