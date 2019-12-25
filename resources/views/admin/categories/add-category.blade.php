@extends('admin.master')

@section('body')
    <div class="card card-login mx-auto mt-5">
        <div class="card-body">
            <form method="POST" action="{{route('add_category')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="input_category_name">Category Name</label>
                    <input type="text" name="title" class="form-control" id="input_category_name" required>
                </div>

                <div class="form-group">
                    <label for="input_image_field">Example file input</label>
                    <input type="file" name="image" class="form-control-file" id="input_image_field">
                </div>

                <div class="form-group">
                    <label for="input_parent_category">Parent Category</label>
                    <select class="form-control" name="parentCategory" id="input_parent_category">
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" >Create</button>
                <a class="btn btn-primary" href="{{route('manage_category')}}">Cancel</a>
            </form>
        </div>
    </div>
@endsection
