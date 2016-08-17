@extends('layouts.app')

@section('content')
    <h1 class="text-center">Nations</h1>
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
                <td>None</td>
                <td>420</td>
            </tr>
        @endforeach
    </table>
@endsection