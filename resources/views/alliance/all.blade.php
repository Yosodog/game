@extends('layouts.app')

@section('content')
    @include("alerts") {{-- Include the template for alerts. This checks if there's something needed to display --}}
    <h1 class="text-center">Alliances</h1>
    <div class="text-center">
        {{ $alliances->links() }}
    </div>
    <table class="table table-striped table-hover">
        <tr>
            <td>Name</td>
            <td>Members</td>
            <td>Avg Score</td>
            <td>Score</td>
        </tr>
        @foreach ($alliances as $alliance)
            <tr>
                <td><a href="{{ url("/alliance/".$alliance->id) }}">{{ $alliance->name }}</a></td>
                <td>{{ $alliance->countMembers() }}</td>
                <td>69</td>
                <td>420</td>
            </tr>
        @endforeach
    </table>

    <div class="text-center">
        {{ $alliances->links() }}
    </div>
@endsection