<table class="table table-striped table-hover">
    <tr>
        <th>Name</th>
        <th>About</th>
        <th>Energy</th>
        <th>Requires</th>
        <th>Time</th>
        <th>Current</th>
        {!! ($isOwner) ? "<th>Buy/Sell</th>" : "" !!}
    </tr>
    @foreach (\App\Models\BuildingTypes::getByCategory($buildingTypes, $category) as $building)
        <tr>
            <td>{{ $building->name }}</td>
            <td>{{ $building->description }}</td>
            <td>{{ $building->energy }} MW</td>
            <td>${{ number_format($building->baseCost) }}</td>
            <td>{{ $building->buildingTime }} Turns</td>
            <td>{{ $quantity[$building->id] ?? 0 }}</td>
            @if ($isOwner)
                <td>
                    <form method="post" action="{{ url("/cities/".$city->id."/buildings/buy"."/$building->id") }}" class="form-inline smallForm">
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Buy">
                        </div>
                        {{ csrf_field() }}
                    </form>
                    <form method="post" action="{{ url("/cities/".$city->id."/buildings/sell"."/$building->id") }}" class="form-inline smallForm">
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Sell">
                        </div>
                        {{ csrf_field() }}
                    </form>
                </td>
            @endif
        </tr>
    @endforeach
</table>