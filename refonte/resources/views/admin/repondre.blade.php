@extends('layouts.template_admin')

@section('content')

	<!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">REPONDRE</h1>
    </div>
	<hr>
    <!-- Content Row -->
    <div class="col-lg-12">
    	<div class="row">
	    	<div class="col-lg-9">
			      <div class="modal-content">
			        <div class="modal-header">
			       
			          <h4 class="modal-title">Répondre à un message</h4>
			        </div>

			        <form method="post" action="{{ route('repondreS') }}">
			        	{{ csrf_field() }}
				        <input type="hidden" name="id" value="{{$id}}">
				        <input type="hidden" name="email" value="{{$email}}">

				        <div class="form-group">
				        	<label>Message : </label> <br>
				        	<label style="margin-left: 40px" for="message">{{ $message }}</label>
				        </div>

				         <div class="form-group">
				              <label for="reponse">Donner la réponse (<i style="color: red">*</i>)</label>
				              <textarea class="form-control" name="reponse" placeholder="Entrer la réponse" value="{{ old('reponse') }}" autofocus autocomplete style="height: 150px"></textarea>
				            	@if($errors->has('reponse'))
			                      <p style="color: red">{{ $errors->first('reponse') }}</p>
			                  	@endif
				            </div>

				            <button type="submit" class="btn btn-primary">Envoyer</button>
			        </form>
				</div>
			</div>
		</div>
	</div>
@endsection