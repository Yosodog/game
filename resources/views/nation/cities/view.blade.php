@extends('layouts.app')

@section('content')
    </div> {{-- The container is set in the layout, but here close it so we can do the parallax background --}}
<div class="parallax-window">
    <div class="cityName">
        <span>{{ $city->name }}</span>
    </div>
</div>
<div class="container" style="margin-top: 20px;">
    @include("alerts") {{-- Include the template for alerts. This checks if there's something needed to display --}}
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
                            <td>{{ number_format($city->properties["Growth Rate"]["value"]) }} ppl Per Day</td>
                        </tr>
                        <tr>
                            <td>Birth Rate</td>
                            <td>{{ number_format($city->properties["Birth Rate"]["value"]) }}</td>
                        </tr>
                        <tr>
                            <td>Death Rate</td>
                            <td>{{ number_format($city->properties["Death Rate"]["value"]) }}</td>
                        </tr>
                        <tr>
                            <td>Immigration</td>
                            <td>{{ number_format($city->properties["Immigration"]["value"]) }}</td>
                        </tr>
                        <tr>
                            <td>Crime</td>
                            <td>{{ number_format($city->properties["Crime"]["value"]) }}%</td>
                        </tr>
                        <tr>
                            <td>Disease</td>
                            <td>{{ number_format($city->properties["Disease"]["value"]) }}%</td>
                        </tr>
                        <tr>
                            <td>Satisfaction</td>
                            <td>{{ number_format($city->properties["Govt Satisfaction"]["value"]) }}%</td>
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
                            <td>${{ number_format($city->properties["Avg Income"]["value"]) }}</td>
                        </tr>
                        <tr>
                            <td>Unemployment</td>
                            <td>{{ number_format($city->properties["Unemployment"]["value"]) }}%</td>
                        </tr>
                        <tr>
                            <td>Literacy</td>
                            <td>{{ $city->properties["Literacy"]["value"] }}%</td>
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
    <h2>Buildings</h2>
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#services">Services</a> </li>
        <li><a data-toggle="tab" href="#transportation">Transportation</a> </li>
        <li><a data-toggle="tab" href="#raw">Extractors</a> </li>
        <li><a data-toggle="tab" href="#manufactories">Manufactories</a> </li>
    </ul>

    <div class="tab-content">
        <div id="services" class="tab-pane fade in active">
            @include('nation.cities.buildings', ['category' => "services"])
        </div>
        <div id="transportation" class="tab-pane fade">
            @include('nation.cities.buildings', ['category' => "transportation"])
        </div>
        <div id="raw" class="tab-pane fade">
            @include('nation.cities.buildings', ['category' => "raw"])
        </div>
        <div id="manufactories" class="tab-pane fade">
            @include('nation.cities.buildings', ['category' => "manufactory"])
        </div>
    </div>

    @if ($city->isOwner())
        @if (count($city->jobs) === 0)
            <p>No active/pending jobs</p>
        @else
            <hr>
            <h2>Queue</h2>
            <table class="table table-hover table-striped">
                <tr>
                    <th>Building</th>
                    <th>Status</th>
                    <th>Turns Left</th>
                    <th>Progress</th>
                </tr>
                @foreach ($city->jobs as $job)
                    @if ($job->status === "active" || $job->status === "queued")
                        <tr>
                            <td>{{ $job->relation->name }}</td>
                            <td class="text-capitalize">{{ $job->status }}</td>
                            <td>{{ $job->turnsLeft }} Turns</td>
                            <td>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped active" role="progressbar"
                                         aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:{{ $job->percentageFinished() }}%">
                                        {{ $job->percentageFinished() }}%
                                    </div>
                                </div>

                            </td>
                        </tr>
                    @endif
                @endforeach
            </table>
        @endif
    @endif

    @if ($isOwner)
        <hr>
        <h2>Land</h2>
        <form method="post" action="{{ url("/cities/".$city->id."/land") }}">
            <table class="table">
                <tr>
                    <th>Buy Price</th>
                    <th>Sell Price</th>
                    <th>Amount</th>
                    <th>Cost</th>
                    <th>Go</th>
                </tr>
                <tr>
                    <td>$100</td>
                    <td>$10</td>
                    <td>
                        <input type="number" id="amount" name="amount" class="form-control" required>
                    </td>
                    <td>$0</td>
                    <td>
                        <input type="submit" value="Buy" class="btn btn-primary">
                    </td>
                </tr>
            </table>
            {{ csrf_field() }}
        </form>
        <hr>
        <h2>Rename City</h2>
        <form method="post" action="{{ url("/cities/".$city->id."/rename") }}">
            <table class="table">
                <tr>
                    <th>New Name</th>
                    <th>Submit</th>
                </tr>
                <tr>
                    <td><input type="text" id="name" name="name" class="form-control" required></td>
                    <td>
                        <input type="submit" value="Rename" class="btn btn-primary">
                    </td>
                </tr>
            </table>
            {{ csrf_field() }}
        </form>
    @endif
@endsection

@section("scripts")
        <script src="{{ url("lib/parallax/parallax.min.js") }}"></script>
    <script>
        $('.parallax-window').parallax({imageSrc: 'http://wallpapercave.com/wp/WShsIJl.jpg'});
    </script>
@endsection