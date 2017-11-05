<a href="#" class="nav-link dropdown-toggle">
    Nation <span class="caret"></span>
</a>

<ul class="dropdown-menu" role="menu">
    <li><a href="{{ url("/nation/view/".Auth::user()->nation->id) }}" class="dropdown-item">View Nation</a></li>
    <li class="dropdown"><a href="{{ url("#") }}" class="dropdown-item dropdown-toggle">Cities</a>
        <ul class="dropdown-menu">
            <li class="dropdown-item"><a href="{{ url("/cities") }}" class="dropdown-item">View All</a></li>
            <li class="dropdown-divider"></li>
            @foreach (Auth::user()->nation->cities as $city)
                <li class="dropdown-item"><a href="{{ url("cities/view/".$city->id) }}" class="dropdown-item">{{ $city->name }}</a></li>
            @endforeach
        </ul>
    </li>
</ul>