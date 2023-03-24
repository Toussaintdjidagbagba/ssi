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
                <h1 class="h4 text-gray-900 mb-4">ENVOYER RECU MONEY GRAM</h1>
              </div>

              <div class="text-center">
                @include('flash::message')
              </div>
              <!-- Formulaire de création de compte -->
              <form class="user" method="post" action="{{ route('gramrecuS') }}"> 
                {{ csrf_field() }}
              
                <div class="form-group">
                  <label>Référence du recu MONEY GRAM SSI : </label>
                  <input type="text" class="form-control" name="reff" value="{{ $demande->reff }}" disabled="true" >
				  <input type="hidden" class="form-control" name="reff" value="{{ $demande->reff }}" >
                </div>


                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Nom :</label>
                    <input type="text" class="form-control" name="nom" value="{{ $demande->nom }}" disabled="true">
                  </div>
                  
                  <div class="col-sm-6">
                    <label>Prénom :</label>
                    <input type="text" class="form-control " name="prenom" value="{{ $demande->prenom }}" disabled="true">
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Adresse :</label>
                    <input type="text" class="form-control" name="adresse" value="{{ $demande->adresse }}" disabled="true">
                  </div>
                  
                  <div class="col-sm-6">
                    <label>Ville :</label>
                    <input type="text" class="form-control " name="ville" value="{{ $demande->ville }}" disabled="true">
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Pays :</label>
                    <input type="text" class="form-control" name="pays" value="{{ $demande->pays }}" disabled="true">
                  </div>
                  
                  <div class="col-sm-6">
                    <label>Motif :</label>
                    <input type="text" class="form-control " name="motif" value="{{ $demande->motif }}" disabled="true">
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