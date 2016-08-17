@extends('layouts.app')

@section('content')
    <h1 class="text-center">Cities</h1>
    <table class="table table-striped table-hover">
        <tr>
            <th>Name</th>
            <th>Population</th>
            <th>Avg Income</th>
            <th>Growth Rate</th>
        </tr>
        @foreach (Auth::user()->nation->cities as $city)
            <tr>
                <td><a href="{{ url("cities/view"."/$city->id") }}">{{ $city->name }}</a></td>
                <td>{{ number_format($city->population) }}</td>
                <td>${{ number_format($city->avgIncome) }}</td>
                <td>{{ number_format($city->popGrowth) }}</td>
            </tr>
        @endforeach
    </table>
    <hr>
    <h1 class="text-center">Create A City</h1>
    <div class="col-md-6 col-md-offset-3">
        <p class="text-center">Next City Cost: <strong>$420</strong></p>
        <form role="form" method="post" action="{{ url("/cities/create") }}">
            <div class="form-group">
                <label for="name">City Name</label>
                <input type="text" class="form-control" name="name" id="name" maxlength="25">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary">
            </div>
            {{ csrf_field() }}
        </form>
    </div>
@endsection