<!-- JavaScripts -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.smartmenus/1.0.0/jquery.smartmenus.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.smartmenus/1.0.0/addons/bootstrap/jquery.smartmenus.bootstrap.min.js"></script>
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
@yield("scripts") {{-- For loading custom scripts on pages --}}