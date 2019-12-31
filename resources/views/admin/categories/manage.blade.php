@extends('admin.master')


@section('body')

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Category Name</th>
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
                    <td>{{ $category->ParentCategory['title'] }}</td>
                    <td>{{$category->CreatedBy['name']}}</td>
                    <td>{{$category->UpdatedBy['name']}}</td>
                    <td>
                        <a type="button" class="btn btn-danger">
                            Edit
                        </a>
                        <a type="button" class="btn btn-danger">
                            Delete
                        </a>
                    </td>
                </tr>

            @endforeach

            </tbody>
        </table>
        <a type="submit" class="btn btn-primary" href="{{route('add_category')}}" >Create New Category</a>
        <a class="btn btn-primary" href="{{route('admin')}}">Cancel</a>
    </div>
@endsection
