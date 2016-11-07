@extends('layouts.app')

@section('content')
    @include("alerts") {{-- Include the template for alerts. This checks if there's something needed to display --}}
    <div class="row">
        <div class="col-md-3">
            @include("account.accountNav")
        </div>
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">Change Email</div>
                <div class="panel-body">
                    <div class="col-md-6">
                        <form method="post" action="{{ url("/account/edit/email") }}">

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="{{ $user->email }}" required>
                            </div>

                            <div class="form-group">
                                {{ csrf_field() }}
                                {{ method_field("PATCH") }}
                                <input type="submit" value="Edit" class="btn btn-default">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Change Username</div>
                <div class="panel-body">
                    <div class="col-md-6">
                        <form method="post" action="{{ url("/account/edit/username") }}">

                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" id="username" name="username" class="form-control" placeholder="{{ $user->name }}" required>
                            </div>

                            <div class="form-group">
                                {{ csrf_field() }}
                                {{ method_field("PATCH") }}
                                <input type="submit" value="Edit" class="btn btn-default">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Edit Password</div>
                <div class="panel-body">
                    <div class="col-md-6">
                        <form method="post" action="{{ url("/account/edit/password") }}">

                            <div class="form-group">
                                <label for="oldPass">Old Password</label>
                                <input type="password" id="oldPass" name="oldPass" class="form-control" placeholder="Old Password" required>
                            </div>

                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="New Password" required>
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Confirm New Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirm New Password" required>
                            </div>

                            <div class="form-group">
                                {{ csrf_field() }}
                                {{ method_field("PATCH") }}
                                <input type="submit" value="Edit" class="btn btn-default">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
