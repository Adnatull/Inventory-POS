@extends('admin.master')

@section('title')
  Edit Brand
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

            <form method="POST" action="{{route('edited-brand')}}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $brand->id }}">
                <div class="form-group">
                    <label for="input_brand_name">Brand Name</label>
                    <input type="text" name="name" class="form-control" id="input_brand_name" value="{{ $brand->name }}" required>
                </div>

                <div class="form-group">
                    <img src="{{ $brand->image }}" alt="Any alt text" style="width:100px;height:auto;"/>
                    <br>
                    <label for="input_image_field">Select Brand Image</label>
                    <input type="file" name="image" class="form-control-file" id="input_image_field">
                </div>

                <div class="form-group">
                    <label for="input_brand_name">Status</label>
                    <select class="form-control" name="status" id="input_brand_name">

                        @if($brand->status ==  0)
                            <option value="0" selected> Inactive </option>
                            <option value="1" > Active</option>
                        @else
                            <option value="0" > Inactive </option>
                            <option value="1" selected> Active</option>
                        @endif

                    </select>
                </div>


                <button type="submit" class="btn btn-primary" >Edit</button>
                <a class="btn btn-primary" href="{{route('manage-brands')}}">Cancel</a>
            </form>
        </div>
    </div>

@endsection
