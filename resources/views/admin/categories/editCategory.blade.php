@extends('admin.master')

@section('title')
  Edit Category
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

            <form method="POST" action="{{route('editedCategory')}}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $category->id }}">
                <div class="form-group">
                    <label for="input_category_name">Category Name</label>
                    <input type="text" name="title" class="form-control" id="input_category_name" value="{{ old('title') != null ? old('title') : $category->title }}" required>
                </div>

                <div class="form-group">
                    <img src="{{ $category->image }}" alt="Any alt text" style="width:100px;height:auto;"/>
                    <br>
                    <label for="input_image_field">Select Category Image</label>
                    <input type="file" name="image" class="form-control-file" id="input_image_field">
                </div>

                <div class="form-group">
                    <label for="input_status">Status</label>
                    <select class="form-control" name="status" id="input_status">

                        @if($category->status ==  0)
                            <option value="0" selected> Inactive </option>
                            <option value="1" > Active</option>
                        @else
                            <option value="0" > Inactive </option>
                            <option value="1" selected> Active</option>
                        @endif

                    </select>
                </div>

                <div class="form-group">
                    <label for="input_parent_category">Parent Category</label>
                    <select class="form-control" name="parent_id" id="input_parent_category">
                        <option value="0">None</option>
                        @foreach($allCategories as $categor)
                            @if($categor->id ==  $category->parent_id)
                                <option value="{{$categor->id}}" selected> {{$categor->title}}</option>
                            @else
                                <option value="{{$categor->id}}"> {{$categor->title}}</option>
                            @endif
                        @endforeach

                    </select>
                </div>
                <button type="submit" class="btn btn-primary" >Edit</button>
                <a class="btn btn-primary" href="{{route('manage_category')}}">Cancel</a>
            </form>
        </div>
    </div>

@endsection
