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
                <th scope="col">Total Product types</th>
                <th scope="col">Description</th>


                <th scope="col">Total Purchase Cost</th>
                <th scope="col">Discount</th>
                <th scope="col">Total Paid</th>
                <th scope="col">Dues</th>

                <th scope="col">Bought by</th>
                <th scope="col">Buy Date </th>


                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($purchases as $purchase)
                <tr>
                    <th scope="row">{{$purchase->id}}</th>
                    <td>{{ $purchase->Supplier['supplier_name'] }}</td>
                    <td>{{ $purchase->totalProductTypes() }}</td>
                    <td> {{ $purchase->description}}</td>

                     <td>{{ $purchase->total_purchases_cost }}</td>

                    <td>{{ $purchase->discount }}</td>
                    <td>{{ $purchase->total_paid }}</td>
                    <td>{{ $purchase->total_purchases_cost - ($purchase->discount+$purchase->total_paid) }}</td>
                    <td>{{$purchase->CreatedBy['name']}}</td>
                    <td>{{$purchase->created_at}}</td>
                    <td>
                      <a type="button" class="btn btn-danger" href="{{route('purchase detials', ['id'=> $purchase->id])}}">
                          Details
                      </a>

                    </td>
                </tr>

            @endforeach

            </tbody>
        </table>
        <a type="submit" class="btn btn-primary" href="{{route('buy-products')}}" >Purchase New Products</a>
        <a class="btn btn-primary" href="{{route('admin')}}">Cancel</a>
    </div>
@endsection
