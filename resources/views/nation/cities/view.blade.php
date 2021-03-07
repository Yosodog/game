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
            <div class="card nationInfoPanel">
                <div class="card-header">Information</div>
                <div class="card-body">
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
                        <tr {{ $city->isPowered() ? "" : "class=table-danger" }}>
                            <td>Power</td>
                            <td>{{ $city->calculatePowerUsage() - $city->calculatePowerProduction() }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card nationInfoPanel">
                <div class="card-header">Population Info</div>
                <div class="card-body">
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
            <div class="card nationInfoPanel">
                <div class="card-header">Economy</div>
                <div class="card-body">
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
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#services">Services</a> </li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#transportation">Transportation</a> </li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#raw">Extractors</a> </li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#manufactories">Manufactories</a> </li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#power">Power</a> </li>
    </ul>

    <div class="tab-content">
        <div id="services" class="tab-pane fade in active show">
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
        <div id="power" class="tab-pane fade">
            @include('nation.cities.buildings', ['category' => "power"])
        </div>
    </div>

    @if ($city->isOwner())
        <hr>
        <div class="row">
            <div class="col-sm-6">
                <h2>Queue</h2>
            </div>
            <div class="col-sm-6">
                <h2 class="text-right">{{ $city->countActiveJobs() }}/{{ $city->getTotalBuildingSlots() }} slots</h2>
            </div>
        </div>
        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th>Building</th>
                <th>Status</th>
                <th>Time Left</th>
                <th>Progress</th>
                <th>Cancel</th>
            </tr>
            </thead>
            <tbody>
            @forelse($city->buildingQueue as $job)
                <tr>
                    <td>{{ $job->buildingType->name }}</td>
                    <td class="text-capitalize">{{ $job->isActive() ? "Building..." : "Queued" }}</td>
                    <td>{{ $job->isActive() ? $job->timeLeft() : "Queued" }}</td>
                    <td>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar"
                                 aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:{{ $job->isActive() ? $job->percLeft() : 0 }}%">
                            </div>
                        </div>

                    </td>
                    <td>
                        <form method="post" action="{{ url("/cities/".$city->id."/buildings/cancel"."/$job->id") }}" class="form-inline smallForm">
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Cancel">
                            </div>
                            {{ csrf_field() }}
                        </form>
                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="5" class="text-center"><strong>No Queued Buildings</strong></td>
                </tr>
            @endforelse
            </tbody>
        </table>
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