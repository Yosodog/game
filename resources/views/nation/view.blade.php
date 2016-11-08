@extends('layouts.app')

@section('content')
    @include("alerts") {{-- Include the template for alerts. This checks if there's something needed to display --}}
    <div class="jumbotron">
        <div class="row">
            <div class="col-md-4">
                <img src="{{ url($nation->flag->url) }}" class="mainFlag">
            </div>
            <div class="col-md-8">
                <h1 class="text-center">{{ $nation->name }}</h1>
                <p class="text-center"><em>"Some Nice Motto"</em></p>
            </div>
        </div>
    </div>
    <div class="btn-group btn-group-justified">
        <a href="#" class="btn btn-default">Button</a>
        <a href="#" class="btn btn-default">Button</a>
        <a href="#" class="btn btn-default">Button</a>
        <a href="#" class="btn btn-default">Button</a>
        <a href="#" class="btn btn-default">Button</a>
        <a href="#" class="btn btn-default">Button</a>
        <a href="#" class="btn btn-default">Button</a>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default nationInfoPanel">
                <div class="panel-heading">Information</div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <tr>
                            <td>Leader</td>
                            <td>{{ $nation->user->name }}</td>
                        </tr>
                        <tr>
                            <td>Founded</td>
                            <td>{{ \Carbon\Carbon::parse($nation->created_at)->toDateString() }}</td>
                        </tr>
                        <tr>
                            <td>Age</td>
                            <td>{{ \Carbon\Carbon::parse($nation->created_at)->diffInDays() }} Days</td>
                        </tr>
                        <tr>
                            <td>Population</td>
                            <td>{{ number_format($nation->population) }}</td>
                        </tr>
                        <tr>
                            <td>Land</td>
                            <td>{{ number_format($nation->land) }}</td>
                        </tr>
                        <tr>
                            <td>Pollution</td>
                            <td>{{ number_format($nation->pollution) }}</td>
                        </tr>
                        <tr>
                            <td>Some Label</td>
                            <td>Some Data</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default nationInfoPanel">
                <div class="panel-heading">Population Info</div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <tr>
                            <td>Growth Rate</td>
                            <td>{{ number_format($nation->growth_rate) }} ppl per day</td>
                        </tr>
                        <tr>
                            <td>Birth Rate</td>
                            <td>{{ number_format($nation->birth_rate) }} ppl per day</td>
                        </tr>
                        <tr>
                            <td>Death Rate</td>
                            <td>{{ number_format($nation->death_rate) }} ppl per day</td>
                        </tr>
                        <tr>
                            <td>Immigration</td>
                            <td>{{ number_format($nation->immigration) }} ppl per day</td>
                        </tr>
                        <tr>
                            <td>Crime</td>
                            <td>{{ number_format($nation->crime) }}</td>
                        </tr>
                        <tr>
                            <td>Disease</td>
                            <td>{{ number_format($nation->disease) }}</td>
                        </tr>
                        <tr>
                            <td>Satisfaction</td>
                            <td>{{ number_format($nation->satisfaction) }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default nationInfoPanel">
                <div class="panel-heading">Economy</div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <tr>
                            <td>Income</td>
                            <td>${{ number_format($nation->income) }}</td>
                        </tr>
                        <tr>
                            <td>Avg Income</td>
                            <td>${{ number_format($nation->avg_income) }}</td>
                        </tr>
                        <tr>
                            <td>Unemployment</td>
                            <td>{{ number_format($nation->unemployment) }}</td>
                        </tr>
                        <tr>
                            <td>Literacy</td>
                            <td>{{ number_format($nation->literacy) }}</td>
                        </tr>
                        <tr>
                            <td>Some Label</td>
                            <td>Some Data</td>
                        </tr>
                        <tr>
                            <td>Some Label</td>
                            <td>Some Data</td>
                        </tr>
                        <tr>
                            <td>Some Label</td>
                            <td>Some Data</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <h2>Cities</h2>
    <table class="table table-striped table-hover">
        <tr>
            <th>Name</th>
            <th>Population</th>
            <th>Avg Income</th>
            <th>Growth Rate</th>
            <th>Land</th>
        </tr>
        @foreach ($nation->cities as $city)
            <tr>
                <td><a href="{{ url("cities/view"."/$city->id") }}">{{ $city->name }}</a></td>
                <td>{{ number_format($city->population) }}</td>
                <td>${{ number_format($city->properties["Avg Income"]["value"]) }}</td>
                <td>{{ number_format($city->properties["Growth Rate"]["value"]) }} ppl per day</td>
                <td>{{ number_format($city->land) }} sq mi</td>
            </tr>
        @endforeach
    </table>
@endsection