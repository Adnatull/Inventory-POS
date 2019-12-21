@extends('admin.master')

@section('body')
    <div class="card card-login mx-auto mt-5">
        <div class="card-body">
            <form>
                <div class="form-group">
                    <label for="input_category_name">Category Name</label>
                    <input type="text" name="categoryName" class="form-control" id="input_category_name" >
                </div>
                <div class="form-group">
                    <label for="input_parent_category">Parent Category</label>
                    <select class="form-control" name="parentCategory" id="input_parent_category">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" >Create</button>
                <a class="btn btn-primary" href="{{route('manage_category')}}">Cancel</a>
            </form>
        </div>
    </div>
@endsection
