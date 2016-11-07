@extends('layouts.app')

@section('content')
    @include("alerts") {{-- Include the template for alerts. This checks if there's something needed to display --}}
    <h1 class="text-center">Edit Account</h1>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-info">
                <div class="panel-heading">Change Email</div>
                <div class="panel-body">
                    <form method="post" action="{{ url("/account/edit/email") }}">

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="{{ $user->email }}" required>
                        </div>

                        <div class="form-group">
                            {{ csrf_field() }}
                            {{ method_field("PATCH") }}
                            <input type="submit" value="Edit" class="btn btn-info">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel panel-info">
                <div class="panel-heading">Change Username</div>
                <div class="panel-body">
                    <form method="post" action="{{ url("/account/edit/username") }}">

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="username" id="username" name="username" class="form-control" placeholder="{{ $user->name }}" required>
                        </div>

                        <div class="form-group">
                            {{ csrf_field() }}
                            {{ method_field("PATCH") }}
                            <input type="submit" value="Edit" class="btn btn-info">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
