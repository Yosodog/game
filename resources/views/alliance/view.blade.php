@extends('layouts.app')

@section('content')
</div> {{-- The container is set in the layout, but here close it so we can do the parallax background --}}
<div class="parallax-window">
    <div class="col-lg-3 col-centered allianceInfoBoxContainer">
        <img src="{{ url($alliance->flag->url) }}" class="allianceFlag">
        <table class="table">
            <tr>
                <td>Name</td>
                <td>{{ $alliance->name }}</td>
            </tr>
            <tr>
                <td>Members</td>
                <td>{{ $alliance->countMembers() }}</td>
            </tr>
            <tr>
                <td>Score</td>
                <td>45,872</td>
            </tr>
            <tr>
                <td>Avg Score</td>
                <td>1,024</td>
            </tr>
        </table>
    </div>
</div>
<div class="container" style="margin-top: 20px;">
    @include("alerts") {{-- Include the template for alerts. This checks if there's something needed to display --}}
    <div class="btn-group btn-group-justified"> {{-- Button group for non-alliance members --}}
        <a href="{{ url("/alliance/".$alliance->id) }}" class="btn btn-default">View</a>
        <a href="{{ $alliance->forumURL }}" class="btn btn-default" target="_blank">Forums</a>
        <a href="https://widget01.mibbit.com/?settings=0c9c2174544a34bb7bd3d56129a27a01&server=irc.coldfront.net&channel={{ urlencode($alliance->IRCChan) }}" class="btn btn-default">IRC</a>
        <a href="{{ $alliance->discord ?? "#" }}" class="btn btn-default">Discord</a>
        <a href="#" class="btn btn-default">Wars</a>
        @if (Auth::user()->nation->allianceID != $alliance->id)
       		<form method="post" action="{{ url("/alliance/".$alliance->id."/join") }}" class="btn btn-default">
            {{ csrf_field() }}
            {{ method_field("PATCH") }}
            <input type="submit" value="Join">
            </form>
        @else (Auth::user()->nation->allianceID == $alliance->id)
        	<form method="post" action="{{ url("/alliance/".$alliance->id."/leave") }}" class="btn btn-default">
            {{ csrf_field() }}
            {{ method_field("PATCH") }}
            <input type="submit" value="Leave">
            </form>
            <a href="#" class="btn btn-default">Edit</a> {{-- TODO make it so this button only shows to people with the proper permissions --}}
            <a href="#" class="btn btn-default">Bank</a>
            <a href="#" class="btn btn-default">Announcements</a>
        @endif
    </div>
    {{-- TODO make this look better --}}
    <div class="row">
        <h3 class="text-center">Alliance Description</h3>
        {!! BBCode::parse(nl2br(e($alliance->description))) !!}
    </div>
    @if (Auth::user()->nation->allianceID == $alliance->id)
        <hr>
        <div class="row">
            <h3 class="text-center">Member Board</h3>
            {!! BBCode::parse(nl2br(e($alliance->member_board))) !!}
        </div>
    @endif
    <hr>
    <h3 class="text-center">Members</h3>
    <div class="text-center">
        {{ $nations->links() }}
    </div>
    <div class="table-responsive">
        <table class="table">
            <tr>
                <th>Leader</th>
                <th>Score</th>
                <th>Position</th>
            </tr>
            @foreach ($nations as $nation)
                <tr>
                    <td><a href="{{ url("/nation/view/".$nation->id) }}">{{ $nation->user->name }}</a></td>
                    <td>420</td>
                    <td>Member</td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="text-center">
        {{ $nations->links() }}
    </div>
</div>
@endsection

@section("scripts")
    <script src="{{ url("lib/parallax/parallax.min.js") }}"></script>
    <script>
        $('.parallax-window').parallax({imageSrc: 'https://i.ytimg.com/vi/FTykHVuXPUg/maxresdefault.jpg'});
    </script>
@endsection