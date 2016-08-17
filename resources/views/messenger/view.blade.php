@extends('layouts.app')

@section('content')
    <h1 class="text-center">{{ $thread->subject }}</h1>
    @foreach ($thread->messages as $message)
        <div class="media">
            <a class="media-left" href="{{ url("/nation/view"."/{$message->user->nation->id}") }}">
                <img src="{{ url($message->user->nation->flag->url) }}" class="img-circle avatarFlag">
            </a>
            <div class="media-body">
                <h5 class="media-heading"><a href="{{ url("/nation/view"."/{$message->user->nation->id}") }}">{{ $message->user->name }}</a></h5>
                <p>{!! BBCode::parse(nl2br(e($message->body))) !!}</p>
                <div class="text-muted"><small title="{{ $message->created_at }}">Posted {{ $message->created_at->diffForHumans() }}</small></div>
            </div>
        </div>
    @endforeach
    <hr>
    <h2>Reply</h2>
    <form method="post" action="{{ url("/account/messages/update"."/$thread->id") }}">
        <div class="form-group">
            <label for="message">Message</label>
            <textarea id="message" name="message" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Reply">
        </div>
        {{ csrf_field() }}
        {{ method_field('PUT') }}
    </form>
@endsection