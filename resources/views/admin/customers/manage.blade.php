@extends('admin.master')

@section('title')
  Manage Suppliers
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

             <th scope="col">Phone</th>

                <th scope="col">Email</th>
                <th scope="col">Address</th>
                <th scope="col">Status</th>
                <th scope="col">Total Purchase Worth</th>
                <th scope="col">Total Paid</th>


                <th scope="col">Created By</th>
                <th scope="col">Updated By</th>

                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($customers as $customer)
                <tr>
                    <th scope="row">{{$customer->id}}</th>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->phone }}</td>

                     <td>{{ $customer->email }}</td>

                    <td>{{ $customer->address }}</td>

                    <td>
                        @if($customer->status == 1)
                            {{"Active" }}
                        @else
                            {{"Not Active"}}
                        @endif
                    </td>
                    <td>{{ $customer->total_purchase_worth }}</td>
                    <td>{{ $customer->total_paid }}</td>

                    <td>{{$customer->CreatedBy['name']}}</td>
                    <td>{{$customer->UpdatedBy['name']}}</td>
                    <td>


                    </td>
                </tr>

            @endforeach

            </tbody>
        </table>
        <a type="submit" class="btn btn-primary" href="{{route('add-supplier')}}" >Add New Customer</a>
        <a class="btn btn-primary" href="{{route('admin')}}">Cancel</a>
    </div>
@endsection
