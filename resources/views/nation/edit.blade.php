@extends('layouts.app')

@section('content')
    @include("alerts") {{-- Include the template for alerts. This checks if there's something needed to display --}}
    
    <div class="row">
       <div class="col-md-9">
           <div class="card mt-4">
              <div class="card-header">Change Nation Name</div>
                <div class="card-body">
                    <div class="col-md-6">
                        <form method="post" action="{{ url("/nation/edit/renameNation") }}">

                            <div class="form-group">
                                <label for="name">Nation Name</label>
                                <input type="name" id="name" name="name" class="form-control" value="{{ $nation->name }}" required>
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
           
    <div class="row">
       <div class="col-md-9">
           <div class="card mt-4">
              <div class="card-header">Change Nation Motto</div>
                <div class="card-body">
                    <div class="col-md-6">
                        <form method="post" action="{{ url("/nation/edit/changeMotto") }}">

                            <div class="form-group">
                                <label for="motto">Nation Motto</label>
                                <input type="name" id="motto" name="motto" class="form-control" value="{{ $nation->motto }}" required>
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
           
      <div class="row">
       <div class="col-md-9">
           <div class="card mt-4">
              <div class="card-header">Change Flag</div>
                <div class="card-body">
                    <div class="col-md-6">
                        <form method="post" action="{{ url("/nation/edit/changeFlag") }}">
            				<div class="form-group">
                                <label for="flag">Flag</label>
                                	@include("templates.flagPreview", ["default" => $nation->flagID])
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
           
<a href="{{ url("/nation/view") }}" class="btn btn-default">Go Back</a>
@endsection