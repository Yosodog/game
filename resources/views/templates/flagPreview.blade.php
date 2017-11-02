
<select name="flag" id="flags" class="form-control">
    @if (isset($default))
        <option value="{{ $flags->where("id", $default)->first()->id }}">{{ $flags->where("id", $default)->first()->name }}</option>
    @endif

    @foreach ($flags as $flag)
        <option value="{{ $flag->id }}">{{ $flag->name }}</option>
    @endforeach
</select>
<img src="{{ isset($default) ? url($flags->where("id", $default)->first()->url) : url($flags[0]->url) }}" class="mainFlag" id="flagPreview">

@section("scripts")
    <script>
        $("#flags").change(function() {
            var flagID = $(this).val();

            $.getJSON("{{ url("/api/v1/flag") }}/" + flagID)
                    .done(function(data) {
                        $("#flagPreview").attr("src", "{{ url("/") }}/" + data.url);
                    });
        })
    </script>
@endsection