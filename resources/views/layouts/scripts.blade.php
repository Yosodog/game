<!-- JavaScripts -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.smartmenus/1.1.0/jquery.smartmenus.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.smartmenus/1.1.0/addons/bootstrap-4/jquery.smartmenus.bootstrap-4.min.js"></script>
<script>
    $.SmartMenus.prototype.isTouchMode = function() {
        return true;
    };

    $(function() {
        $('#main-menu').smartmenus({
            subIndicators: false,
        });
        // activate touch mode permanently
    });
</script>
@if (!Auth::guest() && Auth::user()->hasNation) {{-- We only want to update the user's resources if they have a nation and are logged in --}}
    <script>
        <?php
                // PHP TAGS IN A BLADE TEMPLATE? OMG. This is a hack and makes my life easier
                $resources = [
                        "money", "coal", "oil", "gas", "rubber", "steel", "iron", "bauxite", "aluminum", "lead", "ammo",
                        "clay", "cement", "timber", "brick", "concrete", "lumber", "wheat", "livestock", "bread", "meat", "water"
                ]
        ?>
        function addCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
        // Visually update user's resources
        setInterval(function() {
            @foreach ($resources as $resource)
                $("#{{ $resource }}").text(function() {
                    var value = parseFloat($(this).text().replace(/,/g,''));
                    return addCommas(parseFloat(value + {{ session($resource."PerSec") }}).toFixed(2));
                });
            @endforeach
        }, 1000)
    </script>
@endif
@yield("scripts") {{-- For loading custom scripts on pages --}}