@extends('admin.master')

@section('title')
  Manage Products
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
                <th scope="col">Product Code</th>
                <th scope="col">Product Name</th>
                <th scope="col">Actual Cost</th>
                <th scope="col">Selling Cost</th>
                <th scope="col">Quantity</th>
                <th scope="col">Status</th>
                <th scope="col">Category</th>
                <th scope="col">Created By</th>
                <th scope="col">Updated By</th>

                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <th scope="row">{{$product->id}}</th>
                    <td>{{ $product->code }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->cost }}</td>
                    <td>{{ $product->selling_cost }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>
                        @if($product->is_ready_for_sale == 1)
                            {{"Active" }}
                        @else
                            {{"Not Active"}}
                        @endif
                    </td>

                    <td>{{ $product->Category['title'] }}</td>
                    <td>{{$product->CreatedBy['name']}}</td>
                    <td>{{$product->UpdatedBy['name']}}</td>
                    <td>
                        @if($product->HasImages())
                            <a type="button" class="btn btn-danger" href="{{route('viewPhotos', ['id'=> $product->id])}}">
                                View All Photos
                            </a>
                        @else
                            <a type="button" class="btn btn-danger" href="{{route('add-product-photos', ['id'=> $product->id])}}">
                                Add Photos
                            </a>
                        @endif
                        @if(Auth::user()->hasRole('manager'))
                                <a type="button" class="btn btn-danger" href="{{route('changeProductPrice', ['id' => $product->id])}}">
                                    Change Price
                                </a>
                                <a type="button" class="btn btn-danger" href="{{route('deleteProduct', ['id' => $product->id])}}">
                                    Delete
                                </a>
                        @endif
                    </td>
                </tr>

            @endforeach

            </tbody>
        </table>
        <a type="submit" class="btn btn-primary" href="{{route('add-product')}}" >Add New Product</a>
        <a class="btn btn-primary" href="{{route('admin')}}">Cancel</a>
    </div>
@endsection
