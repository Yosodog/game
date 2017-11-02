@extends('layouts.app')

@section('content')
    @include("alerts") {{-- Include the template for alerts. This checks if there's something needed to display --}}
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create An Alliance</div>
                <div class="panel-body">
                    <h1 class="text-center">Create An Alliance</h1>
                    <h3>Alliance Information</h3>
                    <hr>
                    <div class="col-md-8 col-md-offset-2">
                        <form method="post">
                            <div class="form-group">
                                <label for="name">Alliance Name</label>
                                <input type="text" class="form-control" id="name" name="name" maxlength="25">
                            </div>
                            <div class="form-group">
                                <label for="forumURL">Forum URL</label>
                                <input type="url" class="form-control" id="forumURL" name="forumURL">
                            </div>
                            <div class="form-group">
                                <label for="discord">Alliance Discord</label>
                                <input type="url" class="form-control" id="discord" name="discord">
                            </div>
                            <div class="form-group">
                                <label for="description">Alliance Description</label>
                                <textarea class="form-control" id="description" name="description" rows="5"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="flag">Flag</label>
                                @include("templates.flagPreview")
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Create An Alliance">
                            </div>
                            {{ csrf_field() }}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("scripts")
    <script>
        // Updating the flag preview
        // TODO create an API to retrive info about the flag and display the previewed flag
        /*$("#flags").change(function() {
         $("#flagPreview").attr("src", $("#flags").val());
         });*/
    </script>
@endsection