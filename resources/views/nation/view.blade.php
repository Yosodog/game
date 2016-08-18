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
@endsection