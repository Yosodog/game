<table class="table table-striped table-hover">
    <tr>
        <td>Name</td>
        <td>About</td>
        <td>Energy</td>
        <td>Requires</td>
        <td>Current</td>
        {!! ($isOwner) ? "<td>Buy</td>" : "" !!}
    </tr>
    @foreach (\App\Models\BuildingTypes::getByCategory($buildings, $category) as $building)
        <tr>
            <td>{{ $building->name }}</td>
            <td>{{ $building->description }}</td>
            <td>{{ $building->energy }} MW</td>
            <td>${{ number_format($building->cost) }}</td>
            <td>0</td>
            @if ($isOwner)
                <td>
                    <form method="post" action="{{ url("/city/".$city->id."/building"."/$building->id") }}" class="form-inline smallForm">
                        <div class="form-group">
                            <input type="number" class="form-control" name="amount">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Buy">
                        </div>
                    </form>
                </td>
            @endif
        </tr>
    @endforeach
</table>