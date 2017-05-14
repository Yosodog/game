@extends('layouts.app')

@section('content')
    @include("alerts") {{-- Include the template for alerts. This checks if there's something needed to display --}}
    <h1 class="text-center">Error</h1>
    <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <h4 class="text-capitalize">Uh oh</h4>
        <ul>
            <li>{{ $error ?? "Something went wrong" }}</li>
        </ul>
    </div>
@endsection