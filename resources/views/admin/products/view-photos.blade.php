@extends('admin.master')

@section('title')
  View Product Photos
@endsection

@section('body')
    @if($errors->count()>0)
        @foreach( $errors->all() as $message )
            <div class="alert alert-primary" role="alert">
                {{$message}}
            </div>
        @endforeach
    @endif

    <div class="alert alert-primary" role="alert">
       Product Name: {{$product->name}}
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Image</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($images as $image)
                <tr>
                    <th scope="row">{{$image->id}}</th>

                    <td><img src="{{ $image->image }}" alt="Any alt text" style="width:300px;height:auto;"/></td>
                    <td>
                        @if(Auth::user()->hasRole('manager'))
                            <a type="button" class="btn btn-danger" href="{{route('deleteProductPhoto', ['id' => $image->id])}}">
                                    Delete
                            </a>
                        @endif

                    </td>
                </tr>

            @endforeach

            </tbody>
        </table>
        <a type="submit" class="btn btn-primary" href="{{route('add-product')}}" >Add New Product</a>
        <a class="btn btn-primary" href="{{route('manage-products')}}">Cancel</a>
@endsection
