@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create Your Nation</div>
                <div class="panel-body">
                    <h1 class="text-center">Create Your Nation</h1>
                    <h3>Nation Information</h3>
                    <hr>
                    <div class="col-md-8 col-md-offset-2">
                        <form method="post">
                            <div class="form-group">
                                <label for="name">Nation Name</label>
                                <input type="text" class="form-control" id="name" name="name" maxlength="25" placeholder="Nation Name">
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Create Your Nation">
                            </div>
                            {{ csrf_field() }}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection