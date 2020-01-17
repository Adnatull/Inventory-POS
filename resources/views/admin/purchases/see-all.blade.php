@extends('admin.master')

@section('title')
  All Transactions
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
                <th scope="col">Supplier Name</th>
                <th scope="col">Product Name</th>

                <th scope="col">Quantity</th>

                <th scope="col">Total Purchase Cost</th>
                <th scope="col">Total Paid</th>
                <th scope="col">Description</th>

                <th scope="col">Status</th>
                <th scope="col">Created By</th>
                <th scope="col">Updated By</th>

                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($purchases as $purchase)
                <tr>
                    <th scope="row">{{$purchase->id}}</th>
                    <td>{{ $purchase->Supplier['supplier_name'] }}</td>
                    <td>{{ $purchase->Product['name'] }}</td>
                    <td>{{ $purchase->quantity }}</td>

                     <td>{{ $purchase->purchase_cost }}</td>

                    <td>{{ $purchase->paid }}</td>
                    <td>{{ $purchase->description }}</td>

                    <td>
                        @if($purchase->status == 1)
                            {{"Active" }}
                        @else
                            {{"Not Active"}}
                        @endif
                    </td>


                    <td>{{$purchase->CreatedBy['name']}}</td>
                    <td>{{$purchase->UpdatedBy['name']}}</td>
                    <td>


                    </td>
                </tr>

            @endforeach

            </tbody>
        </table>
        <a type="submit" class="btn btn-primary" href="{{route('buy-products')}}" >Purchase New Products</a>
        <a class="btn btn-primary" href="{{route('admin')}}">Cancel</a>
    </div>
@endsection
