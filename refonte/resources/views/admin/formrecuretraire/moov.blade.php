@extends('layouts.template_admin')

@section('css') 
  <!-- Custom fonts for this template -->
  <link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
  <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="{{asset('css/clean-blog.min.css')}}" rel="stylesheet">
  <link href="{{asset('css/mlm.css')}}" rel="stylesheet">
  
@endsection

@section('content')
	<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-2">
            
          </div>
          <div class="col-lg-8">
            <div class="p-5">
              <!-- Titre -->
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">ENVOYER RECU MOOV</h1>
              </div>

              <div class="text-center">
                @include('flash::message')
              </div>
              <!-- Formulaire de création de compte -->
              <form class="user" method="post" action="{{ route('moovrecuS') }}"> 
                {{ csrf_field() }}
				
				<div class="form-group">
                  <label>Référence du recu MOOV SSI : </label>
                  <input type="text" class="form-control" name="reff" value="{{ $demande->reff }}" disabled="true" >
				  <input type="hidden" class="form-control" name="reff" value="{{ $demande->reff }}" >
                </div>


                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Motif :</label>
					<input type="text" class="form-control" name="intituler" value="{{ $demande->intitule }}" disabled="true">
                  </div>
                  
                  <div class="col-sm-6">
                    <label>Numéro :</label>
                    <input type="text" class="form-control " name="numero" value="{{ $demande->numero }}" disabled="true">
                  </div>
                </div>
				
				<div class="form-group row">
                  <div class="col-sm-12">
                    <label>Montant :</label>
                    <input type="text" class="form-control " name="montant" value="{{ $demande->montant }}" disabled="true">
                  </div>
                </div>
            
                <input type="submit" name="ENVOYER RECU" value="ENVOYER RECU" class="btn btn-user btn-block" id="but" />
                
              </form>
              <hr>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>


@endsection