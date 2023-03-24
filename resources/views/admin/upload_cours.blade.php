@extends('layouts.template_admin')

@section('css')
	
	<style type="text/css">
		#sidebar_right
		{
		    background-color: #f0f8ff;
		    border-bottom: 1px solid #688a7e !important;
		    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.176) !important;
		    
		}

		#link{
		    color: #65BBD6;
		}
		.bg-link
		{
			background-color: #65BBD6;
			color: white; 
		}
	</style>

@endsection

@section('content')

	<!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">AJOUTER UN COURS</h1>
    </div>
	<hr>
    <!-- Content Row -->
    <div class="col-lg-12">
    	<div class="row">
	    	<div class="col-lg-9">
			      <div class="modal-content">
			        <div class="modal-header">
			       
			          <h4 class="modal-title">Enregistrer un cours</h4>
			        </div>
			        <div class="modal-body">

			          <form role="form" method="post" enctype="multipart/form-data" action="{{ route('coursS')}}">
			            {{ csrf_field() }}
			            <div class="form-group">
			              <label for="titre">Titre du cours (<i style="color: red">*</i>)</label>
			              <input type="text" class="form-control" id="titre" name="titre" placeholder="Titre du cours" value="{{ old('titre') }}" autofocus autocomplete>
			              @if($errors->has('titre'))
		                      <p style="color: red">{{ $errors->first('titre') }}</p>
		                  @endif
			            </div>
			            
			            <div class="form-group">
			              <label for="cout">Cout du cours (<i style="color: red">*</i>)</label>
			              <input type="number" class="form-control" id="cout" name="cout" placeholder="Cout du cours" value="{{ old('cout') }}" autofocus autocomplete>
			              @if($errors->has('cout'))
		                      <p style="color: red">{{ $errors->first('cout') }}</p>
		                  @endif
			            </div>

			            <div class="form-group">
			              <label for="cours">Choisissez votre cours (<i style="color: red">*</i>)</label>
			              <input type="file" class="form-control" id="document" name="cours" >
			            	@if($errors->has('cours'))
		                      <p style="color: red">{{ $errors->first('cours') }}</p>
		                  	@endif
			            </div>

			            <div class="form-group">
			              <label for="description">Description (<i style="color: red">*</i>)</label>
			              <textarea class="form-control" id="description" name="description" placeholder="Entrer la description du cours" value="{{ old('description') }}" autofocus autocomplete style="height: 150px"></textarea>
			            	@if($errors->has('description'))
		                      <p style="color: red">{{ $errors->first('description') }}</p>
		                  	@endif
			            </div>

			            <button type="submit" class="btn btn-primary">Valider</button>  
			          </form>

			        </div>
			      </div>
	    	</div>


	    	<div class="col-lg-3 "  id="sidebar_right">
	    		<br>
	    		<div class="col-lg-12" >
	    			<div class="row">
	    				<div class="col-lg-12" id="link">
	    					Catégorie : 
	    				</div>
	    				<div class="col-lg-12">
		    				<div class="col-lg-11 offset-lg-1">
		    					> Par défaut
		    				</div>
		    				<hr>	
	    				</div> <br>
	    				<div class="col-lg-12" id="link">
	    					<a href="">VOIR LES COURS ENREGISTRER</a>
	    				</div>
	    			</div>
	    		</div>
	    		<br>
	    	</div>
	    	
      	</div>
	</div>        		
@endsection