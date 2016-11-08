<select name="flag" id="flags" class="form-control">
    @foreach ($flags as $flag)
        <option value="{{ $flag->id }}">{{ $flag->name }}</option>
    @endforeach
</select>
<img src="{{ url($flags[0]->url) }}" class="mainFlag" id="flagPreview">

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