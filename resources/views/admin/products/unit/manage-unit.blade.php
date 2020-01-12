@extends('admin.master')

@section('title')
Manage Product Units
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
            <th scope="col">Unit Type</th>

            <th scope="col">Created By</th>
            <th scope="col">Updated By</th>

            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($units as $unit)
            <tr>
                <th scope="row">{{$unit->id}}</th>
                <td>{{ $unit->type }}</td>

                <td>{{$unit->CreatedBy['name']}}</td>
                <td>{{$unit->UpdatedBy['name']}}</td>
                <td>

                </td>
            </tr>

        @endforeach

        </tbody>
    </table>
    <a type="submit" class="btn btn-primary" href="{{route('add-unit')}}" >Create New Unit</a>
    <a class="btn btn-primary" href="{{route('admin')}}">Cancel</a>
</div>
@endsection
