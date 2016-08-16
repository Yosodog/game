@foreach (['danger', 'warning', 'success', 'info'] as $msg)
    @if (Session::has('alert-'.$msg))
        <div class="alert alert-{{ $msg }} alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <h4 class="text-capitalize">{{ $msg }}</h4>
            <ul>
                @foreach (Session::get('alert-'.$msg) as $alert)
                   <li>{{ $alert }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endforeach

@if (count($errors))
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <h4 class="text-capitalize">Error!</h4>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif