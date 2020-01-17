@extends('admin.master')

@section('title')
  Edit Supplier
@endsection

@section('body')
<div class="card card-login mx-auto mt-5">
    <div class="card-body">
        @if($errors->count()>0)
            @foreach( $errors->all() as $message )
                <div class="alert alert-primary" role="alert">
                    {{$message}}
                </div>
            @endforeach
        @endif

        <form method="POST" action="{{route('update-supplier')}}" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="id" value="{{ $supplier->id }}" />

            <div class="form-group">
                <label for="input_supplier_name">Supplier Name</label>
                <input type="text" name="supplier_name" class="form-control" id="input_supplier_name" value="{{ $supplier->supplier_name }}" required>
            </div>
            <div class="form-group">
                <label for="input_contact_person">Contact Person Name</label>
                <input type="text" name="contact_person" class="form-control" value="{{ $supplier->contact_person }}" id="input_contact_person" required>
            </div>
            <div class="form-group">
                <label for="input_phone">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ $supplier->phone }}" id="input_phone" required>
            </div>
            <div class="form-group">
                <label for="input_email">Email</label>
                <input type="email" name="email" class="form-control" value="{{ $supplier->email }}" id="input_email">
            </div>
            <div class="form-group">
                <label for="input_address">Address</label>
                <input type="text" name="address" class="form-control" value="{{ $supplier->address }}" id="input_address">
            </div>

            <div class="form-group">
                <label for="input_category_name">Status</label>
                <select class="form-control" name="status" id="input_parent_category">

                    @if($supplier->status ==  0)
                        <option value="0" selected> Inactive </option>
                        <option value="1" > Active</option>
                    @else
                        <option value="0" > Inactive </option>
                        <option value="1" selected> Active</option>
                    @endif
                </select>
            </div>


            <button type="submit" class="btn btn-primary" >Update</button>
            <a class="btn btn-primary" href="{{route('manage-suppliers')}}">Cancel</a>
        </form>
    </div>
</div>
@endsection
