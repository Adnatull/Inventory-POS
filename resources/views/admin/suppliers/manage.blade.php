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
                <th scope="col">Supplier Code</th>
                <th scope="col">Supplier Name</th>
                <th scope="col">Contact Person</th>

             <th scope="col">Phone</th>

                <th scope="col">Email</th>
                <th scope="col">Status</th>

                <th scope="col">Address</th>
                <th scope="col">Created By</th>
                <th scope="col">Updated By</th>

                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($suppliers as $supplier)
                <tr>
                    <th scope="row">{{$supplier->id}}</th>
                    <td>{{ $supplier->supplier_code }}</td>
                    <td>{{ $supplier->supplier_name }}</td>
                    <td>{{ $supplier->contact_person }}</td>

                     <td>{{ $supplier->phone }}</td>

                    <td>{{ $supplier->email }}</td>

                    <td>
                        @if($supplier->status == 1)
                            {{"Active" }}
                        @else
                            {{"Not Active"}}
                        @endif
                    </td>

                    <td>{{$supplier->address}}</td>
                    <td>{{$supplier->CreatedBy['name']}}</td>
                    <td>{{$supplier->UpdatedBy['name']}}</td>
                    <td>

                        @if(Auth::user()->hasRole('admin'))

                                <a type="button" class="btn btn-danger" href="{{route('edit-supplier', ['id' => $supplier->id])}}">
                                    Edit
                                </a>
                        @endif
                    </td>
                </tr>

            @endforeach

            </tbody>
        </table>
        <a type="submit" class="btn btn-primary" href="{{route('add-supplier')}}" >Add New Supplier</a>
        <a class="btn btn-primary" href="{{route('admin')}}">Cancel</a>
    </div>
@endsection
