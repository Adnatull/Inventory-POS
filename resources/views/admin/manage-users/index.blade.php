@extends('admin.master')

@section('body')

    @if($errors->count()>0)
        @foreach( $errors->all() as $message )
            <div class="alert alert-primary" role="alert">
                {{$message}}
            </div>
        @endforeach
    @endif

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"> Admin
                </div>
                <div class="card-body">
                    @foreach($users as $user)
                        <div class="row mb-4">
                            <div class="col-sm-6">
                                {{$user->name}}
                                @foreach($user->roles as $role)
                                    <small class="text-muted">{{$role->name}} </small>
                                @endforeach
                            </div>
                            @if($user->id != Auth::user()->id)
                                <div class="col-sm-6">
                                    <form method="post" action="{{ route('give-role') }}">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $user->id }}" />
                                        <div class="form-group">
                                            <select name="role_id" class="form-control" >
                                                @foreach($user->rolesNotAssociated() as $role)
                                                    <option value="{{ $role['id'] }}"> {{ $role['name'] }}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="btn btn-primary">
                                                Add Role
                                            </button>
                                        </div>
                                    </form>
                                    <hr class="my-4">
                                    <form method="post" action="{{ route('remove-role') }}">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $user->id }}" />
                                        <div class="form-group">
                                            <select name="role_id" class="form-control" >
                                                @foreach($user->roles as $role)
                                                    <option value="{{$role->id}}"> {{$role->name}}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="btn btn-primary">
                                                Remove Role
                                            </button>
                                        </div>
                                    </form>
                                </div>

                            @endif
                        </div>
                        <hr class="my-4">
                    @endforeach
                </div>
            </div>

        </div>

    </div>

@endsection
