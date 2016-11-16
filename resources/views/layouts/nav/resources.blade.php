<a href="#">
    Resources <span class="caret"></span>
</a>

<ul class="dropdown-menu" role="menu">
    <li><a href="#">${{ number_format(Auth::user()->nation->resources->money) }}</a></li>
    <li class="dropdown">
        <a href="#">Energy <i class="fa fa-caret-right" aria-hidden="true"></i></a>

        <ul class="dropdown-menu" role="menu">
            <li><a href="#">Coal: <span class="pull-right">{{ number_format(Auth::user()->nation->resources->coal) }}</span></a></li>
            <li><a href="#">Oil: <span class="pull-right">{{ number_format(Auth::user()->nation->resources->oil) }}</span></a></li>
            <li><a href="#">Gas: <span class="pull-right">{{ number_format(Auth::user()->nation->resources->gas) }}</span></a></li>
        </ul>
    </li>
    <li class="dropdown">
        <a href="#">Food <i class="fa fa-caret-right" aria-hidden="true"></i></a>

        <ul class="dropdown-menu" role="menu">
            <li><a href="#">Wheat: <span class="pull-right">{{ number_format(Auth::user()->nation->resources->wheat) }}</span></a></li>
            <li><a href="#">Livestock: <span class="pull-right">{{ number_format(Auth::user()->nation->resources->livestock) }}</span></a></li>
            <li><a href="#">Bread: <span class="pull-right">{{ number_format(Auth::user()->nation->resources->bread) }}</span></a></li>
            <li><a href="#">Meat: <span class="pull-right">{{ number_format(Auth::user()->nation->resources->meat) }}</span></a></li>
            <li><a href="#">Water: <span class="pull-right">{{ number_format(Auth::user()->nation->resources->water) }}</span></a></li>
        </ul>
    </li>
    <li class="dropdown">
        <a href="#">Construction <i class="fa fa-caret-right" aria-hidden="true"></i></a>

        <ul class="dropdown-menu" role="menu">
            <li><a href="#">Clay: <span class="pull-right">{{ number_format(Auth::user()->nation->resources->clay) }}</span></a></li>
            <li><a href="#">Cement: <span class="pull-right">{{ number_format(Auth::user()->nation->resources->cement) }}</span></a></li>
            <li><a href="#">Timber: <span class="pull-right">{{ number_format(Auth::user()->nation->resources->timber) }}</span></a></li>
            <li><a href="#">Brick: <span class="pull-right">{{ number_format(Auth::user()->nation->resources->brick) }}</span></a></li>
            <li><a href="#">Concrete: <span class="pull-right">{{ number_format(Auth::user()->nation->resources->concrete) }}</span></a></li>
            <li><a href="#">Lumber: <span class="pull-right">{{ number_format(Auth::user()->nation->resources->lumber) }}</span></a></li>
        </ul>
    </li>
    <li class="dropdown">
        <a href="#">Military <i class="fa fa-caret-right" aria-hidden="true"></i></a>

        <ul class="dropdown-menu" role="menu">
            <li><a href="#">Rubber: <span class="pull-right">{{ number_format(Auth::user()->nation->resources->rubber) }}</span></a></li>
            <li><a href="#">Iron: <span class="pull-right">{{ number_format(Auth::user()->nation->resources->iron) }}</span></a></li>
            <li><a href="#">Steel: <span class="pull-right">{{ number_format(Auth::user()->nation->resources->steel) }}</span></a></li>
            <li><a href="#">Bauxite: <span class="pull-right">{{ number_format(Auth::user()->nation->resources->bauxite) }}</span></a></li>
            <li><a href="#">Aluminum: <span class="pull-right">{{ number_format(Auth::user()->nation->resources->aluminum) }}</span></a></li>
            <li><a href="#">Lead: <span class="pull-right">{{ number_format(Auth::user()->nation->resources->lead) }}</span></a></li>
            <li><a href="#">Ammo: <span class="pull-right">{{ number_format(Auth::user()->nation->resources->ammo) }}</span></a></li>
        </ul>
    </li>
</ul>