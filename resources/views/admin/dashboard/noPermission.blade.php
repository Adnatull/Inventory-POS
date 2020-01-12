@extends('admin.master')

@section('title')
  Access Denied
@endsection

@section('body')
        <div class="row">
            <div class="col-md-12">
                <div class="error-template">
                    <h1>
                        Oops!</h1>
                    <h2>
                        403 No Permission</h2>
                    <div class="error-details">
                        Sorry, it seems you are not authorized in this page! Contact with the admin.
                    </div>
                </div>
            </div>
        </div>
@endsection
