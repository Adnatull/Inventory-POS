@extends('admin.master')

@section('title')
  Manage Categories
@endsection

@section('body')

    @if($errors->count()>0)
        @foreach( $errors->all() as $message )
            <div class="alert alert-primary" role="alert">
                {{$message}}
            </div>
        @endforeach
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Category Name</th>
                <th scope="col">Image</th>
                <th scope="col">Status</th>

                <th scope="col">Parent Category</th>
                <th scope="col">Created By</th>
                <th scope="col">Updated By</th>

                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr>
                    <th scope="row">{{$category->id}}</th>
                    <td>{{ $category->title }}</td>
                    <td><img src="{{ $category->image }}" alt="Any alt text" style="width:100px;height:auto;"/></td>
                    <td>
                        @if($category->status == 1)
                        {{"Active" }}
                        @else
                        {{"Not Active"}}
                        @endif
                    </td>

                    <td>
                      @if($category->ParentCategory != null)
                      {{$category->ParentCategory['title'] }}
                      @else
                      {{"Root"}}
                      @endif
                      </td>
                    <td>{{$category->CreatedBy['name']}}</td>
                    <td>{{$category->UpdatedBy['name']}}</td>
                    <td>
                        <a type="button" class="btn btn-danger" href="{{route('editCategory', ['id'=> $category->id])}}">
                            Edit
                        </a>
                        <?php
                        // <a type="button" class="btn btn-danger" href="{{route('deleteCategory', ['id' => $category->id])}}" onclick="return confirm('Are you sure?')">
                        //     Delete
                        // </a>
                        ?>

                    </td>
                </tr>

            @endforeach

            </tbody>
        </table>
        <a type="submit" class="btn btn-primary" href="{{route('add_category')}}" >Create New Category</a>
        <a class="btn btn-danger" href="{{route('admin')}}">Cancel</a>
    </div>
@endsection
