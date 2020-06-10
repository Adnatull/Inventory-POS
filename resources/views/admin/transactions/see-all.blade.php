@extends('admin.master')

@section('title')
  All Sale Transactions
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
                <th scope="col">Customer Name</th>
                <th scope="col">Total Product types</th>
                <th scope="col">Description</th>


                <th scope="col">Total Sale Cost</th>
                <th scope="col">Discount</th>
                <th scope="col">Total Paid</th>
                <th scope="col">Dues</th>

                <th scope="col">Sold by</th>
                <th scope="col">Sale Date </th>


                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($sales as $sale)
                <tr>
                    <th scope="row">{{$sale->id}}</th>
                    <td>
                      @if($sale->Customer != null)
                        {{ $sale->Cusomer['name'] }}
                      @endif
                    </td>
                    <td>{{ $sale->totalSaleTypes() }}</td>
                    <td> {{ $sale->description}}</td>

                     <td>{{ $sale->total_sales_cost }}</td>

                    <td>{{ $sale->discount }}</td>
                    <td>{{ $sale->total_paid }}</td>
                    <td>{{ $sale->total_sales_cost - ($sale->discount+$sale->total_paid) }}</td>
                    <td>{{$sale->CreatedBy['name']}}</td>
                    <td>{{$sale->created_at}}</td>
                    <td>
                      <a type="button" class="btn btn-danger" href="{{route('sale detials', ['id'=> $sale->id])}}">
                          Details
                      </a>

                    </td>
                </tr>

            @endforeach

            </tbody>
        </table>
        <a type="submit" class="btn btn-primary" href="{{route('sell-products')}}" >Sell New Products</a>
        <a class="btn btn-primary" href="{{route('admin')}}">Cancel</a>
    </div>
@endsection
