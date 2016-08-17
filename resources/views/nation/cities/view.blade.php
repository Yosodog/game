@extends('layouts.app')

@section('content')
    </div> {{-- The container is set in the layout, but here close it so we can do the parallax background --}}
<div class="parallax-window" data-parallax="scroll" data-image-src="http://wallpapercave.com/wp/WShsIJl.jpg">
    <div class="cityName">
        <span>{{ $city->name }}</span>
    </div>
</div>
<div class="container" style="margin-top: 20px;">
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default nationInfoPanel">
                <div class="panel-heading">Information</div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <tr>
                            <td>Name</td>
                            <td>{{ $city->name }}</td>
                        </tr>
                        <tr>
                            <td>Founded</td>
                            <td>{{ \Carbon\Carbon::parse($city->created_at)->toDateString() }}</td>
                        </tr>
                        <tr>
                            <td>Age</td>
                            <td>{{ \Carbon\Carbon::parse($city->created_at)->diffInDays() }} Days</td>
                        </tr>
                        <tr>
                            <td>Population</td>
                            <td>{{ number_format($city->population) }}</td>
                        </tr>
                        <tr>
                            <td>Land</td>
                            <td>{{ number_format($city->land) }} sq mi</td>
                        </tr>
                        <tr>
                            <td>Pollution</td>
                            <td>{{ number_format($city->pollution) }}</td>
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
                            <td>{{ number_format($city->popGrowth) }} ppl Per Day</td>
                        </tr>
                        <tr>
                            <td>Birth Rate</td>
                            <td>{{ number_format($city->birthRate) }}</td>
                        </tr>
                        <tr>
                            <td>Death Rate</td>
                            <td>{{ number_format($city->deathRate) }}</td>
                        </tr>
                        <tr>
                            <td>Immigration</td>
                            <td>{{ number_format($city->immigration) }}</td>
                        </tr>
                        <tr>
                            <td>Crime</td>
                            <td>{{ number_format($city->crime) }}%</td>
                        </tr>
                        <tr>
                            <td>Disease</td>
                            <td>{{ number_format($city->disease) }}%</td>
                        </tr>
                        <tr>
                            <td>Satisfaction</td>
                            <td>{{ number_format($city->satisfaction) }}%</td>
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
                            <td>Avg Income</td>
                            <td>${{ number_format($city->avgIncome) }}</td>
                        </tr>
                        <tr>
                            <td>Unemployment</td>
                            <td>{{ number_format($city->unemployment) }}%</td>
                        </tr>
                        <tr>
                            <td>Literacy</td>
                            <td>{{ $city->literacy }}</td>
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

@section("scripts")
        <script src="{{ url("lib/parallax/parallax.min.js") }}"></script>
    <script>
        $('.parallax-window').parallax({imageSrc: 'http://wallpapercave.com/wp/WShsIJl.jpg'});
    </script>
@endsection