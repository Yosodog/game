@extends('layouts.app')

@section('content')
    @include("alerts") {{-- Include the template for alerts. This checks if there's something needed to display --}}
    <h1 class="text-center">Nations</h1>

    <div class="text-center">
        <form method="post">
            <div class="form-inline">
                Search for <input type="text" class="form-control" id="search" name="search" value="@if(isset($search)){{$search}}@endif">
                in <select class="form-control" id="category" name="category">
                    <option value="everything">Everything</option>
                    <option value="nName">Nation Name</option>
                    <option value="nLeader">Nation Leader</option>
                    <option value="aName">Alliance</option>
                </select>
                <input type="submit" class="btn btn-primary" value="Search">
            </div>
            {{ csrf_field() }}
        </form>
    </div>

    <div class="text-center">
        {{ $nations->links() }}
    </div>
    <table class="table table-striped table-hover">
        <tr>
            <td>Leader</td>
            <td>Name</td>
            <td>Alliance</td>
            <td>Score</td>
        </tr>
        @foreach ($nations as $nation)
            <tr>
                <td>{{ $nation->user->name }}</td>
                <td><a href="{{ url("/nation/view"."/$nation->id") }}">{{ $nation->name }}</a></td>
                <td>
                    @if ($nation->allianceID != null)
                        <a href="{{ url("/alliance/".$nation->allianceID) }}">{{ $nation->alliance->name }}</a>
                    @else
                        None
                    @endif
                </td>
                <td>420</td>
            </tr>
        @endforeach
    </table>

    <div class="text-center">
        {{ $nations->links() }}
    </div>
@endsection