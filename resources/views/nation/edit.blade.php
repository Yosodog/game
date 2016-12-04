@extends('layouts.app')

@section('content')
    @include("alerts") {{-- Include the template for alerts. This checks if there's something needed to display --}}
    
    <div class="row">
       <div class="col-md-9">
           <div class="panel panel-default">
              <div class="panel-heading">Change Nation Name</div>
                <div class="panel-body">
                    <div class="col-md-6">
                        <form method="post" action="{{ url("/nation/edit/renameNation") }}">

                            <div class="form-group">
                                <label for="name">Nation Name</label>
                                <input type="name" id="name" name="name" class="form-control" placeholder="{{ $nation->name }}" required>
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
           <div class="panel panel-default">
              <div class="panel-heading">Change Nation Motto</div>
                <div class="panel-body">
                    <div class="col-md-6">
                        <form method="post" action="{{ url("/nation/edit/changeMotto") }}">

                            <div class="form-group">
                                <label for="motto">Nation Motto</label>
                                <input type="name" id="motto" name="motto" class="form-control" placeholder="{{ $nation->motto }}" required>
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
           <div class="panel panel-default">
              <div class="panel-heading">Change Flag</div>
                <div class="panel-body">
                    <div class="col-md-6">
                        <form method="post" action="{{ url("/nation/edit/changeFlag") }}">
            				<div class="form-group">
                                <label for="flag">Flag</label>
                                	@include("templates.flagPreview")
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