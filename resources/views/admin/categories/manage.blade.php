@extends('admin.master')


@section('body')

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Category Name</th>
                <th scope="col">Parent Category</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td>
                    <a type="button" class="btn btn-danger">
                        Edit
                    </a>
                    <a type="button" class="btn btn-danger">
                        Delete
                    </a>
                </td>
            </tr>
            <tr>
                <th scope="row">2</th>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>
                    <a type="button" class="btn btn-danger">
                        Edit
                    </a>
                    <a type="button" class="btn btn-danger">
                        Delete
                    </a>
                </td>
            </tr>
            <tr>
                <th scope="row">3</th>
                <td>Larry</td>
                <td>the Bird</td>
                <td>
                    <a type="button" class="btn btn-danger">
                        Edit
                    </a>
                    <a type="button" class="btn btn-danger">
                        Delete
                    </a>
                </td>
            </tr>
            </tbody>
        </table>
        <a type="submit" class="btn btn-primary" href="{{route('add_category')}}" >Create New Category</a>
        <a class="btn btn-primary" href="{{route('admin')}}">Cancel</a>
    </div>
@endsection
