<a href="#" class="nav-link dropdown-toggle">
    Resources <span class="caret"></span>
</a>

<ul class="dropdown-menu" role="menu">
    <li><a href="#" class="dropdown-item">$<span id="money">{{ number_format(Auth::user()->nation->resources->money, 2) }}</span></a></li>
    <li class="dropdown">
        <a href="#" class="dropdown-item dropdown-toggle">Energy</a>

        <ul class="dropdown-menu" role="menu">
            <li><a href="#" class="dropdown-item">Coal: <span class="pull-right" id="coal" class="dropdown-item">{{ number_format(Auth::user()->nation->resources->coal, 2) }}</span></a></li>
            <li><a href="#" class="dropdown-item">Oil: <span class="pull-right" id="oil" class="dropdown-item">{{ number_format(Auth::user()->nation->resources->oil, 2) }}</span></a></li>
            <li><a href="#" class="dropdown-item">Gas: <span class="pull-right" id="gas" class="dropdown-item">{{ number_format(Auth::user()->nation->resources->gas, 2) }}</span></a></li>
        </ul>
    </li>
    <li class="dropdown">
        <a href="#" class="dropdown-item dropdown-toggle">Food</a>

        <ul class="dropdown-menu" role="menu">
            <li><a href="#" class="dropdown-item">Wheat: <span class="pull-right" id="wheat">{{ number_format(Auth::user()->nation->resources->wheat, 2) }}</span></a></li>
            <li><a href="#" class="dropdown-item">Livestock: <span class="pull-right" id="livestock">{{ number_format(Auth::user()->nation->resources->livestock, 2) }}</span></a></li>
            <li><a href="#" class="dropdown-item">Bread: <span class="pull-right" id="bread">{{ number_format(Auth::user()->nation->resources->bread, 2) }}</span></a></li>
            <li><a href="#" class="dropdown-item">Meat: <span class="pull-right" id="meat">{{ number_format(Auth::user()->nation->resources->meat, 2) }}</span></a></li>
            <li><a href="#" class="dropdown-item">Water: <span class="pull-right" id="water">{{ number_format(Auth::user()->nation->resources->water, 2) }}</span></a></li>
        </ul>
    </li>
    <li class="dropdown">
        <a href="#" class="dropdown-item dropdown-toggle">Construction</a>

        <ul class="dropdown-menu" role="menu">
            <li><a href="#" class="dropdown-item">Clay: <span class="pull-right" id="clay">{{ number_format(Auth::user()->nation->resources->clay, 2) }}</span></a></li>
            <li><a href="#" class="dropdown-item">Cement: <span class="pull-right" id="cement">{{ number_format(Auth::user()->nation->resources->cement, 2) }}</span></a></li>
            <li><a href="#" class="dropdown-item">Timber: <span class="pull-right" id="timber">{{ number_format(Auth::user()->nation->resources->timber, 2) }}</span></a></li>
            <li><a href="#" class="dropdown-item">Brick: <span class="pull-right" id="brick">{{ number_format(Auth::user()->nation->resources->brick, 2) }}</span></a></li>
            <li><a href="#" class="dropdown-item">Concrete: <span class="pull-right" id="concrete">{{ number_format(Auth::user()->nation->resources->concrete, 2) }}</span></a></li>
            <li><a href="#" class="dropdown-item">Lumber: <span class="pull-right" id="lumber">{{ number_format(Auth::user()->nation->resources->lumber, 2) }}</span></a></li>
        </ul>
    </li>
    <li class="dropdown">
        <a href="#" class="dropdown-item dropdown-toggle">Military</a>

        <ul class="dropdown-menu" role="menu">
            <li><a href="#" class="dropdown-item">Rubber: <span class="pull-right" id="rubber">{{ number_format(Auth::user()->nation->resources->rubber, 2) }}</span></a></li>
            <li><a href="#" class="dropdown-item">Iron: <span class="pull-right" id="iron">{{ number_format(Auth::user()->nation->resources->iron, 2) }}</span></a></li>
            <li><a href="#" class="dropdown-item">Steel: <span class="pull-right" id="steel">{{ number_format(Auth::user()->nation->resources->steel, 2) }}</span></a></li>
            <li><a href="#" class="dropdown-item">Bauxite: <span class="pull-right" id="bauxite">{{ number_format(Auth::user()->nation->resources->bauxite, 2) }}</span></a></li>
            <li><a href="#" class="dropdown-item">Aluminum: <span class="pull-right" id="aluminum">{{ number_format(Auth::user()->nation->resources->aluminum, 2) }}</span></a></li>
            <li><a href="#" class="dropdown-item">Lead: <span class="pull-right" id="lead">{{ number_format(Auth::user()->nation->resources->lead, 2) }}</span></a></li>
            <li><a href="#" class="dropdown-item">Ammo: <span class="pull-right" id="ammo">{{ number_format(Auth::user()->nation->resources->ammo, 2) }}</span></a></li>
        </ul>
    </li>
</ul>