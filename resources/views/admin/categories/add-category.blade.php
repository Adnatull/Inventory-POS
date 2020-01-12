@extends('admin.master')

@section('title')
  Add Category
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

            <form method="POST" action="{{route('add_category')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="input_category_name">Category Name</label>
                    <input type="text" name="title" class="form-control" id="input_category_name" required>
                </div>

                <div class="form-group">
                    <label for="input_image_field">Select Category Image</label>
                    <input type="file" name="image" class="form-control-file" id="input_image_field">
                </div>

                <div class="form-group">
                    <label for="input_parent_category">Parent Category</label>
                    <select class="form-control" name="parent_id" id="input_parent_category">
                        <option value="0">None</option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}"> {{$category->title}}</option>
                        @endforeach

                    </select>
                </div>
                <button type="submit" class="btn btn-primary" >Create</button>
                <a class="btn btn-primary" href="{{route('manage_category')}}">Cancel</a>
            </form>
        </div>
    </div>
@endsection
