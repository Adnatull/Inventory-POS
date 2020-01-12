@extends('admin.master')

@section('title')
  Add Product Unit
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

        <form method="POST" action="{{route('add-unit')}}" >
            @csrf
            <div class="form-group">
                <label for="input_unit_name">Unit Type</label>
                <input type="text" name="name" class="form-control" id="input_unit_name" required>
            </div>

            <button type="submit" class="btn btn-primary" >Create</button>
            <a class="btn btn-primary" href="{{route('manage-units')}}">Cancel</a>
        </form>
    </div>
</div>

@endsection
