<a href="#">
    Nation <span class="caret"></span>
</a>

<ul class="dropdown-menu" role="menu">
    <li><a href="{{ url("/nation/view/".Auth::user()->nation->id) }}">View Nation</a></li>
    <li class="dropdown"><a href="{{ url("#") }}">Cities <i class="fa fa-caret-right" aria-hidden="true"></i></a>
        <ul class="dropdown-menu">
            <li><a href="{{ url("/cities") }}">View All</a></li>
            <li class="divider"></li>
            @foreach (Auth::user()->nation->cities as $city)
                <li><a href="{{ url("cities/view/".$city->id) }}">{{ $city->name }}</a></li>
            @endforeach
        </ul>
    </li>
</ul>