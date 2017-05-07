@extends('layouts.app')

@section('content')

@include("alerts") {{-- Include the template for alerts. This checks if there's something needed to display --}}
    @if (Auth::user()->nation->role->canChangeName)
    <div class="row">
       <div class="col-md-9">
           <div class="panel panel-default">
              <div class="panel-heading">Change Alliance Name</div>
                <div class="panel-body">
                    <div class="col-md-6">
                        <form method="post" action="{{ url("/alliance/".$alliance->id."/edit/renameAlliance") }}">

                            <div class="form-group">
                                <label for="name">Alliance Name</label>
                                <input type="name" id="name" name="name" class="form-control" placeholder="{{ $alliance->name }}" required>
                            </div>

                            <div class="form-group">
                                {{ csrf_field() }}
                                {{ method_field("POST") }}
                                <input type="submit" value="Edit" class="btn btn-default">
                            </div>
                        </form>
                    </div>
                 </div>
               </div>
             </div>
           </div>
     @endif
   	 @if (Auth::user()->nation->role->canChangeCosmetics)
     <div class="row">
       <div class="col-md-9">
           <div class="panel panel-default">
              <div class="panel-heading">Change Forum URL</div>
                <div class="panel-body">
                    <div class="col-md-6">
                        <form method="post" action="{{ url("/alliance/".$alliance->id."/edit/changeForumURL") }}">

                            <div class="form-group">
                                <label for="forumURL">Forum URL</label>
                                <input type="url" id="forumURL" name="forumURL" class="form-control" placeholder="{{ $alliance->forumURL }}" required>
                            </div>

                            <div class="form-group">
                                {{ csrf_field() }}
                                {{ method_field("POST") }}
                                <input type="submit" value="Edit" class="btn btn-default">
                            </div>
                        </form>
                    </div>
                 </div>
               </div>
             </div>
           </div>
      <div class="row">
       <div class="col-md-9">
           <div class="panel panel-default">
              <div class="panel-heading">Change IRC Channel</div>
                <div class="panel-body">
                    <div class="col-md-6">
                        <form method="post" action="{{ url("/alliance/".$alliance->id."/edit/changeIRCChannel") }}">

                            <div class="form-group">
                                <label for="IRCChan">IRC Channel</label>
                                <input type="name" id="IRCChan" name="IRCChan" class="form-control" placeholder="{{ $alliance->IRCChan }}" required>
                            </div>

                            <div class="form-group">
                                {{ csrf_field() }}
                                {{ method_field("POST") }}
                                <input type="submit" value="Edit" class="btn btn-default">
                            </div>
                        </form>
                    </div>
                 </div>
               </div>
             </div>
           </div>
	<div class="row">
       <div class="col-md-9">
           <div class="panel panel-default">
              <div class="panel-heading">Change Discord Server</div>
                <div class="panel-body">
                    <div class="col-md-6">
                        <form method="post" action="{{ url("/alliance/".$alliance->id."/edit/changeDiscordServer") }}">

                            <div class="form-group">
                                <label for="discord">Discord Server</label>
                                <input type="url" id="discord" name="discord" class="form-control" placeholder="{{ $alliance->discord }}">
                            </div>

                            <div class="form-group">
                                {{ csrf_field() }}
                                {{ method_field("POST") }}
                                <input type="submit" value="Edit" class="btn btn-default">
                            </div>
                        </form>
                    </div>
                 </div>
               </div>
             </div>
           </div>
	<div class="row">
       <div class="col-md-9">
           <div class="panel panel-default">
              <div class="panel-heading">Change Alliance Description</div>
                <div class="panel-body">
                    <div class="col-md-6">
                        <form method="post" action="{{ url("/alliance/".$alliance->id."/edit/changeAllianceDescription") }}">

                            <div class="form-group">
                                <label for="description">Alliance Description</label>
                                <textarea class="form-control" id="description" name="description" class="form-control" rows="5" placeholder="{{ $alliance->description }}" required></textarea>
                            </div>

                            <div class="form-group">
                                {{ csrf_field() }}
                                {{ method_field("POST") }}
                                <input type="submit" value="Edit" class="btn btn-default">
                            </div>
                        </form>
                    </div>
                 </div>
               </div>
             </div>
           </div>
	<div class="row">
       <div class="col-md-9">
           <div class="panel panel-default">
              <div class="panel-heading">Change Flag</div>
                <div class="panel-body">
                    <div class="col-md-6">
                        <form method="post" action="{{ url("/alliance/".$alliance->id."/edit/changeAllianceFlag") }}">
            				<div class="form-group">
                                <label for="flag">Flag</label>
                                	@include("templates.flagPreview")
                           		 </div>
                           		 
								<div class="form-group">
								{{ csrf_field() }}
                                {{ method_field("POST") }}
                                <input type="submit" value="Edit" class="btn btn-default">
                            	</div>
                         </form>
                    </div>
                 </div>
               </div>
             </div>
           </div>
    @endif
    @if (Auth::user()->nation->role->canRemoveMember)
	<div class="row">
       <div class="col-md-9">
           <div class="panel panel-default">
              <div class="panel-heading">Remove Member</div>
                <div class="panel-body">
                    <div class="col-md-6">
                        <form method="post" action="{{ url("/alliance/".$alliance->id."/edit/removeMember") }}">
            				<div class="form-group">
                                <select name="nation" id="nation" class="form-control">
                                	@foreach ($nations as $nation)
            						<option value=" {{$nation->id}} ">{{$nation->user->name}}</option>
           							@endforeach
           							</select>
                           		 </div>
                           		 
								<div class="form-group">
								{{ csrf_field() }}
                                {{ method_field("PATCH") }}
                                <input type="submit" value="Remove" class="btn btn-default">
                            	</div>
                         </form>
                    </div>
                 </div>
               </div>
             </div>
           </div>
    @endif
    @if (Auth::user()->nation->role->canDisbandAlliance)
	<div class="row">
    	<div class="col-md-9">
			<div class="panel panel-danger">
              <div class="panel-heading">Disband Alliance</div>
                <div class="panel-body">
                    <p>Disbanding this alliance is <strong>permanent</strong>. The alliance will be completely removed from the game and all members set to None. It will NOT be restored.</p>
                    <div class="col-md-6">
                        <form method="post" action="{{ url("/alliance/".$alliance->id."/edit/disband") }}" onsubmit="return confirm('Are you sure you want to disband this alliance? This cannot be undone.')">

                            <div class="form-group">
                                {{ csrf_field() }}
                                {{ method_field("DELETE") }}
                                <input type="submit" class="btn btn-danger" value="Disband">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
         </div>
      </div>
      @endif
      @if (Auth::user()->nation->role->canCreateRoles)
	<div class="row">
       <div class="col-md-9">
           <div class="panel panel-default">
              <div class="panel-heading">Create Role</div>
                <div class="panel-body">
                    <div class="col-md-6">
                        <form method="post" action="{{ url("/alliance/".$alliance->id."/edit/createRole") }}">
            				<div class="form-group">
            				 <input type="name" id="name" name="name" class="form-control" placeholder="Role Name" required><br>
								<input type="checkbox"	id="nameChange" name="nameChange">Change Alliance Name<br>
								<input type="checkbox" id="userRemove" name="userRemove">Remove Members<br>
								<input type="checkbox" id="disband" name="disband">Disband Alliance<br>
								<input type="checkbox" id="cosmetics" name="cosmetics">Change Cosmetics<br>
								<input type="checkbox" id="roleCreate" name="roleCreate">Create Roles<br>
								<input type="checkbox" id="roleEdit" name="roleEdit">Edit Roles<br>
								<input type="checkbox" id="roleRemove" name="roleRemove">Remove Roles<br>
								<input type="checkbox" id="announcements" name="announcements">Read Announcements<br>
								<input type="checkbox" id="roleAssign" name="roleAssign">Assign Roles<br>
								</div>
								
								<div class="form-group">
								{{ csrf_field() }}
                                {{ method_field("PATCH") }}
                                <input type="submit" value="Create" class="btn btn-default">
                            	</div>
                         </form>
                    </div>
                 </div>
               </div>
             </div>
           </div>
      @endif
      @if (Auth::user()->nation->role->canEditRoles)
	<div class="row">
       <div class="col-md-9">
           <div class="panel panel-default">
              <div class="panel-heading">Edit Role</div>
                <div class="panel-body">
                    <div class="col-md-6">
                        <form method="post" action="{{ url("/alliance/".$alliance->id."/edit/editRole") }}">
            				<div class="form-group">
                                <select name="role" id="role" class="form-control">
                                	@foreach ($roles as $role)
            						<option value="{{$role->id}}">{{$role->name}}</option>
           							@endforeach
           							</select>
                           		 </div>
                           		 
								 <div class="form-group"> 
								<input type="name" id="name" name="name" class="form-control" placeholder="Role Name" required><br>
								<input type="checkbox"	id="nameChange" name="nameChange">Change Alliance Name<br>
								<input type="checkbox" id="userRemove" name="userRemove">Remove Members<br>
								<input type="checkbox" id="disband" name="disband">Disband Alliance<br>
								<input type="checkbox" id="cosmetics" name="cosmetics">Change Cosmetics<br>
								<input type="checkbox" id="roleCreate" name="roleCreate">Create Roles<br>
								<input type="checkbox" id="roleEdit" name="roleEdit">Edit Roles<br>
								<input type="checkbox" id="roleRemove" name="roleRemove">Remove Roles<br>
								<input type="checkbox" id="announcements" name="announcements">Read Announcements<br>
								<input type="checkbox" id="roleAssign" name="roleAssign">Assign Roles<br>
								</div>

								<div class="form-group">
								{{ csrf_field() }}
                                {{ method_field("PATCH") }}
                                <input type="submit" value="Edit" class="btn btn-default">
                            	</div>
                         </form>
                    </div>
                 </div>
               </div>
             </div>
           </div>
      @endif
      @if (Auth::user()->nation->role->canRemoveRoles)
	<div class="row">
       <div class="col-md-9">
           <div class="panel panel-default">
              <div class="panel-heading">Delete Role</div>
                <div class="panel-body">
                    <div class="col-md-6">
                        <form method="post" action="{{ url("/alliance/".$alliance->id."/edit/removeRole/") }}">
            				<div class="form-group">
                                <select name="role" id="role" class="form-control">
                                	@foreach ($roles as $role)
            						<option value=" {{$role->id}} ">{{$role->name}}</option>
           							@endforeach
           						</select>
                           		 </div>
                           		 
								<div class="form-group">
								{{ csrf_field() }}
                                {{ method_field("PATCH") }}
                                <input type="submit" value="Delete" class="btn btn-default">
                            	</div>
                         </form>
                    </div>
                 </div>
               </div>
             </div>
           </div>
      @endif
      @if (Auth::user()->nation->role->canAssignRoles)
	<div class="row">
       <div class="col-md-9">
           <div class="panel panel-default">
              <div class="panel-heading">Assign Role</div>
                <div class="panel-body">
                    <div class="col-md-6">
                        <form method="post" action="{{ url("/alliance/".$alliance->id."/edit/assignRole") }}">
            				<div class="form-group">
                                <select name="nation" id="nation" class="form-control">
                                	@foreach ($nations as $nation)
            						<option value=" {{$nation->id}} ">{{$nation->user->name}}</option>
           							@endforeach
           						</select>
                           		 </div>
                           		 
                           	<div class="form-group">
                                <select name="role" id="role" class="form-control">
                                	@foreach ($roles as $role)
            						<option value=" {{$role->id}} ">{{$role->name}}</option>
           							@endforeach
           						</select>
                           		 </div>
                           		 
								<div class="form-group">
								{{ csrf_field() }}
                                {{ method_field("PATCH") }}
                                <input type="submit" value="Assign" class="btn btn-default">
                            	</div>
                         </form>
                    </div>
                 </div>
               </div>
             </div>
           </div>
      @endif
            <br>
            <a href="{{ url("/alliance/".$alliance->id) }}" class="btn btn-default">Go Back</a>
@endsection