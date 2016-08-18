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
                <div class="panel-heading">Information</div>
                <div class="panel-body">
                    <table class="table table-hover">
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
                <div class="panel-heading">Information</div>
                <div class="panel-body">
                    <table class="table table-hover">
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
                <td>${{ number_format($city->avgincome) }}</td>
                <td>{{ number_format($city->popGrowth) }}</td>
                <td>{{ number_format($city->land) }} sq mi</td>
            </tr>
        @endforeach
    </table>
@endsection