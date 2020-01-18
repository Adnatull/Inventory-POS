@extends('admin.master')

@section('title')
  Add Customer
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

        <form method="POST" action="{{route('add-customer')}}" enctype="multipart/form-data">
            @csrf


            <div class="form-group">
                <label for="input_name">Cusomer Name</label>
                <input type="text" name="name" class="form-control" value="{{old('name')}}" id="input_name" required>
            </div>

            <div class="form-group">
                <label for="input_phone">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{old('phone')}}" id="input_phone" required>
            </div>
            <div class="form-group">
                <label for="input_email">Email</label>
                <input type="email" name="email" class="form-control" value="{{old('email')}}" id="input_email">
            </div>

            <div class="form-group">
                <label for="input_address">Address</label>
                <input type="text" name="address" class="form-control" value="{{old('address')}}" id="input_address">
            </div>


            <button type="submit" class="btn btn-primary" >Create</button>
            <a class="btn btn-primary" href="{{route('manage-customers')}}">Cancel</a>
        </form>
    </div>
</div>
@endsection
