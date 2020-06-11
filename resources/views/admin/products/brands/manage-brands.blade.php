@extends('admin.master')

@section('title')
Manage Brands
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
            <th scope="col">Brand Name</th>
            <th scope="col">Image</th>
            <th scope="col">Status</th>


            <th scope="col">Created By</th>
            <th scope="col">Updated By</th>

            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($brands as $brand)
            <tr>
                <th scope="row">{{$brand->id}}</th>
                <td>{{ $brand->name }}</td>
                <td><img src="{{ $brand->image }}" alt="Any alt text" style="width:100px;height:auto;"/></td>
                <td>
                    @if($brand->status == 1)
                    {{"Active" }}
                    @else
                    {{"Not Active"}}
                    @endif
                </td>


                <td>{{$brand->CreatedBy['name']}}</td>
                <td>{{$brand->UpdatedBy['name']}}</td>
                <td>
                    <a type="button" class="btn btn-danger" href="{{route('edit-brand', ['id'=> $brand->id])}}">
                        Edit
                    </a>
                    <?php
                      // <a type="button" class="btn btn-danger" href="{{route('delete-brand', ['id' => $brand->id])}}" onclick="return confirm('Are you sure?')">
                      //     Delete
                      // </a>
                    ?>

                </td>
            </tr>

        @endforeach

        </tbody>
    </table>
    <a type="submit" class="btn btn-primary" href="{{route('add-brand')}}" >Create New Brand</a>
    <a class="btn btn-primary" href="{{route('admin')}}">Cancel</a>
</div>
@endsection
