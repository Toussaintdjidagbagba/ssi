@extends('layouts.templaterefonteadmin')

@section('content')

<section class="content">
    <div class="container-fluid">
        <!-- Hover Rows -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                      <h2>
                      Répondre au message
                    </div>
                    <div class="text-center">
                          @include('flash::message')
                    </div>
                    <div class="body">

			        <form method="post" action="{{ route('repondreS') }}">
			        	{{ csrf_field() }}
				        <input type="hidden" name="id" value="{{$cont->id}}">

				        <div class="form-group">
				        	<label>Message : </label> <br>
				        	<label style="margin-left: 40px" for="message">{{ $cont->Message }}</label>
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
</section>

@endsection