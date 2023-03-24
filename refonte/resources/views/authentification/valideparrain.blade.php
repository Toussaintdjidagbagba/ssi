@extends('layouts.template')


@section('content')
<section id="services">
  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">
      <div class="col-xl-8 col-lg-8 col-md-10 col-sm-10 col-xs-10  col-xl-offset-2 col-lg-offset-2 col-md-offset-1 col-xs-offset-1 col-sm-offset-1 at-itemt">
        <div class="text-center">
          @include('flash::message')
        </div>
      </div>

      <div class="col-xl-8 col-lg-8 col-md-10 col-sm-10 col-xs-10  col-xl-offset-2 col-lg-offset-2 col-md-offset-1 col-xs-offset-1 col-sm-offset-1 at-itemt">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-2">
                
              </div>
              <div class="col-lg-8">
                <div class="p-5">
                  <div class="text-center">
                    <h1 style="color: #4f2e14; font-size: x-large;" class="h4 text-gray-900 mb-4">Entrer un nouveau code de parrainage ou bénéficier celui de l'administrateur pour le reste de votre création</h1>
                  </div>
                  <form class="user" method="post" action="{{ route('valideParrain') }}">
                    {{ csrf_field() }}
                    
                    <input type="hidden" name="id1" value="{{ $id1 }}">
                     <input type="hidden" name="payerf" value="{{ $payerf }}">
                      <input type="hidden" name="position_actuel" value="{{ $position_actuel }}">
                      <input type="hidden" name="nom" value="{{ $nom }}">
                      <input type="hidden" name="prenom" value="{{ $prenom }}">
                      <input type="hidden" name="sexe" value="{{ $sexe }}">
                      <input type="hidden" name="tel" value="{{ $tel }}">
                      <input type="hidden" name="compteactive" value="{{ $compteactive }}">
                      <input type="hidden" name="mail" value="{{ $email }}">
                      <input type="hidden" name="password" value="{{ $password }}">
                      <input type="hidden" name="pseudo" value="{{ $pseudo }}">
                      <input type="hidden" name="moyendepayement" value="{{ $moyendepayement }}">
                      <input type="hidden" name="compteacreer" value="{{ $compteacreer }}">  
                    <div class="form-group">
                      <label>Code parrain <i style="color: red">*</i></label>
                    <input type="text" class="form-control" name="parrain" id="input" placeholder="Code de parrainage" data-original-title="Entrer votre Pays" /> 
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" id="parain" name="cocherparrain" value="Pas de code de parrainage.">
                      <label class="form-check-label" for="parain">Pas de code de parrainage.</label>
                    </div>
                    </div>           
                    <button type="submit" class="btn btn-user btn-block" id="bouton">
                      <b style="color: #fff">VALIDER</b>
                    </button>    
                  </form>
                  <hr>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection('content')