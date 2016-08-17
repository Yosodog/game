@extends('layouts.app')

@section('content')
    <h1 class="text-center">Compose a New Message</h1>
    <form method="post">
        <div class="form-group">
            <label for="subject">Subject</label>
            <input type="text" class="form-control" name="subject" id="subject" required>
        </div>
        <div class="form-group">
            <label for="to">To</label>
            <input type="text" class="form-control" name="to" id="to" required>
        </div>
        <div class="form-group">
            <label for="message">Message</label>
            <textarea name="message" id="message" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Send">
        </div>
        {{ csrf_field() }}
    </form>
@endsection